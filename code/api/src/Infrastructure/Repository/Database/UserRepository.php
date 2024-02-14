<?php

namespace Project\Infrastructure\Repository\Database;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception;
use Doctrine\DBAL\ParameterType;
use Project\Domain\Entity\User;
use Project\Infrastructure\Exception\Database\UserNotFoundException;
use Project\Infrastructure\Interfaces\Database\UserRepositoryInterface;

class UserRepository implements UserRepositoryInterface
{
    private Connection $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    /**
     * @throws Exception
     * @throws UserNotFoundException
     */
    public function getUser(int $id): User
    {
        $sql = "SELECT * FROM users WHERE id = :id";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindValue('id', $id, ParameterType::INTEGER);
        $user = $stmt->executeQuery()->fetchAssociative();

        if (!$user) {
            throw new UserNotFoundException('User id not found: ' . $id);
        }

        return User::buildFromArray($user);
    }
}
