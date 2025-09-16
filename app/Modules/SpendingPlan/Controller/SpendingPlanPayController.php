<?php

namespace App\Modules\SpendingPlan\Controller;

use App\Infra\Controller\Create\BaseCreateControllerV2;
use App\Infra\UseCase\Create\ICreateUseCaseV2;
use App\Modules\SpendingPlan\UseCase\SpendingPlanPayUseCase;

class SpendingPlanPayController extends BaseCreateControllerV2
{
    public function __construct(private SpendingPlanPayUseCase $useCase)
    {
    }

    protected function getUseCase(): ICreateUseCaseV2
    {
        return $this->useCase;
    }

    protected function getRules(): array
    {
        return [
            'planId' => 'required|integer|exists:spending_plan,id',
            'walletId' => 'required|integer|exists:wallets,id',
            'installmentNumber' => 'sometimes|integer|min:1',
        ];
    }
}
