<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class () extends Migration {
    public function up(): void
    {
        DB::table('users')->update(['plan_id' => 1]);
    }

    public function down(): void
    {
        DB::table('users')->update(['plan_id' => 0]);
    }
};
