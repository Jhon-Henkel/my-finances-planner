<?php

namespace App\Repositories\CreditCard;

use App\DTO\Date\DatePeriodDTO;
use App\Models\CreditCardTransaction;
use App\Repositories\BasicRepository;
use App\Resources\CreditCard\CreditCardTransactionResource;

class CreditCardTransactionRepository extends BasicRepository
{
    public function __construct(
        private readonly CreditCardTransaction $model,
        private readonly CreditCardTransactionResource $resource
    ) {
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
        return $this->getModel()->where('credit_card_id', $cardId)->get()->toArray();
    }

    public function findByPeriod(DatePeriodDTO $period): array
    {
        $itens = $this->getModel()
            ->select('*')
            ->where('next_installment', '>=', $period->getStartDate())
            ->where('next_installment', '<=', $period->getEndDate())
            ->orderBy('id', 'desc')
            ->get();
        return $itens ? $this->getResource()->arrayToDtoItens($itens->toArray()) : [];
    }

    public function countByCreditCardId(int $creditCardId): int
    {
        return $this->getModel()->where('credit_card_id', $creditCardId)->count();
    }
}