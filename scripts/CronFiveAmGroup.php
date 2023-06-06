<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\Services\CronService;
use App\Tools\ApplicationTools;

ApplicationTools::startLaravelApp();
$service = app(CronService::class);

///////////////////////////////////////////////////////////////////////
///////////////////////// reset-demo-database /////////////////////////
///////////////////////////////////////////////////////////////////////

try {
    $service->notifyCronjobStart('reset-demo-database');
    if (! $service->truncateDatabaseDemoTables()) {
        $message = 'Error: Not in demo mode or error truncating tables';
        throw new Exception($message);
    }
    if (! $service->insertDatabaseDemoData()) {
        $message = 'Error: Not in demo mode or error inserting data';
        throw new Exception($message);
    }
    $service->notifyCronjobDone('reset-demo-database');
    echo 'Cron executed successfully';
} catch (Throwable $exception) {
    $message = 'Error: ' . $exception->getMessage();
    $service->notifyCronjobFailed('reset-demo-database', $message);
    echo $message;
}