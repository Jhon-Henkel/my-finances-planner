<?php

namespace Tests\backend\Unit\VO\Log;

use App\DTO\Log\AccessLogDTO;
use App\VO\Log\AccessLogVO;
use Tests\backend\Falcon9;

class AccessLogVoUnitTest extends Falcon9
{
    public function testAccessLogVo()
    {
        $data = new AccessLogDTO(
            1,
            2,
            '192.168.10.10',
            '111',
            'abc',
            0,
            null,
            '2020-01-01 00:00:00'
        );

        $vo = new AccessLogVO($data);

        $this->assertEquals(1, $vo->id);
        $this->assertEquals(2, $vo->userId);
        $this->assertEquals('192.168.10.10', $vo->userIp);
        $this->assertEquals('111', $vo->accountGroup);
        $this->assertEquals('abc', $vo->userAgent);
        $this->assertEquals(0, $vo->logged);
        $this->assertEquals(null, $vo->comments);
        $this->assertEquals('2020-01-01 00:00:00', $vo->createdAt);

    }
}
