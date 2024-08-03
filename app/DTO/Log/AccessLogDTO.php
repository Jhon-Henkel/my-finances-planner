<?php

namespace App\DTO\Log;

readonly class AccessLogDTO
{
    public function __construct(
        private null|int $id,
        private int $userId,
        private string $userIp,
        private string $userAgent,
        private int $logged,
        private null|string $comments,
        private mixed $created_at = null
    ) {
    }

    public function getId(): null|int
    {
        return $this->id;
    }

    public function getUserId(): int
    {
        return $this->userId;
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
