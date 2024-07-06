<?php

namespace App\VO\Investment;

use App\DTO\Investment\InvestmentDTO;

class InvestmentVO
{
    public null|int $id;
    public null|int $creditCardId;
    public string $description;
    public int $type;
    public float $amount;
    public int $liquidity;
    public float $profitability;
    public mixed $createdAt;
    public mixed $updatedAt;

    public function __construct(InvestmentDTO $item)
    {
        $this->id = $item->getId();
        $this->creditCardId = $item->getCreditCardId();
        $this->description = $item->getDescription();
        $this->type = $item->getType();
        $this->amount = $item->getAmount();
        $this->liquidity = $item->getLiquidity();
        $this->profitability = $item->getProfitability();
        $this->createdAt = $item->getCreatedAt();
        $this->updatedAt = $item->getUpdatedAt();
    }
}
