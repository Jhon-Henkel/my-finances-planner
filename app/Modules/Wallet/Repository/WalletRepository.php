<?php

namespace App\Modules\Wallet\Repository;

use App\Models\WalletModel;
use App\Modules\Wallet\Resource\WalletResource;
use App\Repositories\BasicRepository;

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
