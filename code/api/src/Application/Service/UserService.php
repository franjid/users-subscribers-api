<?php

namespace Project\Application\Service;

class UserService
{
    public function getUser(int $id): array
    {
        return ["id" => $id, "name" => "Name-" . $id];
    }
}
