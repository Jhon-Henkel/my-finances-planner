<?php

namespace App\Repositories;

use App\Models\CreditCardTransaction;
use App\Resources\CreditCardTransactionResource;

class CreditCardTransactionRepository extends BasicRepository
{
    protected CreditCardTransaction $model;
    protected CreditCardTransactionResource $resource;

    public function __construct(CreditCardTransaction $model)
    {
        $this->model = $model;
        $this->resource = app(CreditCardTransactionResource::class);
    }

    protected function getModel(): CreditCardTransaction
    {
        return $this->model;
    }

    protected function getResource(): CreditCardTransactionResource
    {
        return $this->resource;
    }
}