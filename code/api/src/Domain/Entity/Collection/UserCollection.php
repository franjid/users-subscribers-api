<?php

namespace Project\Domain\Entity\Collection;

use Project\Domain\Entity\User;

class UserCollection
{
    /** @var User[] $users */
    private array $users;

    public function __construct(?User ...$users)
    {
        $this->users = $users;
    }

    public function getItems(): array
    {
        return $this->users;
    }

    public function count(): int
    {
        return count($this->getItems());
    }

    public function toArray(): array
    {
        $result = [];

        foreach ($this->users as $user) {
            $result[] = $user->toArray();
        }

        return $result;
    }

    public function toArrayLite(): array
    {
        $result = [];

        foreach ($this->users as $user) {
            $result[] = $user->toArrayLite();
        }

        return $result;
    }
}
