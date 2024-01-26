<?php

namespace Database\Seeders;

use App\Enums\WalletTypeEnum;
use App\Models\User;
use App\Models\WalletModel;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class WalletSeeder extends Seeder
{
    public function run(): void
    {
        for ($index = 0; $index < 7; $index++) {
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
                'type' => WalletTypeEnum::Money->value,
            ],
            [
                'name' => 'Vale Alimentação',
                'type' => WalletTypeEnum::MealTicket->value,
            ],
            [
                'name' => 'Vale Transporte',
                'type' => WalletTypeEnum::TransportTicket->value,
            ],
            [
                'name' => 'Vale Saúde',
                'type' => WalletTypeEnum::HealthInsurance->value,
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
                'type' => WalletTypeEnum::BankCount->value,
            ],
            [
                'name' => 'Banco Inter',
                'type' => WalletTypeEnum::BankCount->value,
            ],
            [
                'name' => 'Banco Itaú',
                'type' => WalletTypeEnum::BankCount->value,
            ],
            [
                'name' => 'Banco Santander',
                'type' => WalletTypeEnum::BankCount->value,
            ],
            [
                'name' => 'Banco Bradesco',
                'type' => WalletTypeEnum::BankCount->value,
            ],
            [
                'name' => 'Banco Nubank',
                'type' => WalletTypeEnum::BankCount->value,
            ],
            [
                'name' => 'Banco Neon',
                'type' => WalletTypeEnum::BankCount->value,
            ],
            [
                'name' => 'Banco Original',
                'type' => WalletTypeEnum::BankCount->value,
            ],
            [
                'name' => 'Banco C6',
                'type' => WalletTypeEnum::BankCount->value,
            ],
            [
                'name' => 'Banco Next',
                'type' => WalletTypeEnum::BankCount->value,
            ],
            [
                'name' => 'Banco PagBank',
                'type' => WalletTypeEnum::BankCount->value,
            ],
            [
                'name' => 'Banco BTG Pactual',
                'type' => WalletTypeEnum::BankCount->value,
            ],
            [
                'name' => 'Banco BMG',
                'type' => WalletTypeEnum::BankCount->value,
            ],
            [
                'name' => 'Banco Pan',
                'type' => WalletTypeEnum::BankCount->value,
            ],
        ];
    }
}