<?php

namespace App\Repositories\Movement;

use App\DTO\Date\DatePeriodDTO;
use App\DTO\Movement\MovementDTO;
use App\Enums\DateFormatEnum;
use App\Models\MovementModel;
use App\Repositories\BasicRepository;
use App\Resources\Movement\MovementResource;
use App\Tools\Calendar\CalendarTools;

class MovementRepository extends BasicRepository
{
    public function __construct(
        private readonly MovementModel $model,
        private readonly MovementResource $resource
    ) {
    }

    protected function getModel(): MovementModel
    {
        return $this->model;
    }

    protected function getResource(): MovementResource
    {
        return $this->resource;
    }

    /** @return MovementDTO[] */
    public function findByPeriod(DatePeriodDTO $period, ?int $tenantId = null): array
    {
        $items = $this->getModel()
            ->query()
            ->select('movements.*', 'wallets.name')
            ->where('movements.created_at', '>=', $period->getStartDate())
            ->where('movements.created_at', '<=', $period->getEndDate());
        if ($tenantId) {
            $items->where('movements.tenant_id', '=', $tenantId);
        }
        $items->join('wallets', 'movements.wallet_id', '=', 'wallets.id')
            ->orderBy('id', 'desc');
        $items = $items->get();
        return $this->getResource()->arrayToDtoItens($items->toArray());
    }

    /** @return MovementDTO[] */
    public function findByPeriodAndType(DatePeriodDTO $period, int $type): array
    {
        $items = $this->getModel()
            ->query()
            ->select('movements.*', 'wallets.name')
            ->where('movements.created_at', '>=', $period->getStartDate())
            ->where('movements.created_at', '<=', $period->getEndDate());
        if ($type != 0) {
            $items->where('movements.type', '=', $type);
        }
        $items->join('wallets', 'movements.wallet_id', '=', 'wallets.id')
            ->orderBy('id', 'desc');
        $items = $items->get();
        return $this->getResource()->arrayToDtoItens($items->toArray());
    }

    public function getSumMovementsByPeriod(DatePeriodDTO $period): array
    {
        return $this->model::selectRaw('sum(amount) as total, type')
            ->where('created_at', '>=', $period->getStartDate())
            ->where('created_at', '<=', $period->getEndDate())
            ->groupBy('type')
            ->get()
            ->toArray();
    }

    public function getLastMovements(int $limit): array
    {
        $itens = $this->model::select('movements.*', 'wallets.name')
            ->join('wallets', 'movements.wallet_id', '=', 'wallets.id')
            ->orderBy('id', 'desc')
            ->limit($limit)
            ->get();
        return $this->resource->arrayToDtoItens($itens->toArray());
    }

    public function getLastMonthsSumGroupByTypeAndMonth(int $months): array
    {
        $dateNow = CalendarTools::getDateNow()->format(DateFormatEnum::DefaultDbDateFormat->value);
        $dateStart = CalendarTools::subMonthInDate($dateNow, $months);
        return $this->model::selectRaw(
            'sum(amount) as total, type, month(created_at) as month, year(created_at) as year'
        )->where('created_at', '>=', $dateStart)
            ->groupBy('year', 'month')
            ->groupBy('type')
            ->get()
            ->toArray();
    }

    public function countByWalletId(int $walletId): int
    {
        return $this->model::where('wallet_id', $walletId)->count();
    }
}