<?php

namespace App\Modules\Old\Wallet\Repository;

use App\Models\Wallet\Wallet;
use App\Modules\Old\Wallet\Resource\WalletResource;
use App\Repositories\BasicRepository;

class WalletRepository extends BasicRepository
{
    public function __construct(
        private readonly Wallet $model,
        private readonly WalletResource $resource
    ) {
    }

    protected function getModel(): Wallet
    {
        return $this->model;
    }

    protected function getResource(): WalletResource
    {
        return $this->resource;
    }
}
