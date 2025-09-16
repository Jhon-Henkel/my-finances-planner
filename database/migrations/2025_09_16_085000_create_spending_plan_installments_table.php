<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('spending_plan_installments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('spending_plan_id');
            $table->unsignedInteger('number');
            $table->decimal('amount', 12, 2);
            $table->date('due_date');
            $table->string('bank_slip_code')->nullable();
            $table->boolean('is_paid')->default(false);
            $table->timestamps();

            $table->foreign('spending_plan_id')->references('id')->on('spending_plan')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('spending_plan_installments');
    }
};
