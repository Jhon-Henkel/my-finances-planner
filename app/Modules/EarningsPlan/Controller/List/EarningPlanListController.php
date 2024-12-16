<?php

namespace App\Modules\EarningsPlan\Controller\List;

use App\Infra\Controller\List\BaseListController;
use App\Infra\Shared\UseCase\List\IListUseCase;
use App\Modules\EarningsPlan\UseCase\List\EarningPlanListUseCase;

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
