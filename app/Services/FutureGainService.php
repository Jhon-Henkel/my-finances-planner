<?php

namespace App\Services;

use App\DTO\FutureGainDTO;
use App\Enums\BasicFieldsEnum;
use App\Enums\InvoiceEnum;
use App\Factory\InvoiceFactory;
use App\Repositories\FutureGainRepository;
use App\Resources\FutureGainResource;
use App\Tools\CalendarTools;
use Exception;

class FutureGainService extends BasicService
{
    protected FutureGainRepository $repository;
    protected FutureGainResource $resource;

    public function __construct(FutureGainRepository $repository)
    {
        $this->repository = $repository;
        $this->resource = app(FutureGainResource::class);
    }

    protected function getRepository(): FutureGainRepository
    {
        return $this->repository;
    }

    /**
     * @throws Exception
     */
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
        $isEqualsValue = $options[BasicFieldsEnum::VALUE] === $gain->getAmount();
        $isEqualsWallet = $options[BasicFieldsEnum::WALLET_ID_JSON] === $gain->getWalletId();
        if (! $options[BasicFieldsEnum::PARTIAL] && $isEqualsValue && $isEqualsWallet) {
            return $this->receiveFullGain($gain);
        }
        return $this->receiveWithOptions($gain, $options);
    }

    protected function receiveFullGain(FutureGainDTO $gain): bool
    {
        $movementService = app(MovementService::class);
        $movement = $movementService->populateByFutureGain($gain);
        if (! $movementService->insert($movement)){
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
            $remainingInstallments = InvoiceEnum::FIXED_INSTALLMENTS;
        }
        $gain->setInstallments($remainingInstallments);
        $gain->setForecast(CalendarTools::addMonthInDate($gain->getForecast(), 1));
        return (bool)$this->getRepository()->update($gain->getId(), $gain);
    }

    protected function receiveWithOptions(FutureGainDTO $gain, array $options): bool
    {
        $isEqualsValue = $options[BasicFieldsEnum::VALUE] === $gain->getAmount();
        $isEqualsWallet = $options[BasicFieldsEnum::WALLET_ID_JSON] === $gain->getWalletId();
        $value = $isEqualsValue ? $gain->getAmount() : $options[BasicFieldsEnum::VALUE];
        $walletId = $isEqualsWallet ? $gain->getWalletId() : $options[BasicFieldsEnum::WALLET_ID_JSON];
        if ($options[BasicFieldsEnum::PARTIAL] && $options[BasicFieldsEnum::VALUE] < $gain->getAmount()) {
            $newSpent = $this->makeGainForParcialReceive($gain, $gain->getAmount() - $value);
            $this->insert($newSpent);
        }
        $movementService = app(MovementService::class);
        $movement = $movementService->populateByFutureGain($gain);
        $movement->setAmount($value);
        $movement->setWalletId($walletId);
        $description = $movement->getDescription();
        if ($options[BasicFieldsEnum::PARTIAL]) {
            $description = 'Recebimento parcial ' . strtolower($gain->getDescription());
        }
        $movement->setDescription($description);
        if (! $movementService->insert($movement)){
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
        $period = CalendarTools::getThisYearPeriod(CalendarTools::getThisYear());
        $gains = $this->getRepository()->findByPeriod($period);
        $total = 0;
        foreach ($gains as $gain) {
            $installments = $gain->getInstallments() == 0 ? 1 : $gain->getAmount() * $gain->getInstallments();
            $total += ($gain->getAmount() * $installments);
        }
        return $total;
    }

    public function getThisMonthFutureGainSum(): float
    {
        $period = CalendarTools::getThisMonthPeriod(CalendarTools::getThisMonth(), CalendarTools::getThisYear());
        $gains = $this->getRepository()->findByPeriod($period);
        $total = 0;
        foreach ($gains as $gain) {
            $total += $gain->getAmount();
        }
        return $total;
    }
}