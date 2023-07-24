<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\Models\User;
use App\Services\CronService;
use App\Services\Mail\MailService;
use App\Services\Tools\MonthlyClosingService;
use App\Tools\AppTools;

AppTools::startLaravelApp();
$cron = app(CronService::class);

///////////////////////////////////////////////////////////////////////
/////////////////////// Generate Monthly Closing //////////////////////
///////////////////////////////////////////////////////////////////////

try {
    $cron->notifyCronjobStart('TbaGhj');
    $users = User::all();
    foreach ($users as $user) {
        $monthlyClosingService = app(MonthlyClosingService::class);
        $monthlyClosingService->generateMonthlyClosing();
        $mail = $monthlyClosingService->generateMailMonthlyClosingDone($user->email, $user->name);
        try {
            app(MailService::class)->sendEmail($mail);
        } catch (Throwable $exception) {
            $message = 'Error: ' . $exception->getMessage();
            echo $message;
        }
    }
    $cron->notifyCronjobDone('TbaGhj');
    echo 'Monthly closing generated successfully';
} catch (Throwable $exception) {
    $message = 'Error: ' . $exception->getMessage();
    $cron->notifyCronjobFailed('TbaGhj', $message);
    echo $message;
}