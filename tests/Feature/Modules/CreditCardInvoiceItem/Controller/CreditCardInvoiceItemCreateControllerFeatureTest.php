<?php

namespace Tests\Feature\Modules\CreditCardInvoiceItem\Controller;

use App\Enums\RouteNameEnum;
use App\Models\CreditCard\CreditCard;
use App\Models\CreditCard\CreditCardInvoice;
use App\Models\CreditCard\CreditCardInvoiceItem;
use Carbon\Carbon;
use Tests\FeatureTestCase;

class CreditCardInvoiceItemCreateControllerFeatureTest extends FeatureTestCase
{
    public function testCreateCreditCardInvoiceItemWithInstallments()
    {
        $creditCard = CreditCard::factory()->create();
        $date = Carbon::now()->toDateString();
        $dueDate = Carbon::now()->addMonth()->toDateString();
        $closingDate = Carbon::now()->addMonth()->subDays(7)->toDateString();

        $this->postJson(route(RouteNameEnum::ApiV3CreditCardInvoiceItemCreate), [
            'credit_card_id' => $creditCard->id,
            'invoice_name' => 'Fatura de Teste',
            'due_date' => $dueDate,
            'closing_date' => $closingDate,
            'name' => 'Item de Teste',
            'value' => 100.50,
            'date' => $date,
            'is_fixed' => false,
            'installments' => 2,
        ])->assertCreated();

        $this->assertDatabaseHas(CreditCardInvoice::class, [
            'name' => 'Fatura de Teste',
        ]);

        $this->assertDatabaseCount(CreditCardInvoiceItem::class, 2);
    }

    public function testCreateCreditCardInvoiceItemFixed()
    {
        $creditCard = CreditCard::factory()->create();
        $date = Carbon::now()->toDateString();
        $dueDate = Carbon::now()->addMonth()->toDateString();
        $closingDate = Carbon::now()->addMonth()->subDays(7)->toDateString();

        $this->postJson(route(RouteNameEnum::ApiV3CreditCardInvoiceItemCreate), [
            'credit_card_id' => $creditCard->id,
            'invoice_name' => 'Fatura de Teste',
            'due_date' => $dueDate,
            'closing_date' => $closingDate,
            'name' => 'Item Fixo de Teste',
            'value' => 50.00,
            'date' => $date,
            'is_fixed' => true,
            'installments' => 1,
        ])->assertCreated();

        $this->assertDatabaseHas(CreditCardInvoice::class, [
            'name' => 'Fatura de Teste',
        ]);

        $this->assertDatabaseHas(CreditCardInvoiceItem::class, [
            'name' => 'Item Fixo de Teste',
            'is_fixed' => true,
        ]);
    }
}
