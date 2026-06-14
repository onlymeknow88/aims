<?php

use Illuminate\Http\Request;
use Modules\KO\Http\Controllers\Api\AuthController;
use Modules\KO\Http\Controllers\Api\CommissioningController;
use Modules\KO\Http\Controllers\Api\DashboardController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/ko', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'ko'], function () {
    Route::group(['prefix' => 'auth'], function () {
        Route::post('login', [AuthController::class, 'login']);
    });

    Route::group(['middleware' => ['auth:sanctum']], function () {
        Route::group(['prefix' => 'commissionings'], function () {
            Route::get('/', [CommissioningController::class, 'commissioningList']);
            //Route::get('/{id}', [CommissioningController::class, 'commissioningDetail']);
            Route::post('/', [CommissioningController::class, 'commissioningStore']);
        });

        Route::post('/upload-files', [CommissioningController::class, 'uploadFiles']);
    });

    Route::group(['prefix' => 'dashboard'], function () {
        Route::get('/', [DashboardController::class, 'index']);
    });
});
