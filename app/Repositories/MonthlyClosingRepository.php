<?php

namespace App\Repositories;

use App\DTO\MonthlyClosingDTO;
use App\Models\MonthlyClosing;
use App\Resources\MonthlyClosingResource;

class MonthlyClosingRepository extends BasicRepository
{
    protected MonthlyClosing $model;
    protected MonthlyClosingResource $resource;

    public function __construct(MonthlyClosing $model)
    {
        $this->model = $model;
        $this->resource = app(MonthlyClosingResource::class);
    }

    protected function getModel(): MonthlyClosing
    {
        return $this->model;
    }

    protected function getResource(): MonthlyClosingResource
    {
        return $this->resource;
    }

    public function findLast(): null|MonthlyClosingDTO
    {
        $last = $this->getModel()->orderBy('id', 'desc')->first();
        return $last ? $this->getResource()->arrayToDto($last->toArray()) : null;
    }
}