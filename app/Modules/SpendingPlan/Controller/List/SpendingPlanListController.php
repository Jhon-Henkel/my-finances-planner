<?php

namespace App\Modules\SpendingPlan\Controller\List;

use App\Infra\Controller\List\BaseListController;
use App\Infra\Shared\UseCase\List\IListUseCase;
use App\Modules\SpendingPlan\UseCase\SpendingPlanListUseCase;

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
