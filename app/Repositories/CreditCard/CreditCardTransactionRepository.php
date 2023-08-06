<?php

namespace App\Repositories\CreditCard;

use App\DTO\Date\DatePeriodDTO;
use App\Enums\BasicFieldsEnum;
use App\Models\CreditCardTransaction;
use App\Repositories\BasicRepository;
use App\Resources\CreditCard\CreditCardTransactionResource;

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

    public function countByCreditCardId(int $creditCardId): int
    {
        return $this->getModel()->where(BasicFieldsEnum::CREDIT_CARD_ID_DB, $creditCardId)->count();
    }

    public function countByPeriod(DatePeriodDTO $period, int $cardId): int
    {
        return $this->getModel()->where('next_installment', '>=', $period->getStartDate())
            ->where('next_installment', '<=', $period->getEndDate())
            ->where(BasicFieldsEnum::CREDIT_CARD_ID_DB, $cardId)
            ->count();
    }
}