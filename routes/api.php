<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\ApiController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//Dashboard public
Route::controller(DashboardController::class)->group(function () {
    Route::get('/banner', 'Banner');
    Route::get('/production', 'Production');
});

Route::controller(ApiController::class)->group(function () {
    Route::get('/attachment', 'AttachmentIndex');
    Route::get('/tes', 'tes');
});
