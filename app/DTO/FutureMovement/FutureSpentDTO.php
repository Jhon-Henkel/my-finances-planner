<?php

namespace App\DTO\FutureMovement;

class FutureSpentDTO implements IFutureMovementDTO
{
    private null|int $id;
    private int $walletId;
    private null|string $walletName;
    private string $description;
    private float|int $amount;
    private int $installments;
    private mixed $forecast;
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

    public function setWalletName(null|string $walletName): void
    {
        $this->walletName = $walletName;
    }

    public function setWalletId(int $walletId): void
    {
        $this->walletId = $walletId;
    }

    public function getWalletName(): null|string
    {
        return $this->walletName;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function getAmount(): float|int
    {
        return $this->amount;
    }

    public function setAmount(float|int $amount): void
    {
        $this->amount = $amount;
    }

    public function getInstallments(): int
    {
        return $this->installments;
    }

    public function setInstallments(int $installments): void
    {
        $this->installments = $installments;
    }

    public function getForecast(): mixed
    {
        return $this->forecast;
    }

    public function setForecast(mixed $forecast): void
    {
        $this->forecast = $forecast;
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
