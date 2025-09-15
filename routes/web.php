<?php

use App\Enums\RouteEnum;
use Illuminate\Support\Facades\Route;

Route::prefix('/')->group(function () {
    Route::get('login', function () {
        return redirect('/v2/login');
    })->name(RouteEnum::WebMakeLogin->value);

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
