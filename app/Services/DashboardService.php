<?php

namespace App\Services;

use App\Enums\MovementEnum;

class DashboardService
{
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
        return app(WalletService::class)->getTotalWalletValue();
    }

    protected function getMovementsData(): array
    {
        $movementService = app(MovementService::class);
        $lastMonth = $movementService->getMonthSumMovementsByOptionFilter(MovementEnum::FILTER_BY_LAST_MONTH);
        $thisMonth = $movementService->getMonthSumMovementsByOptionFilter(MovementEnum::FILTER_BY_THIS_MONTH);
        $thisYear = $movementService->getMonthSumMovementsByOptionFilter(MovementEnum::FILTER_BY_THIS_YEAR);
        $lastMovements = $movementService->getLastMovements(8);
        return [
            'lastMonthSpent' => isset($lastMonth[0]) ? $lastMonth[0]['total'] : 0,
            'thisMonthSpent' => isset($thisMonth[0]) ? $thisMonth[0]['total'] : 0,
            'thisYearSpent' => isset($thisYear[0]) ? $thisYear[0]['total'] : 0,
            'lastMonthGain' => isset($lastMonth[1]) ? $lastMonth[1]['total'] : 0,
            'thisMonthGain' => isset($thisMonth[1]) ? $thisMonth[1]['total'] : 0,
            'thisYearGain' => isset($thisYear[1]) ? $thisYear[1]['total'] : 0,
            'lastMovements' => $lastMovements,
            'dataForGraph' => $movementService->generateDataForGraph()
        ];
    }

    protected function getFutureSpentData(): array
    {
        $futureSpentService = app(FutureSpentService::class);
        return [
            'thisMonth' => $futureSpentService->getThisMonthFutureSpentSum(),
            'thisYear' => $futureSpentService->getThisYearFutureSpentSum(),
        ];
    }

    protected function getFutureGainData(): array
    {
        $futureSpentService = app(FutureGainService::class);
        return [
            'thisMonth' => $futureSpentService->getThisMonthFutureGainSum(),
            'thisYear' => $futureSpentService->getThisYearFutureGainSum(),
        ];
    }

    protected function getCreditCardsData(): array
    {
        $creditCardTransactionService = app(CreditCardTransactionService::class);
        return [
            'thisMonth' => $creditCardTransactionService->getThisMonthInvoiceSum(),
            'thisYear' => $creditCardTransactionService->getThisYearInvoiceSum(),
        ];
    }
}