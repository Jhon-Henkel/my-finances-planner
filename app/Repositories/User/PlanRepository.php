<?php

namespace App\Repositories\User;

use App\Enums\Plan\PlanNameEnum;
use App\Exceptions\NotImplementedException;
use App\Models\User\Plan;
use App\Repositories\BasicRepository;

class PlanRepository extends BasicRepository
{
    public function __construct(private readonly Plan $model)
    {
    }

    protected function getModel(): Plan
    {
        return $this->model;
    }

    protected function getResource()
    {
        throw new NotImplementedException();
    }

    public function freePlan(): Plan
    {
        return $this->model->where('name', PlanNameEnum::Free->name)->first();
    }
}
