<?php

namespace Database\Seeders;

use App\Models\CreditCard;
use App\Models\CreditCardTransaction;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CreditCardTransactionSeeder extends Seeder
{
    public function run(): void
    {
        $creditCards = CreditCard::all();
        foreach ($creditCards as $creditCard) {
            for ($index = 0; $index < 5; $index++) {
                CreditCardTransaction::factory()->create(
                    [
                        'credit_card_id' => $creditCard->id,
                        'name' => $this->getTransactionDescription(),
                        'next_installment' => $this->getNextInstallment(),
                    ]
                );
            }
        }
        $user = User::all()->first();
        DB::table('credit_card_transaction')->update(['tenant_id' => $user->tenant_id,]);
    }

    protected function getTransactionDescription(): string
    {
        $names = [
            'Netflix',
            'IPhone',
            'Notebook',
            'Curso de Laravel',
            'Curso de PHP',
            'Curso de Vue',
            'Camiseta',
            'Calça',
            'Tênis',
            'Pneu Moto',
            'Pneu Carro',
            'Jogos',
            'Livros',
            'Cinema',
            'Spotify',
            'Amazon Prime',
            'HBO Max',
            'Disney Plus',
            'Restaurante',
            'Lanche',
            'Café',
            'Cerveja',
            'Kalzone',
            'Pizza',
            'Curso de Inglês',
            'Curso de Espanhol',
            'Curso de Francês',
            'Lanchonete',
            'Farmácia',
            'Supermercado',
            'Posto de Gasolina',
            'Uber',
            'Plano Celular'
        ];
        return $names[array_rand($names)];
    }

    protected function getNextInstallment(): string
    {
        $dates = [];
        $thisYear = date('Y');
        $month = date('m');
        $dates[] = $thisYear . '-' . $month . '-' . rand(1, 28);
        if ($month == 12) {
            $month = 1;
            $thisYear++;
        } else {
            $month++;
        }
        $month = str_pad($month, 2, '0', STR_PAD_LEFT);
        $day = str_pad(rand(1, 28), 2, '0', STR_PAD_LEFT);
        $dates[] = $thisYear . '-' . $month . '-' . $day;
        return rand(0, 1) ? $dates[0] : $dates[1];
    }
}
