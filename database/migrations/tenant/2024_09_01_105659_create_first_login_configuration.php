<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class () extends Migration {
    public function up(): void
    {
        $configurations = [
            [
                'name' => 'must_show_welcome_page',
                'value' => '1'
            ],
        ];
        DB::table('configurations')->insert($configurations);
    }

    public function down(): void
    {
        DB::table('configurations')->where('name', 'must_show_welcome_page')->delete();
    }
};
