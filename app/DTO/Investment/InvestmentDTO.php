<?php

namespace App\DTO\Investment;

class InvestmentDTO
{
    public function __construct(
        readonly private ?int $id,
        private ?int $creditCardId,
        private string $description,
        readonly private int $type,
        private float $amount,
        private int $liquidity,
        private float $profitability,
        readonly private mixed $createdAt,
        readonly private mixed $updatedAt
    ) {
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCreditCardId(): ?int
    {
        return $this->creditCardId;
    }

    public function setCreditCardId(?int $creditCardId): void
    {
        $this->creditCardId = $creditCardId;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function getType(): int
    {
        return $this->type;
    }

    public function getAmount(): float
    {
        return $this->amount;
    }

    public function setAmount(float $amount): void
    {
        $this->amount = $amount;
    }

    public function getLiquidity(): int
    {
        return $this->liquidity;
    }

    public function setLiquidity(int $liquidity): void
    {
        $this->liquidity = $liquidity;
    }

    public function getProfitability(): float
    {
        return $this->profitability;
    }

    public function setProfitability(float $profitability): void
    {
        $this->profitability = $profitability;
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