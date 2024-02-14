<?php

namespace Project\Infrastructure\Interfaces\Database;

use Project\Domain\Entity\User;
use Project\Domain\Entity\UserRaw;

interface UserRepositoryInterface
{
    public function getUser(int $id): User;
    public function getUserByUuid(string $uuid): User;
    public function createUser(UserRaw $user): User;
}
