<?php

namespace App\VO\CreditCard;

class CreditCardVO
{
    public ?int $id;
    public string $name;
    public float $limit;
    public int|string $dueDate;
    public int|string $closingDay;
    public mixed $createdAt;
    public mixed $updatedAt;
    public null|bool $isThinsMouthInvoicePayed;
    public null|float $totalValueSpending;
    public null|float $nextInvoiceValue;
    public bool $active;

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
        null|bool $isThinsMouthInvoicePayed,
        bool $active,
    ): self {
        $vo =  new self();
        $vo->id = $id;
        $vo->name = $name;
        $vo->limit = $limit;
        $vo->dueDate = str_pad((string)$dueDate, 2, '0', STR_PAD_LEFT);
        $vo->closingDay = str_pad((string)$closingDay, 2, '0', STR_PAD_LEFT);
        $vo->createdAt = $createdAt;
        $vo->updatedAt = $updatedAt;
        $vo->totalValueSpending = $totalValueSpending;
        $vo->nextInvoiceValue = $nextInvoiceValue;
        $vo->isThinsMouthInvoicePayed = $isThinsMouthInvoicePayed;
        $vo->active = $active;
        return $vo;
    }
}
