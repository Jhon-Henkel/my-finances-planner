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
            'lastMonthSpent' => $lastMonth[0]['total'],
            'thisMonthSpent' => $thisMonth[0]['total'],
            'thisYearSpent' => $thisYear[0]['total'],
            'lastMonthGain' => $lastMonth[1]['total'],
            'thisMonthGain' => $thisMonth[1]['total'],
            'thisYearGain' => $thisYear[1]['total'],
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