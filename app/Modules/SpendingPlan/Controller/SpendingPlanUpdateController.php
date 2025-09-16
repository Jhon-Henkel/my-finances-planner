<?php

namespace App\Modules\SpendingPlan\Controller;

use App\Infra\Controller\Update\BaseUpdateControllerV2;
use App\Infra\UseCase\Update\IUpdateUseCaseV2;
use App\Modules\SpendingPlan\UseCase\SpendingPlanUpdateUseCase;

class SpendingPlanUpdateController extends BaseUpdateControllerV2
{
    public function __construct(private SpendingPlanUpdateUseCase $useCase)
    {
    }

    protected function getUseCase(): IUpdateUseCaseV2
    {
        return $this->useCase;
    }

    protected function getRules(): array
    {
        return [
            'name' => 'sometimes|string',
            'amount' => 'sometimes|numeric|min:0.01',
            'isFixed' => 'sometimes|boolean',
            'installments' => 'sometimes|integer|min:1',
            'recurrence' => 'sometimes|integer|min:1',
            'bankSlipCode' => 'sometimes|nullable|string',
            'dueDate' => 'sometimes|date',
            'installmentUpdate' => 'sometimes|array',
            'installmentUpdate.installmentNumber' => 'required_with:installmentUpdate|integer|min:1',
            'installmentUpdate.applyToNext' => 'required_with:installmentUpdate|boolean',
            'installmentUpdate.amount' => 'sometimes|numeric|min:0',
            'installmentUpdate.dueDate' => 'sometimes|date',
            'installmentUpdate.bankSlipCode' => 'sometimes|nullable|string',
            'installmentUpdate.isPaid' => 'sometimes|boolean',
        ];
    }
}
