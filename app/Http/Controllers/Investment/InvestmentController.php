<?php

namespace App\Http\Controllers\Investment;

use App\Http\Controllers\BasicController;
use App\Resources\Investment\InvestmentResource;
use App\Services\Investment\InvestmentService;

class InvestmentController extends BasicController
{
    public function __construct(
        readonly private InvestmentService $service,
        readonly private InvestmentResource $resource
    ) {
    }

    protected function rulesInsert(): array
    {
        return [
            'credit_card_id' => 'int|exists:App\Models\CreditCard,id',
            'description' => 'required|max:255|string',
            'type' => 'required|numeric',
            'amount' => 'required|decimal:0,2',
            'liquidity' => 'required|numeric',
            'profitability' => 'required|decimal:0,2'
        ];
    }

    protected function rulesUpdate(): array
    {
        return [
            'credit_card_id' => 'int|exists:App\Models\CreditCard,id',
            'description' => 'required|max:255|string',
            'type' => 'required|numeric',
            'amount' => 'required|decimal:0,2',
            'liquidity' => 'required|numeric',
            'profitability' => 'required|decimal:0,2'
        ];
    }

    protected function getService(): InvestmentService
    {
        return $this->service;
    }

    protected function getResource(): InvestmentResource
    {
        return $this->resource;
    }
}