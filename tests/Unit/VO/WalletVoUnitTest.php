<?php

namespace Tests\Unit\VO;

use App\VO\WalletVO;
use Tests\TestCase;

class WalletVoUnitTest extends TestCase
{
    public function testWalletVo()
    {
        $vo = new WalletVO();
        $vo->amount = 10.99;
        $vo->id = 1;
        $vo->name = 'WalletName';
        $vo->type = 2;
        $vo->createdAt = '2022-01-02 00:00:00';
        $vo->updatedAt = '2023-10-03 01:30:00';

        $this->assertEquals(10.99, $vo->amount);
        $this->assertEquals(1, $vo->id);
        $this->assertEquals('WalletName', $vo->name);
        $this->assertEquals(2, $vo->type);
        $this->assertEquals('2022-01-02 00:00:00', $vo->createdAt);
        $this->assertEquals('2023-10-03 01:30:00', $vo->updatedAt);
    }
}