<?php

namespace App\DTO\Plan;

class PlanDTO
{
    public function __construct(
        public int|null $id,
        public string $name,
        public int $walletLimit,
        public int $creditCardLimit
    ) {
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getWalletLimit(): int
    {
        return $this->walletLimit;
    }

    public function getCreditCardLimit(): int
    {
        return $this->creditCardLimit;
    }


}
