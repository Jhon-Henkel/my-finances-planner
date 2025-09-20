<?php

namespace Tests\Feature\Modules\CreditCardInvoice\Controller;

use App\Enums\RouteNameEnum;
use App\Models\CreditCard\CreditCard;
use App\Models\CreditCard\CreditCardInvoice;
use Carbon\Carbon;
use Tests\FeatureTestCase;

class CreditCardInvoiceCreateControllerFeatureTest extends FeatureTestCase
{
    public function testCreateCreditCardInvoice()
    {
        $creditCard = CreditCard::factory()->create();
        $dueDate = Carbon::now()->addMonth()->toDateString();
        $closingDate = Carbon::now()->addMonth()->subDays(7)->toDateString();

        $this->postJson(route(RouteNameEnum::ApiV3CreditCardInvoiceCreate), [
            'credit_card_id' => $creditCard->id,
            'name' => 'Fatura de Teste',
            'due_date' => $dueDate,
            'closing_date' => $closingDate,
        ])->assertCreated();

        $this->assertDatabaseHas(CreditCardInvoice::class, [
            'credit_card_id' => $creditCard->id,
            'name' => 'Fatura de Teste',
            'due_date' => $dueDate,
            'closing_date' => $closingDate,
        ]);
    }
}
