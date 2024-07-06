<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropConstrainedForeignId('tenant_id');
        });

        Schema::table('configurations', function (Blueprint $table) {
            $table->dropConstrainedForeignId('tenant_id');
        });

        Schema::table('access_log', function (Blueprint $table) {
            $table->dropConstrainedForeignId('tenant_id');
        });

        Schema::table('credit_card', function (Blueprint $table) {
            $table->dropConstrainedForeignId('tenant_id');
        });

        Schema::table('credit_card_transaction', function (Blueprint $table) {
            $table->dropConstrainedForeignId('tenant_id');
        });

        Schema::table('credit_card_movement', function (Blueprint $table) {
            $table->dropConstrainedForeignId('tenant_id');
        });

        Schema::table('future_gain', function (Blueprint $table) {
            $table->dropConstrainedForeignId('tenant_id');
        });

        Schema::table('future_spent', function (Blueprint $table) {
            $table->dropConstrainedForeignId('tenant_id');
        });

        Schema::table('movements', function (Blueprint $table) {
            $table->dropConstrainedForeignId('tenant_id');
        });

        Schema::table('wallets', function (Blueprint $table) {
            $table->dropConstrainedForeignId('tenant_id');
        });

        Schema::dropIfExists('tenants');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
