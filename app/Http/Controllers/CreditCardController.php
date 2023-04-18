<?php

namespace App\Http\Controllers;

use App\Resources\CreditCardResource;
use App\Services\CreditCardService;

class CreditCardController extends BasicController
{
    protected CreditCardService $service;
    protected CreditCardResource $resource;

    public function __construct(CreditCardService $service)
    {
        $this->service = $service;
        $this->resource = app(CreditCardResource::class);
    }

    // todo validar dias de vencimento e fechamento, o dia de vencimento não pode ser menor que o dia de fechamento
    protected function rulesInsert(): array
    {
        return [
            'name' => 'required|string|unique:App\Models\CreditCard,name',
            'limit' => 'required|numeric',
            'dueDate' => 'required|integer|between:1,31',
            'closingDay' => 'required|integer|between:1,31'
        ];
    }

    // todo validar dias de vencimento e fechamento, o dia de vencimento não pode ser menor que o dia de fechamento
    protected function rulesUpdate(): array
    {
        return [
            'name' => 'required|string|unique:App\Models\CreditCard,name',
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