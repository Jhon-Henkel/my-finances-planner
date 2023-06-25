<?php

namespace App\Services;

use App\Repositories\MonthlyClosingRepository;

class MonthlyClosingService extends BasicService
{
    private MonthlyClosingRepository $repository;

    public function __construct(MonthlyClosingRepository $repository)
    {
        $this->repository = $repository;
    }

    protected function getRepository(): MonthlyClosingRepository
    {
        return $this->repository;
    }
}