<?php

namespace Database\Seeders;

use App\Enums\DateEnum;
use App\Enums\MovementEnum;
use App\Models\MovementModel;
use App\Models\User;
use App\Models\WalletModel;
use App\Tools\Calendar\CalendarTools;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MovementsSeeder extends Seeder
{
    public function run(): void
    {
        $walletIds = $this->getWalletIds();
        $descriptions = $this->makeDescriptions();
        $types = $this->makeTypes();
        $amounts = $this->makeAmounts();
        $dates = $this->getCreatedAtDates();
        for ($index = 0; $index < 13 * 3; $index++) {
            MovementModel::factory()->create(
                [
                    'description' => $descriptions[$index],
                    'type' => $types[$index],
                    'amount' => $amounts[$index],
                    'wallet_id' => $walletIds[array_rand($walletIds)],
                    'created_at' => $dates[$index],
                ]
            );
        }
        $user = User::all()->first();
        DB::table('movements')->update(['tenant_id' => $user->tenant_id,]);
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

    protected function makeDescriptions(): array
    {
        $descriptions = [
            'Salário',
            'Vale Alimentação',
            'Vale Transporte',
            'Gim Pass',
            'Mercado',
            'Farmácia',
            'Aluguel',
            'Energia',
            'Gasolina',
            'Internet',
            'Curso de Inglês',
            'Móveis',
            'Academia'
        ];
        return array_merge($descriptions, $descriptions, $descriptions);
    }

    protected function makeTypes(): array
    {
        $types = [
            MovementEnum::GAIN,
            MovementEnum::GAIN,
            MovementEnum::GAIN,
            MovementEnum::GAIN,
            MovementEnum::SPENT,
            MovementEnum::SPENT,
            MovementEnum::SPENT,
            MovementEnum::SPENT,
            MovementEnum::SPENT,
            MovementEnum::SPENT,
            MovementEnum::SPENT,
            MovementEnum::SPENT,
            MovementEnum::SPENT
        ];
        return array_merge($types, $types, $types);
    }

    protected function makeAmounts(): array
    {
        $amounts = [5310, 350, 150, 100, 250, 50, 1500, 250, 250, 109.90, 299.65, 370.90, 120];
        return array_merge($amounts, $amounts, $amounts);
    }

    protected function getCreatedAtDates(): array
    {
        $now = CalendarTools::getDateNow()->format(DateEnum::DEFAULT_DB_DATE_FORMAT);
        $today = (int)CalendarTools::getDayFromStringDate($now);
        $firstMonth = CalendarTools::getThisMonth();
        $firstYear = CalendarTools::getThisYear();
        $firstDate = $firstYear . '-' . $firstMonth . '-';
        $secondMonth = (int)$firstMonth - 1;
        $secondYear = $firstYear;
        if ($secondMonth < DateEnum::JANUARY_MONTH_NUMBER) {
            $secondMonth = DateEnum::DECEMBER_MONTH_NUMBER;
            $secondYear--;
        }
        $secondDate = $secondYear . '-' . $secondMonth . '-';
        $thirdMonth = (int)$secondMonth - 1;
        $thirdYear = $secondYear;
        if ($thirdMonth < DateEnum::JANUARY_MONTH_NUMBER) {
            $thirdMonth = DateEnum::DECEMBER_MONTH_NUMBER + $thirdMonth;
            $thirdYear--;
        }
        $thirdDate = $thirdYear . '-' . $thirdMonth . '-';
        return array_merge(
            $this->makeDates($firstDate, $today),
            $this->makeDates($secondDate, 28),
            $this->makeDates($thirdDate, 28)
        );
    }

    protected function makeDates($date, $maxDay): array
    {
        return [
            $date . str_pad(rand(1, $maxDay), 2, '0', STR_PAD_LEFT) . ' 00:00:00',
            $date . str_pad(rand(1, $maxDay), 2, '0', STR_PAD_LEFT) . ' 00:00:00',
            $date . str_pad(rand(1, $maxDay), 2, '0', STR_PAD_LEFT) . ' 00:00:00',
            $date . str_pad(rand(1, $maxDay), 2, '0', STR_PAD_LEFT) . ' 00:00:00',
            $date . str_pad(rand(1, $maxDay), 2, '0', STR_PAD_LEFT) . ' 00:00:00',
            $date . str_pad(rand(1, $maxDay), 2, '0', STR_PAD_LEFT) . ' 00:00:00',
            $date . str_pad(rand(1, $maxDay), 2, '0', STR_PAD_LEFT) . ' 00:00:00',
            $date . str_pad(rand(1, $maxDay), 2, '0', STR_PAD_LEFT) . ' 00:00:00',
            $date . str_pad(rand(1, $maxDay), 2, '0', STR_PAD_LEFT) . ' 00:00:00',
            $date . str_pad(rand(1, $maxDay), 2, '0', STR_PAD_LEFT) . ' 00:00:00',
            $date . str_pad(rand(1, $maxDay), 2, '0', STR_PAD_LEFT) . ' 00:00:00',
            $date . str_pad(rand(1, $maxDay), 2, '0', STR_PAD_LEFT) . ' 00:00:00',
            $date . str_pad(rand(1, $maxDay), 2, '0', STR_PAD_LEFT) . ' 00:00:00'
        ];
    }
}