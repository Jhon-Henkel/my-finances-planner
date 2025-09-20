<?php

namespace App\Modules\CreditCardInvoice\UseCase;

use App\Infra\UseCase\Update\IUpdateUseCaseV2;
use App\Models\CreditCard\CreditCardInvoice;

class CreditCardInvoiceUpdateUseCase implements IUpdateUseCaseV2
{
    public function execute(int $id, array $data): array
    {
        $invoice = CreditCardInvoice::findOrFail($id);
        $invoice->update($data);
        return [];
    }
}
