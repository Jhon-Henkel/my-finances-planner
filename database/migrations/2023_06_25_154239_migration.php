<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('monthly_closing', function (Blueprint $table) {
            $table->increments('id');
            $table->decimal('predicted_earnings', 60, 2)->default(null);
            $table->decimal('predicted_expenses', 60, 2)->default(null);
            $table->decimal('real_earnings', 60, 2)->nullable(true)->default(null);
            $table->decimal('real_expenses', 60, 2)->nullable(true)->default(null);
            $table->decimal('balance', 60, 2)->nullable(true)->default(null);
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::drop('monthly_closing');
    }
};