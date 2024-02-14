<?php

namespace Project\Domain\Service;

use Project\Domain\Entity\Collection\UserCollection;
use Project\Domain\Entity\User;
use Project\Domain\Entity\UserRaw;
use Project\Infrastructure\Interfaces\Database\UserRepositoryInterface;

class UserService
{
    private UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function getUser(int $id): User
    {
        return $this->userRepository->getUser($id);
    }

    public function getUserByUuid(string $uuid): User
    {
        return $this->userRepository->getUserByUuid($uuid);
    }

    public function getUsers(int $offset = 0, int $numResults = 10): UserCollection
    {
        return $this->userRepository->getUsers($offset, $numResults);
    }

    public function getTotalUsers(): int
    {
        return $this->userRepository->getTotalUsers();
    }

    public function createUser(UserRaw $user): User
    {
        return $this->userRepository->createUser($user);
    }
}
