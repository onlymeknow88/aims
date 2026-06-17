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
use Modules\DocumentSystem\Http\Controllers\GeneralController;
use Modules\DocumentSystem\Http\Livewire\Auth\Login;
use Modules\DocumentSystem\Http\Livewire\Dashboard\Dashboard;
use Modules\DocumentSystem\Http\Livewire\Draft\Index as DraftIndex;
use Modules\DocumentSystem\Http\Livewire\Jsa\Active;
use Modules\DocumentSystem\Http\Livewire\Jsa\Create;
use Modules\DocumentSystem\Http\Livewire\Jsa\CreateNewDocument;
use Modules\DocumentSystem\Http\Livewire\Jsa\Detail;
use Modules\DocumentSystem\Http\Livewire\Jsa\Draft;
use Modules\DocumentSystem\Http\Livewire\Jsa\Obsolate;
use Modules\DocumentSystem\Http\Livewire\Maker\AddNewDocument;
use Modules\DocumentSystem\Http\Livewire\Maker\AddnewMaker;
use Modules\DocumentSystem\Http\Livewire\Maker\DetailMaker;
use Modules\DocumentSystem\Http\Livewire\Maker\Maker;
use Modules\DocumentSystem\Http\Livewire\Maker\TableMaker;
use Modules\DocumentSystem\Http\Livewire\Master\CategoriesIndex;
use Modules\DocumentSystem\Http\Livewire\Master\DocumentSystem;
use Modules\DocumentSystem\Http\Livewire\Master\MappingIndex;
use Modules\DocumentSystem\Http\Livewire\Master\ModuleIndex;
use Modules\DocumentSystem\Http\Livewire\Obsolate\Index;
use Modules\DocumentSystem\Http\Livewire\OnGoing\TableOnGoing;
use Modules\DocumentSystem\Http\Livewire\Ptw\Active as PtwActive;
use Modules\DocumentSystem\Http\Livewire\Ptw\Create as PtwCreate;
use Modules\DocumentSystem\Http\Livewire\Ptw\CreateNewDocument as PtwCreateNewDocument;
use Modules\DocumentSystem\Http\Livewire\Ptw\Detail as PtwDetail;

Route::as('auth.')->prefix('login')->middleware('guest')->group(function () {
    Route::get('/', Login::class)->name('login');
});
Route::get('/logout', function () {
    Session::flush();
    Auth::guard('document-system')->logout();
    return redirect(route('document-systems::auth.login'));
})->name('logout');

Route::middleware('auth:document-system')->group(function () {
    Route::get('/', Dashboard::class)->name('dashboard');

    Route::post('autocomplete-peoples', [GeneralController::class, 'invitedPeopleList'])->name('invited_people_list');
    Route::post('autocomplete-sop', [GeneralController::class, 'autocompleteSop'])->name('autocomplete_sop');
    Route::get('attachments/{id}/sas', [GeneralController::class, 'getAttachmentSasUri'])->name('attachments.sas-uri');
    Route::get('attachments/{id}/preview', [GeneralController::class, 'previewAttachment'])->name('attachments.preview');
    Route::get('export', [TableMaker::class, 'export'])->name('document-systems.export');
    Route::get('obsolate', Index::class)->name('document-systems.obsolate');
    Route::get('draft', DraftIndex::class)->name('document-systems.draft');

    Route::prefix('maker')->group(function () {
        Route::get('/', Maker::class)->name('maker');
        Route::get('/ongoing', TableOnGoing::class)->name('ongoing');
        Route::get('/detail-maker/{id}/{type}', DetailMaker::class)->name('detail-maker');
        // Route::get('/edit-maker/{id}', DetailMaker::class)->name('edit-maker');
        Route::get('add-maker', AddNewDocument::class)->name('add-maker');
        // Route::get('add-maker', AddnewMaker::class)->name('add-maker');
        Route::post('/files', [AddNewDocument::class, 'saveFile'])->name('maker.files');
        Route::get('edit-maker/{id}', AddNewDocument::class)->name('edit-maker');
        Route::post('/revision/{id}', [DetailMaker::class, 'uploadTmpFile'])->name('maker.revision.upload-file');
    });

    Route::prefix('jsa')->group(function () {
        Route::get('/active', Active::class)->name('jsa.active');
        Route::get('/draft', Draft::class)->name('jsa.draft');
        Route::get('/create', CreateNewDocument::class)->name('jsa.create');
        Route::get('/obsolate', Obsolate::class)->name('jsa.obsolate');
        Route::get('edit/{id}', Create::class)->name('jsa.edit');
        Route::get('/detail/{id}/{type}', Detail::class)->name('jsa.detail');
        Route::post('/files', [Create::class, 'saveFile'])->name('jsa.files');
        Route::post('/files/renew', [Detail::class, 'saveFile'])->name('jsa.files.renew-document');
    });

    Route::prefix('ptw')->group(function () {
        Route::get('/active', PtwActive::class)->name('ptw.active');
        Route::get('/create', PtwCreateNewDocument::class)->name('ptw.create');
        Route::get('edit/{id}', PtwCreate::class)->name('ptw.edit');
        Route::get('/detail/{id}/{type}', PtwDetail::class)->name('ptw.detail');
        Route::post('/files', [PtwCreate::class, 'saveFile'])->name('ptw.files');
        Route::post('/files/renew', [PtwDetail::class, 'saveFile'])->name('ptw.files.renew-document');
    });

    Route::prefix('master')->group(function () {
        Route::prefix('modules')->group(function () {
            Route::get('/', ModuleIndex::class)->name('master.index');
        });
        Route::get('/categories', CategoriesIndex::class)->name('master.categories.index');
        Route::get('/mapping', MappingIndex::class)->name('master.mapping.index');
        Route::get('/document-system', DocumentSystem::class)->name('master.document-system');
    });
});
