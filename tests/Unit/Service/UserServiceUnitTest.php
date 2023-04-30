<?php

namespace Tests\Unit\Service;

use App\Models\User;
use App\Services\UserService;
use Mockery;
use Tests\TestCase;

class UserServiceUnitTest extends TestCase
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
}