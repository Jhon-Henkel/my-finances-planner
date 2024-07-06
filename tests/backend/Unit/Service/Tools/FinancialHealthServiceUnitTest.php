<?php

namespace Tests\backend\Unit\Service\Tools;

use App\DTO\Movement\MovementDTO;
use App\Enums\MovementEnum;
use App\Services\CreditCard\CreditCardMovementService;
use App\Services\Movement\MovementService;
use App\Services\Tools\FinancialHealthService;
use Mockery;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\TestDox;
use Tests\backend\Falcon9;

class FinancialHealthServiceUnitTest extends Falcon9
{
    #[DataProvider('dataProviderForTestGetCategoryTitleByDescription')]
    public function testGetCategoryTitleByDescription(string $input, string $output)
    {
        $serviceMock = Mockery::mock(FinancialHealthService::class)->makePartial();
        $serviceMock->shouldAllowMockingProtectedMethods();
        $result = $serviceMock->getCategoryTitleByDescription($input);

        $this->assertEquals($output, $result);
    }

    public static function dataProviderForTestGetCategoryTitleByDescription(): array
    {
        return [
            'testCreditCardMovement' => ['input' => 'Fatura cartão de crédito', 'output' => 'Cartão de crédito'],
            'testPartialPaymentMovement' => ['input' => 'Pagamento parcial Carro', 'output' => 'Carro'],
            'testPaymentMovement' => ['input' => 'Pagamento Escola', 'output' => 'Escola'],
            'testPaymentMovementWithMonthName' => ['input' => 'Pagamento Energia Janeiro', 'output' => 'Energia'],
            'testPaymentMovementWithMonthNameAndSpace' => ['input' => 'Pagamento Energia Janeiro ', 'output' => 'Energia'],
            'testReceiveMovement' => ['input' => 'Recebimento Salário', 'output' => 'Salário'],
            'testReceiveMovementWithMonthName' => ['input' => 'Recebimento Salário Janeiro', 'output' => 'Salário'],
            'testRestMovement' => ['input' => 'Restante Aluguel', 'output' => 'Aluguel']
        ];
    }

    #[TestDox('Testando Agrupando despesas cartão')]
    public function testCategorizeMovementsTestOne()
    {
        $movementOne = new MovementDTO();
        $movementOne->setType(MovementEnum::Spent->value);
        $movementOne->setDescription('Cartão de crédito');
        $movementOne->setAmount(100);

        $movementTwo = new MovementDTO();
        $movementTwo->setType(MovementEnum::Spent->value);
        $movementTwo->setDescription('Pagamento Energia');
        $movementTwo->setAmount(200);

        $movementThree = new MovementDTO();
        $movementThree->setType(MovementEnum::Gain->value);
        $movementThree->setDescription('Recebimento Salário');
        $movementThree->setAmount(300);

        $movementFour = new MovementDTO();
        $movementFour->setType(MovementEnum::Gain->value);
        $movementFour->setDescription('Recebimento Salário');
        $movementFour->setAmount(400);

        $movementFive = new MovementDTO();
        $movementFive->setType(MovementEnum::Spent->value);
        $movementFive->setDescription('Pagamento Energia');
        $movementFive->setAmount(500);

        $movements = [$movementOne, $movementTwo, $movementThree, $movementFour, $movementFive];

        $serviceMock = Mockery::mock(FinancialHealthService::class)->makePartial();
        $serviceMock->shouldAllowMockingProtectedMethods();
        $result = $serviceMock->categorizeMovements($movements, false);

        $this->assertCount(2, $result);
        $this->assertCount(2, $result[MovementEnum::Spent->value]);
        $this->assertCount(1, $result[MovementEnum::Gain->value]);
        $this->assertArrayHasKey(MovementEnum::Spent->value, $result);
        $this->assertArrayHasKey(MovementEnum::Gain->value, $result);
        $this->assertArrayHasKey('Cartão de crédito', $result[MovementEnum::Spent->value]);
        $this->assertArrayHasKey('Energia', $result[MovementEnum::Spent->value]);
        $this->assertArrayHasKey('Salário', $result[MovementEnum::Gain->value]);
        $this->assertEquals(100, $result[MovementEnum::Spent->value]['Cartão de crédito']);
        $this->assertEquals(700, $result[MovementEnum::Spent->value]['Energia']);
        $this->assertEquals(700, $result[MovementEnum::Gain->value]['Salário']);
    }

    #[TestDox('Testando Não agrupando despesas cartão')]
    public function testCategorizeMovementsTestTwo()
    {
        $movementOne = new MovementDTO();
        $movementOne->setType(MovementEnum::Spent->value);
        $movementOne->setDescription('Cartão de crédito');
        $movementOne->setAmount(100);

        $movementTwo = new MovementDTO();
        $movementTwo->setType(MovementEnum::Spent->value);
        $movementTwo->setDescription('Pagamento Energia');
        $movementTwo->setAmount(200);

        $movementThree = new MovementDTO();
        $movementThree->setType(MovementEnum::Gain->value);
        $movementThree->setDescription('Recebimento Salário');
        $movementThree->setAmount(300);

        $movementFour = new MovementDTO();
        $movementFour->setType(MovementEnum::Gain->value);
        $movementFour->setDescription('Recebimento Salário');
        $movementFour->setAmount(400);

        $movementFive = new MovementDTO();
        $movementFive->setType(MovementEnum::Spent->value);
        $movementFive->setDescription('Pagamento Energia');
        $movementFive->setAmount(500);

        $movements = [$movementOne, $movementTwo, $movementThree, $movementFour, $movementFive];

        $serviceMock = Mockery::mock(FinancialHealthService::class)->makePartial();
        $serviceMock->shouldAllowMockingProtectedMethods();
        $result = $serviceMock->categorizeMovements($movements, true);

        $this->assertCount(2, $result);
        $this->assertCount(1, $result[MovementEnum::Spent->value]);
        $this->assertCount(1, $result[MovementEnum::Gain->value]);
        $this->assertArrayHasKey(MovementEnum::Spent->value, $result);
        $this->assertArrayHasKey(MovementEnum::Gain->value, $result);
        $this->assertArrayNotHasKey('Cartão de crédito', $result[MovementEnum::Spent->value]);
        $this->assertArrayHasKey('Energia', $result[MovementEnum::Spent->value]);
        $this->assertArrayHasKey('Salário', $result[MovementEnum::Gain->value]);
        $this->assertEquals(700, $result[MovementEnum::Spent->value]['Energia']);
        $this->assertEquals(700, $result[MovementEnum::Gain->value]['Salário']);
    }

    public function testGetMovementsByPeriod()
    {
        $movementMock = Mockery::mock(MovementService::class)->makePartial();
        $movementMock->shouldReceive('findByFilter')->once()->andReturn([]);

        $mocks = [
            Mockery::mock(CreditCardMovementService::class),
            $movementMock
        ];

        $serviceMock = Mockery::mock(FinancialHealthService::class, $mocks)->makePartial();
        $serviceMock->shouldAllowMockingProtectedMethods();
        $result = $serviceMock->getMovementsByPeriod([]);

        $this->assertIsArray($result);
    }

    public function testFindByFilter()
    {
        $serviceMock = Mockery::mock(FinancialHealthService::class)->makePartial();
        $serviceMock->shouldAllowMockingProtectedMethods();
        $serviceMock->shouldReceive('getMovementsByPeriod')->once()->andReturn([]);
        $serviceMock->shouldReceive('categorizeMovements')->once()->andReturn([]);
        $result = $serviceMock->findByFilter([]);

        $this->assertIsArray($result);
    }

    public function testSortByValue()
    {
        $serviceMock = Mockery::mock(FinancialHealthService::class)->makePartial();
        $serviceMock->shouldAllowMockingProtectedMethods();

        $data = [
            'gain' => ['a' => 10.50, 'b' => 9, 'c' => 10.59, 'd' => 50, 'e' => 500],
            'spent' => ['a' => 300, 'b' => 400, 'c' => 100, 'd' => 200, 'e' => 1000]
        ];

        $result = $serviceMock->sortByValue($data);
        $resultJson = json_encode($result);

        $this->assertIsArray($result);
        $this->assertCount(2, $result);
        $this->assertCount(5, $result['gain']);
        $this->assertCount(5, $result['spent']);
        $this->assertEquals(
            '{"gain":{"e":500,"d":50,"c":10.59,"a":10.5,"b":9},"spent":{"e":1000,"b":400,"a":300,"d":200,"c":100}}',
            $resultJson
        );
    }

    #[TestDox('Testando Agrupando despesas cartão')]
    public function testFindByFilterTestOne()
    {
        $creditCardMovementServiceMock = Mockery::mock(CreditCardMovementService::class)->makePartial();
        $creditCardMovementServiceMock->shouldReceive('findByPeriod')->never();

        $mocks = [
            $creditCardMovementServiceMock,
            Mockery::mock(MovementService::class),
        ];

        $serviceMock = Mockery::mock(FinancialHealthService::class, $mocks)->makePartial();
        $serviceMock->shouldAllowMockingProtectedMethods();
        $serviceMock->shouldReceive('getMovementsByPeriod')->once()->andReturn([]);
        $serviceMock->shouldReceive('categorizeMovements')->once()->andReturn([]);
        $serviceMock->shouldReceive('addDataForGraph')->once()->andReturn([]);

        $this->assertEquals([], $serviceMock->findByFilter([]));
    }

    #[TestDox('Testando Não agrupando despesas cartão')]
    public function testFindByFilterTestTwo()
    {
        $creditCardMovementServiceMock = Mockery::mock(CreditCardMovementService::class)->makePartial();
        $creditCardMovementServiceMock->shouldReceive('findByPeriod')->once()->andReturn([]);

        $mocks = [
            $creditCardMovementServiceMock,
            Mockery::mock(MovementService::class),
        ];

        $serviceMock = Mockery::mock(FinancialHealthService::class, $mocks)->makePartial();
        $serviceMock->shouldAllowMockingProtectedMethods();
        $serviceMock->shouldReceive('getMovementsByPeriod')->once()->andReturn([]);
        $serviceMock->shouldReceive('categorizeMovements')->once()->andReturn([]);
        $serviceMock->shouldReceive('addDataForGraph')->once()->andReturn([]);

        $this->assertEquals([], $serviceMock->findByFilter(['dontGroupCardExpenses' => 'true']));
    }
}
