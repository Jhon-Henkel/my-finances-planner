<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class () extends Migration {
    public function up(): void
    {
        $configurations = [
            [
                'name' => 'market_planner_value',
                'value' => '0'
            ],
        ];
        DB::table('configurations')->insert($configurations);
    }

    public function down(): void
    {
        DB::table('configurations')->where('name', 'market_planner_value')->delete();
    }
};
