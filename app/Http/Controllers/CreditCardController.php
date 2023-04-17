<?php

namespace App\Http\Controllers;

use App\Repositories\CreditCardRepository;
use App\Resources\CreditCardResource;

class CreditCardController extends BasicController
{
    protected CreditCardRepository $service;
    protected CreditCardResource $resource;

    public function __construct(CreditCardRepository $service)
    {
        $this->service = $service;
        $this->resource = app(CreditCardResource::class);
    }

    protected function rulesInsert(): array
    {
        // TODO: Implement rulesInsert() method.
    }

    protected function rulesUpdate(): array
    {
        // TODO: Implement rulesUpdate() method.
    }

    protected function getService()
    {
        return $this->service;
    }

    protected function getResource()
    {
        return $this->resource;
    }
}