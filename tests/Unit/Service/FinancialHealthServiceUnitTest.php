<?php

namespace Tests\Unit\Service;

use App\DTO\MovementDTO;
use App\Enums\MovementEnum;
use App\Services\FinancialHealthService;
use App\Services\MovementService;
use Mockery;
use Tests\TestCase;

class FinancialHealthServiceUnitTest extends TestCase
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

    public function testCategorizeMovements()
    {
        $movementOne = new MovementDTO();
        $movementOne->setType(MovementEnum::SPENT);
        $movementOne->setDescription('Pagamento Escola');
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
        $result = $serviceMock->categorizeMovements($movements);

        $this->assertCount(2, $result);
        $this->assertCount(2, $result[MovementEnum::SPENT]);
        $this->assertCount(1, $result[MovementEnum::GAIN]);
        $this->assertArrayHasKey(MovementEnum::SPENT, $result);
        $this->assertArrayHasKey(MovementEnum::GAIN, $result);
        $this->assertArrayHasKey('Escola', $result[MovementEnum::SPENT]);
        $this->assertArrayHasKey('Energia', $result[MovementEnum::SPENT]);
        $this->assertArrayHasKey('Salário', $result[MovementEnum::GAIN]);
        $this->assertEquals(100, $result[MovementEnum::SPENT]['Escola']);
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
        $result = $serviceMock->getMovementsByPeriod(1);

        $this->assertIsArray($result);
    }

    public function testFindByFilter()
    {
        $serviceMock = Mockery::mock(FinancialHealthService::class)->makePartial();
        $serviceMock->shouldAllowMockingProtectedMethods();
        $serviceMock->shouldReceive('getMovementsByPeriod')->once()->andReturn([]);
        $serviceMock->shouldReceive('categorizeMovements')->once()->andReturn([]);
        $result = $serviceMock->findByFilter(1);

        $this->assertIsArray($result);
    }
}