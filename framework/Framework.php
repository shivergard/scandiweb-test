<?php

namespace Sukonovs;

use Twig_Environment;
use DI\ContainerBuilder;
use Sukonovs\Views\View;
use FastRoute\Dispatcher;
use Sukonovs\Http\Request;
use Twig_Loader_Filesystem;
use Sukonovs\Http\Response;
use InvalidArgumentException;
use FastRoute\RouteCollector;
use Illuminate\Database\Capsule\Manager;
use Symfony\Component\HttpFoundation\Response as BaseResponse;

/**
 * Framework object
 *
 * @author Roberts Sukonovs <roberts.sukonovs@gmail.com>
 * @package Sukonovs
 */
class Framework
{
    /**
     * Framework DI container
     *
     * @var \DI\Container
     */
    protected $container;

    /**
     * Route list
     *
     * @var array
     */
    protected $routes;

    /**
     * Class constructor
     */
    public function __construct()
    {
        date_default_timezone_set('Europe/Riga');

        $this->initializeORM();
        $this->buildInitialContainer();
    }

    /**
     * Launch framework
     *
     * @return void
     */
    public function launch()
    {
        $routeInfo = $this->dispatch();
        $response = $this->handleRoute($routeInfo);

        if ($response instanceof BaseResponse) {
            $response->send();
        } else {
            echo (string)$response;
        }
    }

    /**
     * Register GET route
     *
     * @param string $uri url part
     * @param string|array $action
     * @return void
     */
    public function get($uri, $action)
    {
        $this->addRoute('GET', $uri, $action);
    }

    /**
     * Register POST route
     *
     * @param string $uri url part
     * @param string|array
     * @return void
     */
    public function post($uri, $action)
    {
        $this->addRoute('POST', $uri, $action);
    }

    /**
     * Bind controller to route
     *
     * @param string $controller controller/action
     * @return array
     * @throws InvalidArgumentException
     */
    public function controller($controller)
    {
        $parts = explode('@', $controller);

        if (!$parts || count($parts) !== 2) {
            throw new InvalidArgumentException('Please fix controller/action in your routes.');
        }

        return ['instance' => $parts[0], 'action' => $parts[1]];
    }

    /**
     * Bind middleware to route
     *
     * @param string $middleware
     * @return string
     */
    public function middleware($middleware)
    {
        return $middleware;
    }

    /**
     * Add route
     *
     * @param string $method HTTP method
     * @param string $uri url part
     * @param array $action route controllers and middleware
     */
    public function addRoute($method, $uri, $action)
    {
        $action = $this->parseAction($action);

        $this->routes[strtolower($method) . '.' . $uri] = ['method' => $method, 'uri' => $uri, 'action' => $action];
    }

    /**
     * Initialize ORM
     *
     * @return void
     */
    private function initializeORM()
    {
        $capsule = new Manager();
        $capsule->addConnection([
            'driver' => 'sqlite',
            'database' => __DIR__ . '/../database.sqlite',
            'prefix' => ''
        ]);
        $capsule->bootEloquent();
    }

    /**
     * Build container
     *
     * @return void
     */
    protected function buildInitialContainer()
    {
        $builder = new ContainerBuilder();

        $builder->addDefinitions([
            Request::class => Request::createFromGlobals(),
            View::class => function () {
                $loader = new Twig_Loader_Filesystem(__DIR__ . '/../resources/views');
                $environment = new Twig_Environment($loader);

                return new View($environment);
            }
        ]);

        $this->container = $builder->build();
    }

    /**
     * Dispatch request
     *
     * @return array
     */
    private function dispatch()
    {
        $method = $this->getHTTPMethod();
        $path = $this->getHTTPPath();

        return $this->buildDispatcher()->dispatch($method, $path);
    }

    /**
     * Build dispatcher
     *
     * @return Dispatcher
     */
    private function buildDispatcher()
    {
        return \Fastroute\simpleDispatcher(function (RouteCollector $collector) {
            foreach ($this->routes as $route) {
                $collector->addRoute($route['method'], $route['uri'], $route['action']);
            }
        });
    }

    /**
     * Get request method
     *
     * @return string
     */
    private function getHTTPMethod()
    {
        $request = $this->container->get(Request::class);

        return $request->getMethod();
    }

    /**
     * Get request path
     *
     * @return string
     */
    private function getHTTPPath()
    {
        $request = $this->container->get(Request::class);

        return $request->getPathInfo();
    }

    /**
     * Parse route action
     *
     * @param $action mixed
     * @return array
     */
    private function parseAction($action)
    {
        $action = $this->normalizeMiddleware($action);

        if (array_key_exists('instance', $action)) {

            return ['controller' => $action, 'middleware' => $action['middleware']];
        }

        return $action;
    }

    /**
     * Normalize middleware in routes
     *
     * @param array $action
     * @return array
     */
    private function normalizeMiddleware($action)
    {
        if (!array_key_exists('middleware', $action)) {

            $action['middleware'] = false;
        }

        return $action;
    }

    /**
     * Handles route errors
     *
     * @param $routeInfo
     * @return Reponse
     * @throws \DI\NotFoundException
     */
    private function handleRoute($routeInfo)
    {
        switch ($routeInfo[0]) {
            case Dispatcher::NOT_FOUND:
                $view = $this->container->get(View::class)->render('errors.404');

                return $this->container->get(Response::class)->notFound($view);
            case Dispatcher::METHOD_NOT_ALLOWED:
                $view = $this->container->get(View::class)->render('errors.405');
                
                return $this->container->get(Response::class)->notAllowed($view);
            case Dispatcher::FOUND:

                return $this->handleFoundRoute($routeInfo[1]);
        }
    }

    /**
     * Handle controller
     * 
     * @param array $controller
     * @return BaseResponse
     */
    private function handleController($controller)
    {
        $controllerInstance = $this->container->get($controller['instance']);

        return $controllerInstance->{$controller['action']}();
    }

    /**
     * Handles found route
     *
     * @param $controllerParams
     * @return BaseResponse
     */
    private function handleFoundRoute($controllerParams)
    {
        if ($controllerParams['middleware']) {

            return $this->handleMiddleware($controllerParams);
        }

        return $this->handleController($controllerParams['controller']);
    }

    /**
     * Run middleware
     *
     * @param $routeParams
     * @return mixed
     * @throws \DI\NotFoundException
     */
    private function handleMiddleware($routeParams)
    {
        $middlewareInstance = $this->container->get($routeParams['middleware']);

        return $middlewareInstance->handle($this->container, function() use ($routeParams) {

            return $this->handleController($routeParams['controller']);
        });
    }
}