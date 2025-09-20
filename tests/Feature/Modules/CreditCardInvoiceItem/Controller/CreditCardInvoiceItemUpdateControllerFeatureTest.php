<?php

namespace Tests\Feature\Modules\CreditCardInvoiceItem\Controller;

use App\Enums\RouteNameEnum;
use App\Models\CreditCard\CreditCard;
use App\Models\CreditCard\CreditCardInvoice;
use App\Models\CreditCard\CreditCardInvoiceItem;
use Carbon\Carbon;
use Tests\FeatureTestCase;

class CreditCardInvoiceItemUpdateControllerFeatureTest extends FeatureTestCase
{
    public function testUpdateCreditCardInvoiceItem()
    {
        $creditCard = CreditCard::factory()->create();
        $invoice = CreditCardInvoice::factory()->create(['credit_card_id' => $creditCard->id]);
        $item = CreditCardInvoiceItem::factory()->create(['credit_card_invoice_id' => $invoice->id]);
        $newDate = Carbon::now()->addDay()->toDateString();

        $this->putJson(route(RouteNameEnum::ApiV3CreditCardInvoiceItemUpdate, ['id' => $item->id]), [
            'name' => 'Item Atualizado',
            'value' => 200.75,
            'date' => $newDate,
        ])->assertOk();

        $this->assertDatabaseHas(CreditCardInvoiceItem::class, [
            'id' => $item->id,
            'name' => 'Item Atualizado',
            'value' => 200.75,
            'date' => $newDate,
        ]);
    }
}
