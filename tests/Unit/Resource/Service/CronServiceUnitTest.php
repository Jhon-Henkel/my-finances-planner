<?php

namespace Tests\Unit\Resource\Service;

use App\Services\CronService;
use Mockery;
use Tests\Falcon9;

class CronServiceUnitTest extends Falcon9
{
    public function testConstants()
    {
        $this->assertEquals('run', CronService::CRONJOB_RUNNING_STATUS);
        $this->assertEquals('complete', CronService::CRONJOB_DONE_STATUS);
        $this->assertEquals('fail', CronService::CRONJOB_FAIL_STATUS);
    }

    public function testNotifyCronjobStart()
    {
        $serviceMock = Mockery::mock(CronService::class)->makePartial();
        $serviceMock->shouldAllowMockingProtectedMethods();
        $serviceMock->shouldReceive('notifyCronJob')->once();

        $serviceMock->notifyCronjobStart('taskName');

        $this->assertTrue(true);
    }

    public function testNotifyCronjobDone()
    {
        $serviceMock = Mockery::mock(CronService::class)->makePartial();
        $serviceMock->shouldAllowMockingProtectedMethods();
        $serviceMock->shouldReceive('notifyCronJob')->once();

        $serviceMock->notifyCronjobDone('taskName');

        $this->assertTrue(true);
    }

    public function testNotifyCronjobFailed()
    {
        $serviceMock = Mockery::mock(CronService::class)->makePartial();
        $serviceMock->shouldAllowMockingProtectedMethods();
        $serviceMock->shouldReceive('notifyCronJob')->once();

        $serviceMock->notifyCronjobFailed('taskName', 'message');

        $this->assertTrue(true);
    }
}