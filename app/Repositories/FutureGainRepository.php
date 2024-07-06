<?php

namespace App\Repositories;

use App\DTO\Date\DatePeriodDTO;
use App\Models\FutureGain;
use App\Resources\FutureGainResource;

class FutureGainRepository extends BasicRepository
{
    public function __construct(
        private readonly FutureGain $model,
        private readonly FutureGainResource $resource
    ) {
    }

    protected function getModel(): FutureGain
    {
        return $this->model;
    }

    protected function getResource(): FutureGainResource
    {
        return $this->resource;
    }

    public function findByPeriod(DatePeriodDTO $period, ?int $tenantId = null): array
    {
        $items = $this->getModel()
            ->query()
            ->select('future_gain.*', 'wallets.name')
            ->where('future_gain.forecast', '>=', $period->getStartDate())
            ->where('future_gain.forecast', '<=', $period->getEndDate());
        if ($tenantId) {
            $items->where('future_gain.tenant_id', '=', $tenantId);
        }
        $items->join('wallets', 'future_gain.wallet_id', '=', 'wallets.id')
            ->orderBy('id', 'desc');
        $items = $items->get();
        return $items ? $this->getResource()->arrayToDtoItens($items->toArray()) : [];
    }

    public function findAll(): array
    {
        $itens = $this->getModel()
            ->query()
            ->select('future_gain.*', 'wallets.name')
            ->join('wallets', 'future_gain.wallet_id', '=', 'wallets.id')
            ->orderBy('id', 'desc')
            ->get();
        return $itens ? $this->getResource()->arrayToDtoItens($itens->toArray()) : [];
    }
}
