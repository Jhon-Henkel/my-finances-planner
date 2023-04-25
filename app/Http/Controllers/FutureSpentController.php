<?php

namespace App\Http\Controllers;

use App\Resources\FutureSpentResource;
use App\Services\FutureSpentService;
use Exception;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class FutureSpentController extends BasicController
{
    protected FutureSpentService $service;
    protected FutureSpentResource $resource;

    public function __construct(FutureSpentService $service)
    {
        $this->service = $service;
        $this->resource = app(FutureSpentResource::class);
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

    protected function getService(): FutureSpentService
    {
        return $this->service;
    }

    protected function getResource(): FutureSpentResource
    {
        return $this->resource;
    }

    /**
     * @throws Exception
     */
    public function nextSixMonths(): JsonResponse
    {
        $futureGain = $this->getService()->getNextSixMonthsFutureSpent();
        return response()->json($futureGain, ResponseAlias::HTTP_OK);
    }
}