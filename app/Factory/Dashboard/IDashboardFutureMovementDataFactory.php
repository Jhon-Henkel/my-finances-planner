<?php

namespace App\Factory\Dashboard;

class IDashboardFutureMovementDataFactory implements IDashboardFactory
{
    private float $thisMonth;
    private float $thisYear;

    public function __construct(float $thisMonth, float $thisYear)
    {
        $this->thisMonth = $thisMonth;
        $this->thisYear = $thisYear;
    }

    public function toArray(): array
    {
        return [
            'thisMonth' => $this->thisMonth,
            'thisYear' => $this->thisYear,
        ];
    }
}