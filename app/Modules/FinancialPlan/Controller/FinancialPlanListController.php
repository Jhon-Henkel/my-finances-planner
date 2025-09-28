<?php

namespace App\Modules\FinancialPlan\Controller;

use App\Infra\Controller\Read\BaseListController;
use App\Infra\UseCase\Read\IListUseCase;
use App\Modules\FinancialPlan\UseCase\FinancialPlanListUseCase;

class FinancialPlanListController extends BaseListController
{
    public function __construct(private FinancialPlanListUseCase $useCase)
    {
    }

    protected function getUseCase(): IListUseCase
    {
        return $this->useCase;
    }
}
