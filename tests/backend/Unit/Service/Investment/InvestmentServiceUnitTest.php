<?php

namespace Tests\backend\Unit\Service\Investment;

use App\DTO\Investment\InvestmentDTO;
use App\DTO\Movement\MovementDTO;
use App\DTO\WalletDTO;
use App\Enums\MovementEnum;
use App\Repositories\Investment\InvestmentRepository;
use App\Services\Investment\InvestmentService;
use App\Services\Movement\MovementService;
use App\Services\WalletService;
use Mockery;
use PHPUnit\Framework\Attributes\TestDox;
use Tests\backend\Falcon9;

class InvestmentServiceUnitTest extends Falcon9
{
    public function getInvestmentMock(int $id, float $amount, string $description): InvestmentDTO
    {
        return new InvestmentDTO(
            $id,
            1,
            $description,
            1,
            $amount,
            1,
            1,
            null,
            null
        );
    }

    public function testGetRepository()
    {
        $repositoryMock = Mockery::mock(InvestmentRepository::class)->makePartial();
        $walletServiceMock = Mockery::mock(WalletService::class)->makePartial();
        $movementServiceMock = Mockery::mock(MovementService::class)->makePartial();
        $mocks = [$repositoryMock, $walletServiceMock,$movementServiceMock];

        $mock = Mockery::mock(InvestmentService::class, $mocks)->makePartial();
        $mock->shouldAllowMockingProtectedMethods();

        $this->assertInstanceOf(InvestmentRepository::class, $mock->getRepository());
    }

    public function testMakeDataGraph()
    {
        $repositoryMock = Mockery::mock(InvestmentRepository::class)->makePartial();
        $repositoryMock->shouldReceive('findAllInTypes')->andReturn([
            $this->getInvestmentMock(1, 1000, 'CDB'),
            $this->getInvestmentMock(2, 2000, 'CDB'),
            $this->getInvestmentMock(3, 3000, 'CDB'),
        ]);

        $walletServiceMock = Mockery::mock(WalletService::class)->makePartial();
        $movementServiceMock = Mockery::mock(MovementService::class)->makePartial();
        $mocks = [$repositoryMock, $walletServiceMock,$movementServiceMock];

        $mock = Mockery::mock(InvestmentService::class, $mocks)->makePartial();
        $mock->shouldAllowMockingProtectedMethods();
        $mock->shouldReceive('contributedAndRescuedGraphData')->once()->andReturn([]);

        $this->assertEquals([
            'cdb' => [
                'label' => 'CDB',
                'value' => 6000,
            ],
            'contributedAndRescued' => [],
        ], $mock->makeDataGraph());
    }

    #[TestDox('Testando Resgate de investimento')]
    public function testRescueApportInvestmentTestOne()
    {
        $repositoryMock = Mockery::mock(InvestmentRepository::class)->makePartial();
        $repositoryMock->shouldReceive('findById')->andReturn(
            $this->getInvestmentMock(1, 1000, 'CDB')
        );

        $wallet = new WalletDTO();
        $wallet->setId(1);
        $wallet->setAmount(1000);

        $walletServiceMock = Mockery::mock(WalletService::class)->makePartial();
        $walletServiceMock->shouldReceive('findById')->andReturn($wallet);
        $walletServiceMock->shouldReceive('update')->andReturnUsing(
            function ($id, WalletDTO $wallet) {
                $this->assertEquals(1, $id);
                $this->assertEquals(1100, $wallet->getAmount());
            }
        );

        $movementServiceMock = Mockery::mock(MovementService::class)->makePartial();
        $movementServiceMock->shouldReceive('launchMovementForInvestment')->andReturnUsing(
            function ($value, $type, $walletId, $rescue) {
                $this->assertEquals(100, $value);
                $this->assertEquals(1, $walletId);
                $this->assertEquals(MovementEnum::INVESTMENT_CDB, $type);
                $this->assertTrue($rescue);
            }
        );
        $mocks = [$repositoryMock, $walletServiceMock, $movementServiceMock];

        $mock = Mockery::mock(InvestmentService::class, $mocks)->makePartial();
        $mock->shouldAllowMockingProtectedMethods();

        $mock->shouldReceive('update')->andReturnUsing(
            function ($id, InvestmentDTO $investment) {
                $this->assertEquals(1, $id);
                $this->assertEquals(900, $investment->getAmount());
            }
        );

        $mock->rescueApportInvestment([
            'walletId' => 1,
            'investmentId' => 1,
            'value' => 100,
            'rescue' => true,
        ]);

        $this->assertTrue(true);
    }

    #[TestDox('Testando Aporte de investimento')]
    public function testRescueApportInvestmentApportInvestment()
    {
        $repositoryMock = Mockery::mock(InvestmentRepository::class)->makePartial();
        $repositoryMock->shouldReceive('findById')->andReturn(
            $this->getInvestmentMock(1, 1000, 'CDB')
        );

        $wallet = new WalletDTO();
        $wallet->setId(1);
        $wallet->setAmount(1000);

        $walletServiceMock = Mockery::mock(WalletService::class)->makePartial();
        $walletServiceMock->shouldReceive('findById')->andReturn($wallet);
        $walletServiceMock->shouldReceive('update')->andReturnUsing(
            function ($id, WalletDTO $wallet) {
                $this->assertEquals(1, $id);
                $this->assertEquals(900, $wallet->getAmount());
            }
        );

        $movementServiceMock = Mockery::mock(MovementService::class)->makePartial();
        $movementServiceMock->shouldReceive('launchMovementForInvestment')->andReturnUsing(
            function ($value, $type, $walletId, $rescue) {
                $this->assertEquals(100, $value);
                $this->assertEquals(1, $walletId);
                $this->assertEquals(MovementEnum::INVESTMENT_CDB, $type);
                $this->assertFalse($rescue);
            }
        );
        $mocks = [$repositoryMock, $walletServiceMock, $movementServiceMock];

        $mock = Mockery::mock(InvestmentService::class, $mocks)->makePartial();
        $mock->shouldAllowMockingProtectedMethods();

        $mock->shouldReceive('update')->andReturnUsing(
            function ($id, InvestmentDTO $investment) {
                $this->assertEquals(1, $id);
                $this->assertEquals(1100, $investment->getAmount());
            }
        );

        $mock->rescueApportInvestment([
            'walletId' => 1,
            'investmentId' => 1,
            'value' => 100,
            'rescue' => false,
        ]);

        $this->assertTrue(true);
    }

    #[TestDox('Testando Resgate de investimento com valor resgate maior que o valor do investimento')]
    public function testValidateValueToRescueOrApportTestOne()
    {
        $mock = Mockery::mock(InvestmentService::class)->makePartial();
        $mock->shouldAllowMockingProtectedMethods();

        $this->expectExceptionMessage('O valor a ser resgatado é maior que o valor investido!');
        $mock->validateValueToRescueOrApport(1000, 500, 600, true);
    }

    #[TestDox('Testando Aporte de investimento com valor aportado maior que o valor disponível na carteira')]
    public function testValidateValueToRescueOrApportTestTwo()
    {
        $mock = Mockery::mock(InvestmentService::class)->makePartial();
        $mock->shouldAllowMockingProtectedMethods();

        $this->expectExceptionMessage('O valor a ser aportado é maior que o valor disponível na carteira!');
        $mock->validateValueToRescueOrApport(500, 1000, 600, false);
    }

    #[TestDox('Testando Aporte de investimento com valor aportado menor que o valor disponível na carteira')]
    public function testValidateValueToRescueOrApportTestThree()
    {
        $mock = Mockery::mock(InvestmentService::class)->makePartial();
        $mock->shouldAllowMockingProtectedMethods();

        $data = $mock->validateValueToRescueOrApport(1000, 500, 400, false);
        $this->assertTrue($data);
    }

    #[TestDox('Testando Resgate de investimento com valor resgate menor que o valor do investimento')]
    public function testValidateValueToRescueOrApportTestFour()
    {
        $mock = Mockery::mock(InvestmentService::class)->makePartial();
        $mock->shouldAllowMockingProtectedMethods();

        $data = $mock->validateValueToRescueOrApport(1000, 500, 400, true);
        $this->assertTrue($data);
    }

    public function testContributedAndRescuedGraphData()
    {
        $movementOne = new MovementDTO();
        $movementOne->setCreatedAt('2021-01-01');
        $movementOne->setAmount(100);
        $movementOne->setType(MovementEnum::INVESTMENT_CDB);
        $movementOne->setDescription('Resgate de investimento');

        $movementTwo = new MovementDTO();
        $movementTwo->setCreatedAt('2021-01-01');
        $movementTwo->setAmount(200);
        $movementTwo->setType(MovementEnum::INVESTMENT_CDB);
        $movementTwo->setDescription('Aporte de investimento');

        $movementThree = new MovementDTO();
        $movementThree->setCreatedAt('2021-02-01');
        $movementThree->setAmount(300);
        $movementThree->setType(MovementEnum::INVESTMENT_CDB);
        $movementThree->setDescription('Resgate de investimento');

        $movementFour = new MovementDTO();
        $movementFour->setCreatedAt('2021-02-01');
        $movementFour->setAmount(400);
        $movementFour->setType(MovementEnum::INVESTMENT_CDB);
        $movementFour->setDescription('Aporte de investimento');

        $movementFive = new MovementDTO();
        $movementFive->setCreatedAt('2021-03-01');
        $movementFive->setAmount(500);
        $movementFive->setType(MovementEnum::INVESTMENT_CDB);
        $movementFive->setDescription('Resgate de investimento');

        $movementSix = new MovementDTO();
        $movementSix->setCreatedAt('2021-03-01');
        $movementSix->setAmount(600);
        $movementSix->setType(MovementEnum::INVESTMENT_CDB);
        $movementSix->setDescription('Aporte de investimento');

        $movementSeven = new MovementDTO();
        $movementSeven->setCreatedAt('2021-03-01');
        $movementSeven->setAmount(500);
        $movementSeven->setType(MovementEnum::INVESTMENT_CDB);
        $movementSeven->setDescription('Resgate de investimento');

        $movementEight = new MovementDTO();
        $movementEight->setCreatedAt('2021-03-01');
        $movementEight->setAmount(600);
        $movementEight->setType(MovementEnum::INVESTMENT_CDB);
        $movementEight->setDescription('Aporte de investimento');

        $movements = [
            $movementOne,
            $movementTwo,
            $movementThree,
            $movementFour,
            $movementFive,
            $movementSix,
            $movementSeven,
            $movementEight,
        ];

        $repositoryMock = Mockery::mock(InvestmentRepository::class)->makePartial();
        $walletServiceMock = Mockery::mock(WalletService::class)->makePartial();
        $movementServiceMock = Mockery::mock(MovementService::class)->makePartial();
        $movementServiceMock->shouldReceive('findAllByType')->andReturn($movements);
        $mocks = [$repositoryMock, $walletServiceMock,$movementServiceMock];

        $mock = Mockery::mock(InvestmentService::class, $mocks)->makePartial();
        $mock->shouldAllowMockingProtectedMethods();

        $data = $mock->contributedAndRescuedGraphData();

        $this->assertEquals([
            'rescued' => [100, 300, 1000],
            'contributed' => [200, 400, 1200],
            'labels' => ['2021-01', '2021-02', '2021-03']
        ], $data);
    }
}