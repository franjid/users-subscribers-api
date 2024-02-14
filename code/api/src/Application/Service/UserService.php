<?php

namespace Project\Application\Service;

use Project\Application\Dto\ResponseCollection;
use Project\Domain\Entity\User;
use Project\Domain\Entity\UserRaw;
use Project\Domain\Event\CreateUserEvent;
use Project\Domain\Service\UserService as DomainUserService;
use Project\Infrastructure\Exception\Database\UserNotFoundException;
use Project\Infrastructure\Interfaces\Queue\QueueInterface;

class UserService
{
    private DomainUserService $userService;
    private PaginationService $paginationService;
    private QueueInterface $queue;

    public function __construct(
        DomainUserService $userService,
        PaginationService $paginationService,
        QueueInterface $queue
    ) {
        $this->userService = $userService;
        $this->paginationService = $paginationService;
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

    public function getUsers(int $page, int $numResults): ResponseCollection
    {
        $offset = $this->paginationService->getOffset($page, $numResults);
        $users = $this->userService->getUsers($offset, $numResults)->toArrayLite();
        $totalUsers = $this->userService->getTotalUsers();
        $totalPages = $this->paginationService->getTotalPages($totalUsers, $numResults);

        return new ResponseCollection(
            $totalUsers,
            $page,
            $totalPages,
            $users
        );
    }

    public function createUser(UserRaw $user): void
    {
        $this->queue->enqueue(new CreateUserEvent($user));
    }
}
