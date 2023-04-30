<?php

namespace App\VO;

class CreditCardVO
{
    public ?int $id;
    public string $name;
    public float $limit;
    public int $dueDate;
    public int $closingDay;
    public mixed $createdAt;
    public mixed $updatedAt;
    public null|float $totalValueSpending;
    public null|float $nextInvoiceValue;

    public static function makeCreditCardVO(
        ?int $id,
        string $name,
        float $limit,
        int $dueDate,
        int $closingDay,
        mixed $createdAt,
        mixed $updatedAt,
        null|float $totalValueSpending,
        null|float $nextInvoiceValue,
    ): self {
        $vo =  new self();
        $vo->id = $id;
        $vo->name = $name;
        $vo->limit = $limit;
        $vo->dueDate = $dueDate;
        $vo->closingDay = $closingDay;
        $vo->createdAt = $createdAt;
        $vo->updatedAt = $updatedAt;
        $vo->totalValueSpending = $totalValueSpending;
        $vo->nextInvoiceValue = $nextInvoiceValue;
        return $vo;
    }
}