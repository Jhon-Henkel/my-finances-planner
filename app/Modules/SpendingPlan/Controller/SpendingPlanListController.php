<?php

namespace App\Modules\SpendingPlan\Controller;

use App\Infra\Controller\Read\BaseListControllerV2;
use App\Infra\UseCase\Read\IListUseCaseV2;
use App\Modules\SpendingPlan\UseCase\SpendingPlanListUseCase;

class SpendingPlanListController extends BaseListControllerV2
{
    public function __construct(private SpendingPlanListUseCase $useCase)
    {
    }

    protected function getUseCase(): IListUseCaseV2
    {
        return $this->useCase;
    }
}
