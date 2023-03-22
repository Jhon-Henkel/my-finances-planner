<?php

namespace App\Repositories;

use App\Enums\BasicFieldsEnum;
use App\Models\WalletModel;
use App\Resources\WalletResource;

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
        // todo mover para o basic
        $itens = $this->model->where(BasicFieldsEnum::TYPE, $type)->get()->toArray();
        return $this->resource->arrayToDtoItens($itens);
    }

    public function findNameById(int $id): string
    {
        $item = $this->model->select('name')->where('id', '=', $id)->get();
        return $item->first()->toArray()['name'];
    }
}