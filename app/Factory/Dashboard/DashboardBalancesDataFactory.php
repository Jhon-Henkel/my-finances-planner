<?php

namespace App\Factory\Dashboard;

use App\Tools\NumberTools;

class DashboardBalancesDataFactory implements DashboardFactoryInterface
{
    private float $lastMonth;
    private float $thisMonth;
    private float $thisYear;

    public function __construct(
        float $lastMonthGainValue,
        float $lastMonthSpentValue,
        float $thisMonthGainValue,
        float $thisMonthSpentValue,
        float $thisYearGainValue,
        float $thisYearSpentValue
    ) {
        $this->addLastMonth($lastMonthGainValue, $lastMonthSpentValue);
        $this->addThisMonth($thisMonthGainValue, $thisMonthSpentValue);
        $this->addThisYear($thisYearGainValue, $thisYearSpentValue);
    }

    protected function addLastMonth(float $lastMonthGainValue, float $lastMonthSpentValue): void
    {
        $this->lastMonth = NumberTools::makeBalance($lastMonthGainValue, $lastMonthSpentValue);
    }

    protected function addThisMonth(float $thisMonthGainValue, float $thisMonthSpentValue): void
    {
        $this->thisMonth = NumberTools::makeBalance($thisMonthGainValue, $thisMonthSpentValue);
    }

    protected function addThisYear(float $thisYearGainValue, float $thisYearSpentValue): void
    {
        $this->thisYear = NumberTools::makeBalance($thisYearGainValue, $thisYearSpentValue);
    }

    public function toArray(): array
    {
        return [
            'lastMonth' => $this->lastMonth,
            'thisMonth' => $this->thisMonth,
            'thisYear' => $this->thisYear
        ];
    }
}