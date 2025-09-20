<?php

namespace App\Modules\CreditCardInvoiceItem\Controller;

use App\Infra\Controller\Update\BaseUpdateControllerV2;
use App\Infra\UseCase\Update\IUpdateUseCaseV2;
use App\Modules\CreditCardInvoiceItem\UseCase\CreditCardInvoiceItemUpdateUseCase;

class CreditCardInvoiceItemUpdateController extends BaseUpdateControllerV2
{
    public function __construct(private CreditCardInvoiceItemUpdateUseCase $useCase)
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
            'value' => 'sometimes|numeric',
            'date' => 'sometimes|date',
        ];
    }
}
