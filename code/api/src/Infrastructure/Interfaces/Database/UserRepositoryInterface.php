<?php

namespace Project\Infrastructure\Interfaces\Database;

use Project\Domain\Entity\User;

interface UserRepositoryInterface
{
    public function getUser(int $id): User;
}
