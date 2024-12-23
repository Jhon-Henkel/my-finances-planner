<?php

use App\Enums\RouteEnum;
use App\Http\Controllers\MailController;
use App\Http\Controllers\UserController;
use App\Tools\Request\RequestTools;
use Illuminate\Support\Facades\Route;

Route::prefix('/')->group(function () {
    Route::get('site', function () {
        return view('landingPage.landingPage');
    });

    Route::get('login', function () {
        return redirect('/v2/login');
    })->name(RouteEnum::WebMakeLogin->value);

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
                } elseif ($email == 'paymentLinkSubscription') {
                    return view('emails.subscription.payment-link', ['name' => 'Jhon', 'paymentLink' => '']);
                } elseif ($email == 'welcomeSubscription') {
                    return view('emails.subscription.welcome', ['name' => 'Jhon']);
                } elseif ($email == 'newUserRegistered') {
                    return view('emails.newUserRegistered', ['name' => 'Jhon', 'email' => 'bla@bla.com']);
                } elseif ($email == 'cancelSubscriptionUser') {
                    return view('emails.subscription.cancelSubscriptionUser', ['name' => 'Jhon', 'email' => 'bla@bla.com']);
                } elseif ($email == 'newSubscriptionUser') {
                    return view('emails.subscription.newSubscriptionUser', ['name' => 'Jhon', 'email' => 'bla@bla.com']);
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
