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
        Schema::table('wallets', function (Blueprint $table) {
            $table->dropUnique('wallets_name_unique');
        });

        Schema::table('configurations', function (Blueprint $table) {
            $table->dropUnique('configurations_name_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('wallets', function (Blueprint $table) {
            $table->unique('name');
        });

        Schema::table('configurations', function (Blueprint $table) {
            $table->unique('name');
        });
    }
};
