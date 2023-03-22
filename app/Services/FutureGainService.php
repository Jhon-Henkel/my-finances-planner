<?php

namespace App\Services;

use App\DTO\FutureGainDTO;
use App\Repositories\FutureGainRepository;
use App\Tools\CalendarTools;
use Exception;

class FutureGainService extends BasicService
{
    protected FutureGainRepository $repository;

    public function __construct(FutureGainRepository $repository)
    {
        $this->repository = $repository;
    }
    protected function getRepository(): FutureGainRepository
    {
        return $this->repository;
    }

    public function getNextSixMonthsGroupByDate(): ?array
    {
        // todo melhorar esse método, a responsabilidade de formar datas deve ficar na classe CalendarTools
        $months = CalendarTools::getNextSixMonths(CalendarTools::getThisMonth());
        $year = CalendarTools::getThisYear();
        $dateStart = $year . '-' . $months[0] . '-01 00:00:00';
        if ($months[5] < $months[0]) {
            $year = (int)$year + 1;
        }
        $dateEnd = $year . '-' . $months[5] . '-31 23:59:59';
        return $this->repository->getAllByPeriod($dateStart, $dateEnd);
    }

    /**
     * @param FutureGainDTO [] $data
     * @return array
     * @throws Exception
     */
    public function populateItensForCrud(array $data): array
    {
        $dataProcessed = [];
        foreach ($data as $item) {
            $month = CalendarTools::getMonthFromDate($item->getForecast());
            $name = $item->getDescription();
            $dataProcessed[$name]['data'][$month]['month'] = $item->getForecast();
            $dataProcessed[$name]['data'][$month]['id'] = $item->getId();
            $dataProcessed[$name]['data'][$month]['amount'] = $item->getAmount();
            $dataProcessed[$name]['day'] = CalendarTools::getDayFromDate($item->getForecast());
            $dataProcessed[$name]['name'] = $item->getDescription();
            $dataProcessed[$name]['wallet'] = $item->getWalletId();
        }
        return $dataProcessed;
    }
}