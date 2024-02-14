<?php

namespace Project\Domain\Service;

use Project\Domain\Entity\User;
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
}
