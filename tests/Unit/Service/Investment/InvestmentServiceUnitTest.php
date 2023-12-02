<?php

namespace Service\Investment;

use App\DTO\Investment\InvestmentDTO;
use App\DTO\WalletDTO;
use App\Repositories\Investment\InvestmentRepository;
use App\Services\Investment\InvestmentService;
use App\Services\WalletService;
use Mockery;
use Tests\Falcon9;

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

        $mock = Mockery::mock(InvestmentService::class, [$repositoryMock, $walletServiceMock])->makePartial();
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

        $mock = Mockery::mock(InvestmentService::class, [$repositoryMock, $walletServiceMock])->makePartial();
        $mock->shouldAllowMockingProtectedMethods();

        $this->assertEquals([
            'cdb' => [
                'label' => 'CDB',
                'value' => 6000,
            ],
        ], $mock->makeDataGraph());
    }

    /**
     * Parâmetros do teste:
     * - Resgate de investimento
     */
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

        $mock = Mockery::mock(InvestmentService::class, [$repositoryMock, $walletServiceMock])->makePartial();
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

    /**
     * Parâmetros do teste:
     * - Aporte de investimento
     */
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

        $mock = Mockery::mock(InvestmentService::class, [$repositoryMock, $walletServiceMock])->makePartial();
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

    /**
     * Parâmetros do teste:
     * - Resgate de investimento
     * - Valor resgate maior que o valor do investimento
     */
    public function testValidateValueToRescueOrApportTestOne()
    {
        $mock = Mockery::mock(InvestmentService::class)->makePartial();
        $mock->shouldAllowMockingProtectedMethods();

        $this->expectExceptionMessage('O valor a ser resgatado é maior que o valor investido!');
        $mock->validateValueToRescueOrApport(1000, 500, 600, true);
    }

    /**
     * Parâmetros do teste:
     * - Aporte de investimento
     * - Valor aportado maior que o valor disponível na carteira
     */
    public function testValidateValueToRescueOrApportTestTwo()
    {
        $mock = Mockery::mock(InvestmentService::class)->makePartial();
        $mock->shouldAllowMockingProtectedMethods();

        $this->expectExceptionMessage('O valor a ser aportado é maior que o valor disponível na carteira!');
        $mock->validateValueToRescueOrApport(500, 1000, 600, false);
    }

    /**
     * Parâmetros do teste:
     * - Aporte de investimento
     * - Valor aportado menor que o valor disponível na carteira
     */
    public function testValidateValueToRescueOrApportTestThree()
    {
        $mock = Mockery::mock(InvestmentService::class)->makePartial();
        $mock->shouldAllowMockingProtectedMethods();

        $data = $mock->validateValueToRescueOrApport(1000, 500, 400, false);
        $this->assertTrue($data);
    }

    /**
     * Parâmetros do teste:
     * - Resgate de investimento
     * - Valor resgate menor que o valor do investimento
     */
    public function testValidateValueToRescueOrApportTestFour()
    {
        $mock = Mockery::mock(InvestmentService::class)->makePartial();
        $mock->shouldAllowMockingProtectedMethods();

        $data = $mock->validateValueToRescueOrApport(1000, 500, 400, true);
        $this->assertTrue($data);
    }
}