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

    public static function makeCreditCardVO(
        ?int $id,
        string $name,
        float $limit,
        int $dueDate,
        int $closingDay,
        mixed $createdAt,
        mixed $updatedAt
    ): self {
        $vo =  new self();
        $vo->id = $id;
        $vo->name = $name;
        $vo->limit = $limit;
        $vo->dueDate = $dueDate;
        $vo->closingDay = $closingDay;
        $vo->createdAt = $createdAt;
        $vo->updatedAt = $updatedAt;
        return $vo;
    }
}