<?php

namespace App\Modules\Old\EarningsPlan\Controller\List;

use App\Infra\Controller\Read\BaseListController;
use App\Infra\UseCase\Read\IListUseCase;
use App\Modules\Old\EarningsPlan\UseCase\List\EarningPlanListUseCase;

class EarningPlanListController extends BaseListController
{
    public function __construct(protected EarningPlanListUseCase $useCase)
    {
    }

    protected function getUseCase(): IListUseCase
    {
        return $this->useCase;
    }
}
