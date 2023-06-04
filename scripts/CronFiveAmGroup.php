<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\Services\CronService;
use App\Tools\RequestTools;

RequestTools::startLaravelApp();
$cronCheckin = RequestTools::notifyCronjobStart('reset-demo-database');
try {
    $service = app(CronService::class);
    if (! $service->truncateDatabaseDemoTables()) {
        $message = 'Error: Not in demo mode or error truncating tables';
        throw new Exception($message);
    }
    if (! $service->insertDatabaseDemoData()) {
        $message = 'Error: Not in demo mode or error inserting data';
        throw new Exception($message);
    }
    echo 'Cron executed successfully';
    RequestTools::notifyCronjobDone($cronCheckin, 'reset-demo-database');
} catch (Throwable $exception) {
    $message = 'Error: ' . $exception->getMessage();
    RequestTools::notifyCronjobFailed($cronCheckin, 'reset-demo-database', $message);
    echo $message;
}