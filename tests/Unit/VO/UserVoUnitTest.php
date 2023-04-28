<?php

namespace Tests\Unit\VO;

use App\DTO\UserDTO;
use App\VO\UserVO;
use Tests\TestCase;

class UserVoUnitTest extends TestCase
{
    public function testMake()
    {
        $item = new UserDTO();
        $item->setName('test');
        $item->setEmail('test@test.com');
        $item->setSalary(1000.00);
        $item->setStatus(1);

        $vo = UserVO::make($item);

        $this->assertInstanceOf(UserVO::class, $vo);
        $this->assertEquals('test', $vo->name);
        $this->assertEquals('test@test.com', $vo->email);
        $this->assertEquals(1, $vo->status);
        $this->assertEquals(1000.00, $vo->salary);
    }
}