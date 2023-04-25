<?php

namespace App\Services;

use App\DTO\FutureSpentDTO;
use App\Enums\InvoiceEnum;
use App\Factory\InvoiceFactory;
use App\Repositories\FutureSpentRepository;
use App\Resources\FutureSpentResource;
use App\Tools\CalendarTools;
use Exception;

class FutureSpentService extends BasicService
{
    protected FutureSpentRepository $repository;
    protected FutureSpentResource $resource;

    public function __construct(FutureSpentRepository $repository)
    {
        $this->repository = $repository;
        $this->resource = app(FutureSpentResource::class);
    }

    protected function getRepository(): FutureSpentRepository
    {
        return $this->repository;
    }

    /**
     * @throws Exception
     */
    public function getNextSixMonthsFutureSpent(): array
    {
        $month = CalendarTools::getThisMonth();
        $year = CalendarTools::getThisYear();
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
    public function paySpent(FutureSpentDTO $spent): bool
    {
        $movementService = app(MovementService::class);
        $movement = $movementService->populateByFutureSpent($spent);
        if (! $movementService->insert($movement)){
            return false;
        }
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
}