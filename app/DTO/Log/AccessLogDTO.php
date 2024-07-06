<?php

namespace App\DTO\Log;

readonly class AccessLogDTO
{
    public function __construct(
        private null|int $id,
        private int $userId,
        private string $userIp,
        private null|string $accountGroup,
        private string $userAgent,
        private int $logged,
        private null|string $comments,
        private mixed $created_at = null
    ) {
    }

    public function getId(): null|string
    {
        return $this->id;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function getAccountGroup(): null|string
    {
        return $this->accountGroup;
    }

    public function getUserIp(): string
    {
        return $this->userIp;
    }

    public function getUserAgent(): string
    {
        return $this->userAgent;
    }

    public function getLogged(): int
    {
        return $this->logged;
    }

    public function getComments(): null|string
    {
        return $this->comments;
    }

    public function getCreatedAt(): mixed
    {
        return $this->created_at;
    }
}
