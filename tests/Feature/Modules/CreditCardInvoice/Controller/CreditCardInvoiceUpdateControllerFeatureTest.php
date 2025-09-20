<?php

namespace Tests\Feature\Modules\CreditCardInvoice\Controller;

use App\Enums\RouteNameEnum;
use App\Models\CreditCard\CreditCard;
use App\Models\CreditCard\CreditCardInvoice;
use Carbon\Carbon;
use Tests\FeatureTestCase;

class CreditCardInvoiceUpdateControllerFeatureTest extends FeatureTestCase
{
    public function testUpdateCreditCardInvoice()
    {
        $creditCard = CreditCard::factory()->create();
        $invoice = CreditCardInvoice::factory()->create(['credit_card_id' => $creditCard->id]);
        $newDueDate = Carbon::now()->addMonths(2)->toDateString();
        $newClosingDate = Carbon::now()->addMonths(2)->subDays(7)->toDateString();

        $this->putJson(route(RouteNameEnum::ApiV3CreditCardInvoiceUpdate, ['id' => $invoice->id]), [
            'name' => 'Fatura Atualizada',
            'due_date' => $newDueDate,
            'closing_date' => $newClosingDate,
        ])->assertOk();

        $this->assertDatabaseHas(CreditCardInvoice::class, [
            'id' => $invoice->id,
            'name' => 'Fatura Atualizada',
            'due_date' => $newDueDate,
            'closing_date' => $newClosingDate,
        ]);
    }
}
