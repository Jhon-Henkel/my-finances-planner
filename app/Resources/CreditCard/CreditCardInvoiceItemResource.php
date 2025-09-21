<?php

namespace App\Resources\CreditCard;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CreditCardInvoiceItemResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'credit_card_invoice_id' => $this->credit_card_invoice_id,
            'name' => $this->name,
            'value' => $this->value,
            'date' => $this->date,
            'installments' => $this->installments,
            'is_fixed' => $this->is_fixed,
        ];
    }
}
