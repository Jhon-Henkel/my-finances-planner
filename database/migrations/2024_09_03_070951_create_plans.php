<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        $plans = [
            ['name' => 'Free', 'wallet_limit' => 1, 'credit_card_limit' => 1],
            ['name' => 'Pro', 'wallet_limit' => 0, 'credit_card_limit' => 0],
        ];
        foreach ($plans as $plan) {
            DB::table('plan')->insert($plan);
        }
    }

    public function down(): void
    {
        DB::table('plan')->truncate();
    }
};
