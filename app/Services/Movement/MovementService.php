<?php

namespace App\Services\Movement;

use App\DTO\Date\DatePeriodDTO;
use App\DTO\FutureGainDTO;
use App\DTO\FutureSpentDTO;
use App\DTO\Movement\MovementDTO;
use App\DTO\Movement\MovementSumValuesDTO;
use App\Enums\DateEnum;
use App\Enums\MovementEnum;
use App\Exceptions\MovementException;
use App\Factory\DataGraphFactory;
use App\Repositories\Movement\MovementRepository;
use App\Resources\Movement\MovementResource;
use App\Services\BasicService;
use App\Services\WalletService;
use App\Tools\Calendar\CalendarTools;

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
     * @return MovementDTO[]
     */
    public function findByFilter(array $filterOption): array
    {
        $type = MovementEnum::ALL;
        if (isset($filterOption['type'])) {
            $type = $this->validateType($filterOption['type']);
        }
        $dateRange = CalendarTools::makeDateRangeByDefaultFilterParams($filterOption);
        return $this->repository->findByPeriodAndType($dateRange, $type);
    }

    protected function validateType(null|int $type): int
    {
        if (! $type) {
            return MovementEnum::ALL;
        }
        if (! in_array($type, [MovementEnum::TRANSFER, MovementEnum::GAIN, MovementEnum::SPENT])) {
            return MovementEnum::ALL;
        }
        return $type;
    }

    protected function getFilter(int $option): DatePeriodDTO
    {
        return match ($option) {
            MovementEnum::FILTER_BY_LAST_MONTH => CalendarTools::getLastMonthPeriod(),
            MovementEnum::FILTER_BY_THIS_YEAR => CalendarTools::getThisYearPeriod(),
            default => CalendarTools::getThisMonthPeriod(),
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
        $walletService->updateWalletValue($movement->getAmount(), $movement->getWalletId(), $type, true);
        return parent::deleteById($id);
    }

    public function deleteTransferById(int $id)
    {
        $movement = $this->findById($id);
        if (! $movement || $movement->getType() != MovementEnum::TRANSFER) {
            return false;
        }
        $walletService = app(WalletService::class);
        if (str_contains($movement->getDescription(), 'Saída')) {
            $walletService->updateWalletValue($movement->getAmount(), $movement->getWalletId(), MovementEnum::GAIN, true);
        } elseif (str_contains($movement->getDescription(), 'Entrada')) {
            $walletService->updateWalletValue($movement->getAmount(), $movement->getWalletId(), MovementEnum::SPENT, true);
        }
        return $this->parentDeleteById($id);
    }

    protected function parentDeleteById(int $id)
    {
        return parent::deleteById($id);
    }

    public function insert($item)
    {
        $walletService = app(WalletService::class);
        $walletService->updateWalletValue($item->getAmount(), $item->getWalletId(), $item->getType(), true);
        return parent::insert($item);
    }

    public function insertWithWalletUpdateType(MovementDTO $item, int $walletUpdateType)
    {
        $walletService = app(WalletService::class);
        $walletService->updateWalletValue($item->getAmount(), $item->getWalletId(), $walletUpdateType, true);
        return $this->parentInert($item);
    }

    protected function parentInert(MovementDTO $item)
    {
        return parent::insert($item);
    }

    public function update(int $id, $item)
    {
        $movement = $this->findById($id);
        $walletService = app(WalletService::class);
        if ($movement->getAmount() != $item->getAmount()) {
            $type = $this->getTypeForMovementUpdate($movement, $item);
            if ($type == MovementEnum::GAIN) {
                $value = round($item->getAmount() - $movement->getAmount(), 2);
            } else {
                $value = round($movement->getAmount() - $item->getAmount(), 2);
            }
            $walletService->updateWalletValue(abs($value), $movement->getWalletId(), $type, true);
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

    public function getMonthSumMovementsByOptionFilter(int $option): array
    {
        $period = $this->getFilter($option);
        return $this->repository->getSumMovementsByPeriod($period);
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
        $dataGraph = new DataGraphFactory();
        foreach ($movements as $movement) {
            $dataGraph->addLabel(DateEnum::getMonthNameByNumber($movement['month']));
            $dataGraph->addValue($movement['type'], $movement['total']);
        }
        return $dataGraph->getAllDataArray();
    }

    public function countByWalletId(int $walletId): int
    {
        return $this->getRepository()->countByWalletId($walletId);
    }

    public function getSumValuesForPeriod(DatePeriodDTO $period, ?int $tenantId = null): MovementSumValuesDTO
    {
        $movements = $this->getRepository()->findByPeriod($period, $tenantId);
        return $this->makeMovementSumValuesDTO($movements);
    }

    protected function makeMovementSumValuesDTO(array $movements): MovementSumValuesDTO
    {
        $gain = 0;
        $spent = 0;
        foreach ($movements as $movement) {
            if ($movement->getType() == MovementEnum::GAIN) {
                $gain += $movement->getAmount();
            } elseif ($movement->getType() == MovementEnum::SPENT) {
                $spent += $movement->getAmount();
            }
        }
        $balance = round($gain - $spent, 2);
        return new MovementSumValuesDTO($gain, $spent, $balance);
    }
}