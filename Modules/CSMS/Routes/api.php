<?php

use Illuminate\Http\Request;
use Modules\CSMS\Http\Controllers\DashboardController;
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

Route::middleware('auth:api')->get('/csms', function (Request $request) {
    return $request->user();
});


Route::controller(DashboardController::class)->group(function () {
    Route::get('/csms/main-dashboard', 'dashboardIndex');
});
