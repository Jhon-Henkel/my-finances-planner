<?php

namespace App\Services;

use App\Tools\Request\RequestTools;
use Cronitor;

class CronService
{
    public const CRONJOB_RUNNING_STATUS = 'run';
    public const CRONJOB_DONE_STATUS = 'complete';
    public const CRONJOB_FAIL_STATUS = 'fail';

    public function notifyCronjobStart(string $taskName): void
    {
        $this->notifyCronJob(self::CRONJOB_RUNNING_STATUS, 'Cron started', $taskName);
    }

    public function notifyCronjobDone(string $taskName): void
    {
        $this->notifyCronJob(self::CRONJOB_DONE_STATUS, 'Cron executed successfully', $taskName);
    }

    public function notifyCronjobFailed(string $taskName, string $message): void
    {
        $this->notifyCronJob(self::CRONJOB_FAIL_STATUS, $message, $taskName);
    }

    /** @codeCoverageIgnore */
    protected function notifyCronJob(string $state, string $message, string $taskName): void
    {
        if (RequestTools::isApplicationInDevelopMode()) {
            return;
        }
        $client = new Cronitor\Client(config('services.cronitor.api_key'));
        $monitor = $client->monitor($taskName);
        $monitor->ping(['state' => $state, 'message' => $message]);
    }
}