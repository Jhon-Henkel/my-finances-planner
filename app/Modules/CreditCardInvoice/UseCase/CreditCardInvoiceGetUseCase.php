<?php

namespace App\Modules\CreditCardInvoice\UseCase;

use App\Infra\UseCase\Read\IShowUseCaseV2;
use App\Models\CreditCard\CreditCardInvoice;

class CreditCardInvoiceGetUseCase implements IShowUseCaseV2
{
    public function execute(int $id): array
    {
        return CreditCardInvoice::with('items')->findOrFail($id)->toArray();
    }
}
