<?php

namespace Repository\Investment;

use App\Models\Investment\Investment;
use App\Repositories\Investment\InvestmentRepository;
use App\Resources\Investment\InvestmentResource;
use Mockery;
use Tests\Falcon9;

class InvestmentRepositoryUnitTest extends Falcon9
{
    public function testGetModel()
    {
        $resourceMock = Mockery::mock(InvestmentResource::class)->makePartial();

        $mock = Mockery::mock(InvestmentRepository::class, [new Investment(), $resourceMock])->makePartial();
        $mock->shouldAllowMockingProtectedMethods();

        $this->assertInstanceOf(Investment::class, $mock->getModel());
    }

    public function testGetResource()
    {
        $modelMock = Mockery::mock(Investment::class)->makePartial();

        $mock = Mockery::mock(InvestmentRepository::class, [$modelMock, new InvestmentResource()])->makePartial();
        $mock->shouldAllowMockingProtectedMethods();

        $this->assertInstanceOf(InvestmentResource::class, $mock->getResource());
    }
}