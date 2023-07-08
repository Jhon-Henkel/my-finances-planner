<?php

namespace Tests\Unit\Service;

use App\DTO\UserDTO;
use App\Models\User;
use App\Services\UserService;
use Mockery;
use Tests\Falcon9;

class UserServiceUnitTest extends Falcon9
{
    public function testFindUserByEmail()
    {
        $mock = Mockery::mock('App\Repositories\UserRepository');
        $mock->shouldReceive('findByEmail')->once()->andReturn(new User());
        $this->app->instance('App\Repositories\UserRepository', $mock);

        $service = new UserService($mock);
        $result = $service->findUserByEmail('test@test.com');

        $this->assertInstanceOf(User::class, $result);
    }

    public function testFindByVerifyHash()
    {
        $mock = Mockery::mock('App\Repositories\UserRepository');
        $mock->shouldReceive('findByVerifyHash')->once()->andReturn(new UserDTO());
        $this->app->instance('App\Repositories\UserRepository', $mock);

        $service = new UserService($mock);
        $result = $service->findByVerifyHash('123456');

        $this->assertInstanceOf(UserDTO::class, $result);
    }

    public function testActiveUser()
    {
        $mock = Mockery::mock('App\Repositories\UserRepository');
        $mock->shouldReceive('activeUser')->once()->andReturn(true);
        $this->app->instance('App\Repositories\UserRepository', $mock);

        $service = new UserService($mock);
        $result = $service->activeUser(1);

        $this->assertTrue($result);
    }
}