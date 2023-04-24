<?php

namespace App\VO;

use App\DTO\FutureGainDTO;

class FutureGainVO
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

    public function __construct(FutureGainDTO $item)
    {
        $this->id = $item->getId();
        $this->walletId = $item->getWalletId();
        $this->walletName = $item->getWalletName();
        $this->description = $item->getDescription();
        $this->amount = $item->getAmount();
        $this->installments = $item->getInstallments();
        $this->forecast = $item->getForecast();
        $this->createdAt = $item->getCreatedAt();
        $this->updatedAt = $item->getUpdatedAt();
        return $this;
    }
}