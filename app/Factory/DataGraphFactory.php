<?php

namespace App\Factory;

use App\Enums\MovementEnum;
use App\Exceptions\CountGainAndExpenseDataGraphException;

class DataGraphFactory
{
    private array $gainData = [];
    private array $spentData = [];
    private array $balanceData = [];
    private array $labels = [];

    public function addLabel(string $label): void
    {
        if (! in_array($label, $this->labels)) {
            $this->labels[] = $label;
        }
    }

    public function addValue(int $type, float $value): void
    {
        if ($type == MovementEnum::GAIN) {
            $this->gainData[] = $value;
        } elseif ($type == MovementEnum::SPENT) {
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

    /**
     * @throws CountGainAndExpenseDataGraphException
     */
    protected function makeBalanceData(): void
    {
        $this->validateHaveSameSize();
        for ($index = 0; $index < count($this->gainData); $index++) {
            $this->balanceData[] = round($this->gainData[$index] - $this->spentData[$index], 2);
        }
    }

    protected function validateHaveSameSize(): void
    {
        if (count($this->gainData) != count($this->spentData)) {
            throw new CountGainAndExpenseDataGraphException();
        }
    }
}