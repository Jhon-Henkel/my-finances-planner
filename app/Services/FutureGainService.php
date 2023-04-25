<?php

namespace App\Services;

use App\DTO\FutureGainDTO;
use App\Enums\InvoiceEnum;
use App\Enums\MovementEnum;
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

    /**
     * @throws Exception
     */
    public function receive(FutureGainDTO $gain): bool
    {
        $movementService = app(MovementService::class);
        $movement = $movementService->populateByFutureGain($gain);
        if (! $movementService->insert($movement)){
            return false;
        }
        $walletService = app(WalletService::class);
        $walletService->updateWalletValue($gain->getAmount(), $gain->getWalletId(), MovementEnum::GAIN, true);
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
}