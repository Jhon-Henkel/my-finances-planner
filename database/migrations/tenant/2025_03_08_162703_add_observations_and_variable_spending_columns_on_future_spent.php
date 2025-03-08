<?php

use App\Enums\StatusEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::table('future_spent', function (Blueprint $table) {
            $table->string('observations')->nullable()->default(null)->after('bank_slip_code');
            $table->integer('variable_spending')->nullable()->default(StatusEnum::Inactive)->after('observations');
        });
    }

    public function down(): void
    {
        Schema::table('future_spent', function (Blueprint $table) {
            $table->dropColumn('observations');
            $table->dropColumn('variable_spending');
        });
    }
};
