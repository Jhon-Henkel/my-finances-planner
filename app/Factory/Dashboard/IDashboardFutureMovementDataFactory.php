<?php

namespace App\Factory\Dashboard;

readonly class IDashboardFutureMovementDataFactory implements IDashboardFactory
{
    public function __construct(
        private float $thisMonth,
        private float $thisYear
    ) {
    }

    public function toArray(): array
    {
        return [
            'thisMonth' => $this->thisMonth,
            'thisYear' => $this->thisYear,
        ];
    }
}