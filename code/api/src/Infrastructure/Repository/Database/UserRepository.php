<?php

namespace Project\Infrastructure\Repository\Database;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception;
use Doctrine\DBAL\ParameterType;
use Project\Domain\Entity\Collection\UserCollection;
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

    public function getUsers(int $offset = 0, int $numResults = 10): UserCollection
    {
        $sql = "SELECT * FROM users LIMIT " . $offset . ", " . $numResults;
        $stmt = $this->connection->prepare($sql);
        $results = $stmt->executeQuery()->fetchAllAssociative();

        if (!$results) {
            return new UserCollection();
        }

        $users = [];

        foreach ($results as $user) {
            $users[] = User::buildFromArray($user);
        }

        return new UserCollection(...$users);
    }

    public function getTotalUsers(): int
    {
        $sql = "SELECT COUNT(*) AS totalUsers FROM users";
        $stmt = $this->connection->prepare($sql);
        $result = $stmt->executeQuery()->fetchAssociative();

        return $result["totalUsers"];
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
