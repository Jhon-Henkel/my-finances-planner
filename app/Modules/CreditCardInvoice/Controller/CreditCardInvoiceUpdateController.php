<?php

namespace App\Modules\CreditCardInvoice\Controller;

use App\Infra\Controller\Update\BaseUpdateControllerV2;
use App\Infra\UseCase\Update\IUpdateUseCaseV2;
use App\Modules\CreditCardInvoice\UseCase\CreditCardInvoiceUpdateUseCase;

class CreditCardInvoiceUpdateController extends BaseUpdateControllerV2
{
    public function __construct(private CreditCardInvoiceUpdateUseCase $useCase)
    {
    }

    protected function getUseCase(): IUpdateUseCaseV2
    {
        return $this->useCase;
    }

    protected function getRules(): array
    {
        return [
            'credit_card_id' => 'sometimes|integer|exists:credit_card,id',
            'name' => 'sometimes|string',
            'due_date' => 'sometimes|date',
            'closing_date' => 'sometimes|date',
        ];
    }
}
