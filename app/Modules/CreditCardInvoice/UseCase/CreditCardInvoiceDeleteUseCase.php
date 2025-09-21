<?php

namespace App\Modules\CreditCardInvoice\UseCase;

use App\Infra\UseCase\Delete\IDeleteUseCase;
use App\Models\CreditCard\CreditCardInvoice;

class CreditCardInvoiceDeleteUseCase implements IDeleteUseCase
{
    public function execute(int $id): void
    {
        $invoice = CreditCardInvoice::findOrFail($id);
        $invoice->delete();
    }
}
