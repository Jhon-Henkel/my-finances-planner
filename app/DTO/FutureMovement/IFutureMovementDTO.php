<?php

namespace App\DTO\FutureMovement;

interface IFutureMovementDTO
{
    public function getId(): null|int;
    public function setId(null|int $id): void;
    public function getWalletId(): int;
    public function setWalletName(null|string $walletName): void;
    public function setWalletId(int $walletId): void;
    public function getWalletName(): null|string;
    public function getDescription(): string;
    public function setDescription(string $description): void;
    public function getAmount(): float|int;
    public function setAmount(float|int $amount): void;
    public function getInstallments(): int;
    public function setInstallments(int $installments): void;
    public function getForecast(): mixed;
    public function setForecast(mixed $forecast): void;
    public function getCreatedAt(): mixed;
    public function setCreatedAt(null|string $createdAt): void;
    public function getUpdatedAt(): mixed;
    public function setUpdatedAt(null|string $updatedAt): void;
}