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
        Schema::create('credit_card_invoices', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('credit_card_id')->unsigned()->nullable(false);
            $table->string('name', 255)->nullable(false);
            $table->date('due_date')->nullable(false);
            $table->date('closing_date')->nullable(false);
            $table->timestamps();
            $table->foreign('credit_card_id')->references('id')->on('credit_card');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('credit_card_invoices');
    }
};
