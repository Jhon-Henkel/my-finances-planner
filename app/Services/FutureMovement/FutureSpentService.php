<?php

namespace App\Services\FutureMovement;

use App\DTO\FutureMovement\FutureSpentDTO;
use App\DTO\FutureMovement\IFutureMovementDTO;
use App\Factory\InvoiceFactory;
use App\Repositories\FutureSpentRepository;
use App\Resources\FutureSpentResource;
use App\Services\BasicService;
use App\Services\Movement\MovementService;
use App\Services\Tools\MarketPlannerService;
use App\Tools\Calendar\CalendarTools;

class FutureSpentService extends BasicService
{
    use FutureMovementTrait;

    public function __construct(
        private readonly FutureSpentRepository $repository,
        private readonly MarketPlannerService $marketPlannerService,
        private readonly FutureSpentResource $resource,
        private readonly MovementService $movementService
    ) {
    }

    protected function getRepository(): FutureSpentRepository
    {
        return $this->repository;
    }

    public function getNextSixMonthsFutureSpent(): array
    {
        $month = CalendarTools::getThisMonth();
        $year = CalendarTools::getThisYear();
        $period = CalendarTools::getIntervalMonthPeriodByMonthAndYear($month, $year, 6);
        $spending = $this->getRepository()->findByPeriod($period);
        $spentPackage = [];
        foreach ($spending as $spent) {
            $invoice = $this->resource->futureSpentToInvoiceDTO($spent);
            $spentPackage[] = InvoiceFactory::factoryInvoice($invoice, CalendarTools::getThisMonth());
        }
        if ($this->marketPlannerService->useMarketPlanner()) {
            $spentPackage[] = $this->marketPlannerService->getMarketPlannerInvoice();
        }
        return $spentPackage;
    }

    public function paySpent(FutureSpentDTO $spent, array $options): bool
    {
        $isEqualsValue = $options['value'] === $spent->getAmount();
        $isEqualsWallet = $options['walletId'] === $spent->getWalletId();
        if (! $options['partial'] && $isEqualsValue && $isEqualsWallet) {
            return $this->payFullSpent($spent);
        }
        return $this->payWithOptions($spent, $options);
    }

    protected function payFullSpent(FutureSpentDTO $spent): bool
    {
        $movement = $this->movementService->populateByFutureSpent($spent);
        if (! $this->movementService->insert($movement)) {
            return false;
        }
        return $this->updateRemainingInstallments($spent);
    }

    protected function payWithOptions(FutureSpentDTO $spent, array $options): bool
    {
        $isEqualsValue = $options['value'] === $spent->getAmount();
        $isEqualsWallet = $options['walletId'] === $spent->getWalletId();
        $value = $isEqualsValue ? $spent->getAmount() : $options['value'];
        $walletId = $isEqualsWallet ? $spent->getWalletId() : $options['walletId'];
        if ($options['partial'] && $options['value'] < $spent->getAmount()) {
            $newSpent = $this->makeSpentForParcialPay($spent, $spent->getAmount() - $value);
            $this->insert($newSpent);
        }
        $movement = $this->movementService->populateByFutureSpent($spent);
        $movement->setAmount($value);
        $movement->setWalletId($walletId);
        $description = $movement->getDescription();
        if ($options['partial']) {
            $description = 'Pagamento parcial ' . strtolower($spent->getDescription());
        }
        $movement->setDescription($description);
        if (! $this->movementService->insert($movement)) {
            return false;
        }
        return $this->updateRemainingInstallments($spent);
    }

    protected function makeSpentForParcialPay(FutureSpentDTO $spent, float $value): IFutureMovementDTO
    {
        $description = str_replace('Restante ', '', strtolower($spent->getDescription()));
        return $this->makeFutureMovementForParcialReceive($spent, $value, 'Restante ' . $description);
    }

    public function getThisYearFutureSpentSum(): float
    {
        $period = CalendarTools::getThisYearPeriod();
        $spending = $this->getRepository()->findByPeriod($period);
        $total = 0;
        foreach ($spending as $spent) {
            $total += ($spent->getAmount() * ($spent->getInstallments() === 0 ? 1 : $spent->getInstallments()));
        }
        return $total;
    }

    public function getThisMonthFutureSpentSum(): float
    {
        $period = CalendarTools::getThisMonthPeriod();
        $spending = $this->getRepository()->findByPeriod($period);
        $total = 0;
        foreach ($spending as $spent) {
            $total += $spent->getAmount();
        }
        if ($this->marketPlannerService->useMarketPlanner()) {
            $total += $this->marketPlannerService->getMarketPlannerInvoice()->firstInstallment;
        }
        return $total;
    }
}
