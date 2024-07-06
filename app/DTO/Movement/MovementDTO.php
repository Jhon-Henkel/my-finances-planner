<?php

namespace App\DTO\Movement;

use App\Enums\MovementEnum;

class MovementDTO
{
    private null|int $id;
    private int $walletId;
    private null|string $walletName;
    private null|string $description;
    private int $type;
    private int|float $amount;
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

    public function getWalletId(): int
    {
        return $this->walletId;
    }

    public function setWalletId(int $walletId): void
    {
        $this->walletId = $walletId;
    }

    public function getWalletName(): null|string
    {
        return $this->walletName;
    }

    public function setWalletName(null|string $walletName): void
    {
        $this->walletName = $walletName;
    }

    public function getDescription(): null|string
    {
        return $this->description;
    }

    public function setDescription(null|string $description): void
    {
        $this->description = $description;
    }

    public function getType(): int
    {
        return $this->type;
    }

    public function setType(int $type): void
    {
        $this->type = $type;
    }

    public function getAmount(): float|int
    {
        return $this->amount;
    }

    public function setAmount(float|int $amount): void
    {
        $this->amount = abs($amount);
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

    public function isGain(): bool
    {
        return $this->getType() == MovementEnum::Gain->value;
    }

    public function isSpent(): bool
    {
        return $this->getType() == MovementEnum::Spent->value;
    }

    public function isTransfer(): bool
    {
        return $this->getType() == MovementEnum::Transfer->value;
    }

    public function isMarketSpent(): bool
    {
        return strtolower($this->getDescription()) == 'mercado' && $this->isSpent();
    }
}
