<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Modules\KPP\Http\Livewire\Auth\Login;
use Modules\KPP\Http\Livewire\Dashboard\Dashboard;
use Modules\KPP\Http\Livewire\Extraction\Checking\Checking;
use Modules\KPP\Http\Livewire\Extraction\DetailExtraction;
use Modules\KPP\Http\Livewire\Extraction\EditExtraction;
use Modules\KPP\Http\Livewire\Extraction\Extraction;
use Modules\KPP\Http\Livewire\Extraction\InReview\InReview;
use Modules\KPP\Http\Livewire\MasterLibrary\AgencyAuthority\AgencyAuthority;
use Modules\KPP\Http\Livewire\MasterLibrary\Type\Type;
use Modules\KPP\Http\Livewire\Obedience\CreateExtraction;
use Modules\KPP\Http\Livewire\Obedience\DetailObedience;
use Modules\KPP\Http\Livewire\Obedience\EditDraftExtraction;
use Modules\KPP\Http\Livewire\Obedience\Obedience;
use Modules\KPP\Http\Livewire\ObedienceMonitoring\Contractor;
use Modules\KPP\Http\Livewire\ObedienceMonitoring\Detail as DetailObedienceMonitoring;
use Modules\KPP\Http\Livewire\ObedienceMonitoring\Internal;
use Modules\KPP\Http\Livewire\ObedienceMonitoring\Subcontractor;
use Modules\KPP\Http\Livewire\Pica\Pica;
use Modules\KPP\Http\Livewire\Request\Request;
use Modules\KPP\Http\Livewire\Rule\Active;
use Modules\KPP\Http\Livewire\Rule\Create;
use Modules\KPP\Http\Livewire\Rule\Detail;
use Modules\KPP\Http\Livewire\Rule\Draft;
use Modules\KPP\Http\Livewire\Rule\Edit;
use Modules\KPP\Http\Livewire\Rule\Obsolete;
use Modules\KPP\Http\Livewire\Rule\Replace;

// Route::prefix('kpp')->group(function () {
//     Route::get('/', 'KPPController@index');
// });

Route::as('auth.')->prefix('login')->middleware('guest')->group(function () {
    Route::get('/', Login::class)->name('login');
});

Route::get('/logout', function () {
    Session::flush();
    return redirect(route('kpp::auth.login'));
})->name('logout');

Route::middleware(['auth:kpp'])->group(function () {
    //Route::get('/tes', Tes::class);
    Route::get('/', Dashboard::class)->name('dashboard');

    Route::prefix('master-library')->as('master-library.')->group(function () {

        Route::prefix('agency-authority')->as('agency-authority.')->group(function () {
            Route::get('/', AgencyAuthority::class)->name('index');
        });

        Route::prefix('type')->as('type.')->group(function () {
            Route::get('/', Type::class)->name('index');
        });
    });

    Route::prefix('rule')->as('rules.')->group(function () {
        Route::get('/', Active::class)->name('index');
        Route::get('/draft', Draft::class)->name('draft');
        Route::get('/obsolete', Obsolete::class)->name('obsolete');
        Route::get('/detail', Detail::class)->name('detail');
        Route::get('/create', Create::class)->name('create');
        Route::get('/edit', Edit::class)->name('edit');
        Route::get('/replace', Replace::class)->name('replace');
    });

    Route::prefix('request')->as('requests.')->group(function () {
        Route::get('/', Request::class)->name('index');
    });

    Route::prefix('obedience')->as('obediences.')->group(function () {
        Route::get('/', Obedience::class)->name('index');
        Route::get('/detail', DetailObedience::class)->name('detail');
        Route::get('/create-extraction', CreateExtraction::class)->name('create-extraction');
        Route::get('/edit-extraction', EditDraftExtraction::class)->name('edit-extraction');
    });

    Route::prefix('obedience-monitoring')->as('obedience-monitoring.')->group(function () {
        Route::get('/internal', Internal::class)->name('internal');
        Route::get('/contractor', Contractor::class)->name('contractor');
        Route::get('/subcontractor', Subcontractor::class)->name('subcontractor');
        Route::get('/detail', DetailObedienceMonitoring::class)->name('detail');
    });

    Route::prefix('extraction')->as('extractions.')->group(function () {
        Route::get('/', Extraction::class)->name('index');
        Route::get('/detail', DetailExtraction::class)->name('detail');
        Route::get('/edit', EditExtraction::class)->name('edit');

        Route::get('/checking', Checking::class)->name('checking');
        Route::get('/checking-detail', \Modules\KPP\Http\Livewire\Extraction\Checking\DetailExtraction::class)->name('checking.detail');
        Route::get('/checking-edit', \Modules\KPP\Http\Livewire\Extraction\Checking\EditExtraction::class)->name('checking.edit');

        Route::get('/in-review', InReview::class)->name('in-review');
        Route::get('/in-review-detail', \Modules\KPP\Http\Livewire\Extraction\InReview\DetailExtraction::class)->name('in-review.detail');
    });

    Route::prefix('pica')->as('pica.')->group(function () {
        Route::get('/', Pica::class)->name('index');
        Route::get('/detail', \Modules\KPP\Http\Livewire\Pica\DetailPica::class)->name('detail');
        Route::get('/edit', \Modules\KPP\Http\Livewire\Pica\EditPica::class)->name('edit');
    });
});


