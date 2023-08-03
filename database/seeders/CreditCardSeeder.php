<?php

namespace Database\Seeders;

use App\Models\CreditCard;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CreditCardSeeder extends Seeder
{
    public function run(): void
    {
        $names = ['Banco Inter', 'C6 Bank', 'Nubank'];
        for ($index = 0; $index < count($names); $index++) {
            CreditCard::factory()->create(['name' => $names[$index]]);
        }
        $user = User::all()->first();
        DB::table('credit_card')->update(['tenant_id' => $user->tenant_id,]);
    }
}