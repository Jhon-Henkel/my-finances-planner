<?php

namespace Tests\Unit\Http\Controllers;

use App\DTO\MovementDTO;
use App\Enums\MovementEnum;
use App\Resources\MovementResource;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\MessageBag;
use Mockery;
use Symfony\Component\HttpFoundation\ParameterBag;
use Tests\Falcon9;

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

    public function testInsertRules()
    {
        $serviceMock = Mockery::mock('App\Services\MovementService');
        $controllerMock = Mockery::mock('App\Http\Controllers\MovementController', [$serviceMock])->makePartial();
        $controllerMock->shouldAllowMockingProtectedMethods();

        $rules = $controllerMock->rulesInsert();

        $this->assertIsArray($rules);
        $this->assertArrayHasKey('description', $rules);
        $this->assertArrayHasKey('type', $rules);
        $this->assertArrayHasKey('walletId', $rules);
        $this->assertArrayHasKey('amount', $rules);
        $this->assertEquals('max:255|min:2|string', $rules['description']);
        $this->assertEquals('required|int', $rules['type']);
        $this->assertEquals('required|int|exists:App\Models\WalletModel,id', $rules['walletId']);
        $this->assertEquals('required|decimal:0,2', $rules['amount']);
    }

    public function testInsertTransferRules()
    {
        $serviceMock = Mockery::mock('App\Services\MovementService');
        $controllerMock = Mockery::mock('App\Http\Controllers\MovementController', [$serviceMock])->makePartial();
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

    public function testUpdateRules()
    {
        $serviceMock = Mockery::mock('App\Services\MovementService');
        $controllerMock = Mockery::mock('App\Http\Controllers\MovementController', [$serviceMock])->makePartial();
        $controllerMock->shouldAllowMockingProtectedMethods();

        $rules = $controllerMock->rulesUpdate();

        $this->assertIsArray($rules);
        $this->assertArrayHasKey('description', $rules);
        $this->assertArrayHasKey('type', $rules);
        $this->assertArrayHasKey('walletId', $rules);
        $this->assertArrayHasKey('amount', $rules);
        $this->assertEquals('max:255|min:2|string', $rules['description']);
        $this->assertEquals('required|int', $rules['type']);
        $this->assertEquals('required|int|exists:App\Models\WalletModel,id', $rules['walletId']);
        $this->assertEquals('required|decimal:0,2', $rules['amount']);
    }

    public function testGetService()
    {
        $serviceMock = Mockery::mock('App\Services\MovementService');
        $controllerMock = Mockery::mock('App\Http\Controllers\MovementController', [$serviceMock])->makePartial();
        $controllerMock->shouldAllowMockingProtectedMethods();

        $service = $controllerMock->getService();

        $this->assertInstanceOf('App\Services\MovementService', $service);
    }

    public function testGetResource()
    {
        $serviceMock = Mockery::mock('App\Services\MovementService');
        $controllerMock = Mockery::mock('App\Http\Controllers\MovementController', [$serviceMock])->makePartial();
        $controllerMock->shouldAllowMockingProtectedMethods();

        $resource = $controllerMock->getResource();

        $this->assertInstanceOf('App\Resources\MovementResource', $resource);
    }

    public function testDeleteTransfer()
    {
        $serviceMock = Mockery::mock('App\Services\MovementService');
        $serviceMock->shouldReceive('deleteTransferById')->once()->andReturn(true);

        $controllerMock = Mockery::mock('App\Http\Controllers\MovementController', [$serviceMock])->makePartial();
        $controllerMock->shouldAllowMockingProtectedMethods();

        $response = $controllerMock->deleteTransfer(1);

        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testDeleteTransferQueryException()
    {
        $serviceMock = Mockery::mock('App\Services\MovementService');
        $serviceMock->shouldReceive('deleteTransferById')->once()->andThrowExceptions(
            [new QueryException('test', "SELECT ....", [], new Exception())]
        );

        $controllerMock = Mockery::mock('App\Http\Controllers\MovementController', [$serviceMock])->makePartial();
        $controllerMock->shouldAllowMockingProtectedMethods();

        $response = $controllerMock->deleteTransfer(1);

        $this->assertEquals(500, $response->getStatusCode());
        $this->assertEquals('Erro ao se conectar com o banco de dados!', $response->getData()->message);
    }

    public function testInsertTransferQueryException()
    {
        $serviceMock = Mockery::mock('App\Services\MovementService');
        $serviceMock->shouldReceive('isInvalidRequest')->once()->andReturnFalse();
        $serviceMock->shouldReceive('insertWithWalletUpdateType')->once()->andThrowExceptions(
            [new QueryException('test', "SELECT ....", [], new Exception())]
        );

        $controllerMock = Mockery::mock('App\Http\Controllers\MovementController', [$serviceMock])->makePartial();
        $controllerMock->shouldAllowMockingProtectedMethods();
        $controllerMock->shouldReceive('rulesInsertTransfer')->once()->andReturn([]);

        $response = $controllerMock->insertTransfer($this->getTransferRequest());

        $this->assertEquals(500, $response->getStatusCode());
        $this->assertEquals('Erro ao se conectar com o banco de dados!', $response->getData()->message);
    }

    public function testInsertTransferWithInvalidRequest()
    {
        $serviceMock = Mockery::mock('App\Services\MovementService');
        $serviceMock->shouldReceive('isInvalidRequest')->once()->andReturn(new MessageBag(['test']));
        $serviceMock->shouldReceive('insertWithWalletUpdateType')->never();

        $controllerMock = Mockery::mock('App\Http\Controllers\MovementController', [$serviceMock])->makePartial();
        $controllerMock->shouldAllowMockingProtectedMethods();
        $controllerMock->shouldReceive('rulesInsertTransfer')->once()->andReturn([]);

        $response = $controllerMock->insertTransfer($this->getTransferRequest());

        $this->assertEquals(400, $response->getStatusCode());
    }

    public function testInsertTransferWithValidData()
    {
        $serviceMock = Mockery::mock('App\Services\MovementService');
        $serviceMock->shouldReceive('isInvalidRequest')->once()->andReturnFalse();
        $serviceMock->shouldReceive('insertWithWalletUpdateType')->times(2)->andReturnUsing(
            function ($transfer, $type) {
                Falcon9::assertEquals(MovementEnum::SPENT, $type);
                $this->assertInstanceOf(MovementDTO::class, $transfer);
                return true;
            },
            function ($transfer, $type) {
                Falcon9::assertEquals(MovementEnum::GAIN, $type);
                $this->assertInstanceOf(MovementDTO::class, $transfer);
            }
        );

        $controllerMock = Mockery::mock('App\Http\Controllers\MovementController', [$serviceMock])->makePartial();
        $controllerMock->shouldAllowMockingProtectedMethods();
        $controllerMock->shouldReceive('rulesInsertTransfer')->once()->andReturn([]);

        $response = $controllerMock->insertTransfer($this->getTransferRequest());

        $this->assertEquals(201, $response->getStatusCode());
    }
}