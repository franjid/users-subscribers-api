<?php

namespace Project\Infrastructure;

use Project\Infrastructure\Controller\UserController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

class Routes
{
    public function getRoutes(): RouteCollection
    {
        $routes = new RouteCollection();

        $route = new Route(
            "/users/{uuid}",
            [
                "_controller" => UserController::class,
                "method" => "getUser"
            ],
            methods: [Request::METHOD_GET]
        );
        $routes->add("user", $route);

        $route = new Route(
            "/users",
            [
                "_controller" => UserController::class,
                "method" => "getUsers"
            ],
            methods: [Request::METHOD_GET]
        );
        $routes->add("getUsers", $route);

        $route = new Route(
            "/users",
            [
                "_controller" => UserController::class,
                "method" => "createUser"
            ],
            methods: [Request::METHOD_POST]
        );
        $routes->add("createUser", $route);

        return $routes;
    }
}
