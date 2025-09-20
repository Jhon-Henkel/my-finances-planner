<?php

namespace App\Modules\CreditCardInvoiceItem\UseCase;

use App\Infra\UseCase\Update\IUpdateUseCaseV2;
use App\Models\CreditCard\CreditCardInvoiceItem;

class CreditCardInvoiceItemUpdateUseCase implements IUpdateUseCaseV2
{
    public function execute(int $id, array $data): array
    {
        $item = CreditCardInvoiceItem::findOrFail($id);
        $item->update($data);
        return [];
    }
}
