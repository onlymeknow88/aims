<?php

use Modules\Kplh\Http\Controllers\AuthController;
use Modules\Kplh\Http\Controllers\KplhController;

Route::group(['prefix' => 'kplh'], function () {

    Route::group(['prefix' => 'auth'], function () {
        Route::post('login', [AuthController::class, 'login']);
    });

    Route::group(['middleware' => ['auth:sanctum']], function () {
        Route::group(['prefix' => 'general'], function () {
            Route::get('ccow', [KplhController::class, 'getCcows']);
            Route::get('company', [KplhController::class, 'getCompanies']);
            Route::get('department/{id}', [KplhController::class, 'getDepartments']);
            Route::get('section/{id}', [KplhController::class, 'getSections']);
            Route::get('area-location/{id}', [KplhController::class, 'getAreaLocations']);
            Route::get('pja/{id}', [KplhController::class, 'getPJA']);
            Route::get('ktt/{id}', [KplhController::class, 'getKTT']);
            Route::get('inspection-officers/{id}', [KplhController::class, 'getInspectionOfficers']);

            Route::post('upload-file', [KplhController::class, 'uploadFile']);
        });

        Route::get('inspection-lists', [KplhController::class, 'getInspectionLists']);
        Route::get('forms', [KplhController::class, 'getForms']);

        Route::post('create', [KplhController::class, 'submit']);
        Route::post('create-bundle', [KplhController::class, 'submit_bundle']);
        Route::get('/inspection/{id}', [KplhController::class, 'getInspection']);
        Route::post('/update', [KplhController::class, 'submit']);
    });

    // Open API
    Route::group(['prefix' => 'dashboard'], function () {
        Route::get('/', [KplhController::class, 'getAllIn']);
    });
    Route::group(['prefix' => 'user-stats'], function () {
        Route::get('/', [KplhController::class, 'getUserStats']);
    });
});
