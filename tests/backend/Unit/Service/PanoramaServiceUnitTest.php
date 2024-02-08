<?php

namespace Tests\backend\Unit\Service;

use App\Services\CreditCard\CreditCardService;
use App\Services\CreditCard\CreditCardTransactionService;
use App\Services\FutureMovement\FutureGainService;
use App\Services\FutureMovement\FutureSpentService;
use App\Services\PanoramaService;
use App\Services\WalletService;
use App\VO\InvoiceVO;
use Mockery;
use Tests\backend\Falcon9;

class PanoramaServiceUnitTest extends Falcon9
{
    public function testGetPanoramaData()
    {
        $serviceMock = Mockery::mock(PanoramaService::class)->makePartial();
        $serviceMock->shouldAllowMockingProtectedMethods();
        $serviceMock->shouldReceive('getTotalFutureExpenses')->once()->andReturn([]);
        $serviceMock->shouldReceive('getTotalFutureGains')->once()->andReturn(new InvoiceVO());
        $serviceMock->shouldReceive('getTotalCreditCardExpenses')->once()->andReturn(new InvoiceVO());
        $serviceMock->shouldReceive('getWalletInvoiceData')->once()->andReturn(10.50);
        $serviceMock->shouldReceive('getTotalLeft')->once()->andReturn(new InvoiceVO());

        $result = $serviceMock->getPanoramaData();

        $this->assertIsArray($result);
        $this->assertCount(6, $result);
        $this->assertArrayHasKey('totalWalletValue', $result);
        $this->assertArrayHasKey('futureExpenses', $result);
        $this->assertArrayHasKey('totalFutureExpenses', $result);
        $this->assertArrayHasKey('totalFutureGains', $result);
        $this->assertArrayHasKey('totalCreditCardExpenses', $result);
        $this->assertArrayHasKey('totalLeft', $result);
    }

    public function testGetWalletInvoiceData()
    {
        $invoiceServiceMock = Mockery::mock(FutureSpentService::class);
        $gainServiceMock = Mockery::mock(FutureGainService::class);
        $creditCardInvoiceServiceMock = Mockery::mock(CreditCardTransactionService::class);

        $walletServiceMock = Mockery::mock(WalletService::class);
        $walletServiceMock->shouldReceive('getTotalWalletValue')->once()->andReturn(10.50);

        $mockServices = [
            $walletServiceMock,
            $invoiceServiceMock,
            $gainServiceMock,
            $creditCardInvoiceServiceMock,
            Mockery::mock(CreditCardService::class)
        ];

        $serviceMock = Mockery::mock(PanoramaService::class, $mockServices)->makePartial();
        $serviceMock->shouldAllowMockingProtectedMethods();

        $result = $serviceMock->getWalletInvoiceData();

        $this->assertIsFloat($result);
        $this->assertEquals(10.50, $result);
    }

    public function testGetTotalFutureExpenses()
    {
        $walletServiceMock = Mockery::mock(WalletService::class);
        $gainServiceMock = Mockery::mock(FutureGainService::class);
        $creditCardInvoiceServiceMock = Mockery::mock(CreditCardTransactionService::class);

        $invoiceServiceMock = Mockery::mock(FutureSpentService::class);
        $invoiceServiceMock->shouldReceive('getNextSixMonthsFutureSpent')->once()->andReturn([]);

        $mockServices = [
            $walletServiceMock,
            $invoiceServiceMock,
            $gainServiceMock,
            $creditCardInvoiceServiceMock,
            Mockery::mock(CreditCardService::class)
        ];

        $serviceMock = Mockery::mock(PanoramaService::class, $mockServices)->makePartial();
        $serviceMock->shouldAllowMockingProtectedMethods();

        $result = $serviceMock->getTotalFutureExpenses();

        $this->assertIsArray($result);
        $this->assertCount(0, $result);
    }

    public function testGetTotalFutureGains()
    {
        $invoiceServiceMock = Mockery::mock(FutureSpentService::class);
        $walletServiceMock = Mockery::mock(WalletService::class);
        $creditCardInvoiceServiceMock = Mockery::mock(CreditCardTransactionService::class);

        $gainServiceMock = Mockery::mock(FutureGainService::class);
        $gainServiceMock->shouldReceive('getNextSixMonthsFutureGain')->once()->andReturn([]);

        $mockServices = [
            $walletServiceMock,
            $invoiceServiceMock,
            $gainServiceMock,
            $creditCardInvoiceServiceMock,
            Mockery::mock(CreditCardService::class)
        ];

        $serviceMock = Mockery::mock(PanoramaService::class, $mockServices)->makePartial();
        $serviceMock->shouldAllowMockingProtectedMethods();
        $result = $serviceMock->getTotalFutureGains();

        $this->assertInstanceOf(InvoiceVO::class, $result);
    }

    public function testGetTotalCreditCardExpenses()
    {
        $item = new InvoiceVO();
        $item->countId = 1;
        $item->countName = 'Teste';
        $item->firstInstallment = 10.50;
        $item->secondInstallment = 10.50;
        $item->thirdInstallment = 10.50;
        $item->fourthInstallment = 10.50;
        $item->fifthInstallment = 10.50;
        $item->sixthInstallment = 10.50;

        $invoiceServiceMock = Mockery::mock(FutureSpentService::class);
        $walletServiceMock = Mockery::mock(WalletService::class);
        $gainServiceMock = Mockery::mock(FutureGainService::class);

        $creditCardInvoiceServiceMock = Mockery::mock(CreditCardTransactionService::class);
        $creditCardInvoiceServiceMock->shouldReceive('getAllCardsInvoices')->once()->andReturn([$item]);

        $creditCardServiceMock = Mockery::mock(CreditCardService::class);
        $creditCardServiceMock->shouldReceive('findAll')->once()->andReturn([]);

        $mockServices = [
            $walletServiceMock,
            $invoiceServiceMock,
            $gainServiceMock,
            $creditCardInvoiceServiceMock,
            $creditCardServiceMock
        ];

        $serviceMock = Mockery::mock(PanoramaService::class, $mockServices)->makePartial();
        $serviceMock->shouldAllowMockingProtectedMethods();

        $result = $serviceMock->getTotalCreditCardExpenses();

        $this->assertInstanceOf(InvoiceVO::class, $result);
    }

    public function testGetTotalLeft()
    {
        $item = new InvoiceVO();
        $item->countId = 1;
        $item->countName = 'Teste';
        $item->firstInstallment = 10.50;
        $item->secondInstallment = 10.50;
        $item->thirdInstallment = 10.50;
        $item->fourthInstallment = 10.50;
        $item->fifthInstallment = 10.50;
        $item->sixthInstallment = 10.50;

        $serviceMock = Mockery::mock(PanoramaService::class)->makePartial();
        $serviceMock->shouldAllowMockingProtectedMethods();

        $result = $serviceMock->getTotalLeft($item, $item, $item);

        $this->assertInstanceOf(InvoiceVO::class, $result);
    }
}