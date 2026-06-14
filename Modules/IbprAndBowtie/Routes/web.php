<?php
//use App\Http\Controllers\ExportIbprForm;
use Modules\IbprAndBowtie\Http\Controllers\BaseApp;
use Modules\IbprAndBowtie\Http\Livewire\Auth\Login;
use Modules\IbprAndBowtie\Http\Livewire\Bowtie\Create\CreateBowtie;
use Modules\IbprAndBowtie\Http\Livewire\Bowtie\Create\EditBowtie;
use Modules\IbprAndBowtie\Http\Livewire\Bowtie\Detail\DetailBowtie;
use Modules\IbprAndBowtie\Http\Livewire\Bowtie\Event\CcaListing;
use Modules\IbprAndBowtie\Http\Livewire\Bowtie\Event\EventListing;
use Modules\IbprAndBowtie\Http\Livewire\Bowtie\Event\EventDetail;
use Modules\IbprAndBowtie\Http\Livewire\Bowtie\Event\LostCallculationListing;
use Modules\IbprAndBowtie\Http\Livewire\Bowtie\Event\PerpormanceStandardListing;
use Modules\IbprAndBowtie\Http\Livewire\Bowtie\Listing\BowtieList;
use Modules\IbprAndBowtie\Http\Livewire\Bowtie\Modal\ModalPerformance;

use Modules\IbprAndBowtie\Http\Livewire\Dashboard\Dashboard;
use Modules\IbprAndBowtie\Http\Livewire\Form\EditIbpr;
use Modules\IbprAndBowtie\Http\Livewire\Form\Form;
use Modules\IbprAndBowtie\Http\Livewire\FormIbpr\FormIbpr;
use Modules\IbprAndBowtie\Http\Livewire\Iadl\Form\EditIadl;
use Modules\IbprAndBowtie\Http\Livewire\Iadl\Form\FormIadl;
use Modules\IbprAndBowtie\Http\Livewire\Iadl\FormIbpr\FormListIadl;
use Modules\IbprAndBowtie\Http\Livewire\Iadl\Maker\DetailIadl;
use Modules\IbprAndBowtie\Http\Livewire\Iadl\Maker\ListFormIadl;
use Modules\IbprAndBowtie\Http\Livewire\Iadl\Maker\MakerIadl;
use Modules\IbprAndBowtie\Http\Livewire\Maker\Detail;
use Modules\IbprAndBowtie\Http\Livewire\Maker\ListForm;
use Modules\IbprAndBowtie\Http\Livewire\Maker\Maker;
use Modules\IbprAndBowtie\Http\Livewire\Master\Bahaya\Bahaya;
use Modules\IbprAndBowtie\Http\Livewire\Master\Hirarki\Hirarki;
use Modules\IbprAndBowtie\Http\Livewire\Matrix\Matrix;
use Modules\IbprAndBowtie\Http\Livewire\Pica\Listing\PicaList;
use Modules\IbprAndBowtie\Http\Livewire\RiskList\DetailRiskList;
use Modules\IbprAndBowtie\Http\Livewire\RiskList\Listing;

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

Route::get('/login', Login::class)->name('login');
Route::get('logout/', function () {
    Session::flush();
    return redirect(route('ibpr-and-bowtie::login'));
})->name('logout');

Route::middleware(['auth:ibpr-and-bowtie'])->group(function () {
    Route::get('/', Dashboard::class)->name('dashboard');
    Route::get('/dashboard', Dashboard::class)->name('dashboard-index');

    Route::prefix('master')->as('master.')->group(function () {
        Route::get('/bahaya', Bahaya::class)->name('master-bahaya');
        Route::get('/hirarki', Hirarki::class)->name('master-hirarki');
    });

    Route::prefix('ibpr')->as('ibpr.')->group(function () {
        Route::get('/export/{id}',  [FormIbpr::class, 'exportIbpr'])->name('export');
        Route::get('/create', Form::class)->name('ibpr-create');

        Route::prefix('active')->as('active.')->group(function () {
            Route::get('/list', Maker::class)->name('list-active-ibpr-and-bowtie');
            Route::get('/edit/{id}', EditIbpr::class)->name('edit-ibpr-and-bowtie');
            Route::get('/detail/{id}', Detail::class)->name('detai-active-ibpr-and-bowtie');
            Route::get('/detail/{id}/form', ListForm::class)->name('list-form-ibpr-and-bowtie');
            Route::get('/list/{id}/form', FormIbpr::class)->name('list-form-active-ibpr-and-bowtie');

        });
        Route::prefix('on-progress')->as('on-progress.')->group(function () {
            Route::get('/list', Maker::class)->name('list-on-progress-ibpr-and-bowtie');
        });
        Route::prefix('draft')->as('draft.')->group(function () {
            Route::get('/list', Maker::class)->name('list-draft-ibpr-and-bowtie');
        });
    });

    Route::prefix('iadl')->as('iadl.')->group(function () {
        Route::get('/export/{id}',  [FormIadl::class, 'exportIadl'])->name('export');
        Route::get('/create', FormIadl::class)->name('iadl-create');

        Route::prefix('active')->as('active.')->group(function () {
            Route::get('/list', MakerIadl::class)->name('list-active-iadl-and-bowtie');
            Route::get('/edit/{id}', EditIadl::class)->name('edit-iadl-and-bowtie');
            Route::get('/detail/{id}', DetailIadl::class)->name('detail-active-iadl-and-bowtie');
            Route::get('/detail/{id}/form', ListFormIadl::class)->name('list-form-iadl-and-bowtie');
            Route::get('/list/{id}/form', FormListIadl::class)->name('list-form-active-iadl-and-bowtie');

        });
        Route::prefix('on-progress')->as('on-progress.')->group(function () {
            Route::get('/list', MakerIadl::class)->name('list-on-progress-iadl-and-bowtie');
        });
        Route::prefix('draft')->as('draft.')->group(function () {
            Route::get('/list', MakerIadl::class)->name('list-draft-iadl-and-bowtie');
        });
    });

    Route::prefix('bowtie')->as('bowtie.')->group(function () {
        Route::get('/list', BowtieList::class)->name('list-active-bowtie');
        Route::get('/create', CreateBowtie::class)->name('create-bowtie');
        Route::get('/event/{id}/list', EventListing::class)->name('event-list');

        Route::get('/detail-event/{id}', EventDetail::class)->name('event-detail');

        Route::get('/cca/{id}/list', CcaListing::class)->name('cca-list');
        Route::get('/perpormnace-standard/{id}/list', PerpormanceStandardListing::class)->name('perpormnace-standard-list');
        Route::get('/lost-callculation/{id}/list', LostCallculationListing::class)->name('lost-callculation-list');

        Route::get('/detail/{id}', DetailBowtie::class)->name('detail-bowtie');
        Route::get('/detail/edit/{id}', EditBowtie::class)->name('detail-edit-bowtie');
    });

    Route::prefix('risk-list')->as('risk-list.')->group(function () {
        Route::get('/list', Listing::class)->name('risk-list-table-list');
        Route::get('/detail/{id}', DetailRiskList::class)->name('risk-list-detail');
    });

    Route::prefix('pica')->as('pica.')->group(function () {
        Route::get('/list', PicaList::class)->name('pica-table-list');
        // Route::get('/detail/{id}', DetailRiskList::class)->name('pica-detail');
    });
});

Route::get('/get-notif', [BaseApp::class, 'getNotifInfo'])->name('get.data');
Route::get('/matrix', Matrix::class)->name('matrix');
