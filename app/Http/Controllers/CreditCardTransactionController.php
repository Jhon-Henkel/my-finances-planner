<?php

namespace App\Http\Controllers;

use App\Resources\CreditCardTransactionResource;
use App\Services\CreditCardTransactionService;
use App\Tools\CalendarTools;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class CreditCardTransactionController extends BasicController
{
    protected CreditCardTransactionService $service;
    protected CreditCardTransactionResource $resource;

    public function __construct(CreditCardTransactionService $service)
    {
        $this->service = $service;
        $this->resource = app(CreditCardTransactionResource::class);
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

    // todo ao pagar uma fatura deveremos atualizar os valores installments e nextInstallment
    public function invoices(int $id): JsonResponse
    {
        $expenses = $this->getService()->getInvoices($id);
        return response()->json($expenses, ResponseAlias::HTTP_OK);
    }
}