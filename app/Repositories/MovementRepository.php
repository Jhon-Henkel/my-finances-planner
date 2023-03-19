<?php

namespace App\Repositories;

use App\DTO\MovementDTO;
use App\Enums\DateEnum;
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

    public function findAllByType(int $type): array
    {
        $itens = $this->model->where('type', $type)->get()->toArray();
        return $this->resource->arrayToDtoItens($itens);
    }

    /**
     * @param array $period
     * @return MovementDTO[]
     */
    public function findByPeriod(array $period): array
    {
        if (isset($period['all'])) {
            return $this->findAll();
        }
        $itens = $this->model::where('movements.created_at', '>', $period[DateEnum::DATE_START_NAME])
            ->where('movements.created_at', '<', $period[DateEnum::DATE_END_NAME])
            ->join('wallets', 'movements.wallet_id', '=', 'wallets.id')->get()->toArray();
        return $this->resource->arrayToDtoItens($itens);
    }
}