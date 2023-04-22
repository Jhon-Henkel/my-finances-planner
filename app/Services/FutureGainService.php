<?php

namespace App\Services;

use App\Factory\InvoiceFactory;
use App\Repositories\FutureGainRepository;
use App\Resources\FutureGainResource;
use App\Tools\CalendarTools;

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

    public function getNextSixMonthsFutureGain(): array
    {
        $gains = $this->getRepository()->findAll();
        $gainsPackage = [];
        foreach ($gains as $gain) {
            $futureGainDTO = $this->resource->futureGainToInvoiceDTO($gain);
            $gainsPackage[] = InvoiceFactory::factoryInvoice($futureGainDTO, CalendarTools::getThisMonth());
        }
        return $gainsPackage;
    }
}