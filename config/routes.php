<?php

use FastRoute\RouteCollector;

return function (RouteCollector $r) {
    $r->addRoute('GET', '/', ['Application\Controller\MainController', 'index']);
    $r->addRoute('GET', '/users', ['Application\Controller\UserController', 'index']);
    $r->addRoute('GET', '/prizes', ['Application\Controller\PrizeController', 'index']);

    $r->addRoute('GET', '/test', ['Application\Controller\TestController', 'index']);

    $r->addGroup('/users', function (RouteCollector $r) {
        $r->addRoute(['GET', 'POST'], '/register', ['Application\Controller\UserController', 'register']);
        $r->addRoute(['GET', 'POST'], '/login', ['Application\Controller\UserController', 'login']);
        $r->addRoute('GET', '/profile', ['Application\Controller\UserController', 'profile']);
        $r->addRoute('GET', '/logout', ['Application\Controller\UserController', 'logout']);
    });
    $r->addGroup('/prizes', function (RouteCollector $r) {
        $r->addRoute('GET', '/spin', ['Application\Controller\PrizeController', 'spin']);
        $r->addRoute('POST', '/accept', ['Application\Controller\PrizeController', 'accept']);
        $r->addRoute('POST', '/decline', ['Application\Controller\PrizeController', 'decline']);
    });
};