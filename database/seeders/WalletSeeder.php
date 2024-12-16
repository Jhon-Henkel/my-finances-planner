<?php

namespace Database\Seeders;

use App\Models\WalletModel;
use App\Modules\Wallet\Enum\WalletTypeEnum;
use Illuminate\Database\Seeder;

class WalletSeeder extends Seeder
{
    public function run(): void
    {
        for ($index = 0; $index < 7; $index++) {
            $data = $this->geDataToInsert();
            WalletModel::factory()->create(['name' => $data['name'], 'type' => $data['type']]);
        }
    }

    protected function geDataToInsert(): array
    {
        $dataGroup = $this->getArrayData();
        $data = $dataGroup[array_rand($dataGroup)];
        if (WalletModel::where('name', $data['name'])->exists()) {
            return $this->geDataToInsert();
        }
        return $data;
    }

    protected function getArrayData(): array
    {
        return [
            [
                'name' => 'Dinheiro',
                'type' => WalletTypeEnum::Other->value,
            ],
            [
                'name' => 'Vale Alimentação',
                'type' => WalletTypeEnum::Other->value,
            ],
            [
                'name' => 'Vale Transporte',
                'type' => WalletTypeEnum::Other->value,
            ],
            [
                'name' => 'Vale Saúde',
                'type' => WalletTypeEnum::Other->value,
            ],
            [
                'name' => 'Gim Pass',
                'type' => WalletTypeEnum::Other->value,
            ],
            [
                'name' => 'Vaquinha carro',
                'type' => WalletTypeEnum::Other->value,
            ],
            [
                'name' => 'Vaquinha macbook',
                'type' => WalletTypeEnum::Other->value,
            ],
            [
                'name' => 'Banco Caixa',
                'type' => WalletTypeEnum::Other->value,
            ],
            [
                'name' => 'Banco Inter',
                'type' => WalletTypeEnum::Other->value,
            ],
            [
                'name' => 'Banco Itaú',
                'type' => WalletTypeEnum::Other->value,
            ],
            [
                'name' => 'Banco Santander',
                'type' => WalletTypeEnum::Other->value,
            ],
            [
                'name' => 'Banco Bradesco',
                'type' => WalletTypeEnum::Other->value,
            ],
            [
                'name' => 'Banco Nubank',
                'type' => WalletTypeEnum::Other->value,
            ],
            [
                'name' => 'Banco Neon',
                'type' => WalletTypeEnum::Other->value,
            ],
            [
                'name' => 'Banco Original',
                'type' => WalletTypeEnum::Other->value,
            ],
            [
                'name' => 'Banco C6',
                'type' => WalletTypeEnum::Other->value,
            ],
            [
                'name' => 'Banco Next',
                'type' => WalletTypeEnum::Other->value,
            ],
            [
                'name' => 'Banco PagBank',
                'type' => WalletTypeEnum::Other->value,
            ],
            [
                'name' => 'Banco BTG Pactual',
                'type' => WalletTypeEnum::Other->value,
            ],
            [
                'name' => 'Banco BMG',
                'type' => WalletTypeEnum::Other->value,
            ],
            [
                'name' => 'Banco Pan',
                'type' => WalletTypeEnum::Other->value,
            ],
        ];
    }
}
