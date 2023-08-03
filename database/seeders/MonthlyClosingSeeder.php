<?php

namespace Database\Seeders;

use App\Models\MonthlyClosing;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MonthlyClosingSeeder extends Seeder
{
    public function run(): void
    {
        MonthlyClosing::factory()->count(5)->create();
        $user = User::all()->first();
        DB::table('monthly_closing')->update(['tenant_id' => $user->tenant_id,]);
    }
}