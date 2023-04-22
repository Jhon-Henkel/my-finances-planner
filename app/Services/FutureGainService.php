<?php

namespace App\Services;

use App\Repositories\FutureGainRepository;

class FutureGainService extends BasicService
{
    protected FutureGainRepository $repository;

    public function __construct(FutureGainRepository $repository)
    {
        $this->repository = $repository;
    }
    protected function getRepository(): FutureGainRepository
    {
        return $this->repository;
    }
}