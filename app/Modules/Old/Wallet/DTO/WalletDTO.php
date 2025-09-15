<?php

namespace App\Modules\Old\Wallet\DTO;

use App\Infra\Enum\StatusActiveInactiveEnum;
use App\Modules\Old\Wallet\Enum\WalletTypeEnum;

class WalletDTO
{
    private null|int $id;
    private string $name;
    private int $type = WalletTypeEnum::Other->value;
    private null|bool $movementAlreadyDone = false;
    private float|int $amount;
    private int $hideValue = StatusActiveInactiveEnum::Inactive->value;
    private int $status = StatusActiveInactiveEnum::Active->value;
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

    public function setHideValue(int $hideValue): void
    {
        $this->hideValue = $hideValue;
    }

    public function getHideValue(): int
    {
        return $this->hideValue;
    }

    public function setStatus(int $status): void
    {
        $this->status = $status;
    }

    public function getStatus(): int
    {
        return $this->status;
    }

    public function mustHideValue(): bool
    {
        return $this->hideValue == StatusActiveInactiveEnum::Active->value;
    }

    public function isInactive(): bool
    {
        return $this->status == StatusActiveInactiveEnum::Inactive->value;
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
