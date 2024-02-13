<?php

require_once "vendor/autoload.php";

use Project\Application\Service\UserService;
use Project\Infrastructure\Routes;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;
use Project\Infrastructure\Controller\UserController;

$routes = new Routes();
$requestContext = new RequestContext();
$requestContext->fromRequest(Request::createFromGlobals());
$rawBodyData = $requestContext->getMethod() === Request::METHOD_POST ? file_get_contents("php://input") : null;
$matcher = new UrlMatcher($routes->getRoutes(), $requestContext);

try {
    $resource = $matcher->match($requestContext->getPathInfo());
    $controller = $resource["_controller"];
    $method = $resource["method"];
    $methodParameters = [];
    $controllerDependencies = [];

    switch ($controller) {
        case UserController::class:
            $controllerDependencies["userService"] = new UserService();

            switch ($method) {
                case "getUser":
                    $methodParameters["id"] = $resource["id"];
                    break;
                case "createUser":
                    $methodParameters["body"] = $rawBodyData;
                    break;
            }
            break;
        default:
            throw new LogicException();
    }

    $controllerInstance = new $controller(...$controllerDependencies);
    $controllerInstance->$method(...$methodParameters)->send();
} catch (Exception $e) {
    $response = new Response("", Response::HTTP_NOT_FOUND, ["content-type" => "application/json"]);
    return $response->send();
}


