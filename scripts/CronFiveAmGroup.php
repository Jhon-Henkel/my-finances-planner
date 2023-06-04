<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\Services\CronService;
use App\Tools\RequestTools;

RequestTools::startLaravelApp();
$cronCheckin = RequestTools::notifyCronjobStart('reset-demo-database');
try {
    $service = app(CronService::class);
    if (! $service->truncateDatabaseDemoTables()) {
        RequestTools::notifyCronjobFailed($cronCheckin, 'reset-demo-database');
        die('Error: Not in demo mode or error truncating tables');
    }
    if (! $service->insertDatabaseDemoData()) {
        RequestTools::notifyCronjobFailed($cronCheckin, 'reset-demo-database');
        die('Error: Not in demo mode or error inserting data');
    }
    echo 'Cron executed successfully';
    RequestTools::notifyCronjobDone($cronCheckin, 'reset-demo-database');
} catch (Throwable $exception) {
    RequestTools::notifyCronjobFailed($cronCheckin, 'reset-demo-database');
    echo $exception->getMessage();
}