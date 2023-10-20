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
        Schema::create('credit_card_movement', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('credit_card_id')->unsigned()->nullable(false);
            $table->string('description', '255')->default(null);
            $table->integer('type')->nullable(false);
            $table->decimal('amount', 60,2)->nullable(false);
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
            $table->foreign('credit_card_id')->references('id')->on('credit_card');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('credit_card_movement');
    }
};
