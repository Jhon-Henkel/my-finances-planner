<?php

namespace App\Repositories\CreditCard;

use App\Models\CreditCard\CreditCardMovement;
use App\Repositories\BasicRepository;
use App\Resources\CreditCard\CreditCardMovementResource;

class CreditCardMovementRepository extends BasicRepository
{
    protected CreditCardMovement $model;
    protected CreditCardMovementResource $resource;

    public function __construct(CreditCardMovement $model, CreditCardMovementResource $resource)
    {
        $this->model = $model;
        $this->resource = $resource;
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