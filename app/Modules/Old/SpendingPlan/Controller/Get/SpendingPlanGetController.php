<?php

namespace App\Modules\Old\SpendingPlan\Controller\Get;

use App\Infra\Controller\Read\BaseGetController;
use App\Infra\UseCase\Read\IGetUseCase;
use App\Modules\Old\SpendingPlan\UseCase\SpendingPlanGetUseCase;

class SpendingPlanGetController extends BaseGetController
{
    public function __construct(protected SpendingPlanGetUseCase $useCase)
    {
    }

    protected function getUseCase(): IGetUseCase
    {
        return $this->useCase;
    }
}
