<?php

namespace App\Services;

use App\Enums\MovementEnum;
use App\Factory\Dashboard\IDashboardBalancesDataFactory;
use App\Factory\Dashboard\IDashboardDataFactory;
use App\Factory\Dashboard\IDashboardFutureMovementDataFactory;
use App\Factory\Dashboard\IDashboardMovementDataFactory;
use App\Factory\Dashboard\LastMovements\IDashboardLastMovementFactory;
use App\Factory\Dashboard\LastMovements\IDashboardLastMovementsFactory;
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
        $data = new IDashboardDataFactory(
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

    protected function getMovementsData(): IDashboardMovementDataFactory
    {
        return new IDashboardMovementDataFactory(
            $this->movementService->generateDataForGraph(),
            $this->movementService->getMonthSumMovementsByOptionFilter(MovementEnum::FilterByLastMonth->value),
            $this->movementService->getMonthSumMovementsByOptionFilter(MovementEnum::FilterByThisMonth->value),
            $this->movementService->getMonthSumMovementsByOptionFilter(MovementEnum::FilterByThisYear->value),
            $this->movementService->getLastMovements(8)
        );
    }

    protected function getFutureSpentData(): IDashboardFutureMovementDataFactory
    {
        return new IDashboardFutureMovementDataFactory(
            $this->futureSpentService->getThisMonthFutureSpentSum(),
            $this->futureSpentService->getThisYearFutureSpentSum()
        );
    }

    protected function getFutureGainData(): IDashboardFutureMovementDataFactory
    {
        return new IDashboardFutureMovementDataFactory(
            $this->futureGainService->getThisMonthFutureGainSum(),
            $this->futureGainService->getThisYearFutureGainSum()
        );
    }

    protected function getCreditCardsData(): IDashboardFutureMovementDataFactory
    {
        return new IDashboardFutureMovementDataFactory(
            $this->creditCardTransactionService->getThisMonthInvoiceSum(),
            $this->creditCardTransactionService->getThisYearInvoiceSum()
        );
    }

    protected function getBalancesData(IDashboardMovementDataFactory $movementsData): IDashboardBalancesDataFactory
    {
        $MovementsDataArray = $movementsData->toArray();
        return new IDashboardBalancesDataFactory(
            $MovementsDataArray['lastMonthGain'],
            $MovementsDataArray['lastMonthSpent'],
            $MovementsDataArray['thisMonthGain'],
            $MovementsDataArray['thisMonthSpent'],
            $MovementsDataArray['thisYearGain'],
            $MovementsDataArray['thisYearSpent']
        );
    }

    protected function getLastMovementsData(IDashboardMovementDataFactory $lastMovements): IDashboardLastMovementsFactory
    {
        $lastMovements = $lastMovements->toArray()['lastMovements'];
        $movementsData = new IDashboardLastMovementsFactory();
        foreach ($lastMovements as $lastMovement) {
            $movementData = new IDashboardLastMovementFactory($lastMovement);
            $movementsData->addLastMovement($movementData);
        }
        return $movementsData;
    }
}