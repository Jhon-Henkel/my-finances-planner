<?php

namespace App\Modules\CreditCardInvoice\Controller;

use App\Infra\Controller\Create\BaseCreateControllerV2;
use App\Infra\UseCase\Create\ICreateUseCaseV2;
use App\Modules\CreditCardInvoice\UseCase\CreditCardInvoiceCreateUseCase;

class CreditCardInvoiceCreateController extends BaseCreateControllerV2
{
    public function __construct(private CreditCardInvoiceCreateUseCase $useCase)
    {
    }

    protected function getUseCase(): ICreateUseCaseV2
    {
        return $this->useCase;
    }

    protected function getRules(): array
    {
        return [
            'credit_card_id' => 'required|integer|exists:credit_card,id',
            'name' => 'required|string',
            'due_date' => 'required|date',
            'closing_date' => 'required|date',
        ];
    }
}
