<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('credit_card_invoice_items', function (Blueprint $table) {
            $table->integer('installments')->default(1);
            $table->boolean('is_fixed')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('credit_card_invoice_items', function (Blueprint $table) {
            $table->dropColumn('installments');
            $table->dropColumn('is_fixed');
        });
    }
};
