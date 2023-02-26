<?php

namespace App\Repositories;

use App\Http\Resources\WalletResource;
use App\Models\WalletModel;

class WalletRepository extends BasicRepository
{
    protected WalletModel $model;
    protected WalletResource $resource;

    public function __construct(WalletModel $model)
    {
        $this->model = $model;
        $this->resource = app(WalletResource::class);
    }

    protected function getModel(): WalletModel
    {
        return $this->model;
    }

    protected function getResource(): WalletResource
    {
        return $this->resource;
    }

    public function findAllByType(int $type): array
    {
        $itens = $this->model->where('type', $type)->get()->toArray();
        return $this->resource->arrayToDtoItens($itens);
    }
}
