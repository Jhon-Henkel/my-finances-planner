<?php

namespace App\Modules\EarningPlan\Controller;

use App\Infra\Controller\Read\BaseGetControllerV2;
use App\Infra\UseCase\Read\IGetUseCase;
use App\Modules\EarningPlan\UseCase\EarningPlanGetUseCase;

class EarningPlanGetController extends BaseGetControllerV2
{
    public function __construct(private EarningPlanGetUseCase $useCase)
    {
    }

    protected function getUseCase(): IGetUseCase
    {
        return $this->useCase;
    }
}
