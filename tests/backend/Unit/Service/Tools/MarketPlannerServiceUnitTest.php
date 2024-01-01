<?php

namespace Service\Tools;

use App\DTO\Date\DatePeriodDTO;
use App\DTO\InvoiceItemDTO;
use App\DTO\Movement\MovementDTO;
use App\DTO\UserDTO;
use App\Enums\InvoiceEnum;
use App\Enums\MovementEnum;
use App\Services\Movement\MovementService;
use App\Services\Tools\MarketPlannerService;
use App\Services\UserService;
use App\Tools\Calendar\CalendarToolsReal;
use App\VO\InvoiceVO;
use Mockery;
use Tests\backend\Falcon9;

class MarketPlannerServiceUnitTest extends Falcon9
{
    public function getUserForTest(float $marketValue): UserDTO
    {
        $userDto = new UserDTO();
        $userDto->setMarketPlannerValue($marketValue);
        return $userDto;
    }

    /**
     * Parâmetros do teste:
     * - O usuário tem valor no planejador de mercado
     */
    public function testUseMarketPlannerTestOne()
    {
        $mockUserService = Mockery::mock(UserService::class)->makePartial();
        $mockUserService->shouldReceive('findOne')->once()->andReturn($this->getUserForTest(1000));

        $movementServiceMock = Mockery::mock(MovementService::class)->makePartial();

        $mocks = [$mockUserService, $movementServiceMock];

        $marketPlannerMock = Mockery::mock(MarketPlannerService::class, $mocks)->makePartial();

        $this->assertTrue($marketPlannerMock->useMarketPlanner());
    }

    /**
     * Parâmetros do teste:
     * - O usuário não tem valor no planejador de mercado
     */
    public function testUseMarketPlannerTestTwo()
    {
        $mockUserService = Mockery::mock(UserService::class)->makePartial();
        $mockUserService->shouldReceive('findOne')->once()->andReturn($this->getUserForTest(0));

        $movementServiceMock = Mockery::mock(MovementService::class)->makePartial();

        $mocks = [$mockUserService, $movementServiceMock];

        $marketPlannerMock = Mockery::mock(MarketPlannerService::class, $mocks)->makePartial();

        $this->assertFalse($marketPlannerMock->useMarketPlanner());
    }

    public function testGetMarketPlannerInvoice()
    {
        $invoice = new InvoiceItemDTO(
            0,
            0,
            null,
            'Mercado',
            10,
            '2021-01-01',
            InvoiceEnum::FIXED_INSTALLMENTS
        );

        $mockUserService = Mockery::mock(UserService::class)->makePartial();
        $mockUserService->shouldReceive('findOne')->once()->andReturn($this->getUserForTest(0));

        $movementServiceMock = Mockery::mock(MovementService::class)->makePartial();
        $movementServiceMock->shouldReceive('findByPeriodByDatePeriod')->once()->andReturn([]);

        $mocks = [$mockUserService, $movementServiceMock];

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
        $movementOne->setType(MovementEnum::SPENT);
        $movementOne->setDescription('Mercado');

        $movementTwo = new MovementDTO();
        $movementTwo->setAmount(40);
        $movementTwo->setType(MovementEnum::SPENT);
        $movementTwo->setDescription('Mercado');

        $movementThree = new MovementDTO();
        $movementThree->setAmount(50);
        $movementThree->setType(MovementEnum::GAIN);
        $movementThree->setDescription('Mercado');

        $movements = [$movementOne, $movementTwo, $movementThree];

        $mockUserService = Mockery::mock(UserService::class)->makePartial();
        $mockUserService->shouldReceive('findOne')->once()->andReturn($this->getUserForTest(100));

        $movementServiceMock = Mockery::mock(MovementService::class)->makePartial();

        $mocks = [$mockUserService, $movementServiceMock];

        $marketPlannerMock = Mockery::mock(MarketPlannerService::class, $mocks)->makePartial();
        $marketPlannerMock->shouldAllowMockingProtectedMethods();

        $marketPlannerMock->makeThisMonthMarketSpentValue($movements);

        $this->assertEquals(50, $marketPlannerMock->getFirstInstallmentMarket());
    }

    public function testMakeMarketInvoiceItem()
    {
        $mockUserService = Mockery::mock(UserService::class)->makePartial();
        $mockUserService->shouldReceive('findOne')->once()->andReturn($this->getUserForTest(100));

        $movementServiceMock = Mockery::mock(MovementService::class)->makePartial();

        $mocks = [$mockUserService, $movementServiceMock];

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
        $this->assertEquals(InvoiceEnum::FIXED_INSTALLMENTS, $invoice->getInstallments());
        $this->assertNull($invoice->getCountName());
    }

    /**
     * Parâmetros do teste:
     * - Valor positivo
     */
    public function testGetFirstInstallmentMarketTestOne()
    {
        $marketPlannerMock = Mockery::mock(MarketPlannerService::class)->makePartial();
        $marketPlannerMock->shouldAllowMockingProtectedMethods();
        $marketPlannerMock->shouldReceive('getThisMonthMarketSpentValue')->once()->andReturn(50);
        $marketPlannerMock->shouldReceive('getMarketPlannerValue')->once()->andReturn(100);

        $this->assertEquals(50, $marketPlannerMock->getFirstInstallmentMarket());
    }

    /**
     * Parâmetros do teste:
     * - Valor negativo
     */
    public function testGetFirstInstallmentMarketTwo()
    {
        $marketPlannerMock = Mockery::mock(MarketPlannerService::class)->makePartial();
        $marketPlannerMock->shouldAllowMockingProtectedMethods();
        $marketPlannerMock->shouldReceive('getThisMonthMarketSpentValue')->once()->andReturn(150);
        $marketPlannerMock->shouldReceive('getMarketPlannerValue')->once()->andReturn(100);

        $this->assertEquals(0, $marketPlannerMock->getFirstInstallmentMarket());
    }
}