<?php

namespace tests\Unit\Domain\Service;

use PHPUnit\Framework\TestCase;
use Project\Domain\Entity\Collection\UserCollection;
use Project\Domain\Entity\User;
use Project\Domain\Entity\UserRaw;
use Project\Domain\Service\UserService;
use Project\Infrastructure\Exception\Database\UserNotFoundException;
use Project\Infrastructure\Interfaces\Database\UserRepositoryInterface;
use Ramsey\Uuid\Uuid;

class UserServiceTest extends TestCase
{
    private UserRepositoryInterface $userRepositoryMock;
    private UserService $userService;

    public function setUp(): void
    {
        $this->userRepositoryMock = $this->createMock(UserRepositoryInterface::class);
        $this->userService = new UserService($this->userRepositoryMock);
    }

    public function testGetUser(): void
    {
        $user = new User(
            1,
            Uuid::uuid4(),
            'john@doe.com',
            'John',
            'Doe',
            1,
            new \DateTimeImmutable(),
            new \DateTimeImmutable()
        );

        $this->userRepositoryMock->expects($this->once())
            ->method('getUser')
            ->with(1)
            ->willReturn($user);

        $this->assertEquals($user, $this->userService->getUser(1));
    }

    public function testNotExistingUser(): void
    {
        $this->userRepositoryMock->expects($this->once())
            ->method('getUser')
            ->with(99)
            ->willThrowException($this->createMock(UserNotFoundException::class));

        $this->expectException(UserNotFoundException::class);;

        $this->userService->getUser(99);
    }

    public function testGetUsers(): void
    {
        $user1 = new User(
            1,
            Uuid::uuid4(),
            'john@doe.com',
            'John',
            'Doe',
            1,
            new \DateTimeImmutable(),
            new \DateTimeImmutable()
        );
        $user2 = new User(
            2,
            Uuid::uuid4(),
            'jane@doe.com',
            'Jane',
            'Doe',
            1,
            new \DateTimeImmutable(),
            new \DateTimeImmutable()
        );

        $userCollection = new UserCollection(...[$user1, $user2]);

        $this->userRepositoryMock->expects($this->once())
            ->method('getUsers')
            ->willReturn($userCollection);

        $this->assertEquals($userCollection, $this->userService->getUsers());
    }

    public function testGetUsersWhenNoStoredUsers(): void
    {
        $userCollection = new UserCollection();

        $this->userRepositoryMock->expects($this->once())
            ->method('getUsers')
            ->willReturn($userCollection);

        $this->assertEquals($userCollection, $this->userService->getUsers());
    }

    public function testGetTotalUsers(): void
    {
        $this->userRepositoryMock->expects($this->once())
            ->method('getTotalUsers')
            ->willReturn(10);

        $this->assertEquals(10, $this->userService->getTotalUsers());
    }

    public function testCreateUser(): void
    {
        $userRaw = new UserRaw(
            Uuid::uuid4(),
            'fran@more.com',
            'Fran',
            'More',
        );
        $newUser = new User(
            1,
            $userRaw->getUuid(),
            $userRaw->getEmail(),
            $userRaw->getName(),
            $userRaw->getLastName(),
            1,
            new \DateTimeImmutable(),
            new \DateTimeImmutable()
        );

        $this->userRepositoryMock->expects($this->once())
            ->method('createUser')
            ->with($userRaw)
            ->willReturn($newUser);

        $this->assertEquals($newUser, $this->userService->createUser($userRaw));
    }
}
