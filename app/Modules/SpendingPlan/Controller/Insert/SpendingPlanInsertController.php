<?php

namespace App\Modules\SpendingPlan\Controller\Insert;

use App\Infra\Controller\Insert\BaseInsertController;
use App\Modules\SpendingPlan\UseCase\SpendingPlanInsertUseCase;

class SpendingPlanInsertController extends BaseInsertController
{
    public function __construct(protected SpendingPlanInsertUseCase $useCase)
    {
    }

    protected function getUseCase(): SpendingPlanInsertUseCase
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
