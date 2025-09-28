<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('financial_plan', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable(false);
            $table->integer('type')->default(0);
            $table->integer('installments')->default(0);
            $table->integer('variable')->default(0);
            $table->integer('recurrence')->default(0);
            $table->integer('done')->default(0);
            $table->string('observation')->nullable(false);
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
        });

        Schema::create('financial_plan_installment', function (Blueprint $table) {
            $table->id();
            $table->foreignId('financial_plan_id')->constrained('financial_plan');
            $table->integer('installment')->default(1);
            $table->decimal('amount', 12, 2);
            $table->integer('done')->default(0);
            $table->timestamp('maturity')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->string('payment_info')->nullable();
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('financial_plan');
        Schema::dropIfExists('financial_plan_installment');
    }
};
