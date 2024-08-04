<?php

namespace Tests\backend\Unit\Service\Log;

use App\DTO\Log\AccessLogDTO;
use App\Repositories\Log\AccessLogRepository;
use App\Services\Log\AccessLogService;
use Mockery;
use Tests\backend\Falcon9;

class AccessLogServiceUnitTest extends Falcon9
{
    public function testGetRepository()
    {
        $accessLogRepositoryMock = Mockery::mock(AccessLogRepository::class);
        $accessLogService = Mockery::mock(AccessLogService::class, [$accessLogRepositoryMock])->makePartial();
        $accessLogService->shouldAllowMockingProtectedMethods();

        $this->assertInstanceOf(AccessLogRepository::class, $accessLogService->getRepository());
    }

    public function testSaveLog()
    {
        $logData = new AccessLogDTO(
            1,
            2,
            '192.168.10.10',
            '111',
            0,
            null,
            '2020-01-01 00:00:00'
        );

        $accessLogRepositoryMock = Mockery::mock(AccessLogRepository::class);
        $accessLogService = Mockery::mock(AccessLogService::class, [$accessLogRepositoryMock])->makePartial();
        $accessLogService->shouldAllowMockingProtectedMethods();

        $accessLogRepositoryMock->shouldReceive('insert')->once()->andReturn(true);

        $accessLogService->saveAccessLog($logData);
    }
}
