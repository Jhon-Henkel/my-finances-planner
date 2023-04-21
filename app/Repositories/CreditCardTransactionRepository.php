<?php

namespace App\Repositories;

use App\Enums\BasicFieldsEnum;
use App\Models\CreditCardTransaction;
use App\Resources\CreditCardTransactionResource;

class CreditCardTransactionRepository extends BasicRepository
{
    protected CreditCardTransaction $model;
    protected CreditCardTransactionResource $resource;

    public function __construct(CreditCardTransaction $model)
    {
        $this->model = $model;
        $this->resource = app(CreditCardTransactionResource::class);
    }

    protected function getModel(): CreditCardTransaction
    {
        return $this->model;
    }

    protected function getResource(): CreditCardTransactionResource
    {
        return $this->resource;
    }

    public function getExpenses(int $cardId): array
    {
        return $this->getModel()->where(BasicFieldsEnum::CREDIT_CARD_ID_DB, $cardId)->get()->toArray();
    }

    public function getExpensesByCardIdAndMonth(int $cardId, string $nextInstallment): array
    {
        return $this->getModel()
            ->where(BasicFieldsEnum::CREDIT_CARD_ID_DB, '=', $cardId)
            ->where(BasicFieldsEnum::NEXT_INSTALLMENT_DB, '=', $nextInstallment)
            ->get()
            ->toArray();
    }

    public function payExpense($transaction): bool
    {
        return $this->getModel()->where(BasicFieldsEnum::ID, $transaction[BasicFieldsEnum::ID])->update($transaction);
    }
}