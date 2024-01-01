<?php

namespace Http\Controllers\Investment;

use App\Http\Controllers\Investment\InvestmentController;
use App\Resources\Investment\InvestmentResource;
use App\Services\Investment\InvestmentService;
use Mockery;
use Tests\backend\Falcon9;

class InvestmentControllerUnitTest extends Falcon9
{
    public function testRulesInsert()
    {
        $controllerMock = $this->mock(InvestmentController::class)->makePartial();
        $controllerMock->shouldAllowMockingProtectedMethods();

        $this->assertEquals(
            [
                'credit_card_id' => 'nullable|int|exists:App\Models\CreditCard,id',
                'description' => 'required|max:255|string',
                'type' => 'required|numeric',
                'amount' => 'required|decimal:0,2',
                'liquidity' => 'required|numeric',
                'profitability' => 'required|decimal:0,2'
            ],
            $controllerMock->rulesInsert()
        );
    }

    public function testUpdateRules()
    {
        $controllerMock = $this->mock(InvestmentController::class)->makePartial();
        $controllerMock->shouldAllowMockingProtectedMethods();

        $this->assertEquals(
            [
                'credit_card_id' => 'nullable|int|exists:App\Models\CreditCard,id',
                'description' => 'required|max:255|string',
                'type' => 'required|numeric',
                'amount' => 'required|decimal:0,2',
                'liquidity' => 'required|numeric',
                'profitability' => 'required|decimal:0,2'
            ],
            $controllerMock->rulesUpdate()
        );
    }

    public function testGetService()
    {
        $serviceMock = $this->mock(InvestmentService::class)->makePartial();
        $resourceMock = $this->mock(InvestmentResource::class)->makePartial();
        $controllerMock = Mockery::mock(InvestmentController::class, [$serviceMock, $resourceMock])->makePartial();
        $controllerMock->shouldAllowMockingProtectedMethods();

        $service = $controllerMock->getService();

        $this->assertInstanceOf(InvestmentService::class, $service);
    }

    public function testGetResource()
    {
        $serviceMock = $this->mock(InvestmentService::class)->makePartial();
        $resourceMock = $this->mock(InvestmentResource::class)->makePartial();
        $controllerMock = Mockery::mock(InvestmentController::class, [$serviceMock, $resourceMock])->makePartial();
        $controllerMock->shouldAllowMockingProtectedMethods();

        $resource = $controllerMock->getResource();

        $this->assertInstanceOf(InvestmentResource::class, $resource);
    }

    public function testMakeDataGraph()
    {
        $serviceMock = $this->mock(InvestmentService::class)->makePartial();
        $resourceMock = $this->mock(InvestmentResource::class)->makePartial();
        $controllerMock = Mockery::mock(InvestmentController::class, [$serviceMock, $resourceMock])->makePartial();
        $controllerMock->shouldAllowMockingProtectedMethods();

        $serviceMock->shouldReceive('makeDataGraph')->once()->andReturn([]);

        $response = $controllerMock->makeDataGraph();

        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testRulesRescueApport()
    {
        $controllerMock = $this->mock(InvestmentController::class)->makePartial();
        $controllerMock->shouldAllowMockingProtectedMethods();

        $this->assertEquals(
            [
                'walletId' => 'required|int|exists:App\Models\WalletModel,id',
                'investmentId' => 'required|int|exists:App\Models\Investment\Investment,id',
                'value' => 'required|decimal:0,2',
                'rescue' => 'required|boolean'
            ],
            $controllerMock->rulesRescueApport()
        );
    }
}