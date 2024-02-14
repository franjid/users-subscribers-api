<?php

namespace Project\Infrastructure\Repository\Database;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception;
use Doctrine\DBAL\ParameterType;
use Project\Domain\Entity\User;
use Project\Domain\Entity\UserRaw;
use Project\Infrastructure\Exception\Database\UserAlreadyExistsException;
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
        $stmt->bindValue("id", $id, ParameterType::INTEGER);
        $user = $stmt->executeQuery()->fetchAssociative();

        if (!$user) {
            throw new UserNotFoundException("User id not found: " . $id);
        }

        return User::buildFromArray($user);
    }

    public function getUserByUuid(string $uuid): User
    {
        $sql = "SELECT * FROM users WHERE uuid = :uuid";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindValue("uuid", $uuid);
        $user = $stmt->executeQuery()->fetchAssociative();

        if (!$user) {
            throw new UserNotFoundException("User not found");
        }

        return User::buildFromArray($user);
    }

    public function createUser(UserRaw $user): User
    {
        $sql = "INSERT INTO users (";
        $sql .= "   uuid";
        $sql .= " , email";
        $sql .= " , name";
        $sql .= " , lastName";
        $sql .= ")";
        $sql .= " VALUES (";
        $sql .= "   :uuid";
        $sql .= " , :email";
        $sql .= " , :name";
        $sql .= " , :lastName";
        $sql .= ")";

        $stmt = $this->connection->prepare($sql);
        $stmt->bindValue("uuid", $user->getUuid());
        $stmt->bindValue("email", $user->getEmail());
        $stmt->bindValue("name", $user->getName());
        $stmt->bindValue("lastName", $user->getLastName());

        try {
            $stmt->executeQuery();
            return $this->getUserByUuid($user->getUuid());
        } catch (Exception\UniqueConstraintViolationException $e) {
            throw new UserAlreadyExistsException();
        }
    }
}
