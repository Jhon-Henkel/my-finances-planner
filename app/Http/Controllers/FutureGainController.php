<?php

namespace App\Http\Controllers;

use App\Resources\FutureGainResource;
use App\Services\FutureMovement\FutureGainService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class FutureGainController extends BasicController
{
    public function __construct(
        private readonly FutureGainService $service,
        private readonly FutureGainResource $resource
    ) {
    }

    protected function rulesInsert(): array
    {
        return [
            'description' => 'required|max:255|string',
            'walletId' => 'required|int|exists:App\Modules\Wallet\Model\WalletModel,id',
            'forecast' => 'required|date',
            'amount' => 'required|decimal:0,2',
            'installments' => 'required|int'
        ];
    }

    protected function rulesUpdate(): array
    {
        return [
            'description' => 'required|max:255|string',
            'walletId' => 'required|int|exists:App\Modules\Wallet\Model\WalletModel,id',
            'forecast' => 'required|date',
            'amount' => 'required|decimal:0,2',
            'installments' => 'required|int'
        ];
    }

    protected function getService(): FutureGainService
    {
        return $this->service;
    }

    protected function getResource(): FutureGainResource
    {
        return $this->resource;
    }

    public function nextSixMonths(): JsonResponse
    {
        $futureGain = $this->getService()->getNextSixMonthsFutureGain();
        return response()->json($futureGain, ResponseAlias::HTTP_OK);
    }

    public function receive(int $id, Request $request): JsonResponse
    {
        $gain = $this->getService()->findById($id);
        if (! $gain) {
            return response()->json(['Receita não encontrada!'], ResponseAlias::HTTP_NOT_FOUND);
        }
        return $this->getService()->receive($gain, $request->json()->all())
            ? response()->json(null, ResponseAlias::HTTP_OK)
            : response()->json(['Erro ao receber receita!'], ResponseAlias::HTTP_INTERNAL_SERVER_ERROR);
    }
}
