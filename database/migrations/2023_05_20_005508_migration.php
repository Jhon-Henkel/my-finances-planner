<?php

use App\Models\Configurations;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Configurations::where('name', 'mfp-token')->delete();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // this migration not have rollback
    }
};