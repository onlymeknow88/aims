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

use Modules\Sap\Http\Controllers\SapController;
use Modules\Sap\Http\Livewire\Auth\Login;
use Modules\Sap\Http\Livewire\Home\Index as HomeIndex;

//monthly category
use Modules\Sap\Http\Livewire\Monthly\Category\Index as MonthlyCategoryIndex;
use Modules\Sap\Http\Livewire\Monthly\Category\Create as MonthlyCategoryCreate;
use Modules\Sap\Http\Livewire\Monthly\Category\Create as MonthlyCategoryUpdate;
//monthly list
use Modules\Sap\Http\Livewire\Monthly\Index as MonthlyIndex;
use Modules\Sap\Http\Livewire\Monthly\Create as MonthlyCreate;
use Modules\Sap\Http\Livewire\Monthly\Create as MonthlyUpdate;

//setup kategory
use Modules\Sap\Http\Livewire\Setup\Grade\Category\Index as SetupCategoryIndex;
use Modules\Sap\Http\Livewire\Setup\Grade\Category\Create as SetupCategoryCreate;
use Modules\Sap\Http\Livewire\Setup\Grade\Category\Create as SetupCategoryUpdate;

//setup list
use Modules\Sap\Http\Livewire\Setup\Grade\Index as SetupIndex;
use Modules\Sap\Http\Livewire\Setup\Grade\create as SetupCreate;
use Modules\Sap\Http\Livewire\Setup\Grade\create as SetupUpdate;

//setup list
use Modules\Sap\Http\Livewire\Setup\DepartmentCode\Index as DeptCodeIndex;
use Modules\Sap\Http\Livewire\Setup\DepartmentCode\Update as DeptCodeUpdate;

use Modules\Sap\Http\Livewire\Summary\Index as SummaryIndex;

//guest area
Route::prefix('sap')->middleware('guest')->group(function () {
    Route::get('/login', Login::class)->name('sap-login');
});

//member area
Route::middleware(['auth:sap'])->prefix('sap')->group(function () { //->middleware(['auth:sap'])
    Route::get('/', HomeIndex::class)->name('sap-home-index');

    Route::prefix('setup')->group(function () {
        Route::prefix('category')->group(function () {
            Route::get('/', SetupCategoryIndex::class)->name('sap-setup-category-index');
            Route::get('/create', SetupCategoryCreate::class)->name('sap-setup-category-create');
            Route::get('/{id}/show', SetupCategoryUpdate::class)->name('sap-setup-category-update');
        });
        Route::get('/category/{category_id}/index', SetupIndex::class)->name('sap-setup-index');
        Route::get('/category/{category_id}/create', SetupCreate::class)->name('sap-setup-create');
        Route::get('/category/{category_id}/{id}/show', SetupUpdate::class)->name('sap-setup-update');
    });

    Route::prefix('setup')->group(function () {
        Route::prefix('department/code')->group(function () {
            Route::get('/', DeptCodeIndex::class)->name('sap-setup-dept-code-index');
            Route::get('/update', DeptCodeUpdate::class)->name('sap-setup-dept-code-');
        });
    });

    Route::prefix('monthly')->group(function () {
        Route::prefix('category')->group(function () {
            Route::get('/', MonthlyCategoryIndex::class)->name('sap-monthly-category-index');
            Route::get('/create', MonthlyCategoryCreate::class)->name('sap-monthly-category-create');
            Route::get('/{id}/show', MonthlyCategoryUpdate::class)->name('sap-monthly-category-update');
        });
        //Route::get('/category/{category_id}/index', MonthlyIndex::class)->name('sap-monthly-index');
        Route::get('/category/monthly/create', MonthlyCreate::class)->name('sap-monthly-create');
        Route::get('/category/{category_id}/{id}/show', MonthlyUpdate::class)->name('sap-monthly-update');
    });


    Route::prefix('summary')->group(function () {
        Route::get('/{slug}', SummaryIndex::class)->name('summary-setup-index');
    });
});
