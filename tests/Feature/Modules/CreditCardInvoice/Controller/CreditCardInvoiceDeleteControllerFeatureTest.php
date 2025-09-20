<?php

namespace Tests\Feature\Modules\CreditCardInvoice\Controller;

use App\Enums\RouteNameEnum;
use App\Models\CreditCard\CreditCard;
use App\Models\CreditCard\CreditCardInvoice;
use Tests\FeatureTestCase;

class CreditCardInvoiceDeleteControllerFeatureTest extends FeatureTestCase
{
    public function testDeleteCreditCardInvoice()
    {
        $creditCard = CreditCard::factory()->create();
        $invoice = CreditCardInvoice::factory()->create(['credit_card_id' => $creditCard->id]);

        $this->deleteJson(route(RouteNameEnum::ApiV3CreditCardInvoiceDelete, ['id' => $invoice->id]))
            ->assertOk();

        $this->assertDatabaseMissing(CreditCardInvoice::class, [
            'id' => $invoice->id,
        ]);
    }
}
