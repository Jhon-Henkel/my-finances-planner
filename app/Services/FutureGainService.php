<?php

namespace App\Services;

use App\DTO\FutureGainDTO;
use App\Enums\InvoiceInstallmentsEnum;
use App\Factory\InvoiceFactory;
use App\Repositories\FutureGainRepository;
use App\Resources\FutureGainResource;
use App\Services\Movement\MovementService;
use App\Tools\Calendar\CalendarTools;

class FutureGainService extends BasicService
{
    public function __construct(
        private readonly FutureGainRepository $repository,
        private readonly FutureGainResource $resource,
        private readonly MovementService $movementService
    ) {
    }

    protected function getRepository(): FutureGainRepository
    {
        return $this->repository;
    }

    public function getNextSixMonthsFutureGain(): array
    {
        $year = CalendarTools::getThisYear();
        $month = CalendarTools::getThisMonth();
        $period = CalendarTools::getIntervalMonthPeriodByMonthAndYear($month, $year, 6);
        $gains = $this->getRepository()->findByPeriod($period);
        $gainsPackage = [];
        foreach ($gains as $gain) {
            $futureGainDTO = $this->resource->futureGainToInvoiceDTO($gain);
            $gainsPackage[] = InvoiceFactory::factoryInvoice($futureGainDTO, CalendarTools::getThisMonth());
        }
        return $gainsPackage;
    }

    public function receive(FutureGainDTO $gain, array $options): bool
    {
        $isEqualsValue = $options['value'] === $gain->getAmount();
        $isEqualsWallet = $options['walletId'] === $gain->getWalletId();
        if (! $options['partial'] && $isEqualsValue && $isEqualsWallet) {
            return $this->receiveFullGain($gain);
        }
        return $this->receiveWithOptions($gain, $options);
    }

    protected function receiveFullGain(FutureGainDTO $gain): bool
    {
        $movement = $this->movementService->populateByFutureGain($gain);
        if (! $this->movementService->insert($movement)) {
            return false;
        }
        return $this->updateRemainingInstallments($gain);
    }

    protected function updateRemainingInstallments(FutureGainDTO $gain): bool
    {
        $remainingInstallments = $gain->getInstallments() - 1;
        if ($remainingInstallments === 0) {
            return $this->getRepository()->deleteById($gain->getId());
        }
        if ($remainingInstallments < 0) {
            $remainingInstallments = InvoiceInstallmentsEnum::FixedInstallments->value;
        }
        $gain->setInstallments($remainingInstallments);
        $gain->setForecast(CalendarTools::addMonthInDate($gain->getForecast(), 1));
        return (bool)$this->getRepository()->update($gain->getId(), $gain);
    }

    protected function receiveWithOptions(FutureGainDTO $gain, array $options): bool
    {
        $isEqualsValue = $options['value'] === $gain->getAmount();
        $isEqualsWallet = $options['walletId'] === $gain->getWalletId();
        $value = $isEqualsValue ? $gain->getAmount() : $options['value'];
        $walletId = $isEqualsWallet ? $gain->getWalletId() : $options['walletId'];
        if ($options['partial'] && $options['value'] < $gain->getAmount()) {
            $newSpent = $this->makeGainForParcialReceive($gain, $gain->getAmount() - $value);
            $this->insert($newSpent);
        }
        $movement = $this->movementService->populateByFutureGain($gain);
        $movement->setAmount($value);
        $movement->setWalletId($walletId);
        $description = $movement->getDescription();
        if ($options['partial']) {
            $description = 'Recebimento parcial ' . strtolower($gain->getDescription());
        }
        $movement->setDescription($description);
        if (! $this->movementService->insert($movement)) {
            return false;
        }
        return $this->updateRemainingInstallments($gain);
    }

    protected function makeGainForParcialReceive(FutureGainDTO $spent, float $value): FutureGainDTO
    {
        $newSpent = new FutureGainDTO();
        $newSpent->setId(null);
        $newSpent->setAmount($value);
        $newSpent->setWalletId($spent->getWalletId());
        $newSpent->setInstallments(1);
        $newSpent->setForecast($spent->getForecast());
        $description = str_replace('Restante ', '', strtolower($spent->getDescription()));
        $newSpent->setDescription('Restante ' . $description);
        $newSpent->setCreatedAt(null);
        $newSpent->setUpdatedAt(null);
        return $newSpent;
    }

    public function getThisYearFutureGainSum(): float
    {
        $period = CalendarTools::getThisYearPeriod();
        $gains = $this->getRepository()->findByPeriod($period);
        $total = 0;
        foreach ($gains as $gain) {
            $installments = $gain->getInstallments() == 0 ? 1 : $gain->getAmount() * $gain->getInstallments();
            $total += ($gain->getAmount() * $installments);
        }
        return $total;
    }

    public function getThisMonthFutureGainSum(?int $tenantId = null): float
    {
        $period = CalendarTools::getThisMonthPeriod();
        $gains = $this->getRepository()->findByPeriod($period, $tenantId);
        $total = 0;
        foreach ($gains as $gain) {
            $total += $gain->getAmount();
        }
        return $total;
    }
}