<?php

namespace Tests\Feature\Modules\CreditCardInvoice\Controller;

use App\Enums\RouteNameEnum;
use App\Models\CreditCard\CreditCard;
use App\Models\CreditCard\CreditCardInvoice;
use App\Models\CreditCard\CreditCardInvoiceItem;
use Tests\FeatureTestCase;

class CreditCardInvoiceGetControllerFeatureTest extends FeatureTestCase
{
    public function testGetCreditCardInvoice()
    {
        $creditCard = CreditCard::factory()->create();
        $invoice = CreditCardInvoice::factory()->create(['credit_card_id' => $creditCard->id]);
        $item = CreditCardInvoiceItem::factory()->create(['credit_card_invoice_id' => $invoice->id]);

        $response = $this->getJson(route(RouteNameEnum::ApiV3CreditCardInvoiceGet, ['id' => $invoice->id]))
            ->assertOk()
            ->json();

        $this->assertEquals($invoice->id, $response['data']['id']);
        $this->assertEquals($invoice->name, $response['data']['name']);
        $this->assertCount(1, $response['data']['items']);
        $this->assertEquals($item->id, $response['data']['items'][0]['id']);
    }
}
