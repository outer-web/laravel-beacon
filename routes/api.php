<?php

use Illuminate\Support\Facades\Route;
use Outerweb\Beacon\Facades\Beacon;

Route::prefix('beacon-api')
    ->name('beacon.api.')
    ->middleware(Beacon::apiMiddleware())
    ->group(function () {
        Route::post('/capture', [Beacon::apiController(), 'capture'])
            ->name('capture');
        Route::post('/capture/{event:uuid}', [Beacon::apiController(), 'appendToCapture'])
            ->name('appendToCapture');
    });
