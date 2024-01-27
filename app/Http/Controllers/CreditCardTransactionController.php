<?php

namespace App\Http\Controllers;

use App\Resources\CreditCard\CreditCardTransactionResource;
use App\Services\CreditCard\CreditCardTransactionService;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class CreditCardTransactionController extends BasicController
{
    public function __construct(
        private readonly CreditCardTransactionService $service,
        private readonly CreditCardTransactionResource $resource
    ) {
    }

    protected function rulesInsert(): array
    {
        return [
            "creditCardId" => "required|integer|exists:App\Models\CreditCard,id",
            "name" => "required|string|max:255",
            "value" => "required|numeric",
            "installments" => "required|integer",
            "nextInstallment" => "required|string",
        ];
    }

    protected function rulesUpdate(): array
    {
        return [
            "creditCardId" => "required|integer|exists:App\Models\CreditCard,id",
            "name" => "required|string|max:255",
            "value" => "required|numeric",
            "installments" => "required|integer",
            "nextInstallment" => "required|string",
        ];
    }

    protected function getService(): CreditCardTransactionService
    {
        return $this->service;
    }

    protected function getResource(): CreditCardTransactionResource
    {
        return $this->resource;
    }

    public function invoices(int $cardId): JsonResponse
    {
        $expenses = $this->getService()->getInvoices($cardId);
        return response()->json($expenses, ResponseAlias::HTTP_OK);
    }

    public function payInvoice(int $cardId, int $walletId): JsonResponse
    {
        $expense = $this->getService()->payInvoice($cardId, $walletId);
        if ($expense) {
            return response()->json(null, ResponseAlias::HTTP_OK);
        }
        return response()->json(null, ResponseAlias::HTTP_EXPECTATION_FAILED);
    }
}