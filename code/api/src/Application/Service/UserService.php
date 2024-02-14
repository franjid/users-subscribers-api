<?php

namespace Project\Application\Service;

use Project\Domain\Entity\User;
use Project\Domain\Entity\UserRaw;
use Project\Domain\Event\CreateUserEvent;
use Project\Domain\Service\UserService as DomainUserService;
use Project\Infrastructure\Exception\Database\UserNotFoundException;
use Project\Infrastructure\Interfaces\Queue\QueueInterface;

class UserService
{
    private DomainUserService $userService;
    private QueueInterface $queue;

    public function __construct(
        DomainUserService $userService,
        QueueInterface $queue
    )
    {
        $this->userService = $userService;
        $this->queue = $queue;
    }

    public function getUser(string $uuid): User
    {
        try {
            return $this->userService->getUserByUuid($uuid);
        } catch (UserNotFoundException $e) {
            throw new \Project\Application\Exception\UserNotFoundException($e->getMessage());
        }
    }

    public function createUser(UserRaw $user): void
    {
        $this->queue->enqueue(new CreateUserEvent($user));
    }
}
