<?php

require_once "vendor/autoload.php";

use Project\Application\Service\PaginationService;
use Project\Application\Service\UserService;
use Project\Domain\Service\UserService as DomainUserService;
use Project\Infrastructure\Controller\UserController;
use Project\Infrastructure\DbConnection;
use Project\Infrastructure\QueueConnection;
use Project\Infrastructure\Repository\Database\UserRepository;
use Project\Infrastructure\Repository\Queue\Rabbitmq;
use Project\Infrastructure\Repository\Queue\SenderLocator;
use Project\Infrastructure\Routes;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBus;
use Symfony\Component\Messenger\Middleware\SendMessageMiddleware;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;

$dbConnection = (new DbConnection())->getConnection();
$commandBus = new MessageBus([new SendMessageMiddleware(new SenderLocator((new QueueConnection())->getConnection()))]);
$queue = new Rabbitmq($commandBus);
$routes = new Routes();
$requestContext = new RequestContext();
$requestContext->fromRequest(Request::createFromGlobals());
$rawBodyData = $requestContext->getMethod() === Request::METHOD_POST ? file_get_contents("php://input") : null;
$routeMatcher = new UrlMatcher($routes->getRoutes(), $requestContext);

try {
    $resource = $routeMatcher->match($requestContext->getPathInfo());
    $controller = $resource["_controller"];
    $method = $resource["method"];
    $methodParameters = [];
    $controllerDependencies = [];

    switch ($controller) {
        case UserController::class:
            $userRepository = new UserRepository($dbConnection);
            $domainUserService = new DomainUserService($userRepository);
            $paginationService = new PaginationService();
            $controllerDependencies["userService"] = new UserService($domainUserService, $paginationService, $queue);

            switch ($method) {
                case "getUser":
                    $methodParameters["uuid"] = $resource["uuid"];
                    break;
                case "getUsers":
                    parse_str($requestContext->getQueryString(), $params);

                    $page = isset($params['page']) ? intval($params['page']) : 1;
                    $numResults = isset($params['numResults']) && $params['numResults'] <= 100
                        ? intval($params['numResults'])
                        : 10;

                    $methodParameters["page"] = $page;
                    $methodParameters["numResults"] = $numResults;
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
} catch (ResourceNotFoundException $e) {
    return (new JsonResponse(status: Response::HTTP_NOT_FOUND))->send();
} catch (Exception $e) {
    return (new JsonResponse($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR))->send();
}
