<?php

namespace App\Repositories;

use App\Models\FutureGain;
use App\Resources\FutureGainResource;

class FutureGainRepository extends BasicRepository
{
    protected FutureGain $model;
    protected FutureGainResource $resource;

    public function __construct(FutureGain $model)
    {
        $this->model = $model;
        $this->resource = app(FutureGainResource::class);
    }
    protected function getModel(): FutureGain
    {
        return $this->model;
    }

    protected function getResource(): mixed
    {
        return $this->resource;
    }
}