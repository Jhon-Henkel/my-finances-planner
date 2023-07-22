<?php

namespace App\VO\CreditCard;

class CreditCardTransactionVO
{
    public ?int $id;
    public string $name;
    public float $value;
    public int $installments;
    public string $nextInstallment;
    public int $creditCardId;
    public mixed $createdAt;
    public mixed $updatedAt;

    public static function makeCreditCardTransactionVO(
        ?int $id,
        string $name,
        float $value,
        int $installments,
        string $nextInstallment,
        int $creditCardId,
        mixed $createdAt,
        mixed $updatedAt
    ): self {
        $vo = new self();
        $vo->id = $id;
        $vo->name = $name;
        $vo->value = $value;
        $vo->installments = $installments;
        $vo->nextInstallment = $nextInstallment;
        $vo->creditCardId = $creditCardId;
        $vo->createdAt = $createdAt;
        $vo->updatedAt = $updatedAt;
        return $vo;
    }
}