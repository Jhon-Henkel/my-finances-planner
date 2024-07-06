<?php

namespace App\Repositories;

use App\DTO\Date\DatePeriodDTO;
use App\Models\FutureSpent;
use App\Resources\FutureSpentResource;

class FutureSpentRepository extends BasicRepository
{
    public function __construct(
        private readonly FutureSpent $model,
        private readonly FutureSpentResource $resource
    ) {
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
        $items = $this->getModel()
            ->query()
            ->select('future_spent.*', 'wallets.name')
            ->where('future_spent.forecast', '>=', $period->getStartDate())
            ->where('future_spent.forecast', '<=', $period->getEndDate())
            ->join('wallets', 'future_spent.wallet_id', '=', 'wallets.id')
            ->orderBy('id', 'desc');
        $items = $items->get();
        return $items ? $this->getResource()->arrayToDtoItens($items->toArray()) : array();
    }

    public function findAll(): array
    {
        $itens = $this->getModel()
            ->query()
            ->select('future_spent.*', 'wallets.name')
            ->join('wallets', 'future_spent.wallet_id', '=', 'wallets.id')
            ->orderBy('id', 'desc')
            ->get();
        return $itens ? $this->getResource()->arrayToDtoItens($itens->toArray()) : array();
    }
}
