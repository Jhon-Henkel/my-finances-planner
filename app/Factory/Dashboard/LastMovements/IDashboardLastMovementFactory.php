<?php

namespace App\Factory\Dashboard\LastMovements;

use App\Enums\MovementEnum;
use App\Factory\Dashboard\IDashboardFactory;
use App\VO\Movement\MovementVO;

readonly class IDashboardLastMovementFactory implements IDashboardFactory
{
    public function __construct(private MovementVO $movementInput)
    {
    }

    public function toArray(): array
    {
        return [
            'date' => $this->movementInput->createdAt,
            'typeIcon' => $this->getIconForMovementType(),
            'description' => $this->movementInput->walletName,
            'value' => $this->movementInput->amount,
            'cssClass' => $this->getCssClassForMovementType(),
        ];
    }

    protected function getIconForMovementType(): array
    {
        return match ($this->movementInput->type) {
            MovementEnum::Transfer->value => ['fas', 'building-columns'],
            MovementEnum::Spent->value => ['fas', 'circle-arrow-down'],
            MovementEnum::Gain->value => ['fas', 'circle-arrow-up'],
            MovementEnum::InvestmentCdb->value => ['fas', 'piggy-bank'],
            default => [],
        };
    }

    protected function getCssClassForMovementType(): string
    {
        return match ($this->movementInput->type) {
            MovementEnum::Transfer->value => 'movement-transfer-icon',
            MovementEnum::Spent->value => 'movement-spent-icon',
            MovementEnum::Gain->value => 'movement-gain-icon',
            MovementEnum::InvestmentCdb->value => 'movement-investment-icon',
            default => '',
        };
    }
}