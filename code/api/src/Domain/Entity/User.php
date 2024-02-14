<?php

namespace Project\Domain\Entity;

use DateTimeImmutable;

class User
{
    public const FIELD_ID = 'id';
    public const FIELD_UUID = 'uuid';
    public const FIELD_EMAIL = 'email';
    public const FIELD_NAME = 'name';
    public const FIELD_LAST_NAME = 'lastName';
    public const FIELD_STATUS = 'status';
    public const FIELD_CREATED_AT = 'createdAt';
    public const FIELD_UPDATED_AT = 'updatedAt';

    private int $id;
    private string $uuid;
    private string $email;
    private string $name;
    private string $lastName;
    private int $status;
    private DateTimeImmutable $createdAt;
    private DateTimeImmutable $updatedAt;

    public function __construct(
        int               $id,
        string            $uuid,
        string            $email,
        string            $name,
        string            $lastName,
        int               $status,
        DateTimeImmutable $createdAt,
        DateTimeImmutable $updatedAt
    )
    {
        $this->id = $id;
        $this->uuid = $uuid;
        $this->email = $email;
        $this->name = $name;
        $this->lastName = $lastName;
        $this->status = $status;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
    }

    public function getId(): int
    {
        return $this->id;
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

    public function getStatus(): int
    {
        return $this->status;
    }

    public function getCreatedAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public static function buildFromArray(array $data): self
    {
        return new self(
            $data[self::FIELD_ID],
            $data[self::FIELD_UUID],
            $data[self::FIELD_EMAIL],
            $data[self::FIELD_NAME],
            $data[self::FIELD_LAST_NAME],
            $data[self::FIELD_STATUS],
            DateTimeImmutable::createFromFormat("Y-m-d H:i:s", $data[self::FIELD_CREATED_AT]),
            DateTimeImmutable::createFromFormat("Y-m-d H:i:s", $data[self::FIELD_UPDATED_AT]),
        );
    }

    public function toArray(): array
    {
        return [
            self::FIELD_ID => $this->getId(),
            self::FIELD_UUID => $this->getUuid(),
            self::FIELD_EMAIL => $this->getEmail(),
            self::FIELD_NAME => $this->getName(),
            self::FIELD_LAST_NAME => $this->getLastName(),
            self::FIELD_STATUS => $this->getStatus(),
        ];
    }
}
