<?php

namespace App\Services\Investment;

use App\Repositories\Investment\InvestmentRepository;
use App\Services\BasicService;

class InvestmentService extends BasicService
{
    public function __construct(readonly private InvestmentRepository $repository)
    {}

    protected function getRepository(): InvestmentRepository
    {
        return $this->repository;
    }
}