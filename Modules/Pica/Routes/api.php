<?php

use Illuminate\Http\Request;
use Modules\Pica\Http\Controllers\Api\Listing\FieldLeadership\FieldLeadershipController;

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

Route::middleware('auth:api')->get('/pica', function (Request $request) {
    return $request->user();
});

// Route::group(['middleware' => ['auth:api']], function () {
Route::group(['prefix' => 'pica'], function () {
    Route::group(['prefix' => 'listing'], function () {
        Route::group(['prefix' => 'field-leadership'], function () {
            Route::get('/', [FieldLeadershipController::class, 'getFieldLeadership']);
            Route::get('/{fieldLeadership}', [FieldLeadershipController::class, 'detailFieldLeadership']);
        });
    });
});
// });
