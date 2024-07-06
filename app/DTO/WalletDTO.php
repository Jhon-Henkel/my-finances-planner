<?php

namespace App\DTO;

class WalletDTO
{
    private null|int $id;
    private string $name;
    private int $type;
    private null|bool $movementAlreadyDone = false;
    private float|int $amount;
    private mixed $createdAt;
    private mixed $updatedAt;

    public function getId(): null|int
    {
        return $this->id;
    }

    public function setId(null|int $id): void
    {
        $this->id = $id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getType(): int
    {
        return $this->type;
    }

    public function setType(int $type): void
    {
        $this->type = $type;
    }

    public function getMovementAlreadyDone(): null|bool
    {
        return $this->movementAlreadyDone;
    }

    public function setMovementAlreadyDone(null|bool $movementAlreadyDone): void
    {
        $this->movementAlreadyDone = $movementAlreadyDone;
    }

    public function getAmount(): float|int
    {
        return $this->amount;
    }

    public function setAmount(float|int $amount): void
    {
        $this->amount = $amount;
    }

    public function getCreatedAt(): mixed
    {
        return $this->createdAt;
    }

    public function setCreatedAt(mixed $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    public function getUpdatedAt(): mixed
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(mixed $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }
}
