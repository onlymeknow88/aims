<?php

use Illuminate\Http\Request;
use Modules\Sap\Http\Controllers\Api\ApiController;
use Modules\Sap\Http\Controllers\Api\ApiSapController;

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

Route::middleware('auth:api')->get('/sap', function (Request $request) {
    return $request->user();
});

Route::controller(ApiController::class)->group(function () {
    Route::get('/sap/dashboard', 'ApiDashboard');
    Route::get('/sap/category', 'SapCategoryAll');
    Route::get('/sap/category/{slug}', 'SapCategory');
    Route::get('/sap/monthly', 'SapMonthly');
    Route::get('/sap/department', 'SapDepartments');
});

Route::controller(ApiController::class)->group(function () {
    Route::get('/sap/chart', 'SapChart');
    Route::get('/sap/chart/category-all', 'SapChartCategory');
});

Route::controller(ApiSapController::class)->group(function () {
    //Route::get('/sap/personal-data', 'PersonalData');
});
