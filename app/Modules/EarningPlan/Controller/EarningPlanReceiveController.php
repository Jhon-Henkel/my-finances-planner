<?php

namespace App\Modules\EarningPlan\Controller;

use App\Infra\Controller\Create\BaseCreateControllerV2;
use App\Infra\UseCase\Create\ICreateUseCaseV2;
use App\Modules\EarningPlan\UseCase\EarningPlanReceiveUseCase;

class EarningPlanReceiveController extends BaseCreateControllerV2
{
    public function __construct(private EarningPlanReceiveUseCase $useCase)
    {
    }

    protected function getUseCase(): ICreateUseCaseV2
    {
        return $this->useCase;
    }

    protected function getRules(): array
    {
        return [
            'planId' => 'required|integer|exists:earning_plan,id',
            'walletId' => 'required|integer|exists:wallets,id',
            'installmentNumber' => 'sometimes|integer|min:1',
        ];
    }
}
