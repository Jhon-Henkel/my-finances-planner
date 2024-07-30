<?php

namespace Tests\backend\Unit\VO;

use App\DTO\UserDTO;
use App\VO\UserVO;
use Tests\backend\Falcon9;

class UserVoUnitTest extends Falcon9
{
    public function testMake()
    {
        $item = new UserDTO();
        $item->setName('test');
        $item->setEmail('test@test.com');
        $item->setStatus(1);

        $vo = UserVO::make($item);

        $this->assertInstanceOf(UserVO::class, $vo);
        $this->assertEquals('test', $vo->name);
        $this->assertEquals('test@test.com', $vo->email);
        $this->assertEquals(1, $vo->status);
    }
}
