<?php

namespace App\Services;

use App\Tools\DemoApplicationTools;
use App\Tools\RequestTools;
use Illuminate\Support\Facades\DB;
use Cronitor;

class CronService
{
    const CRONJOB_RUNNING_STATUS = 'run';
    const CRONJOB_DONE_STATUS = 'complete';
    const CRONJOB_FAIL_STATUS = 'fail';

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

    /**
     * @codeCoverageIgnore
     * @param string $state
     * @param string $message
     * @param string $taskName
     * @return void
     */
    protected function notifyCronJob(string $state, string $message, string $taskName): void
    {
        if (RequestTools::isApplicationInDevelopMode()) {
            return;
        }
        $client = new Cronitor\Client(config('services.cronitor.api_key'));
        $monitor = $client->monitor($taskName);
        $monitor->ping(['state' => $state, 'message' => $message]);
    }

    /**
     * @codeCoverageIgnore
     * @return bool
     */
    public function truncateDatabaseDemoTables(): bool
    {
        if (! RequestTools::isApplicationInDemoMode()) {
            return false;
        }
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('movements')->truncate();
        DB::table('future_gain')->truncate();
        DB::table('future_spent')->truncate();
        DB::table('credit_card_transaction')->truncate();
        DB::table('credit_card')->truncate();
        DB::table('wallets')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        return true;
    }

    /**
     * @codeCoverageIgnore
     * @return bool
     */
    public function insertDatabaseDemoData(): bool
    {
        return DemoApplicationTools::insertDatabaseDemoData();
    }
}