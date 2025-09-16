<?php

namespace App\Modules\EarningPlan\Controller;

use App\Infra\Controller\Read\BaseListControllerV2;
use App\Infra\UseCase\Read\IListUseCaseV2;
use App\Modules\EarningPlan\UseCase\EarningPlanListUseCase;

class EarningPlanListController extends BaseListControllerV2
{
    public function __construct(private EarningPlanListUseCase $useCase)
    {
    }

    protected function getUseCase(): IListUseCaseV2
    {
        return $this->useCase;
    }
}
