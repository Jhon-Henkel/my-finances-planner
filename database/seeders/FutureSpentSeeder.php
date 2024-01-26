<?php

namespace Database\Seeders;

use App\Enums\DateFormatEnum;
use App\Models\FutureSpent;
use App\Models\User;
use App\Models\WalletModel;
use App\Tools\Calendar\CalendarTools;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FutureSpentSeeder extends Seeder
{
    public function run(): void
    {
        $walletIds = $this->getWalletIds();
        $descriptions = $this->getDescriptions();
        $now = CalendarTools::getDateNow()->format(DateFormatEnum::DefaultDbDateFormat->value);
        for ($index = 0; $index < count($descriptions); $index++) {
            $forecast = CalendarTools::addMonthInDate($now, rand(1, 4));
            FutureSpent::factory()->create(
                [
                    'description' => $descriptions[$index],
                    'forecast' => $forecast,
                    'wallet_id' => $walletIds[array_rand($walletIds)]
                ]
            );
        }
        $user = User::all()->first();
        DB::table('future_spent')->update(['tenant_id' => $user->tenant_id,]);
    }

    protected function getWalletIds(): array
    {
        $wallets = WalletModel::all();
        $ids = [];
        foreach ($wallets as $wallet) {
            $ids[] = $wallet->id;
        }
        return $ids;
    }

    protected function getDescriptions(): array
    {
        return [
            'Energia',
            'Gasolina',
            'Internet',
            'Aluguel',
            'Ração',
            'Móveis',
            'Academia',
            'Financiamento Carro',
            'Consórcio Casa',
        ];
    }
}
