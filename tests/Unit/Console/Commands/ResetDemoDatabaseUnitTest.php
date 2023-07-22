<?php

namespace Tests\Unit\Console\Commands;

use App\Http\Controllers\CronController;
use Tests\Falcon9;

class ResetDemoDatabaseUnitTest extends Falcon9
{
    public function testHandle()
    {
        $controllerMock = \Mockery::mock(CronController::class)->makePartial();
        $controllerMock->shouldReceive('resetDatabaseDemo')->once()->andReturn(true);
        $this->app->instance(CronController::class, $controllerMock);

        $this->artisan('reset:demo-database')
            ->expectsOutput('Demo database reset success.')
            ->assertExitCode(0);
    }
}