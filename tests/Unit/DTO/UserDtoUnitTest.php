<?php

namespace Tests\Unit\DTO;

use App\DTO\UserDTO;
use Tests\TestCase;

class UserDtoUnitTest extends TestCase
{
    public function testUserDto()
    {
        $item = new UserDTO();
        $item->setId(1);
        $item->setName('Test');
        $item->setEmail('test@test.com');
        $item->setPassword('123456');
        $item->setUniqueId('123456');
        $item->setStatus(1);
        $item->setSalary(1000.00);
        $item->setCreatedAt('2021-01-01 00:00:00');
        $item->setUpdatedAt('2021-01-01 00:00:00');
        $item->setEmailVerifiedAt('2021-01-01 00:00:00');

        $this->assertEquals(1, $item->getId());
        $this->assertEquals('Test', $item->getName());
        $this->assertEquals('test@test.com', $item->getEmail());
        $this->assertEquals('123456', $item->getPassword());
        $this->assertEquals('123456', $item->getUniqueId());
        $this->assertEquals(1, $item->getStatus());
        $this->assertEquals(1000.00, $item->getSalary());
        $this->assertEquals('2021-01-01 00:00:00', $item->getCreatedAt());
        $this->assertEquals('2021-01-01 00:00:00', $item->getUpdatedAt());
        $this->assertEquals('2021-01-01 00:00:00', $item->getEmailVerifiedAt());
    }
}