<?php

use Illuminate\Http\Request;
use Modules\IbprAndBowtie\Http\Controllers\DashboardController;
use Modules\IbprAndBowtie\Http\Livewire\Bowtie\Detail\DetailBowtie;
use Modules\IbprAndBowtie\Http\Livewire\Bowtie\Event\CcaListing;
use Modules\IbprAndBowtie\Http\Livewire\Bowtie\Event\EventListing;
use Modules\IbprAndBowtie\Http\Livewire\Bowtie\Listing\BowtieList;
use Modules\IbprAndBowtie\Http\Livewire\Dashboard\Dashboard;
use Modules\IbprAndBowtie\Http\Livewire\FormIbpr\FormIbpr;
use Modules\IbprAndBowtie\Http\Livewire\Maker\Detail;
use Modules\IbprAndBowtie\Http\Livewire\Maker\ListForm;
use Modules\IbprAndBowtie\Http\Livewire\Maker\Maker;
use Modules\IbprAndBowtie\Http\Livewire\Maker\TableMaker;
use Modules\IbprAndBowtie\Http\Livewire\Pica\Listing\PicaList;
use Modules\IbprAndBowtie\Http\Livewire\RiskList\DetailRiskList;
use Modules\IbprAndBowtie\Http\Livewire\RiskList\Listing;

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

Route::middleware('auth:api')->get('/ibprandbowtie', function (Request $request) {
    Route::get('/', Dashboard::class)->name('dashboard');

    Route::prefix('bowtie')->as('bowtie.')->group(function () {
        Route::get('/list', [BowtieList::class, 'listing'])->name('list-active-bowtie');
        Route::get('/event/{id}/list', [EventListing::class, 'listing'])->name('event-list');
        Route::get('/cca/{id}/list', [CcaListing::class, 'listing'])->name('cca-list');


        Route::get('/detail/{id}', [DetailBowtie::class, 'getDetail'])->name('detail-bowtie');
    });

    Route::prefix('risk-list')->as('risk-list.')->group(function () {
        Route::get('/list', [Listing::class, 'listing'])->name('risk-list-table-list');
        Route::get('/detail/{id}', [DetailRiskList::class, 'getDetail'])->name('risk-list-detail');
    });
});

Route::prefix('ibpr')->as('ibpr.')->group(function () {
    Route::prefix('active')->as('active.')->group(function () {
        Route::get('/list', [TableMaker::class, 'listing'])->name('list-active-ibpr-and-bowtie');
        Route::get('/detail/{id}', [Detail::class, 'getDetail'])->name('detai-active-ibpr-and-bowtie');
        Route::get('/detail/{id}/form', [ListForm::class, 'listing'])->name('list-form-ibpr-and-bowtie');
        Route::get('/list/{id}/form', [FormIbpr::class, 'listing'])->name('list-form-active-ibpr-and-bowtie');

    });
    Route::prefix('on-progress')->as('on-progress.')->group(function () {
        Route::get('/list', [Maker::class, 'listing'])->name('list-on-progress-ibpr-and-bowtie');
    });
    Route::prefix('draft')->as('draft.')->group(function () {
        Route::get('/list', [Maker::class, 'listing'])->name('list-draft-ibpr-and-bowtie');
    });
});


Route::prefix('ibpr-and-bowtie')->as('ibpr-and-bowtie.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard-index');
});

Route::prefix('pica')->as('pica.')->group(function () {
    Route::get('/list', [PicaList::class, 'listing'])->name('pica-table-list');
});
