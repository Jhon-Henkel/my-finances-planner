<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedBigInteger('plan_id')->nullable(false)->after('id')->index();
        });
    }

    public function down(): void
    {
        Schema::table('users', function ($table) {
            $table->dropColumn('plan_id');
        });
    }
};
