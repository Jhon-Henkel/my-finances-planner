<?php

namespace App\Modules\CreditCardInvoiceItem\UseCase;

use App\Infra\UseCase\Delete\IDeleteUseCase;
use App\Models\CreditCard\CreditCardInvoiceItem;

class CreditCardInvoiceItemDeleteUseCase implements IDeleteUseCase
{
    public function execute(int $id): void
    {
        $item = CreditCardInvoiceItem::findOrFail($id);
        $item->delete();
    }
}
