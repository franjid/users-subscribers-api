<?php

namespace Project\Domain\Entity;

class UserRaw
{
    public const FIELD_UUID = 'uuid';
    public const FIELD_EMAIL = 'email';
    public const FIELD_NAME = 'name';
    public const FIELD_LAST_NAME = 'lastName';

    private string $uuid;
    private string $email;
    private string $name;
    private string $lastName;

    public function __construct(
        string            $uuid,
        string            $email,
        string            $name,
        string            $lastName,
    )
    {
        $this->uuid = $uuid;
        $this->email = $email;
        $this->name = $name;
        $this->lastName = $lastName;
    }

    public function getUuid(): string
    {
        return $this->uuid;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public static function buildFromArray(array $data): self
    {
        return new self(
            $data[self::FIELD_UUID],
            $data[self::FIELD_EMAIL],
            $data[self::FIELD_NAME],
            $data[self::FIELD_LAST_NAME],
        );
    }

    public function toArray(): array
    {
        return [
            self::FIELD_UUID => $this->getUuid(),
            self::FIELD_EMAIL => $this->getEmail(),
            self::FIELD_NAME => $this->getName(),
            self::FIELD_LAST_NAME => $this->getLastName(),
        ];
    }
}
