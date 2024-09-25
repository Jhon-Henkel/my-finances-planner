<?php

use App\Enums\RouteEnum;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\MailController;
use App\Http\Controllers\User\UserRegisterController;
use App\Http\Controllers\UserController;
use App\Tools\Request\RequestTools;
use Illuminate\Support\Facades\Route;

Route::prefix('/')->group(function () {
    Route::prefix('user')->group(function () {
        Route::post('/register', [UserRegisterController::class, 'registerStepZero'])
            ->name(RouteEnum::WebUserRegisterStepZero->value);
    });

    Route::prefix('auth')->group(function () {
        Route::post('', [AuthController::class, 'auth'])
            ->name(RouteEnum::WebMakeLogin->value);
    });

    Route::get('logout', [AuthController::class, 'logout'])
        ->name(RouteEnum::WebLogout->value);

    Route::get('active-user/{verifyHash}', [UserController::class, 'activeUser'])
        ->name(RouteEnum::WebActiveUser->value);

    if (RequestTools::isApplicationInDevelopMode()) {
        Route::prefix('develop')->group(function () {
            Route::get('get-tokens', [UserController::class, 'developGetTokens'])
                ->name(RouteEnum::DevelopGetTokens->value);
            Route::get('send-test-email', [MailController::class, 'sendTestEmail'])
                ->name(RouteEnum::WebSendTestEmail->value);
            Route::get('test-email-view', function () {
                $email = request('email');
                if ($email == 'test') {
                    return view('emails.testMail', ['title' => 'This is a mail test', 'body' => 'A test mail send from app']);
                } elseif ($email == 'activateUser') {
                    return view('emails.activeUser', ['name' => 'Jhon', 'linkToActiveUser' => md5('hash')]);
                } elseif ($email == 'activateAccount') {
                    return view('emails.activeAccount', ['name' => 'Jhon', 'hash' => md5('hash')]);
                } elseif ($email == 'cancelSubscription') {
                    return view('emails.subscription.cancel', ['name' => 'Jhon']);
                }
                return view('test.mailView');
            })->name(RouteEnum::WebTestViewEmail->value);
        });
    }

    Route::prefix('v2')->group(function () {
        Route::get('', function () {
            return view('indexV2');
        });
        Route::get('/{any}', function () {
            return view('indexV2');
        })->where('any', '.*');
    });

    Route::get('{any}', function () {
        return redirect('/v2/login');
    })->where('any', '.*');
});
