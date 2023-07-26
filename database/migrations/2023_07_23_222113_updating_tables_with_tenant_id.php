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
        Schema::table('users', function(Blueprint $table) {
            $table->dropColumn('account_group');
        });

        Schema::table('users', function(Blueprint $table) {
            $table->string('account_group', '100')->nullable()->default(null)->after('email');
        });

        Schema::table('access_log', function(Blueprint $table) {
            $table->unsignedBigInteger('tenant_id')->nullable()->after('user_id')->index();
            $table->foreign('tenant_id')->references('id')->on('tenants');
        });

        Schema::table('configurations', function(Blueprint $table) {
            $table->unsignedBigInteger('tenant_id')->nullable()->after('value')->index();
            $table->foreign('tenant_id')->references('id')->on('tenants');
        });

        Schema::table('credit_card', function(Blueprint $table) {
            $table->unsignedBigInteger('tenant_id')->nullable()->after('closing_day')->index();
            $table->foreign('tenant_id')->references('id')->on('tenants');
        });

        Schema::table('credit_card_transaction', function(Blueprint $table) {
            $table->unsignedBigInteger('tenant_id')->nullable()->after('next_installment')->index();
            $table->foreign('tenant_id')->references('id')->on('tenants');
        });

        Schema::table('future_gain', function(Blueprint $table) {
            $table->unsignedBigInteger('tenant_id')->nullable()->after('forecast')->index();
            $table->foreign('tenant_id')->references('id')->on('tenants');
        });

        Schema::table('future_spent', function(Blueprint $table) {
            $table->unsignedBigInteger('tenant_id')->nullable()->after('forecast')->index();
            $table->foreign('tenant_id')->references('id')->on('tenants');
        });

        Schema::table('monthly_closing', function(Blueprint $table) {
            $table->unsignedBigInteger('tenant_id')->nullable()->after('balance')->index();
            $table->foreign('tenant_id')->references('id')->on('tenants');
        });

        Schema::table('movements', function(Blueprint $table) {
            $table->unsignedBigInteger('tenant_id')->nullable()->after('amount')->index();
            $table->foreign('tenant_id')->references('id')->on('tenants');
        });

        Schema::table('wallets', function(Blueprint $table) {
            $table->unsignedBigInteger('tenant_id')->nullable()->after('amount')->index();
            $table->foreign('tenant_id')->references('id')->on('tenants');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('access_log', function(Blueprint $table) {
            $table->dropColumn('tenant_id');
        });

        Schema::table('configurations', function(Blueprint $table) {
            $table->dropColumn('tenant_id');
        });

        Schema::table('credit_card', function(Blueprint $table) {
            $table->dropColumn('tenant_id');
        });

        Schema::table('credit_card_transaction', function(Blueprint $table) {
            $table->dropColumn('tenant_id');
        });

        Schema::table('future_gain', function(Blueprint $table) {
            $table->dropColumn('tenant_id');
        });

        Schema::table('future_spent', function(Blueprint $table) {
            $table->dropColumn('tenant_id');
        });

        Schema::table('monthly_closing', function(Blueprint $table) {
            $table->dropColumn('tenant_id');
        });

        Schema::table('movements', function(Blueprint $table) {
            $table->dropColumn('tenant_id');
        });

        Schema::table('wallets', function(Blueprint $table) {
            $table->dropColumn('tenant_id');
        });
    }
};
