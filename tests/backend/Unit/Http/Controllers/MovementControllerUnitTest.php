<?php

namespace Tests\backend\Unit\Http\Controllers;

use App\DTO\Movement\MovementDTO;
use App\Enums\MovementEnum;
use App\Exceptions\Validator\InvalidRequestDataException;
use App\Http\Controllers\MovementController;
use App\Resources\Movement\MovementResource;
use App\Services\Movement\MovementService;
use Illuminate\Http\Request;
use Mockery;
use Symfony\Component\HttpFoundation\ParameterBag;
use Tests\backend\Falcon9;

class MovementControllerUnitTest extends Falcon9
{
    protected function getTransferRequest(): Request
    {
        $data = new ParameterBag();
        $data->set('originId', 1);
        $data->set('destinationId', 2);
        $data->set('amount', 100);
        $request = new Request();
        $request->setJson($data);
        return $request;
    }

    public function testInsertTransferRules()
    {
        $serviceMock = Mockery::mock(MovementService::class);
        $mocks = [$serviceMock, new MovementResource()];

        $controllerMock = Mockery::mock(MovementController::class, $mocks)->makePartial();
        $controllerMock->shouldAllowMockingProtectedMethods();

        $rules = $controllerMock->rulesInsertTransfer();

        $this->assertIsArray($rules);
        $this->assertArrayHasKey('originId', $rules);
        $this->assertArrayHasKey('destinationId', $rules);
        $this->assertArrayHasKey('amount', $rules);
        $this->assertEquals('required|int|exists:App\Models\WalletModel,id', $rules['originId']);
        $this->assertEquals('required|int|exists:App\Models\WalletModel,id', $rules['destinationId']);
        $this->assertEquals('required|decimal:0,2', $rules['amount']);
    }

    public function testGetService()
    {
        $serviceMock = Mockery::mock(MovementService::class);
        $mocks = [$serviceMock, new MovementResource()];

        $controllerMock = Mockery::mock(MovementController::class, $mocks)->makePartial();
        $controllerMock->shouldAllowMockingProtectedMethods();

        $service = $controllerMock->getService();

        $this->assertInstanceOf(MovementService::class, $service);
    }

    public function testGetResource()
    {
        $serviceMock = Mockery::mock(MovementService::class);
        $mocks = [$serviceMock, new MovementResource()];

        $controllerMock = Mockery::mock(MovementController::class, $mocks)->makePartial();
        $controllerMock->shouldAllowMockingProtectedMethods();

        $resource = $controllerMock->getResource();

        $this->assertInstanceOf(MovementResource::class, $resource);
    }

    public function testDeleteTransfer()
    {
        $serviceMock = Mockery::mock(MovementService::class);
        $serviceMock->shouldReceive('deleteTransferById')->once()->andReturn(true);
        $mocks = [$serviceMock, new MovementResource()];

        $controllerMock = Mockery::mock(MovementController::class, $mocks)->makePartial();
        $controllerMock->shouldAllowMockingProtectedMethods();

        $response = $controllerMock->deleteTransfer(1);

        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testInsertTransferWithInvalidRequest()
    {
        $serviceMock = Mockery::mock(MovementService::class);
        $serviceMock->shouldReceive('insertWithWalletUpdateType')->never();
        $mocks = [$serviceMock, new MovementResource()];

        $controllerMock = Mockery::mock(MovementController::class, $mocks)->makePartial();
        $controllerMock->shouldAllowMockingProtectedMethods();
        $controllerMock->shouldReceive('rulesInsertTransfer')->once()->andReturn(['aaa' => 'required']);

        $this->expectException(InvalidRequestDataException::class);

        $controllerMock->insertTransfer($this->getTransferRequest());
    }

    public function testInsertTransferWithValidData()
    {
        $serviceMock = Mockery::mock(MovementService::class);
        $serviceMock->shouldReceive('insertWithWalletUpdateType')->times(2)->andReturnUsing(
            function ($transfer, $type) {
                Falcon9::assertEquals(MovementEnum::Spent->value, $type);
                $this->assertInstanceOf(MovementDTO::class, $transfer);
                return true;
            },
            function ($transfer, $type) {
                Falcon9::assertEquals(MovementEnum::Gain->value, $type);
                $this->assertInstanceOf(MovementDTO::class, $transfer);
            }
        );
        $mocks = [$serviceMock, new MovementResource()];

        $controllerMock = Mockery::mock(MovementController::class, $mocks)->makePartial();
        $controllerMock->shouldAllowMockingProtectedMethods();
        $controllerMock->shouldReceive('rulesInsertTransfer')->once()->andReturn([]);

        $response = $controllerMock->insertTransfer($this->getTransferRequest());

        $this->assertEquals(201, $response->getStatusCode());
    }
}
