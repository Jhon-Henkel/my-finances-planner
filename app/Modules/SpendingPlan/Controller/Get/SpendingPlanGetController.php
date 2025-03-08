<?php

namespace App\Modules\SpendingPlan\Controller\Get;

use App\Infra\Controller\Get\BaseGetController;
use App\Infra\Shared\UseCase\Get\IGetUseCase;
use App\Modules\SpendingPlan\UseCase\SpendingPlanGetUseCase;

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
