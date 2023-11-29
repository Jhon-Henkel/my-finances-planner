<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('investment', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('credit_card_id')->unsigned()->nullable()->default(null);
            $table->string('description', '255')->nullable(false);
            $table->integer('type')->nullable(false);
            $table->decimal('amount', 60,2)->nullable(false);
            $table->integer('liquidity')->nullable(false);
            $table->decimal('profitability', 5,2)->nullable(false);
            $table->unsignedBigInteger('tenant_id')->nullable()->index();
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
            $table->foreign('credit_card_id')->references('id')->on('credit_card');
            $table->foreign('tenant_id')->references('id')->on('tenants');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('investment');
    }
};
