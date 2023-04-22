<?php

namespace App\Http\Controllers;

use App\Resources\CreditCardTransactionResource;
use App\Services\CreditCardTransactionService;
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

    public function invoices(int $cardId): JsonResponse
    {
        $expenses = $this->getService()->getInvoices($cardId);
        return response()->json($expenses, ResponseAlias::HTTP_OK);
    }

    public function payInvoice(int $cardId, int $month): JsonResponse
    {
        /**
         * todo revisar e desenvolver após ter a tela de transações por carteira
         * 1 - Atualizar o próximo vencimento
         * 2 - Atualizar as parcelas restantes
         * 3 - Se as parcelas após a subtração for igual a zero, excluir a despesa
         * 4 - Lançar a transação na carteira selecionada (adicionar o id da carteira na rota)
         */
        dd('revisar e desenvolver após ter a tela de transações por carteira');
        $expense = $this->getService()->payInvoice($cardId, $month);
        if ($expense) {
            return response()->json(null, ResponseAlias::HTTP_OK);
        }
        return response()->json(null, ResponseAlias::HTTP_EXPECTATION_FAILED);
    }
}