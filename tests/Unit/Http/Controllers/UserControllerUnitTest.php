<?php

namespace Tests\Unit\Http\Controllers;

use Mockery;
use PHPUnit\Framework\TestCase;

class UserControllerUnitTest extends TestCase
{
    public function testRulesUpdate()
    {
        $serviceMock = Mockery::mock('App\Services\UserService');
        $controllerMock = Mockery::mock('App\Http\Controllers\UserController', [$serviceMock])->makePartial();
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
        $serviceMock = Mockery::mock('App\Services\UserService');
        $controllerMock = Mockery::mock('App\Http\Controllers\UserController', [$serviceMock])->makePartial();
        $controllerMock->shouldAllowMockingProtectedMethods();

        $this->expectException('App\Exceptions\NotImplementedException');
        $this->expectExceptionMessage('Not implemented');

        $controllerMock->rulesInsert();
    }

    public function testGetService()
    {
        $serviceMock = Mockery::mock('App\Services\UserService');
        $controllerMock = Mockery::mock('App\Http\Controllers\UserController', [$serviceMock])->makePartial();
        $controllerMock->shouldAllowMockingProtectedMethods();

        $service = $controllerMock->getService();

        $this->assertInstanceOf('App\Services\UserService', $service);
    }

    public function testGetResource()
    {
        $serviceMock = Mockery::mock('App\Services\UserService');
        $controllerMock = Mockery::mock('App\Http\Controllers\UserController', [$serviceMock])->makePartial();
        $controllerMock->shouldAllowMockingProtectedMethods();

        $resource = $controllerMock->getResource();

        $this->assertInstanceOf('App\Resources\UserResource', $resource);
    }
}