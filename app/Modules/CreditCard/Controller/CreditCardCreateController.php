<?php

namespace App\Modules\CreditCard\Controller;

use App\Infra\Controller\Create\BaseCreateControllerV2;
use App\Infra\Enum\StatusActiveInactiveEnum;
use App\Infra\Request\RequestTools;
use App\Infra\UseCase\Create\ICreateUseCaseV2;
use App\Modules\CreditCard\UseCase\CreditCardCreateUseCase;

class CreditCardCreateController extends BaseCreateControllerV2
{
    public function __construct(private CreditCardCreateUseCase $useCase)
    {
    }

    protected function getUseCase(): ICreateUseCaseV2
    {
        return $this->useCase;
    }

    protected function getRules(): array
    {
        return [
            'name' => 'required|string|unique:credit_card,name',
            'limit' => 'required|numeric',
            'dueDate' => 'required|integer|min:1|max:31',
            'closingDay' => 'required|integer|min:1|max:31',
            'status' => 'required|in:' . RequestTools::getEnumKeysForValidation(StatusActiveInactiveEnum::class)
        ];
    }
}
