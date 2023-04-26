<?php

namespace App\Repositories;

use App\DTO\DatePeriodDTO;
use App\Enums\BasicFieldsEnum;
use App\Models\FutureGain;
use App\Resources\FutureGainResource;

class FutureGainRepository extends BasicRepository
{
    protected FutureGain $model;
    protected FutureGainResource $resource;

    public function __construct(FutureGain $model)
    {
        $this->model = $model;
        $this->resource = app(FutureGainResource::class);
    }

    protected function getModel(): FutureGain
    {
        return $this->model;
    }

    protected function getResource(): mixed
    {
        return $this->resource;
    }

    public function findByPeriod(DatePeriodDTO $period): array
    {
        $itens = $this->getModel()->select('future_gain.*', 'wallets.name')
            ->where('future_gain.forecast', '>', $period->getStartDate())
            ->where('future_gain.forecast', '<', $period->getEndDate())
            ->join('wallets', 'future_gain.wallet_id', '=', 'wallets.id')
            ->orderBy(BasicFieldsEnum::ID, 'desc')
            ->get();
        return $itens ? $this->getResource()->arrayToDtoItens($itens->toArray()) : array();
    }
}