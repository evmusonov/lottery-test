<?php

namespace Application\Http;

use FastRoute\Dispatcher;
use function FastRoute\simpleDispatcher;

class Router
{
    protected $container;

    public function __construct($container)
    {
        $this->container = $container;
    }

    public function run()
    {
        $routes = require_once CONFIG_DIR . '/routes.php';
        $dispatcher = simpleDispatcher($routes);

        $route = $dispatcher->dispatch($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);

        switch ($route[0]) {
            case Dispatcher::NOT_FOUND:
                echo '404 Not Found';
                break;

            case Dispatcher::METHOD_NOT_ALLOWED:
                echo '405 Method Not Allowed';
                break;

            case Dispatcher::FOUND:
                $controller = $route[1];
                $parameters = $route[2];

                $this->container->call($controller, $parameters);
                break;
        }
    }
}