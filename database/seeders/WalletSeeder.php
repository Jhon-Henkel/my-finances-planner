<?php

namespace Database\Seeders;

use App\Enums\WalletEnum;
use App\Models\User;
use App\Models\WalletModel;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class WalletSeeder extends Seeder
{
    public function run(): void
    {
        for ($i = 0; $i < 7; $i++) {
            $data = $this->geDataToInsert();
            WalletModel::factory()->create(['name' => $data['name'], 'type' => $data['type']]);
        }
        $user = User::all()->first();
        DB::table('wallets')->update(['tenant_id' => $user->tenant_id,]);
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
                'type' => WalletEnum::MONEY_TYPE,
            ],
            [
                'name' => 'Vale Alimentação',
                'type' => WalletEnum::MEAL_TICKET_TYPE,
            ],
            [
                'name' => 'Vale Transporte',
                'type' => WalletEnum::TRANSPORT_TICKET_TYPE,
            ],
            [
                'name' => 'Vale Saúde',
                'type' => WalletEnum::HEALTH_INSURANCE_TYPE,
            ],
            [
                'name' => 'Gim Pass',
                'type' => WalletEnum::OTHER_TYPE,
            ],
            [
                'name' => 'Vaquinha carro',
                'type' => WalletEnum::OTHER_TYPE,
            ],
            [
                'name' => 'Vaquinha macbook',
                'type' => WalletEnum::OTHER_TYPE,
            ],
            [
                'name' => 'Banco Caixa',
                'type' => WalletEnum::BANK_COUNT_TYPE,
            ],
            [
                'name' => 'Banco Inter',
                'type' => WalletEnum::BANK_COUNT_TYPE,
            ],
            [
                'name' => 'Banco Itaú',
                'type' => WalletEnum::BANK_COUNT_TYPE,
            ],
            [
                'name' => 'Banco Santander',
                'type' => WalletEnum::BANK_COUNT_TYPE,
            ],
            [
                'name' => 'Banco Bradesco',
                'type' => WalletEnum::BANK_COUNT_TYPE,
            ],
            [
                'name' => 'Banco Nubank',
                'type' => WalletEnum::BANK_COUNT_TYPE,
            ],
            [
                'name' => 'Banco Neon',
                'type' => WalletEnum::BANK_COUNT_TYPE,
            ],
            [
                'name' => 'Banco Original',
                'type' => WalletEnum::BANK_COUNT_TYPE,
            ],
            [
                'name' => 'Banco C6',
                'type' => WalletEnum::BANK_COUNT_TYPE,
            ],
            [
                'name' => 'Banco Next',
                'type' => WalletEnum::BANK_COUNT_TYPE,
            ],
            [
                'name' => 'Banco PagBank',
                'type' => WalletEnum::BANK_COUNT_TYPE,
            ],
            [
                'name' => 'Banco BTG Pactual',
                'type' => WalletEnum::BANK_COUNT_TYPE,
            ],
            [
                'name' => 'Banco BMG',
                'type' => WalletEnum::BANK_COUNT_TYPE,
            ],
            [
                'name' => 'Banco Pan',
                'type' => WalletEnum::BANK_COUNT_TYPE,
            ],
        ];
    }
}