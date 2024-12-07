<?php

namespace App\Services\Movement;

use App\DTO\Date\DatePeriodDTO;
use App\DTO\FutureMovement\FutureGainDTO;
use App\DTO\FutureMovement\FutureSpentDTO;
use App\DTO\Movement\MovementDTO;
use App\DTO\Movement\MovementSumValuesDTO;
use App\Enums\CalendarMonthsNumberEnum;
use App\Enums\MovementEnum;
use App\Exceptions\MovementException;
use App\Factory\DataGraph\Movement\DataGraphMovementFactory;
use App\Modules\Wallet\Service\WalletService;
use App\Repositories\Movement\MovementRepository;
use App\Resources\Movement\MovementResource;
use App\Services\BasicService;
use App\Tools\Calendar\CalendarTools;
use App\Tools\NumberTools;
use App\VO\Movement\MovementVO;

class MovementService extends BasicService
{
    public function __construct(
        private readonly MovementRepository $repository,
        private readonly MovementResource $resource,
        private readonly WalletService $walletService,
    ) {
        $walletService->setMovementService($this);
    }

    protected function getRepository(): MovementRepository
    {
        return $this->repository;
    }

    /** @return MovementDTO[] */
    public function findAllByType(int $type): array
    {
        return $this->repository->findAllByType($type);
    }

    /** @return MovementDTO[] */
    public function findByFilter(array $filterOption): array
    {
        $type = MovementEnum::All->value;
        if (isset($filterOption['type'])) {
            $type = $this->validateType($filterOption['type']);
        }
        $dateRange = CalendarTools::makeDateRangeByDefaultFilterParams($filterOption);
        return $this->repository->findByPeriodAndType($dateRange, $type);
    }

    protected function validateType(null|int $type): int
    {
        if (! $type) {
            return MovementEnum::All->value;
        }
        if (! in_array($type, MovementEnum::getTypesValidForFilter())) {
            return MovementEnum::All->value;
        }
        return $type;
    }

    protected function getFilter(int $option): DatePeriodDTO
    {
        return match ($option) {
            MovementEnum::FilterByLastMonth->value => CalendarTools::getLastMonthPeriod(),
            MovementEnum::FilterByThisYear->value => CalendarTools::getThisYearPeriod(),
            default => CalendarTools::getThisMonthPeriod(),
        };
    }

    public function populateByFutureGain(FutureGainDTO $gain): MovementDTO
    {
        $movement = new MovementDTO();
        $movement->setWalletId($gain->getWalletId());
        $movement->setDescription('Recebimento ' . $gain->getDescription());
        $movement->setType(MovementEnum::Gain->value);
        $movement->setAmount($gain->getAmount());
        return $movement;
    }

    public function populateByFutureSpent(FutureSpentDTO $spent): MovementDTO
    {
        $movement = new MovementDTO();
        $movement->setWalletId($spent->getWalletId());
        $movement->setDescription('Pagamento ' . $spent->getDescription());
        $movement->setType(MovementEnum::Spent->value);
        $movement->setAmount($spent->getAmount());
        return $movement;
    }

    public function deleteById(int $id)
    {
        $movement = $this->findById($id);
        if (! $movement) {
            return false;
        }
        $type = $movement->getType() == MovementEnum::Gain->value ? MovementEnum::Spent->value : MovementEnum::Gain->value;
        $this->walletService->updateWalletValue($movement->getAmount(), $movement->getWalletId(), $type, true);
        return parent::deleteById($id);
    }

    public function deleteTransferById(int $id)
    {
        $movement = $this->findById($id);
        if (! $movement || $movement->getType() != MovementEnum::Transfer->value) {
            return false;
        }
        if (str_contains($movement->getDescription(), 'Saída')) {
            $this->walletService->updateWalletValue($movement->getAmount(), $movement->getWalletId(), MovementEnum::Gain->value, true);
        } elseif (str_contains($movement->getDescription(), 'Entrada')) {
            $this->walletService->updateWalletValue($movement->getAmount(), $movement->getWalletId(), MovementEnum::Spent->value, true);
        }
        return $this->parentDeleteById($id);
    }

    protected function parentDeleteById(int $id)
    {
        return parent::deleteById($id);
    }

    public function insert($item)
    {
        $this->walletService->updateWalletValue($item->getAmount(), $item->getWalletId(), $item->getType(), true);
        return parent::insert($item);
    }

    public function insertWithWalletUpdateType(MovementDTO $item, int $walletUpdateType)
    {
        $this->walletService->updateWalletValue($item->getAmount(), $item->getWalletId(), $walletUpdateType, true);
        return $this->parentInert($item);
    }

    protected function parentInert(MovementDTO $item)
    {
        return parent::insert($item);
    }

    public function update(int $id, $item)
    {
        $movement = $this->findById($id);
        if ($movement->getAmount() != $item->getAmount()) {
            $type = $this->getTypeForMovementUpdate($movement, $item);
            if ($type == MovementEnum::Gain->value) {
                $value = NumberTools::roundFloatAmount($item->getAmount() - $movement->getAmount());
            } else {
                $value = NumberTools::roundFloatAmount($movement->getAmount() - $item->getAmount());
            }
            $this->walletService->updateWalletValue(abs($value), $movement->getWalletId(), $type, true);
        } elseif ($movement->getType() != $item->getType()) {
            $this->walletService->updateWalletValue($item->getAmount(), $item->getWalletId(), $item->getType(), true);
        }
        return parent::update($id, $item);
    }

    protected function getTypeForMovementUpdate(MovementDTO $movement, MovementDTO $item): int
    {
        if ($movement->getType() == MovementEnum::Gain->value && $movement->getAmount() > $item->getAmount()) {
            return MovementEnum::Spent->value;
        } elseif ($movement->getType() == MovementEnum::Gain->value && $movement->getAmount() < $item->getAmount()) {
            return MovementEnum::Gain->value;
        } elseif ($movement->getType() == MovementEnum::Spent->value && $movement->getAmount() > $item->getAmount()) {
            return MovementEnum::Gain->value;
        } elseif ($movement->getType() == MovementEnum::Spent->value && $movement->getAmount() < $item->getAmount()) {
            return MovementEnum::Spent->value;
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
        $movement->setType(MovementEnum::Spent->value);
        $movement->setAmount($totalValue);
        $this->insert($movement);
        return true;
    }

    /** @return MovementVO[] */
    public function getLastMovements(int $limit): array
    {
        $items = $this->repository->getLastMovements($limit);
        return $this->resource->arrayDtoToVoItens($items);
    }

    public function generateDataForGraph(): DataGraphMovementFactory
    {
        $movements = $this->getRepository()->getLastMonthsSumGroupByTypeAndMonth(4);
        $dataGraph = new DataGraphMovementFactory();
        foreach ($movements as $movement) {
            $dataGraph->addLabel(CalendarMonthsNumberEnum::getMonthName($movement['month']));
            $dataGraph->addValue($movement['type'], $movement['total']);
        }
        return $dataGraph;
    }

    public function countByWalletId(int $walletId): int
    {
        return $this->getRepository()->countByWalletId($walletId);
    }

    public function getSumValuesForPeriod(DatePeriodDTO $period): MovementSumValuesDTO
    {
        $movements = $this->getRepository()->findByPeriod($period);
        return $this->makeMovementSumValuesDTO($movements);
    }

    /** @param MovementDTO[] $movements */
    protected function makeMovementSumValuesDTO(array $movements): MovementSumValuesDTO
    {
        $movementSum = new MovementSumValuesDTO();
        foreach ($movements as $movement) {
            if ($movement->isGain()) {
                $movementSum->addEarnings($movement->getAmount());
            } elseif ($movement->isSpent()) {
                $movementSum->addExpenses($movement->getAmount());
            }
        }
        return $movementSum;
    }
}
