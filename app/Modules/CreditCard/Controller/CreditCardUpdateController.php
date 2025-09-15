<?php

namespace App\Modules\CreditCard\Controller;

use App\Infra\Controller\Update\BaseUpdateControllerV2;
use App\Infra\Enum\StatusActiveInactiveEnum;
use App\Infra\Request\RequestTools;
use App\Infra\UseCase\Update\IUpdateUseCaseV2;
use App\Modules\CreditCard\UseCase\CreditCardUpdateUseCase;

class CreditCardUpdateController extends BaseUpdateControllerV2
{
    public function __construct(private CreditCardUpdateUseCase $useCase)
    {
    }

    protected function getUseCase(): IUpdateUseCaseV2
    {
        return $this->useCase;
    }

    protected function getRules(): array
    {
        return [
            'name' => 'required|string|unique:credit_card,name,' . $this->getId(),
            'limit' => 'required|numeric',
            'dueDate' => 'required|integer|min:1|max:31',
            'closingDay' => 'required|integer|min:1|max:31',
            'status' => 'required|in:' . RequestTools::getEnumKeysForValidation(StatusActiveInactiveEnum::class)
        ];
    }
}
