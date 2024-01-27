<?php

namespace App\Http\Controllers\Investment;

use App\Exceptions\ValueException;
use App\Http\Controllers\BasicController;
use App\Http\Response\ResponseError;
use App\Resources\Investment\InvestmentResource;
use App\Services\Investment\InvestmentService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\MessageBag;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

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
            'credit_card_id' => 'nullable|int|exists:App\Models\CreditCard,id',
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
            'credit_card_id' => 'nullable|int|exists:App\Models\CreditCard,id',
            'description' => 'required|max:255|string',
            'type' => 'required|numeric',
            'amount' => 'required|decimal:0,2',
            'liquidity' => 'required|numeric',
            'profitability' => 'required|decimal:0,2'
        ];
    }

    protected function rulesRescueApport(): array
    {
        return [
            'walletId' => 'required|int|exists:App\Models\WalletModel,id',
            'investmentId' => 'required|int|exists:App\Models\Investment\Investment,id',
            'value' => 'required|decimal:0,2',
            'rescue' => 'required|boolean'
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

    public function makeDataGraph(): JsonResponse
    {
        $data = $this->getService()->makeDataGraph();
        return response()->json($data, ResponseAlias::HTTP_OK);
    }

    /** @throws ValueException */
    public function rescueApportInvestment(Request $request): JsonResponse
    {
        $invalid = $this->getService()->isInvalidRequest($request, $this->rulesRescueApport());
        if ($invalid instanceof MessageBag) {
            return ResponseError::responseError($invalid, ResponseAlias::HTTP_BAD_REQUEST);
        }
        $this->getService()->rescueApportInvestment($request->all());
        return response()->json(null, ResponseAlias::HTTP_OK);
    }
}