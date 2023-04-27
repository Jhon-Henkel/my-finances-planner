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
        DB::table('configurations')->insert(array('name' => 'salary', 'value' => 0));
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('config')->delete(array('name' => 'salary'));
    }
};
