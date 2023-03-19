<?php

namespace App\Services;

use App\DTO\MovementDTO;
use App\Enums\DateEnum;
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

    public function findByPeriod(int $periodCode): array
    {
        $period = $this->getDateForFilterPeriod($periodCode);
        return $this->repository->findByPeriod($period);
    }

    protected function getDateForFilterPeriod(int $periodCode): array
    {
        $period = [];
        $thisMonth = CalendarTools::getThisMonth();
        $thisYear = CalendarTools::getThisYear();
        switch ($periodCode) {
            case MovementEnum::FILTER_LAST_MONTH:
                $lastMonth = $thisMonth == '01' ? '12' : (int)$thisMonth - 1;
                $year = $thisMonth == '01' ? (int)$thisYear - 1 : $thisYear;
                $period[DateEnum::DATE_START_NAME] = $year . '-' . $lastMonth . '-01 00:00:00';
                $period[DateEnum::DATE_END_NAME] = $year . '-' . $lastMonth . '-31 23:59:59';
                break;
            case MovementEnum::FILTER_THIS_YEAR:
                $period[DateEnum::DATE_START_NAME] = $thisYear . '-01-01 00:00:00';
                $period[DateEnum::DATE_END_NAME] = $thisYear . '-12-31 23:59:59';
                break;
            case MovementEnum::FILTER_ALL:
                break;
            case MovementEnum::FILTER_THIS_MONTH:
            default:
                $period[DateEnum::DATE_START_NAME] = $thisYear . '-' . $thisMonth . '-01 00:00:00';
                $period[DateEnum::DATE_END_NAME] = $thisYear . '-' . $thisMonth . '-31 23:59:59';
            break;
        }
        return $period;
    }
}