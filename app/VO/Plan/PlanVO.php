<?php

namespace App\VO\Plan;

use App\DTO\Plan\PlanDTO;

class PlanVO
{
    public int|null $id;
    public string $name;
    public int $walletLimit;
    public int $creditCardLimit;

    public function __construct(PlanDTO $dto)
    {
        $this->id = $dto->getId();
        $this->name = $dto->getName();
        $this->walletLimit = $dto->getWalletLimit();
        $this->creditCardLimit = $dto->getCreditCardLimit();
    }
}
