<?php

namespace Service\Investment;

use App\DTO\Investment\InvestmentDTO;
use App\Repositories\Investment\InvestmentRepository;
use App\Services\Investment\InvestmentService;
use Mockery;
use Tests\Falcon9;

class InvestmentServiceUnitTest extends Falcon9
{
    public function testGetRepository()
    {
        $repositoryMock = Mockery::mock(InvestmentRepository::class)->makePartial();

        $mock = Mockery::mock(InvestmentService::class, [$repositoryMock])->makePartial();
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

        $mock = Mockery::mock(InvestmentService::class, [$repositoryMock])->makePartial();
        $mock->shouldAllowMockingProtectedMethods();

        $this->assertEquals([
            'cdb' => [
                'label' => 'CDB',
                'value' => 6000,
            ],
        ], $mock->makeDataGraph());
    }

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
}