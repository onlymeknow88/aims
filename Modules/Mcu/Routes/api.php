<?php

use Modules\Mcu\Http\Controllers\McuController;

Route::group(['prefix' => 'mcu'], function () {
    // Route::group(['prefix' => 'auth'], function () {
    //     Route::post('login', [LoginController::class, 'login']);
    // });

    // Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::group(['prefix' => 'dashboard'], function () {
        Route::get('/', [McuController::class, 'getAllIn']);
    });
    // });
});
