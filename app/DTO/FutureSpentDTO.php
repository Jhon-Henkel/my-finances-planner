<?php

namespace App\DTO;

class FutureSpentDTO
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
     * @param string|null $walletName
     */
    public function setWalletName(?string $walletName): void
    {
        $this->walletName = $walletName;
    }

    /**
     * @param int $walletId
     */
    public function setWalletId(int $walletId): void
    {
        $this->walletId = $walletId;
    }

    /**
     * @return string|null
     */
    public function getWalletName(): ?string
    {
        return $this->walletName;
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
     * @return int
     */
    public function getInstallments(): int
    {
        return $this->installments;
    }

    /**
     * @param int $installments
     */
    public function setInstallments(int $installments): void
    {
        $this->installments = $installments;
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
    public function getUpdatedAt(): mixed
    {
        return $this->updatedAt;
    }

    /**
     * @param mixed $updatedAt
     */
    public function setUpdatedAt(mixed $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }
}