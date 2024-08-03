<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::table('access_log', function (Blueprint $table) {
            $table->dropColumn('account_group');
        });
    }

    public function down(): void
    {
        Schema::table('access_log', function (Blueprint $table) {
            $table->string('account_group')->nullable();
        });
    }
};
