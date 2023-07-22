<?php

namespace App\Repositories;

use App\DTO\Date\DatePeriodDTO;
use App\Enums\BasicFieldsEnum;
use App\Models\FutureSpent;
use App\Resources\FutureSpentResource;

class FutureSpentRepository extends BasicRepository
{
    protected FutureSpent $model;
    protected FutureSpentResource $resource;

    public function __construct(FutureSpent $model)
    {
        $this->model = $model;
        $this->resource = app(FutureSpentResource::class);
    }

    protected function getModel(): FutureSpent
    {
        return $this->model;
    }

    protected function getResource(): FutureSpentResource
    {
        return $this->resource;
    }

    public function findByPeriod(DatePeriodDTO $period): array
    {
        $itens = $this->getModel()
            ->select('future_spent.*', 'wallets.name')
            ->where('future_spent.forecast', '>=', $period->getStartDate())
            ->where('future_spent.forecast', '<=', $period->getEndDate())
            ->join('wallets', 'future_spent.wallet_id', '=', 'wallets.id')
            ->orderBy(BasicFieldsEnum::ID, 'desc')
            ->get();
        return $itens ? $this->getResource()->arrayToDtoItens($itens->toArray()) : array();
    }

    public function findAll(): array
    {
        $itens = $this->getModel()
            ->select('future_spent.*', 'wallets.name')
            ->join('wallets', 'future_spent.wallet_id', '=', 'wallets.id')
            ->orderBy(BasicFieldsEnum::ID, 'desc')
            ->get();
        return $itens ? $this->getResource()->arrayToDtoItens($itens->toArray()) : array();
    }
}