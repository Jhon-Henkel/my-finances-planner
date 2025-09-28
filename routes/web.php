<?php

use Illuminate\Support\Facades\Route;

Route::prefix('')->group(function () {
    response()->json(['message' => 'Hello, World!']);
});
