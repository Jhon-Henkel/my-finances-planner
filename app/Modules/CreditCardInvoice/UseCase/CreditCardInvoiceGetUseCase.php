<?php

namespace App\Modules\CreditCardInvoice\UseCase;

use App\Infra\UseCase\Read\IGetUseCase;
use App\Models\CreditCard\CreditCardInvoice;

class CreditCardInvoiceGetUseCase implements IGetUseCase
{
    public function execute(int $id): array
    {
        return CreditCardInvoice::with('items')->findOrFail($id)->toArray();
    }
}
