<?php

namespace App\Repositories;

use App\DTO\FutureGainDTO;
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

    /**
     * @param string $dateStart
     * @param string $dateEnd
     * @return FutureGainDTO[]|null
     */
    public function getAllByPeriod(string $dateStart, string $dateEnd): ?array
    {
        $item = $this->model->where('forecast', '>=', $dateStart)->where('forecast', '<=', $dateEnd)->get();
        return $item ? $this->getResource()->arrayToDtoItens($item->toArray()) : null;
    }
}