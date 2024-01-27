<?php

namespace App\Repositories\CreditCard;

use App\Models\CreditCard\CreditCardMovement;
use App\Repositories\BasicRepository;
use App\Resources\CreditCard\CreditCardMovementResource;

class CreditCardMovementRepository extends BasicRepository
{
    public function __construct(
        private readonly CreditCardMovement $model,
        private readonly CreditCardMovementResource $resource
    ) {
    }

    protected function getModel(): CreditCardMovement
    {
        return $this->model;
    }

    protected function getResource(): CreditCardMovementResource
    {
        return $this->resource;
    }
}