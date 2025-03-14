<?php

namespace App\VO\Log;

use App\DTO\Log\AccessLogDTO;

readonly class AccessLogVO
{
    public ?int $id;
    public int $userId;
    public string $userIp;
    public string $userAgent;
    public string $logged;
    public ?string $comments;
    public string $createdAt;

    public function __construct(AccessLogDTO $dto)
    {
        $this->id = $dto->getId();
        $this->userId = $dto->getUserId();
        $this->userIp = $dto->getUserIp();
        $this->userAgent = $dto->getUserAgent();
        $this->logged = (string)$dto->getLogged();
        $this->comments = $dto->getComments();
        $this->createdAt = $dto->getCreatedAt();
    }
}
