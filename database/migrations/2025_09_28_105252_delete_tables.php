<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::dropIfExists('configurations');
        Schema::dropIfExists('credit_card_movement');
        Schema::dropIfExists('credit_card_transaction');
        Schema::dropIfExists('credit_card_invoice_items');
        Schema::dropIfExists('credit_card_invoices');
        Schema::dropIfExists('future_gain');
        Schema::dropIfExists('future_spent');
        Schema::dropIfExists('spending_plan_installments');
        Schema::dropIfExists('spending_plan');
        Schema::dropIfExists('credit_card');
        Schema::dropIfExists('earning_plan_installments');
        Schema::dropIfExists('earning_plan');
    }

    public function down(): void
    {
        //
    }
};
