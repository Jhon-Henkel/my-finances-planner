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
        $transactionOne = [
            'id' => 1,
            'credit_card_id' => 1,
            'name' => 'Test 1',
            'value' => 10.22,
            'installments' => 10,
            'next_installment' => '2022-10-10'
        ];

        $creditCardTransactionRepositoryMock = Mockery::mock(CreditCardTransactionRepository::class)->makePartial();
        $creditCardTransactionRepositoryMock->shouldReceive('findAllToArray')->once()->andReturn([1 => $transactionOne]);

        $args = [
            $creditCardTransactionRepositoryMock,
            Mockery::mock(CreditCardMovementService::class)->makePartial(),
            Mockery::mock(MovementService::class)->makePartial()
        ];

        $serviceMock = Mockery::mock(CreditCardTransactionService::class, $args)->makePartial();
        $serviceMock->shouldAllowMockingProtectedMethods();

        $invoices = $serviceMock->getAllCardsInvoices();

        $this->assertIsArray($invoices);
        $this->assertCount(1, $invoices);
        $this->assertInstanceOf(InvoiceVO::class, $invoices[0]);
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

        $invoicesGrouped = $serviceMock->getAllCardsInvoicesGroupedByCardId();

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

        $nextInvoices = $serviceMock->getAllNextInvoicesValuesAndTotalValues();

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
}