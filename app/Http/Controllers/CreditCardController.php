<?php

namespace App\Http\Controllers;

use App\Resources\CreditCard\CreditCardResource;
use App\Services\CreditCard\CreditCardService;

class CreditCardController extends BasicController
{
    public function __construct(
        private readonly CreditCardService $service,
        private readonly CreditCardResource $resource
    ) {
    }

    protected function rulesInsert(): array
    {
        return [
            'name' => 'required|string|unique:App\Models\CreditCard,name',
            'limit' => 'required|numeric',
            'dueDate' => 'required|integer|between:1,31',
            'closingDay' => 'required|integer|between:1,31'
        ];
    }

    protected function rulesUpdate(): array
    {
        return [
            'name' => 'required|string',
            'limit' => 'required|numeric',
            'dueDate' => 'required|integer|between:1,31',
            'closingDay' => 'required|integer|between:1,31'
        ];
    }

    protected function getService(): CreditCardService
    {
        return $this->service;
    }

    protected function getResource(): CreditCardResource
    {
        return $this->resource;
    }
}
