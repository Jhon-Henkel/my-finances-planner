<?php

namespace App\Factory\DataGraph\Movement;

use App\Enums\MovementEnum;
use App\Exceptions\CountGainAndExpenseDataGraphException;
use App\Factory\DataGraph\DataGraphInterface;

class DataGraphMovementFactory implements DataGraphInterface
{
    private array $gainData = [];
    private array $spentData = [];
    private array $balanceData = [];
    private array $labels = [];

    private const SAME_SIZE = 0;

    public function addLabel(string $label): void
    {
        if (! in_array($label, $this->labels)) {
            $this->labels[] = $label;
        }
    }

    public function addValue(int $type, float $value): void
    {
        if ($type == MovementEnum::Gain->value) {
            $this->gainData[] = $value;
        } elseif ($type == MovementEnum::Spent->value) {
            $this->spentData[] = $value;
        }
    }

    public function getAllDataArray(): array
    {
        $this->makeBalanceData();
        return [
            'labels' => $this->labels,
            'gainData' => $this->gainData,
            'spentData' => $this->spentData,
            'balanceData' => $this->balanceData
        ];
    }

    /** @throws CountGainAndExpenseDataGraphException */
    protected function makeBalanceData(): void
    {
        $this->validateHaveSameSize();
        for ($index = 0; $index < count($this->gainData); $index++) {
            $this->balanceData[] = round($this->gainData[$index] - $this->spentData[$index], 2);
        }
    }

    protected function validateHaveSameSize(): void
    {
        $diffSize = $this->countDiff();
        if ($diffSize < self::SAME_SIZE) {
            for ($index = 0; $index < abs($diffSize); $index++) {
                $this->gainData[] = 0;
            }
        } elseif ($diffSize > self::SAME_SIZE) {
            for ($index = 0; $index < abs($diffSize); $index++) {
                $this->spentData[] = 0;
            }
        }
        $diffSize = $this->countDiff();
        if ($diffSize != self::SAME_SIZE) {
            throw new CountGainAndExpenseDataGraphException();
        }
    }

    protected function countDiff(): int
    {
        return count($this->gainData) - count($this->spentData);
    }
}
