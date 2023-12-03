<?php

namespace Database\Seeders;

use App\Models\Investment\Investment;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InvestmentSeeder extends Seeder
{
    public function run(): void
    {
        Investment::factory()->count(5)->create();
        $user = User::all()->first();
        DB::table('investment')->update(['tenant_id' => $user->tenant_id,]);
    }
}