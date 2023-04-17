<?php

namespace App\Repositories;

use App\Models\CreditCard;
use App\Resources\CreditCardResource;

class CreditCardRepository extends BasicRepository
{
    protected CreditCard $model;
    protected CreditCardResource $resource;

    public function __construct(CreditCard $model)
    {
        $this->model = $model;
        $this->resource = app(CreditCardResource::class);
    }

    protected function getModel(): CreditCard
    {
        return $this->model;
    }

    protected function getResource()
    {
        return $this->resource;
    }
}