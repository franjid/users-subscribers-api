<?php

namespace Project\Infrastructure\Interfaces\Database;

use Project\Domain\Entity\Collection\UserCollection;
use Project\Domain\Entity\User;
use Project\Domain\Entity\UserRaw;

interface UserRepositoryInterface
{
    public function getUser(int $id): User;
    public function getUserByUuid(string $uuid): User;
    public function getUsers(int $offset = 0, int $numResults = 10): UserCollection;
    public function getTotalUsers(): int;
    public function createUser(UserRaw $user): User;
}
