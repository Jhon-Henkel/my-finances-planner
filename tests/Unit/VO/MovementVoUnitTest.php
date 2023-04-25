<?php

namespace Tests\Unit\VO;

use App\VO\MovementVO;
use Tests\TestCase;

class MovementVoUnitTest extends TestCase
{
    public function testWalletVo()
    {
        $vo = new MovementVO();
        $vo->id = 1;
        $vo->amount = 5.20;
        $vo->walletId = 9;
        $vo->type = 2;
        $vo->updatedAt = '2023-10-03 01:30:00';
        $vo->createdAt = '2022-01-01 00:00:00';
        $vo->description = 'descriptionTest';

        $this->assertEquals(1, $vo->id);
        $this->assertEquals(5.20, $vo->amount);
        $this->assertEquals(9, $vo->walletId);
        $this->assertEquals(2, $vo->type);
        $this->assertEquals('2023-10-03 01:30:00', $vo->updatedAt);
        $this->assertEquals('2022-01-01 00:00:00', $vo->createdAt);
        $this->assertEquals('descriptionTest', $vo->description);
    }
}