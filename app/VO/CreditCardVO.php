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
}