<?php

namespace App\Modules\CreditCardInvoiceItem\UseCase;

use App\Infra\UseCase\Create\ICreateUseCaseV2;
use App\Models\CreditCard\CreditCardInvoice;
use App\Models\CreditCard\CreditCardInvoiceItem;
use Carbon\Carbon;

class CreditCardInvoiceItemCreateUseCase implements ICreateUseCaseV2
{
    public function execute(array $data): array
    {
        $invoice = CreditCardInvoice::firstOrCreate(
            [
                'credit_card_id' => $data['credit_card_id'],
                'name' => $data['invoice_name'],
            ],
            [
                'due_date' => $data['due_date'],
                'closing_date' => $data['closing_date'],
            ]
        );

        if ($data['is_fixed']) {
            CreditCardInvoiceItem::create([
                'credit_card_invoice_id' => $invoice->id,
                'name' => $data['name'],
                'value' => $data['value'],
                'date' => $data['date'],
                'installments' => 1,
                'is_fixed' => true,
            ]);
        } else {
            $firstDate = Carbon::parse($data['date']);
            for ($i = 1; $i <= $data['installments']; $i++) {
                CreditCardInvoiceItem::create([
                    'credit_card_invoice_id' => $invoice->id,
                    'name' => $data['name'] . ' ' . $i . '/' . $data['installments'],
                    'value' => $data['value'],
                    'date' => (clone $firstDate)->addMonthsNoOverflow($i - 1),
                    'installments' => $data['installments'],
                    'is_fixed' => false,
                ]);
            }
        }

        return [];
    }
}
