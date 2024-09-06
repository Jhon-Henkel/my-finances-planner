<?php

namespace App\Services\User;

use App\Models\User\Plan;
use App\Repositories\User\PlanRepository;
use App\Services\BasicService;

class PlanService extends BasicService
{
    public function __construct(private readonly PlanRepository $repository)
    {
    }

    protected function getRepository(): PlanRepository
    {
        return $this->repository;
    }

    public function freePlan(): Plan
    {
        return $this->repository->freePlan();
    }
}
