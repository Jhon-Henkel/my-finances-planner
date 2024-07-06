<?php

namespace App\Repositories\CreditCard;

use App\Models\CreditCard;
use App\Repositories\BasicRepository;
use App\Resources\CreditCard\CreditCardResource;

class CreditCardRepository extends BasicRepository
{
    public function __construct(
        private readonly CreditCard $model,
        private readonly CreditCardResource $resource
    ) {
    }

    protected function getModel(): CreditCard
    {
        return $this->model;
    }

    protected function getResource(): CreditCardResource
    {
        return $this->resource;
    }
}
