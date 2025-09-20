<?php

namespace Tests\Feature\Modules\CreditCardInvoice\Controller;

use App\Enums\RouteNameEnum;
use App\Models\CreditCard\CreditCard;
use App\Models\CreditCard\CreditCardInvoice;
use Tests\FeatureTestCase;

class CreditCardInvoiceListControllerFeatureTest extends FeatureTestCase
{
    public function testListCreditCardInvoices()
    {
        $creditCard = CreditCard::factory()->create();
        CreditCardInvoice::factory()->count(3)->create(['credit_card_id' => $creditCard->id]);

        $response = $this->getJson(route(RouteNameEnum::ApiV3CreditCardInvoiceList))
            ->assertOk()
            ->json();

        $this->assertCount(3, $response['data']);
    }
}
