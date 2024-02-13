<?php

namespace Project\Infrastructure\Controller;

use Project\Application\Service\UserService;
use Symfony\Component\HttpFoundation\Response;

class UserController
{
    private UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function getUser(int $id): Response
    {
        return new Response(
            json_encode(["user" => $this->userService->getUser($id)]),
            Response::HTTP_OK, ["content-type" => "application/json"]
        );
    }

    public function getUsers(): Response
    {
        return new Response(
            json_encode(["message" => "Get list of users"]),
            Response::HTTP_OK, ["content-type" => "application/json"]
        );
    }

    public function createUser(string $body): Response
    {
        $user = json_decode($body, TRUE);

        return new Response(
            json_encode(
                [
                    "message" => "User should be created",
                    "user" => $user
                ]),
            Response::HTTP_ACCEPTED, ["content-type" => "application/json"]
        );
    }
}
