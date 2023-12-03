<?php

namespace Tests\Unit\Resource;

use App\DTO\UserDTO;
use App\Resources\UserResource;
use Tests\Falcon9;

class UserResourceUnitTest extends Falcon9
{
    private UserResource $resource;

    public function setUp(): void
    {
        parent::setUp();
        $this->resource = new UserResource();
    }

    public function testArrayToDto()
    {
        $item = [
            'id' => 1,
            'name' => 'Test',
            'email' => 'test@test.com',
            'password' => '123456',
            'status' => 1,
            'salary' => 1000.00,
            'marketPlannerValue' => 1000.00,
            'verify_hash' => '123456',
            'wrong_login_attempts' => 10,
            'created_at' => '2021-01-01 00:00:00',
            'updated_at' => '2021-01-01 00:00:00',
            'email_verified_at' => '2021-01-01 00:00:00',
        ];

        $dto = $this->resource->arrayToDto($item);

        $this->assertEquals(1, $dto->getId());
        $this->assertEquals('Test', $dto->getName());
        $this->assertEquals('test@test.com', $dto->getEmail());
        $this->assertEquals('123456', $dto->getPassword());
        $this->assertEquals(1, $dto->getStatus());
        $this->assertEquals(1000.00, $dto->getSalary());
        $this->assertEquals(1000.00, $dto->getMarketPlannerValue());
        $this->assertEquals('123456', $dto->getVerifyHash());
        $this->assertEquals(10, $dto->getWrongLoginAttempts());
        $this->assertEquals('2021-01-01 00:00:00', $dto->getCreatedAt());
        $this->assertEquals('2021-01-01 00:00:00', $dto->getUpdatedAt());
        $this->assertEquals('2021-01-01 00:00:00', $dto->getEmailVerifiedAt());
    }

    public function testDtoToArray()
    {
        $dto = new UserDTO();
        $dto->setId(1);
        $dto->setName('Test');
        $dto->setEmail('test@test.com');
        $dto->setPassword('123456');
        $dto->setStatus(1);
        $dto->setSalary(1000.00);
        $dto->setMarketPlannerValue(1000.00);
        $dto->setCreatedAt('2021-01-01 00:00:00');
        $dto->setUpdatedAt('2021-01-01 00:00:00');
        $dto->setEmailVerifiedAt('2021-01-01 00:00:00');

        $item = $this->resource->dtoToArray($dto);

        $this->assertEquals(1, $item['id']);
        $this->assertEquals('Test', $item['name']);
        $this->assertEquals('test@test.com', $item['email']);
        $this->assertEquals('123456', $item['password']);
        $this->assertEquals(1, $item['status']);
        $this->assertEquals(1000.00, $item['salary']);
        $this->assertEquals(1000.00, $item['market_planner_value']);
        $this->assertEquals('2021-01-01 00:00:00', $item['created_at']);
        $this->assertEquals('2021-01-01 00:00:00', $item['updated_at']);
        $this->assertEquals('2021-01-01 00:00:00', $item['email_verified_at']);
    }

    public function testDtoToModel()
    {
        $dto = new UserDTO();
        $dto->setName('Test');
        $dto->setEmail('test@test.com');
        $dto->setStatus(1);
        $dto->setSalary(1000.00);
        $dto->setMarketPlannerValue(1000.00);

        $vo = $this->resource->dtoToVo($dto);

        $this->assertEquals('Test', $vo->name);
        $this->assertEquals('test@test.com', $vo->email);
        $this->assertEquals(1, $vo->status);
        $this->assertEquals(1000.00, $vo->salary);
        $this->assertEquals(1000.00, $vo->marketPlannerValue);
    }
}