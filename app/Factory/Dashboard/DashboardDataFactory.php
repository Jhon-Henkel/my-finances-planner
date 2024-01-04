<?php

namespace App\Factory\Dashboard;

use App\Factory\Dashboard\LastMovements\DashboardLastMovementsFactory;
use App\Tools\NumberTools;

class DashboardDataFactory implements DashboardFactoryInterface
{
    private float $walletBalance;
    private string $walletBalanceScClass;
    private array $movements;
    private array $futureSpent;
    private array $futureGain;
    private array $creditCards;
    private array $balances;
    private array $lastMovements;

    public function __construct(
        float $walletBalance,
        DashboardMovementDataFactory $movements,
        DashboardFutureMovementDataFactory $futureSpent,
        DashboardFutureMovementDataFactory $futureGain,
        DashboardFutureMovementDataFactory $creditCards,
        DashboardBalancesDataFactory $balances,
        DashboardLastMovementsFactory $lastMovements
    ) {
        $this->walletBalance = $walletBalance;
        $this->walletBalanceScClass = $walletBalance < 0 ? 'warning' : 'success';
        $this->movements = $movements->toArray();
        $this->futureSpent = $futureSpent->toArray();
        $this->futureGain = $futureGain->toArray();
        $this->creditCards = $creditCards->toArray();
        $this->balances = $balances->toArray();
        $this->lastMovements = $lastMovements->toArray();
    }

    protected function makeFutureSpentData(): float
    {
        $futureSpent = $this->futureSpent;
        $creditCards = $this->creditCards;
        $thisMonthSpent = $futureSpent['thisMonth'] + $creditCards['thisMonth'];

        return NumberTools::roundFloatAmount($thisMonthSpent);
    }

    public function toArray(): array
    {
        return [
            'walletBalance' => $this->walletBalance,
            'walletBalanceScClass' => $this->walletBalanceScClass,
            'movements' => $this->movements,
            'futureSpent' => $this->makeFutureSpentData(),
            'futureGain' => $this->futureGain,
            'creditCards' => $this->creditCards,
            'balances' => $this->balances,
            'lastMovements' => $this->lastMovements
        ];
    }
}