<?php

namespace Project\Domain\Event;

use Project\Domain\Entity\UserRaw;

class CreateUserEvent
{
    private UserRaw $user;

    public function __construct(UserRaw $user)
    {
        $this->user = $user;
    }

    public function getUser(): UserRaw
    {
        return $this->user;
    }
}
