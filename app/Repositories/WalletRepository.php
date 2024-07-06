<?php

namespace App\Repositories;

use App\Models\WalletModel;
use App\Resources\WalletResource;

class WalletRepository extends BasicRepository
{
    public function __construct(
        private readonly WalletModel $model,
        private readonly WalletResource $resource
    ) {
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
