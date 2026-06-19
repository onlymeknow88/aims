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

// Login

use Modules\Pica\Http\Livewire\Dashboard\DashboardPage;
use Modules\Pica\Http\Livewire\Listing\ActiveDocument\ActiveDocumentPage;
use Modules\Pica\Http\Livewire\Listing\ActiveDocument\CreateActiveDocumentPage;
use Modules\Pica\Http\Livewire\Listing\ActiveDocument\DetailActiveDocumentPage;
use Modules\Pica\Http\Livewire\Listing\ActiveDocument\EditActiveDocumentPage;
use Modules\Pica\Http\Livewire\Listing\Crs\CrsDetailPage;
use Modules\Pica\Http\Livewire\Listing\Crs\CrsPage;
use Modules\Pica\Http\Livewire\Listing\Draft\DraftPage;
use Modules\Pica\Http\Livewire\Listing\ReturnDocument\ReturnDocumentPage;
use Modules\Pica\Http\Livewire\LoginPage\LoginPage;
use Modules\Pica\Http\Controllers\PicaController;

Route::get('/login', LoginPage::class)->name('login');
Route::get('/logout', function () {
    Session::flush();
    return redirect(route('pica::login'));
})->name('logout');

Route::middleware(['auth:pica'])->group(function () {
    Route::get('files/{id}/preview', [PicaController::class, 'previewFile'])->name('files.preview');
    Route::get('files/{id}/sas', [PicaController::class, 'getFileSasUri'])->name('files.sas-uri');

    // Dashboard
    Route::get('/', DashboardPage::class)->name('dashboard');

    // Listing
    Route::prefix('listing')->as('listing.')->group(function () {
        // Active Document
        Route::prefix('active-document')->as('active-document.')->group(function () {
            Route::get('/', ActiveDocumentPage::class)->name('index');
            Route::get('/create', CreateActiveDocumentPage::class)->name('create');
            Route::get('/edit/{id}', EditActiveDocumentPage::class)->name('edit');
            Route::get('/detail/{id}', DetailActiveDocumentPage::class)->name('detail');
        });

        // Draft Document
        Route::prefix('draft-document')->as('draft-document.')->group(function () {
            Route::get('/', DraftPage::class)->name('index');
        });

        // Return Document
        Route::prefix('return-document')->as('return-document.')->group(function () {
            Route::get('/', ReturnDocumentPage::class)->name('index');
        });

        // Review CRS
        Route::prefix('review-crs')->as('review-crs.')->group(function () {
            Route::get('/', CrsPage::class)->name('index');
            Route::get('/detail/{id}', CrsDetailPage::class)->name('detail');
        });
    });
});
