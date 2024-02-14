<?php

namespace Project\Infrastructure\Controller;

use Project\Application\Exception\UserNotFoundException;
use Project\Application\Service\UserService;
use Project\Domain\Entity\UserRaw;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class UserController
{
    private UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function getUser(string $uuid): Response
    {
        try {
            $user = $this->userService->getUser($uuid);
        } catch (UserNotFoundException) {
            return new JsonResponse(status: Response::HTTP_NOT_FOUND);
        }

        return new JsonResponse($user->toArrayLite());
    }

    public function getUsers(int $page, int $numResults): Response
    {
        $users = $this->userService->getUsers($page, $numResults);

        return new JsonResponse($users->toArray());
    }

    public function createUser(string $body): Response
    {
        $user = UserRaw::buildFromArray(json_decode($body, TRUE));
        $this->userService->createUser($user);

        return new JsonResponse($user->toArray(), Response::HTTP_ACCEPTED);
    }
}
