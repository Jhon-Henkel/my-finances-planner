<?php

namespace Tests\backend\Unit\Service\Tools;

use App\DTO\ConfigurationDTO;
use App\DTO\Date\DatePeriodDTO;
use App\DTO\InvoiceItemDTO;
use App\DTO\Movement\MovementDTO;
use App\Enums\InvoiceInstallmentsEnum;
use App\Enums\MovementEnum;
use App\Services\ConfigurationService;
use App\Services\CreditCard\CreditCardTransactionService;
use App\Services\Movement\MovementService;
use App\Services\Tools\MarketPlannerService;
use App\Tools\Calendar\CalendarToolsReal;
use App\VO\InvoiceVO;
use Mockery;
use PHPUnit\Framework\Attributes\TestDox;
use Tests\backend\Falcon9;

class MarketPlannerServiceUnitTest extends Falcon9
{
    #[TestDox('O usuário tem valor no planejador de mercado')]
    public function testUseMarketPlannerTestOne()
    {
        $config = new ConfigurationDTO();
        $config->setName('marketPlanner');
        $config->setValue(1000);

        $movementServiceMock = Mockery::mock(MovementService::class)->makePartial();
        $configMock = Mockery::mock(ConfigurationService::class)->makePartial();
        $configMock
            ->shouldReceive('findConfigByName')
            ->once()
            ->andReturn($config);

        $mocks = [$configMock, $movementServiceMock, Mockery::mock(CreditCardTransactionService::class)->makePartial()];

        $marketPlannerMock = Mockery::mock(MarketPlannerService::class, $mocks)->makePartial();

        $this->assertTrue($marketPlannerMock->useMarketPlanner());
    }

    #[TestDox('O usuário não tem valor no planejador de mercado')]
    public function testUseMarketPlannerTestTwo()
    {
        $config = new ConfigurationDTO();
        $config->setName('marketPlanner');
        $config->setValue(0);

        $movementServiceMock = Mockery::mock(MovementService::class)->makePartial();
        $configMock = Mockery::mock(ConfigurationService::class)->makePartial();
        $configMock
            ->shouldReceive('findConfigByName')
            ->once()
            ->andReturn($config);

        $mocks = [$configMock, $movementServiceMock, Mockery::mock(CreditCardTransactionService::class)->makePartial()];

        $marketPlannerMock = Mockery::mock(MarketPlannerService::class, $mocks)->makePartial();

        $this->assertFalse($marketPlannerMock->useMarketPlanner());
    }

    public function testGetMarketPlannerInvoice()
    {
        $calendarMock = Mockery::mock(CalendarToolsReal::class)->makePartial();
        $calendarMock->shouldReceive('getThisMonth')->andReturn(01);
        $this->app->instance(CalendarToolsReal::class, $calendarMock);

        $invoice = new InvoiceItemDTO(
            0,
            0,
            null,
            'Mercado',
            10,
            '2021-01-01',
            InvoiceInstallmentsEnum::FixedInstallments->value
        );

        $movementServiceMock = Mockery::mock(MovementService::class)->makePartial();
        $movementServiceMock->shouldReceive('findByPeriodByDatePeriod')->once()->andReturn([]);

        $configMock = Mockery::mock(ConfigurationService::class)->makePartial();

        $creditCardTransactionServiceMock = Mockery::mock(CreditCardTransactionService::class)->makePartial();
        $creditCardTransactionServiceMock->shouldReceive('findByPeriod')->once()->andReturn([]);

        $mocks = [$configMock, $movementServiceMock, $creditCardTransactionServiceMock];

        $marketPlannerMock = Mockery::mock(MarketPlannerService::class, $mocks)->makePartial();
        $marketPlannerMock->shouldAllowMockingProtectedMethods();
        $marketPlannerMock->shouldReceive('makeThisMonthMarketSpentValue')->once()->andReturn(null);
        $marketPlannerMock->shouldReceive('makeMarketInvoiceItem')->once()->andReturn($invoice);
        $marketPlannerMock->shouldReceive('getFirstInstallmentMarket')->once()->andReturn(5);

        $invoice = $marketPlannerMock->getMarketPlannerInvoice();

        $this->assertInstanceOf(InvoiceVO::class, $invoice);
        $this->assertEquals(5, $invoice->firstInstallment);
        $this->assertEquals(10, $invoice->secondInstallment);
        $this->assertEquals(10, $invoice->thirdInstallment);
        $this->assertEquals(10, $invoice->fourthInstallment);
        $this->assertEquals(10, $invoice->fifthInstallment);
        $this->assertEquals(10, $invoice->sixthInstallment);
    }

    public function testMakeThisMonthMarketSpentValue()
    {
        $movementOne = new MovementDTO();
        $movementOne->setAmount(10);
        $movementOne->setType(MovementEnum::Spent->value);
        $movementOne->setDescription('Mercado');

        $movementTwo = new MovementDTO();
        $movementTwo->setAmount(40);
        $movementTwo->setType(MovementEnum::Spent->value);
        $movementTwo->setDescription('Mercado');

        $movementThree = new MovementDTO();
        $movementThree->setAmount(50);
        $movementThree->setType(MovementEnum::Gain->value);
        $movementThree->setDescription('Mercado');

        $movements = [$movementOne, $movementTwo, $movementThree];

        $config = new ConfigurationDTO();
        $config->setName('marketPlanner');
        $config->setValue(100);

        $movementServiceMock = Mockery::mock(MovementService::class)->makePartial();
        $configMock = Mockery::mock(ConfigurationService::class)->makePartial();
        $configMock
            ->shouldReceive('findConfigByName')
            ->once()
            ->andReturn($config);

        $mocks = [$configMock, $movementServiceMock, Mockery::mock(CreditCardTransactionService::class)->makePartial()];

        $marketPlannerMock = Mockery::mock(MarketPlannerService::class, $mocks)->makePartial();
        $marketPlannerMock->shouldAllowMockingProtectedMethods();

        $marketPlannerMock->makeThisMonthMarketSpentValue($movements, []);

        $this->assertEquals(50, $marketPlannerMock->getFirstInstallmentMarket());
    }

    public function testMakeMarketInvoiceItem()
    {
        $config = new ConfigurationDTO();
        $config->setName('marketPlanner');
        $config->setValue(100);

        $movementServiceMock = Mockery::mock(MovementService::class)->makePartial();
        $configMock = Mockery::mock(ConfigurationService::class)->makePartial();
        $configMock
            ->shouldReceive('findConfigByName')
            ->once()
            ->andReturn($config);

        $mocks = [$configMock, $movementServiceMock, Mockery::mock(CreditCardTransactionService::class)->makePartial()];

        $marketPlannerMock = Mockery::mock(MarketPlannerService::class, $mocks)->makePartial();
        $marketPlannerMock->shouldAllowMockingProtectedMethods();

        $datePeriod = new DatePeriodDTO('2021-01-01', '2021-12-31');
        $calendarMock = Mockery::mock(CalendarToolsReal::class)->makePartial();
        $calendarMock->shouldReceive('getThisMonthPeriod')->once()->andReturn($datePeriod);
        $this->app->instance(CalendarToolsReal::class, $calendarMock);

        $invoice = $marketPlannerMock->makeMarketInvoiceItem();

        $this->assertInstanceOf(InvoiceItemDTO::class, $invoice);
        $this->assertEquals('Mercado', $invoice->getDescription());
        $this->assertEquals(100, $invoice->getValue());
        $this->assertEquals('2021-12-31', $invoice->getNextInstallment());
        $this->assertEquals(0, $invoice->getId());
        $this->assertEquals(0, $invoice->getCountId());
        $this->assertEquals(InvoiceInstallmentsEnum::FixedInstallments->value, $invoice->getInstallments());
        $this->assertNull($invoice->getCountName());
    }

    #[TestDox('Testando com valor positivo')]
    public function testGetFirstInstallmentMarketTestOne()
    {
        $marketPlannerMock = Mockery::mock(MarketPlannerService::class)->makePartial();
        $marketPlannerMock->shouldAllowMockingProtectedMethods();
        $marketPlannerMock->shouldReceive('getThisMonthMarketSpentValue')->once()->andReturn(50);
        $marketPlannerMock->shouldReceive('getMarketPlannerValue')->once()->andReturn(100);

        $this->assertEquals(50, $marketPlannerMock->getFirstInstallmentMarket());
    }

    #[TestDox('Testando com valor negativo')]
    public function testGetFirstInstallmentMarketTwo()
    {
        $marketPlannerMock = Mockery::mock(MarketPlannerService::class)->makePartial();
        $marketPlannerMock->shouldAllowMockingProtectedMethods();
        $marketPlannerMock->shouldReceive('getThisMonthMarketSpentValue')->once()->andReturn(150);
        $marketPlannerMock->shouldReceive('getMarketPlannerValue')->once()->andReturn(100);

        $this->assertEquals(0, $marketPlannerMock->getFirstInstallmentMarket());
    }
}
