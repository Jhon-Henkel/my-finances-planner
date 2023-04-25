<?php

namespace App\Services;

use App\DTO\DatePeriodDTO;
use App\DTO\FutureGainDTO;
use App\DTO\MovementDTO;
use App\Enums\MovementEnum;
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
            MovementEnum::FILTER_BY_LAST_MONTH => $this->getLastMonthPeriod(),
            MovementEnum::FILTER_BY_THIS_YEAR => $this->getThisYearPeriod(),
            default => $this->getThisMonthPeriod(),
        };
    }

    protected function getLastMonthPeriod(): DatePeriodDTO
    {
        $period = CalendarTools::getLastMonthPeriod(CalendarTools::getThisMonth(), CalendarTools::getThisYear());
        return new DatePeriodDTO($period['start'], $period['end']);
    }

    protected function getThisYearPeriod(): DatePeriodDTO
    {
        $period = CalendarTools::getThisYearPeriod(CalendarTools::getThisYear());
        return new DatePeriodDTO($period['start'], $period['end']);
    }

    protected function getThisMonthPeriod(): DatePeriodDTO
    {
        $period = CalendarTools::getThisMonthPeriod(CalendarTools::getThisMonth(), CalendarTools::getThisYear());
        return new DatePeriodDTO($period['start'], $period['end']);
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
        // todo testar alterando a movimentação para outra carteira, deve adicionar o valor a carteira original e retirar da carteira destino
        $movement = $this->findById($id);
        $walletService = app(WalletService::class);
        if ($movement->getAmount() != $item->getAmount()) {
            $type = $this->getTypeForMovementUpdate($movement, $item);
            $value = abs($movement->getAmount() - $item->getAmount());
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
        $movement->setDescription('Pagamento de fatura do cartão de crédito ' . $cardName);
        $movement->setType(MovementEnum::SPENT);
        $movement->setAmount($totalValue);
        $this->insert($movement);
        return true;
    }
}