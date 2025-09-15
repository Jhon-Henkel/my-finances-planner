<?php

namespace App\Modules\Old\SpendingPlan\Controller\Insert;

use App\Infra\Controller\Create\BaseCreateController;
use App\Modules\Old\SpendingPlan\UseCase\SpendingPlanCreateUseCase;

class SpendingPlanCreateController extends BaseCreateController
{
    public function __construct(protected SpendingPlanCreateUseCase $useCase)
    {
    }

    protected function getUseCase(): SpendingPlanCreateUseCase
    {
        return $this->useCase;
    }

    protected function getRules(): array
    {
        return [
            'description' => 'required|max:255|string',
            'walletId' => 'required|int|exists:App\Models\Wallet,id',
            'forecast' => 'required|date',
            'amount' => 'required|decimal:0,2',
            'installments' => 'required|int',
            'bankSlipCode' => 'string|nullable',
            'observations' => 'string|nullable',
            'variableSpending' => 'required|integer',
        ];
    }
}
