<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::dropIfExists('ai_insight');

        DB::statement('DELETE FROM configurations WHERE name = "must_show_welcome_page"');

        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'tenant_id')) {
                $table->dropForeign(['tenant_id']);
            }

            if (Schema::hasColumn('users', 'plan_id')) {
                $table->dropForeign(['plan_id']);
            }

            $table->dropColumn(['plan_id', 'subscription_id', 'tenant_id']);
        });

        Schema::dropIfExists('plan');
        Schema::dropIfExists('tenants');
        Schema::dropIfExists('telescope_entries_tags');
        Schema::dropIfExists('telescope_monitoring');
        Schema::dropIfExists('telescope_entries');
    }

    public function down(): void
    {
        //
    }
};
