<?php

namespace ScandiWebTest\Middleware;

use Closure;
use DI\Container;
use Sukonovs\Views\View;
use Sukonovs\Http\Request;
use Sukonovs\Http\Response;
use Sukonovs\Http\Middleware;

class Ajax extends Middleware
{
    /**
     * Handle an incoming request.
     *
     * @param Container $container
     * @param  Closure $next
     * @return mixed
     * @throws \DI\NotFoundException
     */
    public function handle(Container $container, Closure $next)
    {
        $request = $container->get(Request::class);

        if (!$request->ajax()) {
            $view = $container->get(View::class)->render('errors.403');

            return $container->get(Response::class)->forbidden($view);
        };

        return $next();
    }
}
