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
        $hash = md5(uniqid()) . md5(uniqid());
        DB::table('configurations')->insert(array('name' => 'mfp-token', 'value' => $hash));
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('config')->delete(array('name' => 'mfp-token'));
    }
};