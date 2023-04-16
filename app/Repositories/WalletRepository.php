<?php

namespace App\Repositories;

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
}