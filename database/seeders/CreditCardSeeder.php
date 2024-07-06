<?php

namespace Database\Seeders;

use App\Models\CreditCard;
use Illuminate\Database\Seeder;

class CreditCardSeeder extends Seeder
{
    public function run(): void
    {
        $names = ['Banco Inter', 'C6 Bank', 'Nubank'];
        for ($index = 0; $index < count($names); $index++) {
            CreditCard::factory()->create(['name' => $names[$index]]);
        }
    }
}
