<?php

namespace App\VO;

class MovementVO
{
    public null|int $id;
    public int $walletId;
    public null|string $description;
    public int $type;
    public int|float $amount;
    public mixed $createdAt;
    public mixed $updatedAt;
}