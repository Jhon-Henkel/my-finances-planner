<?php

namespace App\Http\Controllers;

use App\Resources\CreditCard\CreditCardResource;
use App\Services\CreditCard\CreditCardService;

class CreditCardController extends BasicController
{
    protected CreditCardService $service;
    protected CreditCardResource $resource;

    public function __construct(CreditCardService $service)
    {
        $this->service = $service;
        $this->resource = app(CreditCardResource::class);
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