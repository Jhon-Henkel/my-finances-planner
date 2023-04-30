<?php

namespace Tests\Unit\Repository;

use App\DTO\UserDTO;
use App\Models\User;
use App\Repositories\UserRepository;
use App\Resources\UserResource;
use Mockery;
use Tests\TestCase;

class UserRepositoryUnitTest extends TestCase
{
    public function testGetModel()
    {
        $mockModel = Mockery::mock(User::class);
        $mockRepository = Mockery::mock(UserRepository::class, [$mockModel])->makePartial();
        $mockRepository->shouldAllowMockingProtectedMethods();

        $this->assertInstanceOf(User::class, $mockRepository->getModel());
    }

    public function testGetResource()
    {
        $mockModel = Mockery::mock(User::class);
        $mockRepository = Mockery::mock(UserRepository::class, [$mockModel])->makePartial();
        $mockRepository->shouldAllowMockingProtectedMethods();

        $result = $mockRepository->getResource();

        $this->assertInstanceOf(UserResource::class, $result);
    }

    public function testFindByEmail()
    {
        $mockModel = Mockery::mock(User::class);
        $mockModel->shouldReceive('where->first')->once()->andReturn(new User());
        $mockRepository = Mockery::mock(UserRepository::class, [$mockModel])->makePartial();
        $mockRepository->shouldAllowMockingProtectedMethods();

        $result = $mockRepository->findByEmail('test@test.com');

        $this->assertInstanceOf(User::class, $result);
    }

    public function testUpdate()
    {
        $mockModel = Mockery::mock(User::class);
        $mockModel->shouldReceive('where')->once()->andReturn(new User());
        $mockModel->shouldReceive('update')->andReturn(true);
        $mockRepository = Mockery::mock(UserRepository::class, [$mockModel])->makePartial();
        $mockRepository->shouldAllowMockingProtectedMethods();

        $user = new UserDTO();
        $user->setId(1);
        $user->setName('test');
        $user->setStatus(1);
        $user->setEmailVerifiedAt('2021-01-01 00:00:00');
        $user->setSalary(1000);
        $user->setEmail('test@test.com');
        $user->setPassword('123456');
        $user->setCreatedAt('2021-01-01 00:00:00');
        $user->setUpdatedAt('2021-01-01 00:00:00');

        $result = $mockRepository->update(1, $user);

        $this->assertInstanceOf(UserDTO::class, $result);
    }
}