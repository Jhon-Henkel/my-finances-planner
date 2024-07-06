<?php

namespace App\Factory\DataGraph\Investment;

use App\Factory\DataGraph\DataGraphInterface;

class DataGraphInvestmentFactory implements DataGraphInterface
{
    private float $value = 0;
    private string $label = '';

    public function addLabel(string $label): void
    {
        $this->label = $label;
    }

    public function addValue(float $value): void
    {
        $this->value += $value;
    }

    public function getAllDataArray(): array
    {
        return [
            'label' => $this->label,
            'value' => $this->value,
        ];
    }
}
