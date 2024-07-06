<?php

namespace App\VO;

class WalletVO
{
    public null|int $id;
    public null|string $name;
    public null|int $type;
    public null|float $amount;
    public mixed $createdAt;
    public mixed $updatedAt;

    public static function makeWalletVO(
        null|int $id,
        null|string $name,
        null|int $type,
        null|float $amount,
        mixed $createdAt,
        mixed $updatedAt
    ): self {
        $vo = new self();
        $vo->id = $id;
        $vo->name = $name;
        $vo->type = $type;
        $vo->amount = $amount;
        $vo->createdAt = $createdAt;
        $vo->updatedAt = $updatedAt;
        return $vo;
    }
}
