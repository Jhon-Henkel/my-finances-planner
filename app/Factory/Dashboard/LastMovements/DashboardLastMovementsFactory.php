<?php

namespace App\Factory\Dashboard\LastMovements;

use App\Factory\Dashboard\DashboardFactoryInterface;

class DashboardLastMovementsFactory implements DashboardFactoryInterface
{
    private array $lastMovements = [];

    public function addLastMovement(DashboardLastMovementFactory $lastMovement): void
    {
        $this->lastMovements[] = $lastMovement->toArray();
    }

    public function toArray(): array
    {
        return $this->lastMovements;
    }
}