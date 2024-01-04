<?php

namespace App\Factory\Dashboard\LastMovements;

use App\Enums\MovementEnum;
use App\Factory\Dashboard\DashboardFactoryInterface;
use App\VO\Movement\MovementVO;

readonly class DashboardLastMovementFactory implements DashboardFactoryInterface
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
            MovementEnum::TRANSFER => ['fas', 'building-columns'],
            MovementEnum::SPENT => ['fas', 'circle-arrow-down'],
            MovementEnum::GAIN => ['fas', 'circle-arrow-up'],
            MovementEnum::INVESTMENT_CDB => ['fas', 'piggy-bank'],
            default => [],
        };
    }

    protected function getCssClassForMovementType(): string
    {
        return match ($this->movementInput->type) {
            MovementEnum::TRANSFER => 'movement-transfer-icon',
            MovementEnum::SPENT => 'movement-spent-icon',
            MovementEnum::GAIN => 'movement-gain-icon',
            MovementEnum::INVESTMENT_CDB => 'movement-investment-icon',
            default => '',
        };
    }
}