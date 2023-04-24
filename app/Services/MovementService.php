<?php

namespace App\Services;

use App\DTO\DatePeriodDTO;
use App\DTO\FutureGainDTO;
use App\DTO\MovementDTO;
use App\Enums\MovementEnum;
use App\Repositories\MovementRepository;
use App\Tools\CalendarTools;

class MovementService extends BasicService
{
    protected MovementRepository $repository;

    public function __construct(MovementRepository $repository)
    {
        $this->repository = $repository;
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
        // todo adicionar o nome do mês do ganho na descrição
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
        $walletService->updateWalletValue($movement->getAmount(), $movement->getWalletId(), $type);
        return parent::deleteById($id);
    }
}