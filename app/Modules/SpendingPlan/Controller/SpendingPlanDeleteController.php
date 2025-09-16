<?php

namespace App\Modules\SpendingPlan\Controller;

use App\Infra\Controller\Delete\BaseDeleteControllerV2;
use App\Infra\UseCase\Delete\IDeleteUseCase;
use App\Modules\SpendingPlan\UseCase\SpendingPlanDeleteUseCase;

class SpendingPlanDeleteController extends BaseDeleteControllerV2
{
    public function __construct(private SpendingPlanDeleteUseCase $useCase)
    {
    }

    protected function getUseCase(): IDeleteUseCase
    {
        return $this->useCase;
    }
}
