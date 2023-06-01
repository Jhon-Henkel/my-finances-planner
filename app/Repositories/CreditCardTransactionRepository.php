<?php

namespace App\Repositories;

use App\DTO\DatePeriodDTO;
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

    public function findByPeriod(DatePeriodDTO $period): array
    {
        $itens = $this->getModel()->select('*')
            ->where('next_installment', '>=', $period->getStartDate())
            ->where('next_installment', '<=', $period->getEndDate())
            ->orderBy(BasicFieldsEnum::ID, 'desc')
            ->get();
        return $itens ? $this->getResource()->arrayToDtoItens($itens->toArray()) : array();
    }
}