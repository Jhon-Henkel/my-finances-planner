<?php

namespace App\Modules\CreditCardInvoiceItem\Controller;

use App\Infra\Controller\Create\BaseCreateControllerV2;
use App\Infra\UseCase\Create\ICreateUseCaseV2;
use App\Modules\CreditCardInvoiceItem\UseCase\CreditCardInvoiceItemCreateUseCase;

class CreditCardInvoiceItemCreateController extends BaseCreateControllerV2
{
    public function __construct(private CreditCardInvoiceItemCreateUseCase $useCase)
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
            'invoice_name' => 'required|string',
            'due_date' => 'required|date',
            'closing_date' => 'required|date',
            'name' => 'required|string',
            'value' => 'required|numeric',
            'date' => 'required|date',
            'is_fixed' => 'required|boolean',
            'installments' => 'required_if:is_fixed,false|integer|min:1',
        ];
    }
}
