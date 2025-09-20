<?php

namespace App\Modules\CreditCardInvoice\UseCase;

use App\Infra\UseCase\Create\ICreateUseCaseV2;
use App\Models\CreditCard\CreditCardInvoice;

class CreditCardInvoiceCreateUseCase implements ICreateUseCaseV2
{
    public function execute(array $data): array
    {
        CreditCardInvoice::create($data);
        return [];
    }
}
