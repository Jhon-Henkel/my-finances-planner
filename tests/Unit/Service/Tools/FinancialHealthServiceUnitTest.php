<?php

namespace Tests\Unit\Service\Tools;

use App\DTO\Movement\MovementDTO;
use App\Enums\MovementEnum;
use App\Services\CreditCard\CreditCardMovementService;
use App\Services\Movement\MovementService;
use App\Services\Tools\FinancialHealthService;
use Mockery;
use Tests\Falcon9;

class FinancialHealthServiceUnitTest extends Falcon9
{
    /**
     * @dataProvider dataProviderForTestGetCategoryTitleByDescription
     */
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

    /**
     * Parâmetros do teste:
     * - Agrupando despesas cartão
     */
    public function testCategorizeMovementsTestOne()
    {
        $movementOne = new MovementDTO();
        $movementOne->setType(MovementEnum::SPENT);
        $movementOne->setDescription('Cartão de crédito');
        $movementOne->setAmount(100);

        $movementTwo = new MovementDTO();
        $movementTwo->setType(MovementEnum::SPENT);
        $movementTwo->setDescription('Pagamento Energia');
        $movementTwo->setAmount(200);

        $movementThree = new MovementDTO();
        $movementThree->setType(MovementEnum::GAIN);
        $movementThree->setDescription('Recebimento Salário');
        $movementThree->setAmount(300);

        $movementFour = new MovementDTO();
        $movementFour->setType(MovementEnum::GAIN);
        $movementFour->setDescription('Recebimento Salário');
        $movementFour->setAmount(400);

        $movementFive = new MovementDTO();
        $movementFive->setType(MovementEnum::SPENT);
        $movementFive->setDescription('Pagamento Energia');
        $movementFive->setAmount(500);

        $movements = [$movementOne, $movementTwo, $movementThree, $movementFour, $movementFive];

        $serviceMock = Mockery::mock(FinancialHealthService::class)->makePartial();
        $serviceMock->shouldAllowMockingProtectedMethods();
        $result = $serviceMock->categorizeMovements($movements, false);

        $this->assertCount(2, $result);
        $this->assertCount(2, $result[MovementEnum::SPENT]);
        $this->assertCount(1, $result[MovementEnum::GAIN]);
        $this->assertArrayHasKey(MovementEnum::SPENT, $result);
        $this->assertArrayHasKey(MovementEnum::GAIN, $result);
        $this->assertArrayHasKey('Cartão de crédito', $result[MovementEnum::SPENT]);
        $this->assertArrayHasKey('Energia', $result[MovementEnum::SPENT]);
        $this->assertArrayHasKey('Salário', $result[MovementEnum::GAIN]);
        $this->assertEquals(100, $result[MovementEnum::SPENT]['Cartão de crédito']);
        $this->assertEquals(700, $result[MovementEnum::SPENT]['Energia']);
        $this->assertEquals(700, $result[MovementEnum::GAIN]['Salário']);
    }

    /**
     * Parâmetros do teste:
     * - Não agrupando despesas cartão
     */
    public function testCategorizeMovementsTestTwo()
    {
        $movementOne = new MovementDTO();
        $movementOne->setType(MovementEnum::SPENT);
        $movementOne->setDescription('Cartão de crédito');
        $movementOne->setAmount(100);

        $movementTwo = new MovementDTO();
        $movementTwo->setType(MovementEnum::SPENT);
        $movementTwo->setDescription('Pagamento Energia');
        $movementTwo->setAmount(200);

        $movementThree = new MovementDTO();
        $movementThree->setType(MovementEnum::GAIN);
        $movementThree->setDescription('Recebimento Salário');
        $movementThree->setAmount(300);

        $movementFour = new MovementDTO();
        $movementFour->setType(MovementEnum::GAIN);
        $movementFour->setDescription('Recebimento Salário');
        $movementFour->setAmount(400);

        $movementFive = new MovementDTO();
        $movementFive->setType(MovementEnum::SPENT);
        $movementFive->setDescription('Pagamento Energia');
        $movementFive->setAmount(500);

        $movements = [$movementOne, $movementTwo, $movementThree, $movementFour, $movementFive];

        $serviceMock = Mockery::mock(FinancialHealthService::class)->makePartial();
        $serviceMock->shouldAllowMockingProtectedMethods();
        $result = $serviceMock->categorizeMovements($movements, true);

        $this->assertCount(2, $result);
        $this->assertCount(1, $result[MovementEnum::SPENT]);
        $this->assertCount(1, $result[MovementEnum::GAIN]);
        $this->assertArrayHasKey(MovementEnum::SPENT, $result);
        $this->assertArrayHasKey(MovementEnum::GAIN, $result);
        $this->assertArrayNotHasKey('Cartão de crédito', $result[MovementEnum::SPENT]);
        $this->assertArrayHasKey('Energia', $result[MovementEnum::SPENT]);
        $this->assertArrayHasKey('Salário', $result[MovementEnum::GAIN]);
        $this->assertEquals(700, $result[MovementEnum::SPENT]['Energia']);
        $this->assertEquals(700, $result[MovementEnum::GAIN]['Salário']);
    }

    public function testGetMovementsByPeriod()
    {
        $movementMock = Mockery::mock(MovementService::class)->makePartial();
        $movementMock->shouldReceive('findByFilter')->once()->andReturn([]);
        $this->app->instance(MovementService::class, $movementMock);

        $serviceMock = Mockery::mock(FinancialHealthService::class)->makePartial();
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

    /**
     * Parâmetros do teste:
     * - Agrupando despesas cartão
     */
    public function testFindByFilterTestOne()
    {
        $creditCardMovementServiceMock = Mockery::mock(CreditCardMovementService::class)->makePartial();
        $creditCardMovementServiceMock->shouldReceive('findByPeriod')->never();

        $serviceMock = Mockery::mock(FinancialHealthService::class, [$creditCardMovementServiceMock])->makePartial();
        $serviceMock->shouldAllowMockingProtectedMethods();
        $serviceMock->shouldReceive('getMovementsByPeriod')->once()->andReturn([]);
        $serviceMock->shouldReceive('categorizeMovements')->once()->andReturn([]);
        $serviceMock->shouldReceive('addDataForGraph')->once()->andReturn([]);

        $this->assertEquals([], $serviceMock->findByFilter([]));
    }

    /**
     * Parâmetros do teste:
     * - Nãoo agrupando despesas cartão
     */
    public function testFindByFilterTestTwo()
    {
        $creditCardMovementServiceMock = Mockery::mock(CreditCardMovementService::class)->makePartial();
        $creditCardMovementServiceMock->shouldReceive('findByPeriod')->once()->andReturn([]);

        $serviceMock = Mockery::mock(FinancialHealthService::class, [$creditCardMovementServiceMock])->makePartial();
        $serviceMock->shouldAllowMockingProtectedMethods();
        $serviceMock->shouldReceive('getMovementsByPeriod')->once()->andReturn([]);
        $serviceMock->shouldReceive('categorizeMovements')->once()->andReturn([]);
        $serviceMock->shouldReceive('addDataForGraph')->once()->andReturn([]);

        $this->assertEquals([], $serviceMock->findByFilter(['dontGroupCardExpenses' => 'true']));
    }
}