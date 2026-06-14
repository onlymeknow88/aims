<?php

use Modules\Coe\Http\Controllers\CoeController;

Route::group(['prefix' => 'coe'], function () {
    // Route::group(['prefix' => 'auth'], function () {
    //     Route::post('login', [LoginController::class, 'login']);
    // });

    // Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::group(['prefix' => 'dashboard'], function () {

    Route::get('/', [CoeController::class, 'getAllIn']);
        Route::get('ytd', [CoeController::class, 'getYtd']);
        Route::get('count-annual', [CoeController::class, 'getAnnualCount']);
        Route::get('annual-completion', [CoeController::class, 'getAnnualCompletion']);
        Route::get('annual-on-going', [CoeController::class, 'getAnnualOnGoing']);
        Route::get('bycategory', [CoeController::class, 'getBycategory']);
        Route::get('thismonth', [CoeController::class, 'getThisMonth']);
        Route::get('thisyear', [CoeController::class, 'getThisYear']);
        Route::get('completion-by-month', [CoeController::class, 'getCompletionByMonth']);

        Route::get('something/{id}', [CoeController::class, 'getSomethings']);
        Route::get('someone/{id}/{type}', [CoeController::class, 'getSomeone']);
    });

    Route::group(['prefix' => 'listing'], function () {
        Route::group(['prefix' => 'approval'], function () {
            Route::get('/', [CoeController::class, 'getS']);
        });
    });

    Route::group(['prefix' => 'master'], function () {
        Route::group(['prefix' => 'category'], function () {
            Route::get('/', [CoeController::class, 'getCategory']);
        });
    });

    // Mobile
    Route::get('monthly-lists', [CoeController::class, 'getMonthlyListsCount']);
    Route::get('day-lists', [CoeController::class, 'getEventDayLists']);
    Route::get('event-details/{id}', [CoeController::class, 'getEventDetails']);
    // Mobile
    // });
});
