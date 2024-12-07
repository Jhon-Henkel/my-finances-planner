<?php

namespace Database\Seeders;

use App\Enums\DateFormatEnum;
use App\Models\FutureGain;
use App\Modules\Wallet\Model\WalletModel;
use App\Tools\Calendar\CalendarTools;
use Illuminate\Database\Seeder;

class FutureGainSeeder extends Seeder
{
    public function run(): void
    {
        $walletIds = $this->getWalletIds();
        $descriptions = $this->getDescriptions();
        $now = CalendarTools::getDateNow()->format(DateFormatEnum::DefaultDbDateFormat->value);
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
