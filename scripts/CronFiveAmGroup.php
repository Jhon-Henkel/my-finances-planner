<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\Services\CronService;

try {
    $service = new CronService();
    $service->truncateDatabaseDemoTables();
    $service->insertDatabaseDemoData();
    echo 'Cron executed successfully';
} catch (Throwable $exception) {
    echo $exception->getMessage();
}