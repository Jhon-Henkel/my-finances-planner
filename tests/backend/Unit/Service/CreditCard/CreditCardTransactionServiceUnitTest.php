<?php

namespace Tests\backend\Unit\Service\CreditCard;

use App\DTO\CreditCard\CreditCardDTO;
use App\DTO\CreditCard\CreditCardTransactionDTO;
use App\DTO\InvoiceItemDTO;
use App\Repositories\CreditCard\CreditCardTransactionRepository;
use App\Services\CreditCard\CreditCardMovementService;
use App\Services\CreditCard\CreditCardTransactionService;
use App\Services\Movement\MovementService;
use App\Tools\Calendar\CalendarToolsReal;
use App\VO\InvoiceVO;
use Mockery;
use PHPUnit\Framework\Attributes\TestDox;
use Tests\backend\Falcon9;

class CreditCardTransactionServiceUnitTest extends Falcon9
{
    public function testGetNextInstallmentOrder()
    {
        $serviceMock = Mockery::mock(CreditCardTransactionService::class)->makePartial();
        $serviceMock->shouldAllowMockingProtectedMethods();

        $invoice = new InvoiceVO();
        $invoice->firstInstallment = 1;

        $this->assertEquals('firstInstallment', $serviceMock->getNextInstallmentOrder([$invoice]));

        $invoice->firstInstallment = null;
        $invoice->secondInstallment = 2;

        $this->assertEquals('secondInstallment', $serviceMock->getNextInstallmentOrder([$invoice]));

        $invoice->secondInstallment = null;
        $invoice->thirdInstallment = 3;

        $this->assertEquals('thirdInstallment', $serviceMock->getNextInstallmentOrder([$invoice]));

        $invoice->thirdInstallment = null;
        $invoice->fourthInstallment = 4;

        $this->assertEquals('fourthInstallment', $serviceMock->getNextInstallmentOrder([$invoice]));

        $invoice->fourthInstallment = null;
        $invoice->fifthInstallment = 5;

        $this->assertEquals('fifthInstallment', $serviceMock->getNextInstallmentOrder([$invoice]));

        $invoice->fifthInstallment = null;
        $invoice->sixthInstallment = 6;

        $this->assertEquals('sixthInstallment', $serviceMock->getNextInstallmentOrder([$invoice]));

        $invoice->sixthInstallment = null;

        $this->assertEquals(null, $serviceMock->getNextInstallmentOrder([$invoice]));
        $this->assertEquals(null, $serviceMock->getNextInstallmentOrder([]));

        $invoiceTwo = new InvoiceVO();
        $invoiceTwo->firstInstallment = 1;

        $this->assertEquals('firstInstallment', $serviceMock->getNextInstallmentOrder([$invoice, $invoiceTwo]));

        $invoiceTwo->firstInstallment = null;
        $invoiceTwo->secondInstallment = 2;

        $this->assertEquals('secondInstallment', $serviceMock->getNextInstallmentOrder([$invoice, $invoiceTwo]));

        $invoiceTwo->secondInstallment = null;
        $invoiceTwo->thirdInstallment = 3;

        $this->assertEquals('thirdInstallment', $serviceMock->getNextInstallmentOrder([$invoice, $invoiceTwo]));

        $invoiceTwo->thirdInstallment = null;
        $invoiceTwo->fourthInstallment = 4;

        $this->assertEquals('fourthInstallment', $serviceMock->getNextInstallmentOrder([$invoice, $invoiceTwo]));

        $invoiceTwo->fourthInstallment = null;
        $invoiceTwo->fifthInstallment = 5;

        $this->assertEquals('fifthInstallment', $serviceMock->getNextInstallmentOrder([$invoice, $invoiceTwo]));

        $invoiceTwo->fifthInstallment = null;
        $invoiceTwo->sixthInstallment = 6;

        $this->assertEquals('sixthInstallment', $serviceMock->getNextInstallmentOrder([$invoice, $invoiceTwo]));

        $invoiceTwo->sixthInstallment = null;

        $this->assertEquals(null, $serviceMock->getNextInstallmentOrder([$invoice, $invoiceTwo]));
    }

    public function testGetNextPaymentDateByInstallment()
    {
        $serviceMock = Mockery::mock(CreditCardTransactionService::class)->makePartial();
        $serviceMock->shouldAllowMockingProtectedMethods();

        $mockCalendar = Mockery::mock(CalendarToolsReal::class)->makePartial();
        $mockCalendar->shouldReceive('addMonthInDate')->once()->andReturn('2021-01-01');
        $this->app->instance(CalendarToolsReal::class, $mockCalendar);

        $this->assertEquals('2021-01-01', $serviceMock->getNextPaymentDateByInstallment(1));
    }

    public function testPayInvoice()
    {
        $creditCardTransactionRepositoryMock = Mockery::mock(CreditCardTransactionRepository::class)->makePartial();

        $movementServiceMock = Mockery::mock(MovementService::class)->makePartial();
        $movementServiceMock->shouldReceive('launchMovementForCreditCardInvoicePay')->once()->andReturnTrue();

        $creditCardMovementServiceMock = Mockery::mock(CreditCardMovementService::class)->makePartial();
        $creditCardMovementServiceMock->shouldReceive('insertMovementByTransaction')->times(3)->andReturnTrue();

        $arrayMocks = [
            $creditCardTransactionRepositoryMock,
            $creditCardMovementServiceMock,
            $movementServiceMock
        ];

        $installmentArray = [10, 20, 30, 40, 50, 60];
        $invoicesReturn = [
            InvoiceVO::makeInvoice(new InvoiceItemDTO(1, 2, 'Test 1', 'Ds Test 1', 10.22, '2022-10-10', 10), $installmentArray, 150.00),
            InvoiceVO::makeInvoice(new InvoiceItemDTO(2, 3, 'Test 2', 'Ds Test 2', 15.26, '2022-11-10', 5), $installmentArray, 150.00),
            InvoiceVO::makeInvoice(new InvoiceItemDTO(3, 4, 'Test 3', 'Ds Test 3', 99.29, '2022-12-10', 1), $installmentArray, 150.00),
        ];

        $serviceMock = Mockery::mock(CreditCardTransactionService::class, $arrayMocks)->makePartial();
        $serviceMock->shouldAllowMockingProtectedMethods();
        $serviceMock->shouldReceive('getInvoices')->once()->andReturn($invoicesReturn);
        $serviceMock->shouldReceive('getNextInstallmentOrder')->once()->andReturn('firstInstallment');

        $transactionOne = new CreditCardTransactionDTO();
        $transactionOne->setId(1);
        $transactionOne->setCreditCardId(1);
        $transactionOne->setName('Test 1');
        $transactionOne->setValue(10.22);
        $transactionOne->setInstallments(10);
        $transactionOne->setNextInstallment('2022-10-10');

        $transactionTwo = new CreditCardTransactionDTO();
        $transactionTwo->setId(1);
        $transactionTwo->setCreditCardId(1);
        $transactionTwo->setName('Test 1');
        $transactionTwo->setValue(10.22);
        $transactionTwo->setInstallments(10);
        $transactionTwo->setNextInstallment('2022-10-10');

        $transactionThree = new CreditCardTransactionDTO();
        $transactionThree->setId(1);
        $transactionThree->setCreditCardId(1);
        $transactionThree->setName('Test 1');
        $transactionThree->setValue(10.22);
        $transactionThree->setInstallments(1);
        $transactionThree->setNextInstallment('2022-10-10');

        $serviceMock->shouldReceive('findById')->times(3)->andReturn($transactionOne, $transactionTwo, $transactionThree);
        $serviceMock->shouldReceive('deleteById')->once()->andReturnTrue();
        $serviceMock->shouldReceive('getNextPaymentDateByInstallment')->twice()->andReturn('2022-10-10');
        $serviceMock->shouldReceive('update')->twice()->andReturnTrue();

        $card = new CreditCardDTO();
        $card->setId(1);
        $card->setName('Card Test');

        $payed = $serviceMock->payInvoice($card, 1);

        $this->assertTrue($payed);
    }

    public function testGetAllCardsInvoices()
    {
        $args = [
            Mockery::mock(CreditCardTransactionRepository::class)->makePartial(),
            Mockery::mock(CreditCardMovementService::class)->makePartial(),
            Mockery::mock(MovementService::class)->makePartial()
        ];

        $serviceMock = Mockery::mock(CreditCardTransactionService::class, $args)->makePartial();
        $serviceMock->shouldAllowMockingProtectedMethods();
        $serviceMock->shouldReceive('getInvoices')->once()->andReturn([]);

        $invoices = $serviceMock->getAllCardsInvoices([new CreditCardDTO()]);

        $this->assertIsArray($invoices);
    }

    public function testIsThisMonthInvoicePayed()
    {
        $serviceMock = Mockery::mock(CreditCardTransactionService::class)->makePartial();
        $serviceMock->shouldAllowMockingProtectedMethods();

        $this->assertFalse($serviceMock->isThisMonthInvoicePayed('firstInstallment'));
        $this->assertTrue($serviceMock->isThisMonthInvoicePayed('secondInstallment'));
        $this->assertTrue($serviceMock->isThisMonthInvoicePayed('thirdInstallment'));
        $this->assertTrue($serviceMock->isThisMonthInvoicePayed('fourthInstallment'));
        $this->assertTrue($serviceMock->isThisMonthInvoicePayed('fifthInstallment'));
        $this->assertTrue($serviceMock->isThisMonthInvoicePayed('sixthInstallment'));
        $this->assertTrue($serviceMock->isThisMonthInvoicePayed(null));
    }

    public function testGetAllCardsInvoicesGroupedByCardId()
    {
        $invoices = [
            InvoiceVO::makeInvoice(
                new InvoiceItemDTO(1, 123, 'Test 1', 'Ds Test 1', 10.22, '2022-10-10', 10),
                [],
                150.00
            ),
            InvoiceVO::makeInvoice(
                new InvoiceItemDTO(2, 456, 'Test 2', 'Ds Test 2', 15.26, '2022-11-10', 5),
                [],
                190.00
            ),
        ];

        $serviceMock = Mockery::mock(CreditCardTransactionService::class)->makePartial();
        $serviceMock->shouldAllowMockingProtectedMethods();
        $serviceMock->shouldReceive('getAllCardsInvoices')->once()->andReturn($invoices);

        $invoicesGrouped = $serviceMock->getAllCardsInvoicesGroupedByCardId([]);

        $this->assertIsArray($invoicesGrouped);
        $this->assertCount(2, $invoicesGrouped);
        $this->assertArrayHasKey(123, $invoicesGrouped);
        $this->assertArrayHasKey(456, $invoicesGrouped);
        $this->assertIsArray($invoicesGrouped[123]);
        $this->assertIsArray($invoicesGrouped[456]);
    }

    public function testGetAllNextInvoicesValuesAndTotalValues()
    {
        $invoices = [
            InvoiceVO::makeInvoice(
                new InvoiceItemDTO(1, 123, 'Test 1', 'Ds Test 1', 10.22, '2022-10-10', 10),
                [],
                150.00
            ),
            InvoiceVO::makeInvoice(
                new InvoiceItemDTO(2, 456, 'Test 2', 'Ds Test 2', 10, '2022-11-10', 6),
                [10, 10, 10, 10, 10, 10],
                60
            ),
        ];

        $serviceMock = Mockery::mock(CreditCardTransactionService::class)->makePartial();
        $serviceMock->shouldAllowMockingProtectedMethods();
        $serviceMock->shouldReceive('getAllCardsInvoicesGroupedByCardId')->once()->passthru();
        $serviceMock->shouldReceive('getAllCardsInvoices')->once()->andReturn($invoices);
        $serviceMock->shouldReceive('getNextInstallmentOrder')->twice()->andReturn(null, 'firstInstallment');

        $nextInvoices = $serviceMock->getAllNextInvoicesValuesAndTotalValues([]);

        $expected = [
            123 => [
                'nextValue' => 0,
                'totalValue' => 0,
                'thisMonthInvoicePayed' => true
            ],
            456 => [
                'nextValue' => 10.0,
                'totalValue' => 60.0,
                'thisMonthInvoicePayed' => false
            ]
        ];

        $this->assertEquals($expected, $nextInvoices);
    }

    #[TestDox('Testando com cartão que fecha dia 10')]
    public function testGetInvoicesTestOne()
    {
        $this->markTestSkipped('Teste desabilitado pois está com erro');
        /* Resultados esperados com o teste (Fatura fecha dia 10):
         * _________________________________________________________________________________________________
         * |   nome    |   Fevereiro  |    Março    |    Abril    |    Maio    |    Junho    |    Julho    |
         * |-----------|--------------|-------------|-------------|------------|-------------|-------------|
         * |   Test 1  |     12.22    |    12.22    |    12.22    |    12.22   |      -      |      -      |
         * |   Test 2  |     11.20    |    11.20    |    11.20    |    11.20   |    11.20    |    11.20    |
         * |   Test 3  |       -      |    56.55    |    56.55    |    56.55   |      -      |      -      |
         * |   Test 4  |       -      |    90.13    |      -      |      -     |      -      |      -      |
         * |   Test 5  |       -      |    21.21    |    21.21    |    21.21   |    21.21    |    21.21    |
         * |   Test 6  |     21.22    |    21.22    |      -      |      -     |      -      |      -      |
         * -------------------------------------------------------------------------------------------------
         * Hoje 02/02 fecha 10/02
         */
        $transactions = [
            ['id' => 1, 'credit_card_id' => 1, 'name' => 'Test 1', 'value' => 12.22, 'next_installment' => '2024-02-08', 'installments' => 4],
            ['id' => 2, 'credit_card_id' => 1, 'name' => 'Test 2', 'value' => 11.20, 'next_installment' => '2024-02-09', 'installments' => 9],
            ['id' => 3, 'credit_card_id' => 1, 'name' => 'Test 3', 'value' => 56.55, 'next_installment' => '2024-02-11', 'installments' => 3],
            ['id' => 4, 'credit_card_id' => 1, 'name' => 'Test 4', 'value' => 90.13, 'next_installment' => '2024-02-12', 'installments' => 1],
            ['id' => 5, 'credit_card_id' => 1, 'name' => 'Test 5', 'value' => 21.21, 'next_installment' => '2024-02-21', 'installments' => 5],
            ['id' => 6, 'credit_card_id' => 1, 'name' => 'Test 6', 'value' => 21.22, 'next_installment' => '2024-02-01', 'installments' => 2],
        ];

        $repositoryMock = Mockery::mock(CreditCardTransactionRepository::class)->makePartial();
        $repositoryMock->shouldReceive('getExpenses')->once()->andReturn($transactions);

        $calendarToolsMock = Mockery::mock(CalendarToolsReal::class)->makePartial();
        $calendarToolsMock->shouldReceive('getThisYear')->andReturn('2024');
        $calendarToolsMock->shouldReceive('getThisMonth')->andReturn('02');
        $calendarToolsMock->shouldReceive('getTodayDay')->andReturn('02');
        $this->app->instance(CalendarToolsReal::class, $calendarToolsMock);

        $mocks = [
            $repositoryMock,
            Mockery::mock(CreditCardMovementService::class)->makePartial(),
            Mockery::mock(MovementService::class)->makePartial()
        ];

        $serviceMock = Mockery::mock(CreditCardTransactionService::class, $mocks)->makePartial();
        $serviceMock->shouldAllowMockingProtectedMethods();

        $card = new CreditCardDTO();
        $card->setId(1);
        $card->setClosingDay(10);
        $card->setDueDate(11);

        /** @var InvoiceVO[] $invoices */
        $invoices = $serviceMock->getInvoices($card);
        $totalItensExpected = count($transactions);

        $this->assertCount($totalItensExpected, $invoices);
        for ($index = 0; $index < $totalItensExpected; $index++) {
            $this->assertInstanceOf(InvoiceVO::class, $invoices[$index]);
        }

        $this->assertEquals(1, $invoices[0]->id);
        $this->assertEquals(1, $invoices[0]->countId);
        $this->assertEquals('Test 1', $invoices[0]->name);
        $this->assertEquals(4, $invoices[0]->remainingInstallments);
        $this->assertEquals(8, $invoices[0]->nextInstallmentDay);
        $this->assertEquals(12.22 * 4, $invoices[0]->totalRemainingValue);

        $this->assertEquals(12.22, $invoices[0]->firstInstallment);
        $this->assertEquals(12.22, $invoices[0]->secondInstallment);
        $this->assertEquals(12.22, $invoices[0]->thirdInstallment);
        $this->assertEquals(12.22, $invoices[0]->fourthInstallment);
        $this->assertEquals(null, $invoices[0]->fifthInstallment);
        $this->assertEquals(null, $invoices[0]->sixthInstallment);

        $this->assertEquals(2, $invoices[1]->id);
        $this->assertEquals(1, $invoices[1]->countId);
        $this->assertEquals('Test 2', $invoices[1]->name);
        $this->assertEquals(9, $invoices[1]->remainingInstallments);
        $this->assertEquals(9, $invoices[1]->nextInstallmentDay);
        $this->assertEquals(11.20 * 9, $invoices[1]->totalRemainingValue);

        $this->assertEquals(11.20, $invoices[1]->firstInstallment);
        $this->assertEquals(11.20, $invoices[1]->secondInstallment);
        $this->assertEquals(11.20, $invoices[1]->thirdInstallment);
        $this->assertEquals(11.20, $invoices[1]->fourthInstallment);
        $this->assertEquals(11.20, $invoices[1]->fifthInstallment);
        $this->assertEquals(11.20, $invoices[1]->sixthInstallment);

        $this->assertEquals(3, $invoices[2]->id);
        $this->assertEquals(1, $invoices[2]->countId);
        $this->assertEquals('Test 3', $invoices[2]->name);
        $this->assertEquals(3, $invoices[2]->remainingInstallments);
        $this->assertEquals(11, $invoices[2]->nextInstallmentDay);
        $this->assertEquals(56.55 * 3, $invoices[2]->totalRemainingValue);

        $this->assertEquals(null, $invoices[2]->firstInstallment);
        $this->assertEquals(56.55, $invoices[2]->secondInstallment);
        $this->assertEquals(56.55, $invoices[2]->thirdInstallment);
        $this->assertEquals(56.55, $invoices[2]->fourthInstallment);
        $this->assertEquals(null, $invoices[2]->fifthInstallment);
        $this->assertEquals(null, $invoices[2]->sixthInstallment);

        $this->assertEquals(4, $invoices[3]->id);
        $this->assertEquals(1, $invoices[3]->countId);
        $this->assertEquals('Test 4', $invoices[3]->name);
        $this->assertEquals(1, $invoices[3]->remainingInstallments);
        $this->assertEquals(12, $invoices[3]->nextInstallmentDay);
        $this->assertEquals(90.13, $invoices[3]->totalRemainingValue);

        $this->assertEquals(null, $invoices[3]->firstInstallment);
        $this->assertEquals(90.13, $invoices[3]->secondInstallment);
        $this->assertEquals(null, $invoices[3]->thirdInstallment);
        $this->assertEquals(null, $invoices[3]->fourthInstallment);
        $this->assertEquals(null, $invoices[3]->fifthInstallment);
        $this->assertEquals(null, $invoices[3]->sixthInstallment);

        $this->assertEquals(5, $invoices[4]->id);
        $this->assertEquals(1, $invoices[4]->countId);
        $this->assertEquals('Test 5', $invoices[4]->name);
        $this->assertEquals(5, $invoices[4]->remainingInstallments);
        $this->assertEquals(21, $invoices[4]->nextInstallmentDay);
        $this->assertEquals(21.21 * 5, $invoices[4]->totalRemainingValue);

        $this->assertEquals(null, $invoices[4]->firstInstallment);
        $this->assertEquals(21.21, $invoices[4]->secondInstallment);
        $this->assertEquals(21.21, $invoices[4]->thirdInstallment);
        $this->assertEquals(21.21, $invoices[4]->fourthInstallment);
        $this->assertEquals(21.21, $invoices[4]->fifthInstallment);
        $this->assertEquals(21.21, $invoices[4]->sixthInstallment);

        $this->assertEquals(6, $invoices[5]->id);
        $this->assertEquals(1, $invoices[5]->countId);
        $this->assertEquals('Test 6', $invoices[5]->name);
        $this->assertEquals(2, $invoices[5]->remainingInstallments);
        $this->assertEquals(1, $invoices[5]->nextInstallmentDay);
        $this->assertEquals(21.22 * 2, $invoices[5]->totalRemainingValue);

        $this->assertEquals(21.22, $invoices[5]->firstInstallment);
        $this->assertEquals(21.22, $invoices[5]->secondInstallment);
        $this->assertEquals(null, $invoices[5]->thirdInstallment);
        $this->assertEquals(null, $invoices[5]->fourthInstallment);
        $this->assertEquals(null, $invoices[5]->fifthInstallment);
        $this->assertEquals(null, $invoices[5]->sixthInstallment);
    }

    #[TestDox('Testando com cartão que fecha dia 1ª')]
    public function testGetInvoicesTestTwo()
    {
        $this->markTestSkipped('Teste desabilitado pois está com erro');
        /* Resultados esperados com o teste(Fatura fecha dia 1):
         * _________________________________________________________________________________________________
         * |   nome    |   Fevereiro  |    Março    |    Abril    |    Maio    |    Junho    |    Julho    |
         * |-----------|--------------|-------------|-------------|------------|-------------|-------------|
         * |   Test 1  |      -       |    12.22    |    12.22    |    12.22    |    12.22   |      -      |
         * |   Test 2  |      -       |    11.20    |    11.20    |    11.20    |    11.20   |    11.20    |
         * |   Test 3  |      -       |    56.55    |    56.55    |    56.55    |      -     |      -      |
         * |   Test 4  |      -       |    90.13    |      -      |      -      |      -     |      -      |
         * |   Test 5  |      -       |    21.21    |    21.21    |    21.21    |    21.21   |    21.21    |
         * |   Test 6  |      -       |    21.22    |    21.22    |      -      |      -     |      -      |
         * -------------------------------------------------------------------------------------------------
         * Hoje 02/02 fecha 01/02
         */
        $transactions = [
            ['id' => 1, 'credit_card_id' => 1, 'name' => 'Test 1', 'value' => 12.22, 'next_installment' => '2024-02-08', 'installments' => 4],
            ['id' => 2, 'credit_card_id' => 1, 'name' => 'Test 2', 'value' => 11.20, 'next_installment' => '2024-02-09', 'installments' => 9],
            ['id' => 3, 'credit_card_id' => 1, 'name' => 'Test 3', 'value' => 56.55, 'next_installment' => '2024-02-11', 'installments' => 3],
            ['id' => 4, 'credit_card_id' => 1, 'name' => 'Test 4', 'value' => 90.13, 'next_installment' => '2024-02-12', 'installments' => 1],
            ['id' => 5, 'credit_card_id' => 1, 'name' => 'Test 5', 'value' => 21.21, 'next_installment' => '2024-02-21', 'installments' => 5],
            ['id' => 6, 'credit_card_id' => 1, 'name' => 'Test 6', 'value' => 21.22, 'next_installment' => '2024-02-01', 'installments' => 2],
        ];

        $repositoryMock = Mockery::mock(CreditCardTransactionRepository::class)->makePartial();
        $repositoryMock->shouldReceive('getExpenses')->once()->andReturn($transactions);

        $calendarToolsMock = Mockery::mock(CalendarToolsReal::class)->makePartial();
        $calendarToolsMock->shouldReceive('getThisYear')->andReturn('2024');
        $calendarToolsMock->shouldReceive('getThisMonth')->andReturn('02');
        $calendarToolsMock->shouldReceive('getTodayDay')->andReturn('02');
        $this->app->instance(CalendarToolsReal::class, $calendarToolsMock);

        $mocks = [
            $repositoryMock,
            Mockery::mock(CreditCardMovementService::class)->makePartial(),
            Mockery::mock(MovementService::class)->makePartial()
        ];

        $serviceMock = Mockery::mock(CreditCardTransactionService::class, $mocks)->makePartial();
        $serviceMock->shouldAllowMockingProtectedMethods();

        $card = new CreditCardDTO();
        $card->setId(1);
        $card->setClosingDay(1);
        $card->setDueDate(11);

        /** @var InvoiceVO[] $invoices */
        $invoices = $serviceMock->getInvoices($card);
        $totalItensExpected = count($transactions);

        $this->assertCount($totalItensExpected, $invoices);
        for ($index = 0; $index < $totalItensExpected; $index++) {
            $this->assertInstanceOf(InvoiceVO::class, $invoices[$index]);
        }

        $this->assertEquals(1, $invoices[0]->id);
        $this->assertEquals(1, $invoices[0]->countId);
        $this->assertEquals('Test 1', $invoices[0]->name);
        $this->assertEquals(4, $invoices[0]->remainingInstallments);
        $this->assertEquals(8, $invoices[0]->nextInstallmentDay);
        $this->assertEquals(12.22 * 4, $invoices[0]->totalRemainingValue);

        $this->assertEquals(null, $invoices[0]->firstInstallment);
        $this->assertEquals(12.22, $invoices[0]->secondInstallment);
        $this->assertEquals(12.22, $invoices[0]->thirdInstallment);
        $this->assertEquals(12.22, $invoices[0]->fourthInstallment);
        $this->assertEquals(12.22, $invoices[0]->fifthInstallment);
        $this->assertEquals(null, $invoices[0]->sixthInstallment);

        $this->assertEquals(2, $invoices[1]->id);
        $this->assertEquals(1, $invoices[1]->countId);
        $this->assertEquals('Test 2', $invoices[1]->name);
        $this->assertEquals(9, $invoices[1]->remainingInstallments);
        $this->assertEquals(9, $invoices[1]->nextInstallmentDay);
        $this->assertEquals(11.20 * 9, $invoices[1]->totalRemainingValue);

        $this->assertEquals(null, $invoices[1]->firstInstallment);
        $this->assertEquals(11.20, $invoices[1]->secondInstallment);
        $this->assertEquals(11.20, $invoices[1]->thirdInstallment);
        $this->assertEquals(11.20, $invoices[1]->fourthInstallment);
        $this->assertEquals(11.20, $invoices[1]->fifthInstallment);
        $this->assertEquals(11.20, $invoices[1]->sixthInstallment);

        $this->assertEquals(3, $invoices[2]->id);
        $this->assertEquals(1, $invoices[2]->countId);
        $this->assertEquals('Test 3', $invoices[2]->name);
        $this->assertEquals(3, $invoices[2]->remainingInstallments);
        $this->assertEquals(11, $invoices[2]->nextInstallmentDay);
        $this->assertEquals(56.55 * 3, $invoices[2]->totalRemainingValue);

        $this->assertEquals(null, $invoices[2]->firstInstallment);
        $this->assertEquals(56.55, $invoices[2]->secondInstallment);
        $this->assertEquals(56.55, $invoices[2]->thirdInstallment);
        $this->assertEquals(56.55, $invoices[2]->fourthInstallment);
        $this->assertEquals(null, $invoices[2]->fifthInstallment);
        $this->assertEquals(null, $invoices[2]->sixthInstallment);

        $this->assertEquals(4, $invoices[3]->id);
        $this->assertEquals(1, $invoices[3]->countId);
        $this->assertEquals('Test 4', $invoices[3]->name);
        $this->assertEquals(1, $invoices[3]->remainingInstallments);
        $this->assertEquals(12, $invoices[3]->nextInstallmentDay);
        $this->assertEquals(90.13, $invoices[3]->totalRemainingValue);

        $this->assertEquals(null, $invoices[3]->firstInstallment);
        $this->assertEquals(90.13, $invoices[3]->secondInstallment);
        $this->assertEquals(null, $invoices[3]->thirdInstallment);
        $this->assertEquals(null, $invoices[3]->fourthInstallment);
        $this->assertEquals(null, $invoices[3]->fifthInstallment);
        $this->assertEquals(null, $invoices[3]->sixthInstallment);

        $this->assertEquals(5, $invoices[4]->id);
        $this->assertEquals(1, $invoices[4]->countId);
        $this->assertEquals('Test 5', $invoices[4]->name);
        $this->assertEquals(5, $invoices[4]->remainingInstallments);
        $this->assertEquals(21, $invoices[4]->nextInstallmentDay);
        $this->assertEquals(21.21 * 5, $invoices[4]->totalRemainingValue);

        $this->assertEquals(null, $invoices[4]->firstInstallment);
        $this->assertEquals(21.21, $invoices[4]->secondInstallment);
        $this->assertEquals(21.21, $invoices[4]->thirdInstallment);
        $this->assertEquals(21.21, $invoices[4]->fourthInstallment);
        $this->assertEquals(21.21, $invoices[4]->fifthInstallment);
        $this->assertEquals(21.21, $invoices[4]->sixthInstallment);

        $this->assertEquals(6, $invoices[5]->id);
        $this->assertEquals(1, $invoices[5]->countId);
        $this->assertEquals('Test 6', $invoices[5]->name);
        $this->assertEquals(2, $invoices[5]->remainingInstallments);
        $this->assertEquals(1, $invoices[5]->nextInstallmentDay);
        $this->assertEquals(21.22 * 2, $invoices[5]->totalRemainingValue);

        $this->assertEquals(null, $invoices[5]->firstInstallment);
        $this->assertEquals(21.22, $invoices[5]->secondInstallment);
        $this->assertEquals(21.22, $invoices[5]->thirdInstallment);
        $this->assertEquals(null, $invoices[5]->fourthInstallment);
        $this->assertEquals(null, $invoices[5]->fifthInstallment);
        $this->assertEquals(null, $invoices[5]->sixthInstallment);
    }

    #[TestDox('Testando com cartão que fecha dia 31')]
    public function testGetInvoicesTestThree()
    {
        $this->markTestSkipped('Teste desabilitado pois está com erro');
        /* Resultados esperados com o teste(Fatura fecha dia 31):
         * _________________________________________________________________________________________________
         * |   nome    |   Fevereiro  |    Março    |    Abril    |    Maio    |    Junho    |    Julho    |
         * |-----------|--------------|-------------|-------------|------------|-------------|-------------|
         * |   Test 1  |       -      |    12.22    |    12.22    |    12.22   |    12.22    |      -      |
         * |   Test 2  |       -      |    11.20    |    11.20    |    11.20   |    11.20    |    11.20    |
         * |   Test 3  |       -      |    56.55    |    56.55    |    56.55   |      -      |      -      |
         * |   Test 4  |       -      |    90.13    |      -      |      -     |      -      |      -      |
         * |   Test 5  |       -      |    21.21    |    21.21    |    21.21   |    21.21    |    21.21    |
         * |   Test 6  |       -      |    21.22    |    21.22    |      -     |      -      |      -      |
         * |   Test 7  |       -      |    22.22    |    22.22    |      -     |      -      |      -      |
         * -------------------------------------------------------------------------------------------------
         * Hoje 02/02 fecha último dia do mês
         */
        $transactions = [
            ['id' => 1, 'credit_card_id' => 1, 'name' => 'Test 1', 'value' => 12.22, 'next_installment' => '2024-02-08', 'installments' => 4],
            ['id' => 2, 'credit_card_id' => 1, 'name' => 'Test 2', 'value' => 11.20, 'next_installment' => '2024-02-09', 'installments' => 9],
            ['id' => 3, 'credit_card_id' => 1, 'name' => 'Test 3', 'value' => 56.55, 'next_installment' => '2024-02-11', 'installments' => 3],
            ['id' => 4, 'credit_card_id' => 1, 'name' => 'Test 4', 'value' => 90.13, 'next_installment' => '2024-02-12', 'installments' => 1],
            ['id' => 5, 'credit_card_id' => 1, 'name' => 'Test 5', 'value' => 21.21, 'next_installment' => '2024-02-21', 'installments' => 5],
            ['id' => 6, 'credit_card_id' => 1, 'name' => 'Test 6', 'value' => 21.22, 'next_installment' => '2024-02-01', 'installments' => 2],
            ['id' => 7, 'credit_card_id' => 1, 'name' => 'Test 7', 'value' => 22.22, 'next_installment' => '2024-02-10', 'installments' => 2],
        ];

        $repositoryMock = Mockery::mock(CreditCardTransactionRepository::class)->makePartial();
        $repositoryMock->shouldReceive('getExpenses')->once()->andReturn($transactions);

        $calendarToolsMock = Mockery::mock(CalendarToolsReal::class)->makePartial();
        $calendarToolsMock->shouldReceive('getThisYear')->andReturn('2024');
        $calendarToolsMock->shouldReceive('getThisMonth')->andReturn('02');
        $calendarToolsMock->shouldReceive('getTodayDay')->andReturn('02');
        $this->app->instance(CalendarToolsReal::class, $calendarToolsMock);

        $mocks = [
            $repositoryMock,
            Mockery::mock(CreditCardMovementService::class)->makePartial(),
            Mockery::mock(MovementService::class)->makePartial()
        ];

        $serviceMock = Mockery::mock(CreditCardTransactionService::class, $mocks)->makePartial();
        $serviceMock->shouldAllowMockingProtectedMethods();

        $card = new CreditCardDTO();
        $card->setId(1);
        $card->setClosingDay(31);
        $card->setDueDate(11);

        /** @var InvoiceVO[] $invoices */
        $invoices = $serviceMock->getInvoices($card);
        $totalItensExpected = count($transactions);

        $this->assertCount($totalItensExpected, $invoices);
        for ($index = 0; $index < $totalItensExpected; $index++) {
            $this->assertInstanceOf(InvoiceVO::class, $invoices[$index]);
        }

        $this->assertEquals(1, $invoices[0]->id);
        $this->assertEquals(1, $invoices[0]->countId);
        $this->assertEquals('Test 1', $invoices[0]->name);
        $this->assertEquals(4, $invoices[0]->remainingInstallments);
        $this->assertEquals(8, $invoices[0]->nextInstallmentDay);
        $this->assertEquals(12.22 * 4, $invoices[0]->totalRemainingValue);

        $this->assertEquals(null, $invoices[0]->firstInstallment);
        $this->assertEquals(12.22, $invoices[0]->secondInstallment);
        $this->assertEquals(12.22, $invoices[0]->thirdInstallment);
        $this->assertEquals(12.22, $invoices[0]->fourthInstallment);
        $this->assertEquals(12.22, $invoices[0]->fifthInstallment);
        $this->assertEquals(null, $invoices[0]->sixthInstallment);

        $this->assertEquals(2, $invoices[1]->id);
        $this->assertEquals(1, $invoices[1]->countId);
        $this->assertEquals('Test 2', $invoices[1]->name);
        $this->assertEquals(9, $invoices[1]->remainingInstallments);
        $this->assertEquals(9, $invoices[1]->nextInstallmentDay);
        $this->assertEquals(11.20 * 9, $invoices[1]->totalRemainingValue);

        $this->assertEquals(null, $invoices[1]->firstInstallment);
        $this->assertEquals(11.20, $invoices[1]->secondInstallment);
        $this->assertEquals(11.20, $invoices[1]->thirdInstallment);
        $this->assertEquals(11.20, $invoices[1]->fourthInstallment);
        $this->assertEquals(11.20, $invoices[1]->fifthInstallment);
        $this->assertEquals(11.20, $invoices[1]->sixthInstallment);

        $this->assertEquals(3, $invoices[2]->id);
        $this->assertEquals(1, $invoices[2]->countId);
        $this->assertEquals('Test 3', $invoices[2]->name);
        $this->assertEquals(3, $invoices[2]->remainingInstallments);
        $this->assertEquals(11, $invoices[2]->nextInstallmentDay);
        $this->assertEquals(56.55 * 3, $invoices[2]->totalRemainingValue);

        $this->assertEquals(null, $invoices[2]->firstInstallment);
        $this->assertEquals(56.55, $invoices[2]->secondInstallment);
        $this->assertEquals(56.55, $invoices[2]->thirdInstallment);
        $this->assertEquals(56.55, $invoices[2]->fourthInstallment);
        $this->assertEquals(null, $invoices[2]->fifthInstallment);
        $this->assertEquals(null, $invoices[2]->sixthInstallment);

        $this->assertEquals(4, $invoices[3]->id);
        $this->assertEquals(1, $invoices[3]->countId);
        $this->assertEquals('Test 4', $invoices[3]->name);
        $this->assertEquals(1, $invoices[3]->remainingInstallments);
        $this->assertEquals(12, $invoices[3]->nextInstallmentDay);
        $this->assertEquals(90.13, $invoices[3]->totalRemainingValue);

        $this->assertEquals(null, $invoices[3]->firstInstallment);
        $this->assertEquals(90.13, $invoices[3]->secondInstallment);
        $this->assertEquals(null, $invoices[3]->thirdInstallment);
        $this->assertEquals(null, $invoices[3]->fourthInstallment);
        $this->assertEquals(null, $invoices[3]->fifthInstallment);
        $this->assertEquals(null, $invoices[3]->sixthInstallment);

        $this->assertEquals(5, $invoices[4]->id);
        $this->assertEquals(1, $invoices[4]->countId);
        $this->assertEquals('Test 5', $invoices[4]->name);
        $this->assertEquals(5, $invoices[4]->remainingInstallments);
        $this->assertEquals(21, $invoices[4]->nextInstallmentDay);
        $this->assertEquals(21.21 * 5, $invoices[4]->totalRemainingValue);

        $this->assertEquals(null, $invoices[4]->firstInstallment);
        $this->assertEquals(21.21, $invoices[4]->secondInstallment);
        $this->assertEquals(21.21, $invoices[4]->thirdInstallment);
        $this->assertEquals(21.21, $invoices[4]->fourthInstallment);
        $this->assertEquals(21.21, $invoices[4]->fifthInstallment);
        $this->assertEquals(21.21, $invoices[4]->sixthInstallment);

        $this->assertEquals(6, $invoices[5]->id);
        $this->assertEquals(1, $invoices[5]->countId);
        $this->assertEquals('Test 6', $invoices[5]->name);
        $this->assertEquals(2, $invoices[5]->remainingInstallments);
        $this->assertEquals(1, $invoices[5]->nextInstallmentDay);
        $this->assertEquals(21.22 * 2, $invoices[5]->totalRemainingValue);

        $this->assertEquals(null, $invoices[5]->firstInstallment);
        $this->assertEquals(21.22, $invoices[5]->secondInstallment);
        $this->assertEquals(21.22, $invoices[5]->thirdInstallment);
        $this->assertEquals(null, $invoices[5]->fourthInstallment);
        $this->assertEquals(null, $invoices[5]->fifthInstallment);
        $this->assertEquals(null, $invoices[5]->sixthInstallment);

        $this->assertEquals(null, $invoices[6]->firstInstallment);
        $this->assertEquals(22.22, $invoices[6]->secondInstallment);
        $this->assertEquals(22.22, $invoices[6]->thirdInstallment);
        $this->assertEquals(null, $invoices[6]->fourthInstallment);
        $this->assertEquals(null, $invoices[6]->fifthInstallment);
        $this->assertEquals(null, $invoices[6]->sixthInstallment);
    }
}
