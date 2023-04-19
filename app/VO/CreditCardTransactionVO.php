<?php

namespace App\VO;

class CreditCardTransactionVO
{
    public ?int $id;
    public string $name;
    public float $value;
    public int $installments;
    public string $firstInstallment;
    public int $creditCardId;
    public ?string $createdAt;
    public ?string $updatedAt;

    public static function makeCreditCardTransactionVO(
        ?int $id,
        string $name,
        float $value,
        int $installments,
        string $firstInstallment,
        int $creditCardId,
        ?string $createdAt,
        ?string $updatedAt
    ): CreditCardTransactionVO {
        $vo = new self();
        $vo->id = $id;
        $vo->name = $name;
        $vo->value = $value;
        $vo->installments = $installments;
        $vo->firstInstallment = $firstInstallment;
        $vo->creditCardId = $creditCardId;
        $vo->createdAt = $createdAt;
        $vo->updatedAt = $updatedAt;
        return $vo;
    }
}