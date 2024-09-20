<?php

namespace App\Repositories\User;

use App\Enums\Plan\PlanNameEnum;
use App\Models\User\Plan;
use App\Repositories\BasicRepository;
use App\Resources\Plan\PlanResource;

class PlanRepository extends BasicRepository
{
    public function __construct(private readonly Plan $model, private readonly PlanResource $planResource)
    {
    }

    protected function getModel(): Plan
    {
        return $this->model;
    }

    protected function getResource(): PlanResource
    {
        return $this->planResource;
    }

    public function freePlan(): Plan
    {
        return $this->model->where('name', PlanNameEnum::Free->name)->first();
    }

    public function proPlan(): Plan
    {
        return $this->model->where('name', PlanNameEnum::Pro->name)->first();
    }
}
