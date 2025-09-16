<?php

namespace App\Modules\EarningPlan\Controller;

use App\Infra\Controller\Create\BaseCreateControllerV2;
use App\Infra\UseCase\Create\ICreateUseCaseV2;
use App\Modules\EarningPlan\UseCase\EarningPlanCreateUseCase;

class EarningPlanCreateController extends BaseCreateControllerV2
{
    public function __construct(private EarningPlanCreateUseCase $useCase)
    {
    }

    protected function getUseCase(): ICreateUseCaseV2
    {
        return $this->useCase;
    }

    protected function getRules(): array
    {
        return [
            'name' => 'required|string',
            'amount' => 'required|numeric|min:0.01',
            'isFixed' => 'required|boolean',
            'installments' => 'required|integer',
            'recurrence' => 'required|integer|min:1',
            'dueDate' => 'required|date',
        ];
    }
}
