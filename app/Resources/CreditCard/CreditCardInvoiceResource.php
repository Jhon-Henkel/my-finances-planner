<?php

namespace App\Resources\CreditCard;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CreditCardInvoiceResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'credit_card_id' => $this->credit_card_id,
            'name' => $this->name,
            'due_date' => $this->due_date,
            'closing_date' => $this->closing_date,
            'items' => CreditCardInvoiceItemResource::collection($this->whenLoaded('items')),
        ];
    }
}
