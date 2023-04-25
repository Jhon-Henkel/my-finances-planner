<?php

namespace App\Services;

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
}