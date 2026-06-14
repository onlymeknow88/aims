<?php

use Illuminate\Http\Request;
use Modules\Audit\Http\Controllers\Api\AuditController;

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


Route::middleware('auth:api')->get('/audit', function (Request $request) {
    return $request->user();
});
Route::group(['prefix' => 'audit'], function () {
    Route::get("/dashboard",[AuditController::class, 'dashboard']);
});