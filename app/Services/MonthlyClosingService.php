<?php

namespace App\Services;

use App\DTO\DatePeriodDTO;
use App\DTO\MailMessageDTO;
use App\DTO\MonthlyClosingDTO;
use App\Enums\MonthlyCLosingEnum;
use App\Exceptions\FilterException;
use App\Models\User;
use App\Repositories\MonthlyClosingRepository;
use App\Tools\CalendarTools;
use App\VO\Chart\ChartDataVO;
use App\VO\Chart\DatasetsVO;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

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
        $data = $this->getRepository()->findByPeriod($filter);
        return $this->addChartData($data);
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

    /**
     * @param MonthlyClosingDTO[] $data
     */
    protected function addChartData(array $data): array
    {
        $labels = [];
        $data = array_reverse($data);
        $predictedEarnings = new DatasetsVO('Receita Prevista', '#096452', '#096452');
        $realEarnings = new DatasetsVO('Receita Real', '#12c4a1', '#12c4a1');
        $predictedExpenses = new DatasetsVO('Despesa Prevista', '#f1676c', '#f1676c');
        $realExpenses = new DatasetsVO('Despesa Real', '#eb4e2c', '#eb4e2c');
        $balance = new DatasetsVO('Balanço', '#e0c857', '#e0c857');
        foreach ($data as $item) {
            $labels[] = CalendarTools::getMonthLabelWithYear($item->getCreatedAt());
            $predictedEarnings->addData($item->getPredictedEarnings());
            $realEarnings->addData($item->getRealEarnings());
            $predictedExpenses->addData($item->getPredictedExpenses());
            $realExpenses->addData($item->getRealExpenses());
            $balance->addData($item->getBalance());
        }
        $chartDataArray = [$predictedEarnings, $realEarnings, $predictedExpenses, $realExpenses, $balance];
        $chartData = new ChartDataVO($labels, $chartDataArray);
        return ['chartData' => $chartData, 'data' => $data];
    }

    public function generateMonthlyClosing(): MonthlyClosingDTO
    {
        $lastClosing = $this->getRepository()->findLast();
        if ($lastClosing) {
            $this->updateLastMonthlyClosing($lastClosing);
        }
        $monthlyClosing = $this->createMonthlyClosing();
        return $this->getRepository()->insert($monthlyClosing);
    }

    protected function updateLastMonthlyClosing(MonthlyClosingDTO $lastClosing): void
    {
        $period = CalendarTools::getMonthPeriodFromDate($lastClosing->getCreatedAt());
        $movementService = app(MovementService::class);
        $sumValues = $movementService->getSumValuesForPeriod($period);
        $lastClosing->setRealEarning($sumValues->getEarnings());
        $lastClosing->setRealExpenses($sumValues->getExpenses());
        $lastClosing->setBalance();
        $this->getRepository()->update($lastClosing->getId(), $lastClosing);
    }

    protected function createMonthlyClosing(): MonthlyClosingDTO
    {
        $predicatedEarnings = app(FutureGainService::class)->getThisMonthFutureGainSum();
        $predicatedExpenses = app(FutureSpentService::class)->getThisMonthFutureSpentSum();
        return new MonthlyClosingDTO(null, $predicatedEarnings, $predicatedExpenses);
    }

    public function generateMailMonthlyClosingDone(string $email, string $name): MailMessageDTO
    {
        $subject = 'Fechamento Mensal Realizado';
        $template = 'emails.monthlyClosingDone';
        $params = ['link' => env('APP_URL') . '/ferramentas/fechamento-mensal', 'name' => $name];
        return new MailMessageDTO($email, $name, $subject, $template, $params);
    }
}