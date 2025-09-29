<?php

namespace App\Modules\FinancialPlan\Controller;

use App\Infra\Controller\Create\BaseCreateController;
use App\Infra\Request\RequestTools;
use App\Infra\UseCase\Create\ICreateUseCase;
use App\Modules\FinancialPlan\Enum\FinancialPlanTypeEnum;
use App\Modules\FinancialPlan\UseCase\FinancialPlanCreateUseCase;

class FinancialPlanCreateController extends BaseCreateController
{
    public function __construct(private FinancialPlanCreateUseCase $useCase)
    {
    }

    protected function getUseCase(): ICreateUseCase
    {
        return $this->useCase;
    }

    protected function getRules(): array
    {
        return [
            'type' => 'required|in:' . RequestTools::getEnumKeysForValidation(FinancialPlanTypeEnum::class),
            'variable' => 'required|bool',
            'name' => 'required|string',
            'observation' => 'nullable|string',
            'paymentInfo' => 'nullable|string',
            'installments' => 'required|int|min:0',
            'recurrence' => 'required|int|min:1',
            'maturity' => 'required|date_format:Y-m-d H:i:s',
            'amount' => 'required|numeric|min:0.01',
        ];
    }
}
