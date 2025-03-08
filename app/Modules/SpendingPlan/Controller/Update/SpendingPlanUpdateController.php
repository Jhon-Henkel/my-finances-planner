<?php

namespace App\Modules\SpendingPlan\Controller\Update;

use App\Infra\Controller\Update\BaseUpdateController;
use App\Modules\SpendingPlan\UseCase\SpendingPlanUpdateUseCase;

class SpendingPlanUpdateController extends BaseUpdateController
{
    public function __construct(protected SpendingPlanUpdateUseCase $useCase)
    {
    }

    protected function getUseCase(): SpendingPlanUpdateUseCase
    {
        return $this->useCase;
    }

    protected function getRules(): array
    {
        return [
            'description' => 'required|max:255|string',
            'walletId' => 'required|int|exists:App\Models\WalletModel,id',
            'forecast' => 'required|date',
            'amount' => 'required|decimal:0,2',
            'installments' => 'required|int',
            'bankSlipCode' => 'string|nullable'
        ];
    }
}
