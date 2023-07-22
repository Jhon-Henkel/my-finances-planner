<?php

namespace App\Repositories\Movement;

use App\DTO\Date\DatePeriodDTO;
use App\DTO\Movement\MovementDTO;
use App\Enums\BasicFieldsEnum;
use App\Models\MovementModel;
use App\Repositories\BasicRepository;
use App\Resources\Movement\MovementResource;
use App\Tools\CalendarTools;

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
            ->where('movements.created_at', '>=', $period->getStartDate())
            ->where('movements.created_at', '<=', $period->getEndDate())
            ->join('wallets', 'movements.wallet_id', '=', 'wallets.id')
            ->orderBy(BasicFieldsEnum::ID, 'desc')
            ->get();
        return $this->resource->arrayToDtoItens($itens->toArray());
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
            ->orderBy(BasicFieldsEnum::ID, 'desc')
            ->limit($limit)
            ->get();
        return $this->resource->arrayToDtoItens($itens->toArray());
    }

    public function getLastTwelveMonthsSumGroupByTypeAndMonth(): array
    {
        return $this->model::selectRaw('sum(amount) as total, type, month(created_at) as month')
            ->where('created_at', '>=', (CalendarTools::getThisYear() - 1))
            ->groupBy('month')
            ->groupBy('type')
            ->get()
            ->toArray();
    }

    public function countByWalletId(int $walletId): int
    {
        return $this->model::where('wallet_id', $walletId)->count();
    }
}