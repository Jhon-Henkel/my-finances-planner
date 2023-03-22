<?php

namespace App\DTO;

class FutureGainDTO
{
    private null|int $id;
    private int $walletId;
    private string $description;
    private float|int $amount;
    private mixed $forecast;
    private mixed $createdAt;
    private mixed $updateddAt;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     */
    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function getWalletId(): int
    {
        return $this->walletId;
    }

    /**
     * @param int $walletId
     */
    public function setWalletId(int $walletId): void
    {
        $this->walletId = $walletId;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    /**
     * @return float|int
     */
    public function getAmount(): float|int
    {
        return $this->amount;
    }

    /**
     * @param float|int $amount
     */
    public function setAmount(float|int $amount): void
    {
        $this->amount = $amount;
    }

    /**
     * @return mixed
     */
    public function getForecast(): mixed
    {
        return $this->forecast;
    }

    /**
     * @param mixed $forecast
     */
    public function setForecast(mixed $forecast): void
    {
        $this->forecast = $forecast;
    }

    /**
     * @return mixed
     */
    public function getCreatedAt(): mixed
    {
        return $this->createdAt;
    }

    /**
     * @param mixed $createdAt
     */
    public function setCreatedAt(mixed $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return mixed
     */
    public function getUpdateddAt(): mixed
    {
        return $this->updateddAt;
    }

    /**
     * @param mixed $updateddAt
     */
    public function setUpdateddAt(mixed $updateddAt): void
    {
        $this->updateddAt = $updateddAt;
    }
}