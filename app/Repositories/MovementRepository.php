<?php

namespace App\Repositories;

use App\Models\MovementModel;

class MovementRepository extends BasicRepository
{
    protected MovementModel $model;
    protected MovementRepository $resource;

    public function __construct(MovementModel $model)
    {
        $this->model = $model;
        $this->resource = app(MovementRepository::class);
    }

    protected function getModel(): MovementModel
    {
        return $this->model;
    }

    protected function getResource(): MovementRepository
    {
        return $this->resource;
    }

    public function findAllByType(int $type): array
    {
        $itens = $this->model->where('type', $type)->get()->toArray();
        return $this->resource->arrayToDtoItens($itens);
    }
}