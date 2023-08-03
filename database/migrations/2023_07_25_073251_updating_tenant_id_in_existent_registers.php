<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::table('tenants')->insert(['user_id' => 1]);
        DB::table('users')->update(['tenant_id' => 1]);
        DB::table('access_log')->update(['tenant_id' => 1]);
        DB::table('configurations')->update(['tenant_id' => 1]);
        DB::table('credit_card')->update(['tenant_id' => 1]);
        DB::table('credit_card_transaction')->update(['tenant_id' => 1]);
        DB::table('future_gain')->update(['tenant_id' => 1]);
        DB::table('future_spent')->update(['tenant_id' => 1]);
        DB::table('monthly_closing')->update(['tenant_id' => 1]);
        DB::table('movements')->update(['tenant_id' => 1]);
        DB::table('wallets')->update(['tenant_id' => 1]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('users')->update(['tenant_id' => null]);
        DB::table('tenants')->truncate();
        DB::table('access_log')->update(['tenant_id' => null]);
        DB::table('configurations')->update(['tenant_id' => null]);
        DB::table('credit_card')->update(['tenant_id' => null]);
        DB::table('credit_card_transaction')->update(['tenant_id' => null]);
        DB::table('future_gain')->update(['tenant_id' => null]);
        DB::table('future_spent')->update(['tenant_id' => null]);
        DB::table('monthly_closing')->update(['tenant_id' => null]);
        DB::table('movements')->update(['tenant_id' => null]);
        DB::table('wallets')->update(['tenant_id' => null]);
    }
};
