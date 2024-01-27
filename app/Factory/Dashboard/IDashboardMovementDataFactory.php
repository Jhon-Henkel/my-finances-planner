<?php

namespace App\Factory\Dashboard;

use App\Enums\MovementEnum;
use App\Factory\DataGraph\Movement\DataGraphMovementFactory;
use App\VO\Movement\MovementVO;

class IDashboardMovementDataFactory implements IDashboardFactory
{
    private float $lastMonthSpent;
    private float $thisMonthSpent;
    private float $lastMonthGain;
    private float $thisMonthGain;
    private float $thisYearSpent;
    private float $thisYearGain;
    private array $lastMovements;

    /** @param  MovementVO[]  $lastMovements */
    public function __construct(
        private readonly DataGraphMovementFactory $dataForGraph,
        array $lastMonthData,
        array $thisMonthData,
        array $thisYearData,
        array $lastMovements
    ) {
        $this->addLastMonthData($lastMonthData);
        $this->addThisMonthData($thisMonthData);
        $this->addThisYearData($thisYearData);
        $this->addLastMovements($lastMovements);
    }

    protected function addLastMonthData(array $lastMonthData): void
    {
        $data = $this->makeMovementValue($lastMonthData);
        $this->lastMonthSpent = $data['spent'];
        $this->lastMonthGain = $data['gain'];
    }

    protected function addThisMonthData(array $thisMonthData): void
    {
        $data = $this->makeMovementValue($thisMonthData);
        $this->thisMonthSpent = $data['spent'];
        $this->thisMonthGain = $data['gain'];
    }

    protected function addThisYearData(array $thisYearData): void
    {
        $data = $this->makeMovementValue($thisYearData);
        $this->thisYearSpent = $data['spent'];
        $this->thisYearGain = $data['gain'];
    }

    /** @param  MovementVO[]  $lastMovements */
    protected function addLastMovements(array $lastMovements): void
    {
        $this->lastMovements = $lastMovements;
    }

    protected function makeMovementValue(array $movementData): array
    {
        $gain = 0;
        $spent = 0;
        foreach ($movementData as $movement) {
            if ($movement['type'] == MovementEnum::Gain->value) {
                $gain += $movement['total'];
            } elseif ($movement['type'] == MovementEnum::Spent->value) {
                $spent += $movement['total'];
            }
        }
        return ['gain' => $gain, 'spent' => $spent];
    }

    public function toArray(): array
    {
        return [
            'dataForGraph' => $this->dataForGraph->getAllDataArray(),
            'lastMonthSpent' => $this->lastMonthSpent,
            'thisMonthSpent' => $this->thisMonthSpent,
            'thisYearSpent' => $this->thisYearSpent,
            'lastMonthGain' => $this->lastMonthGain,
            'thisMonthGain' => $this->thisMonthGain,
            'thisYearGain' => $this->thisYearGain,
            'lastMovements' => $this->lastMovements,
        ];
    }
}