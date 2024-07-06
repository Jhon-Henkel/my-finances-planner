<?php

namespace App\Services\Tools;

use App\DTO\Mail\MailMessageDTO;
use App\DTO\Tools\MonthlyClosingDTO;
use App\Models\User;
use App\Repositories\Tools\MonthlyClosingRepository;
use App\Services\BasicService;
use App\Services\FutureMovement\FutureGainService;
use App\Services\FutureMovement\FutureSpentService;
use App\Services\Movement\MovementService;
use App\Tools\Calendar\CalendarTools;
use App\Tools\NumberTools;
use App\VO\Chart\ChartDataVO;
use App\VO\Chart\DatasetsVO;

class MonthlyClosingService extends BasicService
{
    public function __construct(
        private readonly MonthlyClosingRepository $repository,
        private readonly MovementService $movementService,
        private readonly FutureGainService $futureGainService,
        private readonly FutureSpentService $futureSpentService,
        private readonly MarketPlannerService $marketPlannerService
    ) {
    }

    protected function getRepository(): MonthlyClosingRepository
    {
        return $this->repository;
    }

    public function findByFilter(array $filterOption, int $tenantId): array
    {
        $filter = CalendarTools::makeDateRangeByDefaultFilterParams($filterOption);
        $data = $this->getRepository()->findByPeriodAndTenantId($filter, $tenantId);
        return $this->addChartData($data);
    }

    /** @param MonthlyClosingDTO[] $data */
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

    public function generateMonthlyClosing(User $user): MonthlyClosingDTO
    {
        $tenantId = $user->tenant_id;
        $lastClosing = $this->getRepository()->findLast($tenantId);
        if ($lastClosing) {
            $this->updateLastMonthlyClosing($lastClosing, $tenantId);
        }
        $monthlyClosing = $this->createMonthlyClosing($tenantId);
        return $this->getRepository()->insert($monthlyClosing);
    }

    protected function updateLastMonthlyClosing(MonthlyClosingDTO $lastClosing, int $tenantId): void
    {
        $period = CalendarTools::getMonthPeriodFromDate($lastClosing->getCreatedAt());
        $sumValues = $this->movementService->getSumValuesForPeriod($period, $tenantId);
        $lastClosing->setRealEarning($sumValues->getEarnings());
        $lastClosing->setRealExpenses($sumValues->getExpenses());
        $lastClosing->setBalance();
        $this->getRepository()->update($lastClosing->getId(), $lastClosing);
    }

    protected function createMonthlyClosing(int $tenantId): MonthlyClosingDTO
    {
        $predicatedEarnings = $this->futureGainService->getThisMonthFutureGainSum($tenantId);
        $predicatedExpenses = $this->futureSpentService->getThisMonthFutureSpentSum($tenantId);
        $marketPlannerValue = 0;
        if ($this->marketPlannerService->useMarketPlanner()) {
            $marketPlannerValue = $this->marketPlannerService->getMarketPlannerInvoice()->firstInstallment;
        }
        return new MonthlyClosingDTO(
            id: null,
            predictedEarnings: $predicatedEarnings,
            predictedExpenses: NumberTools::roundFloatAmount($predicatedExpenses + $marketPlannerValue),
            tenantId: $tenantId
        );
    }

    public function generateMailMonthlyClosingDone(string $email, string $name): MailMessageDTO
    {
        $subject = 'Fechamento Mensal Realizado';
        $template = 'emails.monthlyClosingDone';
        $params = ['link' => env('APP_URL') . '/ferramentas/fechamento-mensal', 'name' => $name];
        return new MailMessageDTO($email, $name, $subject, $template, $params);
    }
}
