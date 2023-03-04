<?php

namespace App\Repositories;

use App\Models\MovementModel;
use App\Resources\MovementResource;

class MovementRepository extends BasicRepository
{
    protected MovementModel $model;
    protected MovementResource $resource;

    public function __construct(MovementModel $model)
    {
        $this->model = $model;
        $this->resource = app(MovementResource::class);
    }

    protected function getModel(): MovementModel
    {
        return $this->model;
    }

    protected function getResource(): MovementResource
    {
        return $this->resource;
    }

    public function findAllByType(int $type): array
    {
        $itens = $this->model->where('type', $type)->get()->toArray();
        return $this->resource->arrayToDtoItens($itens);
    }
}