<?php

namespace App\Modules\SpendingPlan\Controller;

use App\Infra\Controller\Read\BaseGetControllerV2;
use App\Infra\UseCase\Read\IGetUseCase;
use App\Modules\SpendingPlan\UseCase\SpendingPlanGetUseCase;

class SpendingPlanGetController extends BaseGetControllerV2
{
    public function __construct(private SpendingPlanGetUseCase $useCase)
    {
    }

    protected function getUseCase(): IGetUseCase
    {
        return $this->useCase;
    }
}
