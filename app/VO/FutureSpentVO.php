<?php

namespace App\VO;

use App\DTO\FutureMovement\FutureSpentDTO;

class FutureSpentVO
{
    public null|int $id;
    public int $walletId;
    public null|string $walletName;
    public string $description;
    public float|int $amount;
    public int $installments;
    public mixed $forecast;
    public mixed $createdAt;
    public mixed $updatedAt;
    public null|string $bankSlipCode;

    public function __construct(FutureSpentDTO $item)
    {
        $this->id = $item->getId();
        $this->walletName = $item->getWalletName();
        $this->walletId = $item->getWalletId();
        $this->amount = $item->getAmount();
        $this->description = $item->getDescription();
        $this->installments = $item->getInstallments();
        $this->forecast = $item->getForecast();
        $this->createdAt = $item->getCreatedAt();
        $this->updatedAt = $item->getUpdatedAt();
        $this->bankSlipCode = $item->getBankSlipCode();
    }
}
