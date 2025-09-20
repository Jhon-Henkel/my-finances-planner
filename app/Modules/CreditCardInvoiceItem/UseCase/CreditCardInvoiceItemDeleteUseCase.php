<?php

namespace App\Modules\CreditCardInvoiceItem\UseCase;

use App\Infra\UseCase\Delete\IDeleteUseCaseV2;
use App\Models\CreditCard\CreditCardInvoiceItem;

class CreditCardInvoiceItemDeleteUseCase implements IDeleteUseCaseV2
{
    public function execute(int $id): bool
    {
        $item = CreditCardInvoiceItem::findOrFail($id);
        return $item->delete();
    }
}
