<?php

use Illuminate\Http\Request;
use Modules\FieldLeadership\Http\Controllers\Auth\LoginController;
use Modules\FieldLeadership\Http\Controllers\General\GeneralController;
use Modules\FieldLeadership\Http\Controllers\Listing\Approval\ApprovalController;
use Modules\FieldLeadership\Http\Controllers\Listing\Document\DocumentController;
use Modules\FieldLeadership\Http\Controllers\Listing\Pja\PjaController;
use Modules\FieldLeadership\Http\Controllers\MainDashboard\MainDashboardController;
use Modules\FieldLeadership\Http\Controllers\Master\Category\CategoryController;
use Modules\FieldLeadership\Http\Controllers\Master\LimitParameter\LimitParameterController;
use Modules\FieldLeadership\Http\Controllers\Master\PotencyConsequence\PotencyConsequenceController;
use Modules\FieldLeadership\Http\Controllers\Master\TypeKta\TypeKtaController;

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

Route::middleware('auth:api')->get('/fieldleadership', function (Request $request) {
    return $request->user();
});


Route::group(['prefix' => 'field-leadership'], function () {

    Route::get('main-dashboard', [MainDashboardController::class, 'mainDashboard']);
    Route::get('sap', [MainDashboardController::class, 'sap']);

    Route::group(['prefix' => 'auth'], function () {
        Route::post('login', [LoginController::class, 'login']);
    });

    Route::group(['middleware' => ['auth:sanctum']], function () {
        Route::group(['prefix' => 'general'], function () {
            Route::get('ccow', [GeneralController::class, 'getCcows']);
            Route::get('company', [GeneralController::class, 'getCompanies']);
            Route::get('department/{id}', [GeneralController::class, 'getDepartments']);
            Route::get('section/{id}', [GeneralController::class, 'getSections']);
            Route::get('area-location/{id}', [GeneralController::class, 'getAreaLocations']);
            Route::get('area-manager/{id}', [GeneralController::class, 'getAreaManagers']);
            Route::get('employee/{id}/{type}', [GeneralController::class, 'getEmployees']);
            Route::get('member/{type}', [GeneralController::class, 'getMembers']);
            Route::get('detail-company', [GeneralController::class, 'getDetailCompany']);

            Route::post('upload-file', [GeneralController::class, 'uploadFile']);
        });

        Route::group(['prefix' => 'listing'], function () {
            Route::group(['prefix' => 'approval'], function () {
                Route::get('/', [ApprovalController::class, 'getFieldLeadershipApproval']);
            });
            Route::group(['prefix' => 'document'], function () {
                Route::get('/', [DocumentController::class, 'getFieldLeadership']);
                Route::get('/question', [DocumentController::class, 'questionPto']);
                Route::get('/type-action', [DocumentController::class, 'typeAction']);
            });
            Route::group(['prefix' => 'pja'], function () {
                Route::get('/', [PjaController::class, 'getFieldLeadershipPja']);
            });
            Route::post('/create', [DocumentController::class, 'store']);
            Route::post('/edit/{id}', [DocumentController::class, 'update']);
            Route::get('/{fieldLeadership}', [DocumentController::class, 'detailFieldLeadership']);
        });

        Route::group(['prefix' => 'master'], function () {
            Route::group(['prefix' => 'category'], function () {
                Route::get('/', [CategoryController::class, 'getCategory']);
            });
            Route::group(['prefix' => 'limit-parameter'], function () {
                Route::get('/', [LimitParameterController::class, 'getLimitParameter']);
            });
            Route::group(['prefix' => 'potency-consequence'], function () {
                Route::get('/', [PotencyConsequenceController::class, 'getPotency']);
            });
            Route::group(['prefix' => 'type-kta'], function () {
                Route::get('/', [TypeKtaController::class, 'getType']);
            });
        });
    });
});
