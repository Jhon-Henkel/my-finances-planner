<?php

namespace App\Modules\Old\SpendingPlan\Controller\List;

use App\Infra\Controller\Read\BaseListController;
use App\Infra\UseCase\Read\IListUseCase;
use App\Modules\Old\SpendingPlan\UseCase\SpendingPlanListUseCase;

class SpendingPlanListController extends BaseListController
{
    public function __construct(protected SpendingPlanListUseCase $useCase)
    {
    }

    protected function getUseCase(): IListUseCase
    {
        return $this->useCase;
    }
}
