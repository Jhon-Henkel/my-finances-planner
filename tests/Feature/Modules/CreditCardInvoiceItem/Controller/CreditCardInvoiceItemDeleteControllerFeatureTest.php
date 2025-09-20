<?php

namespace Tests\Feature\Modules\CreditCardInvoiceItem\Controller;

use App\Enums\RouteNameEnum;
use App\Models\CreditCard\CreditCard;
use App\Models\CreditCard\CreditCardInvoice;
use App\Models\CreditCard\CreditCardInvoiceItem;
use Tests\FeatureTestCase;

class CreditCardInvoiceItemDeleteControllerFeatureTest extends FeatureTestCase
{
    public function testDeleteCreditCardInvoiceItem()
    {
        $creditCard = CreditCard::factory()->create();
        $invoice = CreditCardInvoice::factory()->create(['credit_card_id' => $creditCard->id]);
        $item = CreditCardInvoiceItem::factory()->create(['credit_card_invoice_id' => $invoice->id]);

        $this->deleteJson(route(RouteNameEnum::ApiV3CreditCardInvoiceItemDelete, ['id' => $item->id]))
            ->assertOk();

        $this->assertDatabaseMissing(CreditCardInvoiceItem::class, [
            'id' => $item->id,
        ]);
    }
}
