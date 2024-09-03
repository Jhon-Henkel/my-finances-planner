<?php

namespace App\Exceptions\Plan;

use App\Enums\Gates\GatesAbilityEnum;
use App\Exceptions\ResponseExceptions\ForbiddenException;
use App\Models\CreditCard;
use App\Models\WalletModel;
use Illuminate\Support\Facades\Gate;

class LimitExceededException extends ForbiddenException
{
    public function __construct(string $type)
    {
        return parent::__construct("Limite de '$type' atingido para o seu plano.");
    }

    public static function validateExceeded(GatesAbilityEnum $ability, string $model): void
    {
        if (Gate::denies($ability->value, $model)) {
            match ($model) {
                WalletModel::class => throw new self('carteiras'),
                CreditCard::class => throw new self('cartão de crédito'),
                default => throw new self(''),
            };
        }
    }
}
