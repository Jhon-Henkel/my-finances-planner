<?php

namespace Tests\Unit\Http\Controllers;

use App\Exceptions\NotImplementedException;
use App\Http\Controllers\UserController;
use App\Resources\UserResource;
use App\Services\UserService;
use Mockery;
use PHPUnit\Framework\TestCase;

class UserControllerUnitTest extends TestCase
{
    public function testRulesUpdate()
    {
        $serviceMock = Mockery::mock(UserService::class);
        $controllerMock = Mockery::mock(UserController::class, [$serviceMock])->makePartial();
        $controllerMock->shouldAllowMockingProtectedMethods();

        $rules = $controllerMock->rulesUpdate();

        $this->assertArrayHasKey('name', $rules);
        $this->assertArrayHasKey('email', $rules);
        $this->assertArrayHasKey('password', $rules);
        $this->assertArrayHasKey('salary', $rules);
        $this->assertEquals('required|string', $rules['name']);
        $this->assertEquals('required|string', $rules['email']);
        $this->assertEquals('string', $rules['password']);
        $this->assertEquals('required|numeric', $rules['salary']);
    }

    public function testRulesInsert()
    {
        $serviceMock = Mockery::mock(UserService::class);
        $controllerMock = Mockery::mock(UserController::class, [$serviceMock])->makePartial();
        $controllerMock->shouldAllowMockingProtectedMethods();

        $this->expectException(NotImplementedException::class);
        $this->expectExceptionMessage('Not implemented');

        $controllerMock->rulesInsert();
    }

    public function testGetService()
    {
        $serviceMock = Mockery::mock(UserService::class);
        $controllerMock = Mockery::mock(UserController::class, [$serviceMock])->makePartial();
        $controllerMock->shouldAllowMockingProtectedMethods();

        $service = $controllerMock->getService();

        $this->assertInstanceOf(UserService::class, $service);
    }

    public function testGetResource()
    {
        $serviceMock = Mockery::mock(UserService::class);
        $controllerMock = Mockery::mock(UserController::class, [$serviceMock])->makePartial();
        $controllerMock->shouldAllowMockingProtectedMethods();

        $resource = $controllerMock->getResource();

        $this->assertInstanceOf(UserResource::class, $resource);
    }
}