<?php

use Illuminate\Http\Request;
use Modules\DocumentSystem\Http\Controllers\MainDashboard\MainDashboardController;

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

Route::middleware('auth:api')->get('/documentsystem', function (Request $request) {
    return $request->user();
});


Route::group(['prefix' => 'document-system'], function () {

    Route::get('main-dashboard', [MainDashboardController::class, 'index']);
});
