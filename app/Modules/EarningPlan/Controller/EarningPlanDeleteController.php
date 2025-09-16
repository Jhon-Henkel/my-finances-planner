<?php

namespace App\Modules\EarningPlan\Controller;

use App\Infra\Controller\Delete\BaseDeleteControllerV2;
use App\Infra\UseCase\Delete\IDeleteUseCase;
use App\Modules\EarningPlan\UseCase\EarningPlanDeleteUseCase;

class EarningPlanDeleteController extends BaseDeleteControllerV2
{
    public function __construct(private EarningPlanDeleteUseCase $useCase)
    {
    }

    protected function getUseCase(): IDeleteUseCase
    {
        return $this->useCase;
    }
}
