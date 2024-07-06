<?php

namespace App\Repositories\Investment;

use App\Models\Investment\Investment;
use App\Repositories\BasicRepository;
use App\Resources\Investment\InvestmentResource;

class InvestmentRepository extends BasicRepository
{
    public function __construct(
        readonly private Investment $model,
        readonly private InvestmentResource $resource
    ) {
    }

    protected function getModel(): Investment
    {
        return $this->model;
    }

    protected function getResource(): InvestmentResource
    {
        return $this->resource;
    }
}
