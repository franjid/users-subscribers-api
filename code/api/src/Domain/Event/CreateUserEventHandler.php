<?php

namespace Project\Domain\Event;

use Project\Domain\Service\UserService;
use Project\Infrastructure\Exception\Database\UserAlreadyExistsException;

class CreateUserEventHandler
{
    private UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function __invoke(CreateUserEvent $event): void
    {
        try {
            $this->userService->createUser($event->getUser());
        } catch (UserAlreadyExistsException $e) {
            // Here we could send a warning to Sentry or similar
        }
    }
}
