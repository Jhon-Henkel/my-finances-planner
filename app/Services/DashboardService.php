<?php

namespace App\Services;

use App\Enums\MovementEnum;
use App\Services\CreditCard\CreditCardTransactionService;
use App\Services\Movement\MovementService;

class DashboardService
{
    public function __construct(
        protected WalletService $walletService,
        protected MovementService $movementService,
        protected FutureSpentService $futureSpentService,
        protected FutureGainService $futureGainService,
        protected CreditCardTransactionService $creditCardTransactionService
    ) {
    }

    public function getDashboardData(): array
    {
        return [
            'walletBalance' => $this->getWalletBalance(),
            'movements' => $this->getMovementsData(),
            'futureSpent' => $this->getFutureSpentData(),
            'futureGain' => $this->getFutureGainData(),
            'creditCards' => $this->getCreditCardsData(),
        ];
    }

    protected function getWalletBalance(): float
    {
        return $this->walletService->getTotalWalletValue();
    }

    protected function getMovementsData(): array
    {
        $lastMonth = $this->movementService->getMonthSumMovementsByOptionFilter(MovementEnum::FILTER_BY_LAST_MONTH);
        $thisMonth = $this->movementService->getMonthSumMovementsByOptionFilter(MovementEnum::FILTER_BY_THIS_MONTH);
        $thisYear = $this->movementService->getMonthSumMovementsByOptionFilter(MovementEnum::FILTER_BY_THIS_YEAR);
        $lastMovements = $this->movementService->getLastMovements(8);
        return [
            'lastMonthSpent' => isset($lastMonth[0]) ? $lastMonth[0]['total'] : 0,
            'thisMonthSpent' => isset($thisMonth[0]) ? $thisMonth[0]['total'] : 0,
            'thisYearSpent' => isset($thisYear[0]) ? $thisYear[0]['total'] : 0,
            'lastMonthGain' => isset($lastMonth[1]) ? $lastMonth[1]['total'] : 0,
            'thisMonthGain' => isset($thisMonth[1]) ? $thisMonth[1]['total'] : 0,
            'thisYearGain' => isset($thisYear[1]) ? $thisYear[1]['total'] : 0,
            'lastMovements' => $lastMovements,
            'dataForGraph' => $this->movementService->generateDataForGraph()
        ];
    }

    protected function getFutureSpentData(): array
    {
        return [
            'thisMonth' => $this->futureSpentService->getThisMonthFutureSpentSum(),
            'thisYear' => $this->futureSpentService->getThisYearFutureSpentSum(),
        ];
    }

    protected function getFutureGainData(): array
    {
        return [
            'thisMonth' => $this->futureGainService->getThisMonthFutureGainSum(),
            'thisYear' => $this->futureGainService->getThisYearFutureGainSum(),
        ];
    }

    protected function getCreditCardsData(): array
    {
        return [
            'thisMonth' => $this->creditCardTransactionService->getThisMonthInvoiceSum(),
            'thisYear' => $this->creditCardTransactionService->getThisYearInvoiceSum(),
        ];
    }
}