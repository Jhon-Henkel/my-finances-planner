<?php

namespace Tests\Unit\Service;

use App\Services\CreditCard\CreditCardTransactionService;
use App\Services\FutureGainService;
use App\Services\FutureSpentService;
use App\Services\PanoramaService;
use App\Services\WalletService;
use App\VO\InvoiceVO;
use Mockery;
use Tests\Falcon9;

class PanoramaServiceUnitTest extends Falcon9
{
    public function testGetPanoramaData()
    {
        $serviceMock = Mockery::mock(PanoramaService::class)->makePartial();
        $serviceMock->shouldAllowMockingProtectedMethods();
        $serviceMock->shouldReceive('getTotalFutureExpenses')->times(2)->andReturn([]);
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
        $serviceMock = Mockery::mock(PanoramaService::class)->makePartial();
        $serviceMock->shouldAllowMockingProtectedMethods();

        $walletServiceMock = Mockery::mock(WalletService::class);
        $walletServiceMock->shouldReceive('getTotalWalletValue')->once()->andReturn(10.50);
        $this->app->instance(WalletService::class, $walletServiceMock);

        $result = $serviceMock->getWalletInvoiceData();

        $this->assertIsFloat($result);
        $this->assertEquals(10.50, $result);
    }

    public function testGetTotalFutureExpenses()
    {
        $serviceMock = Mockery::mock(PanoramaService::class)->makePartial();
        $serviceMock->shouldAllowMockingProtectedMethods();

        $invoiceServiceMock = Mockery::mock(FutureSpentService::class);
        $invoiceServiceMock->shouldReceive('getNextSixMonthsFutureSpent')->once()->andReturn([]);
        $this->app->instance(FutureSpentService::class, $invoiceServiceMock);

        $result = $serviceMock->getTotalFutureExpenses();

        $this->assertIsArray($result);
        $this->assertCount(0, $result);
    }

    public function testGetTotalFutureGains()
    {
        $serviceMock = Mockery::mock(PanoramaService::class)->makePartial();
        $serviceMock->shouldAllowMockingProtectedMethods();
        $gainServiceMock = Mockery::mock(FutureGainService::class);
        $gainServiceMock->shouldReceive('getNextSixMonthsFutureGain')->once()->andReturn([]);
        $this->app->instance(FutureGainService::class, $gainServiceMock);

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
        $item->forthInstallment = 10.50;
        $item->fifthInstallment = 10.50;
        $item->sixthInstallment = 10.50;

        $serviceMock = Mockery::mock(PanoramaService::class)->makePartial();
        $serviceMock->shouldAllowMockingProtectedMethods();
        $invoiceServiceMock = Mockery::mock(CreditCardTransactionService::class);
        $invoiceServiceMock->shouldReceive('getAllCardsInvoices')->once()->andReturn([$item]);
        $this->app->instance(CreditCardTransactionService::class, $invoiceServiceMock);

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
        $item->forthInstallment = 10.50;
        $item->fifthInstallment = 10.50;
        $item->sixthInstallment = 10.50;

        $serviceMock = Mockery::mock(PanoramaService::class)->makePartial();
        $serviceMock->shouldAllowMockingProtectedMethods();

        $result = $serviceMock->getTotalLeft($item, $item, $item);

        $this->assertInstanceOf(InvoiceVO::class, $result);
    }
}