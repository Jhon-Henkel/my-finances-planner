<?php

namespace App\Repositories;

use App\DTO\DatePeriodDTO;
use App\DTO\MovementDTO;
use App\Enums\BasicFieldsEnum;
use App\Models\MovementModel;
use App\Resources\MovementResource;

class MovementRepository extends BasicRepository
{
    protected MovementModel $model;
    protected MovementResource $resource;

    public function __construct(MovementModel $model)
    {
        $this->model = $model;
        $this->resource = app(MovementResource::class);
    }

    protected function getModel(): MovementModel
    {
        return $this->model;
    }

    protected function getResource(): MovementResource
    {
        return $this->resource;
    }

    /**
     * @param array $period
     * @return MovementDTO[]
     */
    public function findByPeriod(DatePeriodDTO $period): array
    {
        $itens = $this->model::select('movements.*', 'wallets.name')
            ->where('movements.created_at', '>', $period->getStartDate())
            ->where('movements.created_at', '<', $period->getEndDate())
            ->join('wallets', 'movements.wallet_id', '=', 'wallets.id')
            ->orderBy(BasicFieldsEnum::ID, 'desc')
            ->get();
        return $this->resource->arrayToDtoItens($itens->toArray());
    }

    public function getSumMovementsByPeriod(DatePeriodDTO $period): array
    {
        return $this->model::selectRaw('sum(amount) as total, type')
            ->where('created_at', '>', $period->getStartDate())
            ->where('created_at', '<', $period->getEndDate())
            ->groupBy('type')
            ->get()
            ->toArray();
    }

    public function getLastFiveMovements(): array
    {
        $itens = $this->model::select('movements.*', 'wallets.name')
            ->join('wallets', 'movements.wallet_id', '=', 'wallets.id')
            ->orderBy(BasicFieldsEnum::ID, 'desc')
            ->limit(5)
            ->get();
        return $this->resource->arrayToDtoItens($itens->toArray());
    }
}