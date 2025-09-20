<?php

namespace App\Modules\CreditCardInvoice\UseCase;

use App\Infra\UseCase\Delete\IDeleteUseCaseV2;
use App\Models\CreditCard\CreditCardInvoice;

class CreditCardInvoiceDeleteUseCase implements IDeleteUseCaseV2
{
    public function execute(int $id): bool
    {
        $invoice = CreditCardInvoice::findOrFail($id);
        return $invoice->delete();
    }
}
