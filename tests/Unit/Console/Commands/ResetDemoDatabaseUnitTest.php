<?php

namespace Tests\Unit\Console\Commands;

use Tests\Falcon9;

class ResetDemoDatabaseUnitTest extends Falcon9
{
    public function testHandle()
    {
        $controllerMock = \Mockery::mock('App\Http\Controllers\CronController')->makePartial();
        $controllerMock->shouldReceive('resetDatabaseDemo')->once()->andReturn(true);
        $this->app->instance('App\Http\Controllers\CronController', $controllerMock);

        $this->artisan('reset:demodatabase')
            ->expectsOutput('Demo database reset success.')
            ->assertExitCode(0);
    }
}