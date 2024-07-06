<?php

namespace App\Factory\Dashboard\LastMovements;

use App\Factory\Dashboard\IDashboardFactory;

class IDashboardLastMovementsFactory implements IDashboardFactory
{
    private array $lastMovements = [];

    public function addLastMovement(IDashboardLastMovementFactory $lastMovement): void
    {
        $this->lastMovements[] = $lastMovement->toArray();
    }

    public function toArray(): array
    {
        return $this->lastMovements;
    }
}
