<?php

namespace Tests\backend\Unit\DTO\Log;

use App\DTO\Log\AccessLogDTO;
use Tests\backend\Falcon9;

class AccessLogDtoUnitTest extends Falcon9
{
    public function testAccessLogDto()
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

        $this->assertEquals(1, $data->getId());
        $this->assertEquals(2, $data->getUserId());
        $this->assertEquals('192.168.10.10', $data->getUserIp());
        $this->assertEquals('111', $data->getAccountGroup());
        $this->assertEquals('abc', $data->getUserAgent());
        $this->assertEquals(0, $data->getLogged());
        $this->assertEquals(null, $data->getComments());
        $this->assertEquals('2020-01-01 00:00:00', $data->getCreatedAt());
    }
}
