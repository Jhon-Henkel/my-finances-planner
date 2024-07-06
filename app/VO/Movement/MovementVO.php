<?php

namespace App\VO\Movement;

class MovementVO
{
    public null|int $id;
    public int $walletId;
    public null|string $walletName;
    public null|string $description;
    public int $type;
    public int|float $amount;
    public mixed $createdAt;
    public mixed $updatedAt;
}
