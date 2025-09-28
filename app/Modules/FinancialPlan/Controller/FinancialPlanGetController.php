<?php

namespace App\Modules\FinancialPlan\Controller;

use App\Infra\Controller\Read\BaseGetController;
use App\Infra\UseCase\Read\IGetUseCase;
use App\Modules\FinancialPlan\UseCase\FinancialPlanGetUseCase;

class FinancialPlanGetController extends BaseGetController
{
    public function __construct(private FinancialPlanGetUseCase $useCase)
    {
    }

    protected function getUseCase(): IGetUseCase
    {
        return $this->useCase;
    }
}
