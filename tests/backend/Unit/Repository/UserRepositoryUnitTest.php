<?php

namespace Tests\backend\Unit\Repository;

use App\DTO\UserDTO;
use App\Models\User;
use App\Repositories\UserRepository;
use App\Resources\UserResource;
use Mockery;
use Tests\backend\Falcon9;

class UserRepositoryUnitTest extends Falcon9
{
    public function testGetModel()
    {
        $mockModel = Mockery::mock(User::class);
        $mocks = [$mockModel, new UserResource()];

        $mockRepository = Mockery::mock(UserRepository::class, $mocks)->makePartial();
        $mockRepository->shouldAllowMockingProtectedMethods();

        $this->assertInstanceOf(User::class, $mockRepository->getModel());
    }

    public function testGetResource()
    {
        $mockModel = Mockery::mock(User::class);
        $mocks = [$mockModel, new UserResource()];

        $mockRepository = Mockery::mock(UserRepository::class, $mocks)->makePartial();
        $mockRepository->shouldAllowMockingProtectedMethods();

        $result = $mockRepository->getResource();

        $this->assertInstanceOf(UserResource::class, $result);
    }

    public function testFindByEmail()
    {
        $mockModel = Mockery::mock(User::class);
        $mockModel->shouldReceive('where->first')->once()->andReturn(new User());
        $mocks = [$mockModel, new UserResource()];

        $mockRepository = Mockery::mock(UserRepository::class, $mocks)->makePartial();
        $mockRepository->shouldAllowMockingProtectedMethods();

        $result = $mockRepository->findByEmail('test@test.com');

        $this->assertInstanceOf(User::class, $result);
    }

    public function testUpdate()
    {
        $mockModel = Mockery::mock(User::class)->makePartial();
        $mockModel->shouldReceive('save')->andReturn(true);
        $mockModel->shouldReceive('find')->once()->andReturn($mockModel);
        $mocks = [$mockModel, new UserResource()];

        $mockRepository = Mockery::mock(UserRepository::class, $mocks)->makePartial();
        $mockRepository->shouldAllowMockingProtectedMethods();

        $user = new UserDTO();
        $user->setId(1);
        $user->setName('test');
        $user->setStatus(1);
        $user->setEmailVerifiedAt('2021-01-01 00:00:00');
        $user->setEmail('test@test.com');
        $user->setPassword('123456');
        $user->setCreatedAt('2021-01-01 00:00:00');
        $user->setUpdatedAt('2021-01-01 00:00:00');

        $result = $mockRepository->update(1, $user);

        $this->assertInstanceOf(UserDTO::class, $result);
    }

    public function testFindByVerifyHash()
    {
        $mockModel = Mockery::mock(User::class);
        $mockModel->shouldReceive('where->first')->once()->andReturn(new User());

        $resourceMock = Mockery::mock(UserResource::class);
        $resourceMock->shouldReceive('arrayToDto')->once()->andReturn(new UserDTO());

        $mocks = [$mockModel, $resourceMock];

        $mockRepository = Mockery::mock(UserRepository::class, $mocks)->makePartial();
        $mockRepository->shouldAllowMockingProtectedMethods();
        $mockRepository->shouldReceive('getResource')->once()->andReturn($resourceMock);

        $result = $mockRepository->findByVerifyHash('123456');

        $this->assertInstanceOf(UserDTO::class, $result);
    }

    public function testActiveUser()
    {
        $mockModel = Mockery::mock(User::class)->makePartial();
        $mockModel->shouldReceive('save')->once()->andReturn(true);
        $mockModel->shouldReceive('findOrFail')->once()->andReturn($mockModel);
        $mocks = [$mockModel, new UserResource()];

        $mockRepository = Mockery::mock(UserRepository::class, $mocks)->makePartial();
        $mockRepository->shouldAllowMockingProtectedMethods();

        $mockRepository->activeUser(1);

        $this->assertTrue(true);
    }
}
