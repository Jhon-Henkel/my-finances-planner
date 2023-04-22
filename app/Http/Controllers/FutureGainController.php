<?php

namespace App\Http\Controllers;

use App\Resources\FutureGainResource;
use App\Services\FutureGainService;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class FutureGainController extends BasicController
{
    protected FutureGainService $service;
    protected FutureGainResource $resource;

    public function __construct(FutureGainService $service)
    {
        $this->service = $service;
        $this->resource = app(FutureGainResource::class);
    }

    protected function rulesInsert(): array
    {
        return [
            'description' => 'required|max:255|string',
            'walletId' => 'required|int|exists:App\Models\WalletModel,id',
            'forecast'=> 'required|date',
            'amount' => 'required|decimal:0,2',
            'installments' => 'required|int'
        ];
    }

    protected function rulesUpdate(): array
    {
        return [
            'description' => 'required|max:255|string',
            'walletId' => 'required|int|exists:App\Models\WalletModel,id',
            'forecast'=> 'required|date',
            'amount' => 'required|decimal:0,2',
            'installments' => 'required|int'
        ];
    }

    protected function getService(): FutureGainService
    {
        return $this->service;
    }

    protected function getResource(): mixed
    {
        return $this->resource;
    }

    public function nextSixMonths(): JsonResponse
    {
        $futureGain = $this->getService()->getNextSixMonthsFutureGain();
        return response()->json($futureGain, ResponseAlias::HTTP_OK);
    }
}