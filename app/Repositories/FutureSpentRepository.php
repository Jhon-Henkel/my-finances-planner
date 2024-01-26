<?php

namespace App\Repositories;

use App\DTO\Date\DatePeriodDTO;
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

    public function findByPeriod(DatePeriodDTO $period, ?int $tenantId = null): array
    {
        $items = $this->getModel()
            ->query()
            ->select('future_spent.*', 'wallets.name')
            ->where('future_spent.forecast', '>=', $period->getStartDate())
            ->where('future_spent.forecast', '<=', $period->getEndDate());
        if ($tenantId) {
            $items->where('future_spent.tenant_id', '=', $tenantId);
        }
        $items->join('wallets', 'future_spent.wallet_id', '=', 'wallets.id')
            ->orderBy('id', 'desc');
        $items = $items->get();
        return $items ? $this->getResource()->arrayToDtoItens($items->toArray()) : array();
    }

    public function findAll(): array
    {
        $itens = $this->getModel()
            ->select('future_spent.*', 'wallets.name')
            ->join('wallets', 'future_spent.wallet_id', '=', 'wallets.id')
            ->orderBy('id', 'desc')
            ->get();
        return $itens ? $this->getResource()->arrayToDtoItens($itens->toArray()) : array();
    }
}