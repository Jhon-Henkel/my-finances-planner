<?php

namespace App\Services;

use App\DTO\FutureSpentDTO;
use App\Enums\InvoiceEnum;
use App\Factory\InvoiceFactory;
use App\Repositories\FutureSpentRepository;
use App\Resources\FutureSpentResource;
use App\Services\Movement\MovementService;
use App\Services\Tools\MarketPlannerService;
use App\Tools\Calendar\CalendarTools;

class FutureSpentService extends BasicService
{
    protected FutureSpentRepository $repository;
    protected FutureSpentResource $resource;

    public function __construct(
        FutureSpentRepository $repository,
        readonly private MarketPlannerService $marketPlannerService
    ) {
        $this->repository = $repository;
        $this->resource = app(FutureSpentResource::class);
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
            if (! $invoice) {
                continue;
            }
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
        $movementService = app(MovementService::class);
        $movement = $movementService->populateByFutureSpent($spent);
        if (! $movementService->insert($movement)) {
            return false;
        }
        return $this->updateRemainingInstallments($spent);
    }

    protected function updateRemainingInstallments(FutureSpentDTO $spent): bool
    {
        $remainingInstallments = $spent->getInstallments() - 1;
        if ($remainingInstallments === 0) {
            return $this->getRepository()->deleteById($spent->getId());
        }
        if ($remainingInstallments < 0) {
            $remainingInstallments = InvoiceEnum::FIXED_INSTALLMENTS;
        }
        $spent->setInstallments($remainingInstallments);
        $spent->setForecast(CalendarTools::addMonthInDate($spent->getForecast(), 1));
        return (bool)$this->getRepository()->update($spent->getId(), $spent);
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
        $movementService = app(MovementService::class);
        $movement = $movementService->populateByFutureSpent($spent);
        $movement->setAmount($value);
        $movement->setWalletId($walletId);
        $description = $movement->getDescription();
        if ($options['partial']) {
            $description = 'Pagamento parcial ' . strtolower($spent->getDescription());
        }
        $movement->setDescription($description);
        if (! $movementService->insert($movement)) {
            return false;
        }
        return $this->updateRemainingInstallments($spent);
    }

    protected function makeSpentForParcialPay(FutureSpentDTO $spent, float $value): FutureSpentDTO
    {
        $newSpent = new FutureSpentDTO();
        $newSpent->setId(null);
        $newSpent->setAmount($value);
        $newSpent->setWalletId($spent->getWalletId());
        $newSpent->setInstallments(1);
        $newSpent->setForecast($spent->getForecast());
        $message = str_replace('Restante ', '', strtolower($spent->getDescription()));
        $newSpent->setDescription('Restante ' . $message);
        $newSpent->setCreatedAt(null);
        $newSpent->setUpdatedAt(null);
        return $newSpent;
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

    public function getThisMonthFutureSpentSum(?int $tenantId = null): float
    {
        $period = CalendarTools::getThisMonthPeriod();
        $spending = $this->getRepository()->findByPeriod($period, $tenantId);
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