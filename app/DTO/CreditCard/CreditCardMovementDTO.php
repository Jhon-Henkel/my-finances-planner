<?php

namespace App\DTO\CreditCard;

class CreditCardMovementDTO 
{
    public function __construct(
        private ?int $id,
        private int $creditCardId,
        private string $description,
        private string $type,
        private float $amount,
        private mixed $createdAt = null,
        private mixed $updatedAt = null
    ) {
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCreditCardId(): int
    {
        return $this->creditCardId;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getAmount(): float
    {
        return $this->amount;
    }

    public function getCreatedAt(): mixed
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): mixed
    {
        return $this->updatedAt;
    }
}