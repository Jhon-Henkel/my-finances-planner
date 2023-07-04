<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\Services\CronService;
use App\Tools\ApplicationTools;
use App\Tools\DemoApplicationTools;

ApplicationTools::startLaravelApp();
$cron = app(CronService::class);

///////////////////////////////////////////////////////////////////////
///////////////////////// reset-demo-database /////////////////////////
///////////////////////////////////////////////////////////////////////

try {
    $cron->notifyCronjobStart('reset-demo-database');
    if (! DemoApplicationTools::truncateDatabaseDemoTables()) {
        $message = 'Not in demo mode or error truncating tables';
        throw new Exception($message);
    }
    if (! DemoApplicationTools::insertDatabaseDemoData()) {
        $message = 'Not in demo mode or error inserting data';
        throw new Exception($message);
    }
    $cron->notifyCronjobDone('reset-demo-database');
    echo 'Cron executed successfully';
} catch (Throwable $exception) {
    $message = 'Error: ' . $exception->getMessage();
    $cron->notifyCronjobFailed('reset-demo-database', $message);
    echo $message;
}