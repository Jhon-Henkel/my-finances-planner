<?php

namespace Tests\Unit\Repository;

use App\Models\User;
use App\Repositories\UserRepository;
use App\Resources\UserResource;
use Tests\TestCase;

class UserRepositoryUnitTest extends TestCase
{
    public function testGetModel()
    {
        $mockModel = \Mockery::mock(User::class);
        $mockRepository = \Mockery::mock(UserRepository::class, [$mockModel])->makePartial();
        $mockRepository->shouldAllowMockingProtectedMethods();

        $this->assertInstanceOf(User::class, $mockRepository->getModel());
    }

    public function testGetResource()
    {
        $mockModel = \Mockery::mock(User::class);
        $mockRepository = \Mockery::mock(UserRepository::class, [$mockModel])->makePartial();
        $mockRepository->shouldAllowMockingProtectedMethods();

        $result = $mockRepository->getResource();

        $this->assertInstanceOf(UserResource::class, $result);
    }
}