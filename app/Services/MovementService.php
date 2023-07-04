<?php

namespace App\Services;

use App\DTO\DatePeriodDTO;
use App\DTO\FutureGainDTO;
use App\DTO\FutureSpentDTO;
use App\DTO\MovementDTO;
use App\DTO\MovementSumValuesDTO;
use App\Enums\DateEnum;
use App\Enums\MovementEnum;
use App\Exceptions\MovementException;
use App\Repositories\MovementRepository;
use App\Resources\MovementResource;
use App\Tools\CalendarTools;

class MovementService extends BasicService
{
    protected MovementRepository $repository;
    protected MovementResource $resource;

    public function __construct(MovementRepository $repository)
    {
        $this->repository = $repository;
        $this->resource = app(MovementResource::class);
    }

    protected function getRepository(): MovementRepository
    {
        return $this->repository;
    }

    /**
     * @param int $type
     * @return MovementDTO[]
     */
    public function findAllByType(int $type): array
    {
        return $this->repository->findAllByType($type);
    }

    /**
     * @param int $filterOption
     * @return MovementDTO[]
     */
    public function findByFilter(int $filterOption): array
    {
        $filter = $this->getFilter($filterOption);
        return $this->repository->findByPeriod($filter);
    }

    protected function getFilter(int $option): DatePeriodDTO
    {
        return match ($option) {
            MovementEnum::FILTER_BY_LAST_MONTH => CalendarTools::getLastMonthPeriod(
                CalendarTools::getThisMonth(),
                CalendarTools::getThisYear()
            ),
            MovementEnum::FILTER_BY_THIS_YEAR => CalendarTools::getThisYearPeriod(CalendarTools::getThisYear()),
            default => CalendarTools::getThisMonthPeriod(CalendarTools::getThisMonth(), CalendarTools::getThisYear()),
        };
    }

    public function populateByFutureGain(FutureGainDTO $gain): MovementDTO
    {
        $movement = new MovementDTO();
        $movement->setWalletId($gain->getWalletId());
        $movement->setDescription('Recebimento ' . $gain->getDescription());
        $movement->setType(MovementEnum::GAIN);
        $movement->setAmount($gain->getAmount());
        return $movement;
    }

    public function populateByFutureSpent(FutureSpentDTO $spent): MovementDTO
    {
        $movement = new MovementDTO();
        $movement->setWalletId($spent->getWalletId());
        $movement->setDescription('Pagamento ' . $spent->getDescription());
        $movement->setType(MovementEnum::SPENT);
        $movement->setAmount($spent->getAmount());
        return $movement;
    }

    public function deleteById(int $id)
    {
        $movement = $this->findById($id);
        if (! $movement) {
            return false;
        }
        $walletService = app(WalletService::class);
        $type = $movement->getType() == MovementEnum::GAIN ? MovementEnum::SPENT : MovementEnum::GAIN;
        $walletService->updateWalletValue($movement->getAmount(), $movement->getWalletId(), $type, false);
        return parent::deleteById($id);
    }

    public function insert($item)
    {
        $walletService = app(WalletService::class);
        $walletService->updateWalletValue($item->getAmount(), $item->getWalletId(), $item->getType(), true);
        return parent::insert($item);
    }

    public function update(int $id, $item)
    {
        $movement = $this->findById($id);
        $walletService = app(WalletService::class);
        if ($movement->getAmount() != $item->getAmount()) {
            $type = $this->getTypeForMovementUpdate($movement, $item);
            $value = round($movement->getAmount() - $item->getAmount(), 2);
            $walletService->updateWalletValue($value, $movement->getWalletId(), $type, true);
        } elseif ($movement->getType() != $item->getType()) {
            $walletService->updateWalletValue($item->getAmount(), $item->getWalletId(), $item->getType(), true);
        }
        return parent::update($id, $item);
    }

    protected function getTypeForMovementUpdate(MovementDTO $movement, MovementDTO $item): int
    {
        if ($movement->getType() == MovementEnum::GAIN && $movement->getAmount() > $item->getAmount()) {
            return MovementEnum::SPENT;
        } elseif ($movement->getType() == MovementEnum::GAIN && $movement->getAmount() < $item->getAmount()) {
            return MovementEnum::GAIN;
        } elseif ($movement->getType() == MovementEnum::SPENT && $movement->getAmount() > $item->getAmount()) {
            return MovementEnum::GAIN;
        } elseif ($movement->getType() == MovementEnum::SPENT && $movement->getAmount() < $item->getAmount()) {
            return MovementEnum::SPENT;
        }
        throw new MovementException('Tipo de movimento não identificado!');
    }

    public function launchMovementForWalletUpdate(float $value, int $walletId): bool
    {
        $movement = $this->resource->populateMovementForWalletUpdate($value, $walletId);
        $this->getRepository()->insert($movement);
        return true;
    }

    public function launchMovementForCreditCardInvoicePay(int $walletId, float $totalValue, string $cardName): bool
    {
        $movement = new MovementDTO();
        $movement->setWalletId($walletId);
        $movement->setDescription('Fatura cartão ' . $cardName);
        $movement->setType(MovementEnum::SPENT);
        $movement->setAmount($totalValue);
        $this->insert($movement);
        return true;
    }

    public function getMonthSumMovementsByOptionFilter(int $option): array
    {
        $period = $this->getFilter($option);
        return $this->repository->getSumMovementsByPeriod($period);
    }

    /**
     * @return MovementDTO[]
     */
    public function getLastMovements(int $limit): array
    {
        $items = $this->repository->getLastMovements($limit);
        return $this->resource->arrayDtoToVoItens($items);
    }

    public function generateDataForGraph(): array
    {
        $movements = $this->getRepository()->getLastTwelveMonthsSumGroupByTypeAndMonth();
        $labels = [];
        $gainData = [];
        $spentData = [];
        foreach ($movements as $movement) {
            if (! in_array(DateEnum::getMonthNameByNumber($movement['month']), $labels)) {
                $labels[] = DateEnum::getMonthNameByNumber($movement['month']);
            }
            if ($movement['type'] == MovementEnum::GAIN) {
                $gainData[] = (float)$movement['total'];
            } else if ($movement['type'] == MovementEnum::SPENT) {
                $spentData[] = (float)$movement['total'];
            }
        }
        return [
            'labels' => $labels,
            'gainData' => $gainData,
            'spentData' => $spentData,
        ];
    }

    public function countByWalletId(int $walletId): int
    {
        return $this->getRepository()->countByWalletId($walletId);
    }

    public function getSumValuesForPeriod(DatePeriodDTO $period): MovementSumValuesDTO
    {
        $movements = $this->getRepository()->findByPeriod($period);
        $gain = 0;
        $spent = 0;
        foreach ($movements as $movement) {
            if ($movement->getType() == MovementEnum::GAIN) {
                $gain += $movement->getAmount();
            } else {
                $spent += $movement->getAmount();
            }
        }
        $balance = round($gain - $spent, 2);
        return new MovementSumValuesDTO($gain, $spent, $balance);
    }
}