<?php namespace Sukonovs\Views;

use Twig_Environment;

/**
 * View class
 *
 * @author Roberts Sukonovs <roberts.sukonovs@gmail.com>
 * @package Sukonovs\Views
 */

class View
{
    /**
     * @var Twig_Environment
     */
    private $twig;

    /**
     * Class constructor
     *
     * @param Twig_Environment $twig
     */
    public function __construct(Twig_Environment $twig)
    {
        $this->twig = $twig;
    }

    /**
     * Render view
     *
     * @param string $view
     * @param array $parameters
     * @return string
     */
    public function render($view, array $parameters = [])
    {
        $view = $this->parseViewDots($view);

        return $this->twig->render($view . '.php', $parameters);
    }

    /**
     * Converts dot notation to slashes
     *
     * @param string $view
     * @return string
     */
    private function parseViewDots($view)
    {
        return str_replace('.', '/', $view);
    }
}