<?php

namespace Tests\backend\Feature\Modules\CreditCardTransaction\UseCase\Sum;

use App\Models\CreditCard;
use App\Models\CreditCardTransaction;
use App\Modules\CreditCardTransaction\UseCase\Sum\CreditCardTransactionSumUseCase;
use App\Modules\Invoice\Service\InvoiceListService;
use Tests\backend\Falcon9Feature;

class CreditCardTransactionSumUseCaseFeatureTest extends Falcon9Feature
{
    protected function setUp(): void
    {
        $this->markTestSkipped('Teste quebrando no pipeline do Git Hub');
        parent::setUp();
        $this->insertData();
        $this->connectMaster();
    }

    protected function insertData(): void
    {
        $CreditCardOne = CreditCard::create([
            'name' => 'Banco Inter',
            'limit' => 5511.45,
            'closing_day' => 8,
            'due_date' => 1,
        ]);

        $CreditCardTwo = CreditCard::create([
            'name' => 'C6 Bank',
            'limit' => 7192.56,
            'closing_day' => 26,
            'due_date' => 25,
        ]);

        $CreditCardThree = CreditCard::create([
            'name' => 'Nubank',
            'limit' => 6230.25,
            'closing_day' => 20,
            'due_date' => 4,
        ]);

        CreditCardTransaction::create([
            'credit_card_id' => $CreditCardOne->id,
            'name' => 'Curso de Espanhol',
            'value' => 149.98,
            'installments' => 2,
            'next_installment' => '2024-12-21',
        ]);

        CreditCardTransaction::create([
            'credit_card_id' => $CreditCardOne->id,
            'name' => 'Camiseta',
            'value' => 47.28,
            'installments' => 3,
            'next_installment' => '2024-12-14',
        ]);

        CreditCardTransaction::create([
            'credit_card_id' => $CreditCardOne->id,
            'name' => 'Restaurante',
            'value' => 16.55,
            'installments' => 5,
            'next_installment' => '2024-12-17',
        ]);

        CreditCardTransaction::create([
            'credit_card_id' => $CreditCardOne->id,
            'name' => 'Restaurante',
            'value' => 88.57,
            'installments' => 8,
            'next_installment' => '2025-01-04',
        ]);

        CreditCardTransaction::create([
            'credit_card_id' => $CreditCardOne->id,
            'name' => 'Notebook',
            'value' => 65.84,
            'installments' => 1,
            'next_installment' => '2024-12-14',
        ]);

        CreditCardTransaction::create([
            'credit_card_id' => $CreditCardTwo->id,
            'name' => 'Cerveja',
            'value' => 111.19,
            'installments' => 5,
            'next_installment' => '2024-12-2',
        ]);

        CreditCardTransaction::create([
            'credit_card_id' => $CreditCardTwo->id,
            'name' => 'Posto de Gasolina',
            'value' => 90.49,
            'installments' => 1,
            'next_installment' => '2024-12-26',
        ]);

        CreditCardTransaction::create([
            'credit_card_id' => $CreditCardTwo->id,
            'name' => 'Curso de Espanhol',
            'value' => 42.72,
            'installments' => 8,
            'next_installment' => '2024-12-11',
        ]);

        CreditCardTransaction::create([
            'credit_card_id' => $CreditCardTwo->id,
            'name' => 'HBO Max',
            'value' => 50.08,
            'installments' => 2,
            'next_installment' => '2025-01-25',
        ]);

        CreditCardTransaction::create([
            'credit_card_id' => $CreditCardTwo->id,
            'name' => 'Café',
            'value' => 76.68,
            'installments' => 3,
            'next_installment' => '2024-12-28',
        ]);

        CreditCardTransaction::create([
            'credit_card_id' => $CreditCardThree->id,
            'name' => 'IPhone',
            'value' => 52.28,
            'installments' => 6,
            'next_installment' => '2024-12-23',
        ]);

        CreditCardTransaction::create([
            'credit_card_id' => $CreditCardThree->id,
            'name' => 'Pneu Moto',
            'value' => 22.08,
            'installments' => 5,
            'next_installment' => '2024-12-7',
        ]);

        CreditCardTransaction::create([
            'credit_card_id' => $CreditCardThree->id,
            'name' => 'Notebook',
            'value' => 149.82,
            'installments' => 1,
            'next_installment' => '2024-12-9',
        ]);

        CreditCardTransaction::create([
            'credit_card_id' => $CreditCardThree->id,
            'name' => 'Camiseta',
            'value' => 54.75,
            'installments' => 0,
            'next_installment' => '2025-01-08',
        ]);

        CreditCardTransaction::create([
            'credit_card_id' => $CreditCardThree->id,
            'name' => 'Tênis',
            'value' => 31.14,
            'installments' => 8,
            'next_installment' => '2025-01-19',
        ]);
    }

    public function testSum()
    {
        $useCase = new CreditCardTransactionSumUseCase(new InvoiceListService());
        $this->assertEquals(0, $useCase->execute(['year' => 2024, 'month' => 12]));
        $this->assertEquals(824.91, $useCase->execute(['year' => 2025, 'month' => 1]));
        $this->assertEquals(743.30, $useCase->execute(['year' => 2025, 'month' => 2]));
        $this->assertEquals(593.32, $useCase->execute(['year' => 2025, 'month' => 3]));
        $this->assertEquals(419.28, $useCase->execute(['year' => 2025, 'month' => 4]));
        $this->assertEquals(419.28, $useCase->execute(['year' => 2025, 'month' => 5]));
    }
}
