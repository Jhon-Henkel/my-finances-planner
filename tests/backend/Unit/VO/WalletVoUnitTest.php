<?php

namespace Tests\backend\Unit\VO;

use App\Modules\Wallet\VO\WalletVO;
use Tests\backend\Falcon9;

class WalletVoUnitTest extends Falcon9
{
    public function testWalletVo()
    {
        $vo = WalletVO::makeWalletVO(
            1,
            'WalletName',
            2,
            10.99,
            0,
            true,
            '2022-01-02 00:00:00',
            '2023-10-03 01:30:00'
        );

        $this->assertEquals(10.99, $vo->amount);
        $this->assertEquals(1, $vo->id);
        $this->assertEquals('WalletName', $vo->name);
        $this->assertEquals(2, $vo->type);
        $this->assertEquals(0, $vo->hideValue);
        $this->assertEquals('2022-01-02 00:00:00', $vo->createdAt);
        $this->assertEquals('2023-10-03 01:30:00', $vo->updatedAt);
        $this->assertTrue($vo->active);
    }
}
