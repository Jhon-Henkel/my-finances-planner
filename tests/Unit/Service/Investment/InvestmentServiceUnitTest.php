<?php

namespace Service\Investment;

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
}