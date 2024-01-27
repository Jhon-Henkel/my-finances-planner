<?php

namespace App\Http\Controllers;

use App\Resources\FutureSpentResource;
use App\Services\FutureSpentService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class FutureSpentController extends BasicController
{
    public function __construct(
        private readonly FutureSpentService $service,
        private readonly FutureSpentResource $resource
    ) {
    }

    protected function rulesInsert(): array
    {
        return [
            'description' => 'required|max:255|string',
            'walletId' => 'required|int|exists:App\Models\WalletModel,id',
            'forecast' => 'required|date',
            'amount' => 'required|decimal:0,2',
            'installments' => 'required|int'
        ];
    }

    protected function rulesUpdate(): array
    {
        return [
            'description' => 'required|max:255|string',
            'walletId' => 'required|int|exists:App\Models\WalletModel,id',
            'forecast' => 'required|date',
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

    public function paySpent(int $id, Request $request): JsonResponse
    {
        $spent = $this->getService()->findById($id);
        if (! $spent) {
            return response()->json(['Gasto não encontrada!'], ResponseAlias::HTTP_NOT_FOUND);
        }
        return $this->getService()->paySpent($spent, $request->json()->all())
            ? response()->json(null, ResponseAlias::HTTP_OK)
            : response()->json(['Erro ao pagar despesa!'], ResponseAlias::HTTP_INTERNAL_SERVER_ERROR);
    }
}