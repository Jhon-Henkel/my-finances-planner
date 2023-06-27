<?php

namespace App\Services;

use App\DTO\DatePeriodDTO;
use App\Enums\MonthlyCLosingEnum;
use App\Exceptions\FilterException;
use App\Repositories\MonthlyClosingRepository;
use App\Tools\CalendarTools;

class MonthlyClosingService extends BasicService
{
    private MonthlyClosingRepository $repository;

    public function __construct(MonthlyClosingRepository $repository)
    {
        $this->repository = $repository;
    }

    protected function getRepository(): MonthlyClosingRepository
    {
        return $this->repository;
    }

    public function findByFilter(int $filterOption): array
    {
        $filter = $this->getFilter($filterOption);
        return $this->getRepository()->findByPeriod($filter);
    }

    protected function getFilter(int $filterOption): DatePeriodDTO
    {
        $year = $this->getThisYear();
        return match ($filterOption) {
            MonthlyCLosingEnum::THIS_YEAR => CalendarTools::getThisYearPeriod($year),
            MonthlyCLosingEnum::LAST_YEAR => CalendarTools::getThisYearPeriod(($year - 1)),
            MonthlyCLosingEnum::LAST_FIVE_YEARS => CalendarTools::getLastFiveYearPeriod($year),
            default => throw new FilterException('Opção de filtro inválida')
        };
    }

    protected function getThisYear(): string
    {
        return CalendarTools::getThisYear();
    }
}