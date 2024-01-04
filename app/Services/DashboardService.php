<?php

namespace App\Services;

use App\Enums\MovementEnum;
use App\Factory\Dashboard\DashboardBalancesDataFactory;
use App\Factory\Dashboard\DashboardDataFactory;
use App\Factory\Dashboard\DashboardFutureMovementDataFactory;
use App\Factory\Dashboard\DashboardMovementDataFactory;
use App\Factory\Dashboard\LastMovements\DashboardLastMovementFactory;
use App\Factory\Dashboard\LastMovements\DashboardLastMovementsFactory;
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
        $movementData = $this->getMovementsData();
        $data = new DashboardDataFactory(
            $this->walletService->getTotalWalletValue(),
            $movementData,
            $this->getFutureSpentData(),
            $this->getFutureGainData(),
            $this->getCreditCardsData(),
            $this->getBalancesData($movementData),
            $this->getLastMovementsData($movementData)
        );
        return $data->toArray();
    }

    protected function getMovementsData(): DashboardMovementDataFactory
    {
        return new DashboardMovementDataFactory(
            $this->movementService->generateDataForGraph(),
            $this->movementService->getMonthSumMovementsByOptionFilter(MovementEnum::FILTER_BY_LAST_MONTH),
            $this->movementService->getMonthSumMovementsByOptionFilter(MovementEnum::FILTER_BY_THIS_MONTH),
            $this->movementService->getMonthSumMovementsByOptionFilter(MovementEnum::FILTER_BY_THIS_YEAR),
            $this->movementService->getLastMovements(8)
        );
    }

    protected function getFutureSpentData(): DashboardFutureMovementDataFactory
    {
        return new DashboardFutureMovementDataFactory(
            $this->futureSpentService->getThisMonthFutureSpentSum(),
            $this->futureSpentService->getThisYearFutureSpentSum()
        );
    }

    protected function getFutureGainData(): DashboardFutureMovementDataFactory
    {
        return new DashboardFutureMovementDataFactory(
            $this->futureGainService->getThisMonthFutureGainSum(),
            $this->futureGainService->getThisYearFutureGainSum()
        );
    }

    protected function getCreditCardsData(): DashboardFutureMovementDataFactory
    {
        return new DashboardFutureMovementDataFactory(
            $this->creditCardTransactionService->getThisMonthInvoiceSum(),
            $this->creditCardTransactionService->getThisYearInvoiceSum()
        );
    }

    protected function getBalancesData(DashboardMovementDataFactory $movementsData): DashboardBalancesDataFactory
    {
        $MovementsDataArray = $movementsData->toArray();
        return new DashboardBalancesDataFactory(
            $MovementsDataArray['lastMonthGain'],
            $MovementsDataArray['lastMonthSpent'],
            $MovementsDataArray['thisMonthGain'],
            $MovementsDataArray['thisMonthSpent'],
            $MovementsDataArray['thisYearGain'],
            $MovementsDataArray['thisYearSpent']
        );
    }

    protected function getLastMovementsData(DashboardMovementDataFactory $lastMovements): DashboardLastMovementsFactory
    {
        $lastMovements = $lastMovements->toArray()['lastMovements'];
        $movementsData = new DashboardLastMovementsFactory();
        foreach ($lastMovements as $lastMovement) {
            $movementData = new DashboardLastMovementFactory($lastMovement);
            $movementsData->addLastMovement($movementData);
        }
        return $movementsData;
    }
}