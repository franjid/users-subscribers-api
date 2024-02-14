<?php

namespace Project\Application\Service;

use Project\Domain\Entity\User;
use Project\Domain\Service\UserService as DomainUserService;
use Project\Infrastructure\Exception\Database\UserNotFoundException;

class UserService
{
    private DomainUserService $userService;

    public function __construct(DomainUserService $userService)
    {
        $this->userService = $userService;
    }

    public function getUser(int $id): User
    {
        try {
            return $this->userService->getUser($id);
        } catch (UserNotFoundException $e) {
            throw new \Project\Application\Exception\UserNotFoundException($e->getMessage());
        }
    }
}
