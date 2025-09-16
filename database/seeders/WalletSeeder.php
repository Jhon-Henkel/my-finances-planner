<?php

namespace Database\Seeders;

use App\Models\Wallet\Wallet;
use App\Modules\Old\Wallet\Enum\WalletTypeEnum;
use Illuminate\Database\Seeder;

class WalletSeeder extends Seeder
{
    public function run(): void
    {
        for ($index = 0; $index < 7; $index++) {
            $data = $this->geDataToInsert();
            Wallet::factory()->create(['name' => $data['name']]);
        }
    }

    protected function geDataToInsert(): array
    {
        $dataGroup = $this->getArrayData();
        $data = $dataGroup[array_rand($dataGroup)];
        if (Wallet::where('name', $data['name'])->exists()) {
            return $this->geDataToInsert();
        }
        return $data;
    }

    protected function getArrayData(): array
    {
        return [
            [
                'name' => 'Dinheiro',
            ],
            [
                'name' => 'Vale Alimentação',
            ],
            [
                'name' => 'Vale Transporte',
            ],
            [
                'name' => 'Vale Saúde',
            ],
            [
                'name' => 'Gim Pass',
            ],
            [
                'name' => 'Vaquinha carro',
            ],
            [
                'name' => 'Vaquinha macbook',
            ],
            [
                'name' => 'Banco Caixa',
            ],
            [
                'name' => 'Banco Inter',
            ],
            [
                'name' => 'Banco Itaú',
            ],
            [
                'name' => 'Banco Santander',
            ],
            [
                'name' => 'Banco Bradesco',
            ],
            [
                'name' => 'Banco Nubank',
            ],
            [
                'name' => 'Banco Neon',
            ],
            [
                'name' => 'Banco Original',
            ],
            [
                'name' => 'Banco C6',
            ],
            [
                'name' => 'Banco Next',
            ],
            [
                'name' => 'Banco PagBank',
            ],
            [
                'name' => 'Banco BTG Pactual',
            ],
            [
                'name' => 'Banco BMG',
            ],
            [
                'name' => 'Banco Pan',
            ],
        ];
    }
}
