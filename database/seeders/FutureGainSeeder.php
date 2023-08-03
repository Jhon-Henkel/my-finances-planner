<?php

namespace Database\Seeders;

use App\Enums\DateEnum;
use App\Models\FutureGain;
use App\Models\User;
use App\Models\WalletModel;
use App\Tools\CalendarTools;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FutureGainSeeder extends Seeder
{
    public function run(): void
    {
        $walletIds = $this->getWalletIds();
        $descriptions = $this->getDescriptions();
        $now = CalendarTools::getDateNow()->format(DateEnum::DEFAULT_DB_DATE_FORMAT);
        for ($index = 0; $index < count($descriptions); $index++) {
            $forecast = CalendarTools::addMonthInDate($now, rand(1, 4));
            FutureGain::factory()->create(
                [
                    'description' => $descriptions[$index],
                    'forecast' => $forecast,
                    'wallet_id' => $walletIds[array_rand($walletIds)]
                ]
            );
        }
        $user = User::all()->first();
        DB::table('future_gain')->update(['tenant_id' => $user->tenant_id,]);
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
            'Salário',
            'Vale Alimentação',
            'Vale Transporte',
            'Gim Pass',
            'Retorno Investimento',
            'Presente',
            'Empréstimo Joãozinho'
        ];
    }
}