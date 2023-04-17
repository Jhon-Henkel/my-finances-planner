<?php

namespace App\Repositories;

use App\Models\CreditCart;
use App\Resources\CreditCardResource;

class CreditCardRepository extends BasicRepository
{
    protected CreditCart $model;
    protected CreditCardResource $resource;

    public function __construct(CreditCart $model)
    {
        $this->model = $model;
        $this->resource = app(CreditCardResource::class);
    }

    protected function getModel(): CreditCart
    {
        return $this->model;
    }

    protected function getResource()
    {
        return $this->resource;
    }
}