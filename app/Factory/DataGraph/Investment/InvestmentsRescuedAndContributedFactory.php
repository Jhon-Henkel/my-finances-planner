<?php

namespace App\Factory\DataGraph\Investment;

use App\DTO\Movement\MovementDTO;

class InvestmentsRescuedAndContributedFactory
{
    private array $data = [];

    public function addInvestmentToData(MovementDTO $investment): void
    {
        $key = substr($investment->getCreatedAt(), 0, 7);
        if (! isset($this->data[$key])) {
            $this->data[$key] = [
                'rescued' => $investment->isRescuedInvestmentType() ? $investment->getAmount() : 0,
                'contributed' => $investment->isApportInvestmentType() ? $investment->getAmount() : 0
            ];
            return;
        };
        if ($investment->isRescuedInvestmentType()) {
            $this->data[$key]['rescued'] += $investment->getAmount();
        } elseif ($investment->isApportInvestmentType()) {
            $this->data[$key]['contributed'] += $investment->getAmount();
        }
    }

    public function getAllDataArray(): array
    {
        return [
            'rescued' => array_values(array_map(fn ($data) => $data['rescued'], $this->data)),
            'contributed' => array_values(array_map(fn ($data) => $data['contributed'], $this->data)),
            'labels' => array_keys($this->data)
        ];
    }
}