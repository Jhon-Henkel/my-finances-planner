<?php

namespace App\Repositories\Tools;

use App\DTO\Date\DatePeriodDTO;
use App\DTO\Tools\MonthlyClosingDTO;
use App\Models\MonthlyClosing;
use App\Repositories\BasicRepository;
use App\Resources\Tools\MonthlyClosingResource;

class MonthlyClosingRepository extends BasicRepository
{
    protected MonthlyClosing $model;
    protected MonthlyClosingResource $resource;

    public function __construct(MonthlyClosing $model, MonthlyClosingResource $resource)
    {
        $this->model = $model;
        $this->resource = $resource;
    }

    protected function getModel(): MonthlyClosing
    {
        return $this->model;
    }

    protected function getResource(): MonthlyClosingResource
    {
        return $this->resource;
    }

    public function findLast(int $tenantId): null|MonthlyClosingDTO
    {
        $last = $this->getModel()
            ->query()
            ->where('tenant_id', $tenantId)
            ->orderBy('id', 'desc')
            ->first();
        return $last ? $this->getResource()->arrayToDto($last->toArray()) : null;
    }

    public function findByPeriodAndTenantId(DatePeriodDTO $period, int $tenantId): array
    {
        $itens = $this->getModel()
            ->query()
            ->select()
            ->where('created_at', '>=', $period->getStartDate())
            ->where('created_at', '<=', $period->getEndDate())
            ->where('tenant_id', $tenantId)
            ->orderBy('id', 'desc')
            ->get();
        return $this->resource->arrayToDtoItens($itens->toArray());
    }
}