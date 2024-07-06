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
        Schema::table('users', function (Blueprint $table): void {
            $table->dropColumn('verify_hash');
        });

        Schema::table('users', function (Blueprint $table): void {
            $table->string('verify_hash')->nullable()->default(null)->after('wrong_login_attempts');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {

    }
};
