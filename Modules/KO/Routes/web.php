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
use Modules\KO\Http\Livewire\Auth\Login;
use Modules\KO\Http\Livewire\Commissioning\CreateCommissioning;
use Modules\KO\Http\Livewire\Commissioning\Commissioned;
use Modules\KO\Http\Livewire\Commissioning\CommissionedDetail;
use Modules\KO\Http\Livewire\Commissioning\Commissioning;
use Modules\KO\Http\Livewire\Commissioning\EditCommissioning;
use Modules\KO\Http\Livewire\Commissioning\ReturnedCommissioning;
use Modules\KO\Http\Livewire\Dashboard\Dashboard;
use Modules\KO\Http\Livewire\IssueReport\AdminVerification as AdminVerificationIssueReport;
use Modules\KO\Http\Livewire\IssueReport\CoordinatorVerification as CoordinatorVerificationIssueReport;
use Modules\KO\Http\Livewire\IssueReport\IssueReport;
use Modules\KO\Http\Livewire\IssueReport\Returned as ReturnedIssueReport;
use Modules\KO\Http\Livewire\IssueReport\Solved;
use Modules\KO\Http\Livewire\Ko\AddAttachment;
use Modules\KO\Http\Livewire\Ko\Completed\KoCompleted;
use Modules\KO\Http\Livewire\Ko\CreateProposal;
use Modules\KO\Http\Livewire\Ko\Draft\KoDraft;
use Modules\KO\Http\Livewire\Ko\Ko;
use Modules\KO\Http\Livewire\Ko\KoDetail;
use Modules\KO\Http\Livewire\Ko\Returned\KoReturned;
use Modules\KO\Http\Livewire\MasterLibrary\SpipCategory\SpipCategory;
use Modules\KO\Http\Livewire\MasterLibrary\SpipCategory\SpipCategoryDetail;
use Modules\KO\Http\Livewire\MasterLibrary\SpipType\SpipType;
use Modules\KO\Http\Livewire\MasterLibrary\SpipUnit\SpipUnit;
use Modules\KO\Http\Livewire\MasterLibrary\SpipUnit\SpipUnitDetail;
use Modules\KO\Http\Livewire\MasterLibrary\Unit\Unit;
use Modules\KO\Http\Livewire\MasterLibrary\Unit\UnitCreate;
use Modules\KO\Http\Livewire\MasterLibrary\Unit\UnitDetail;
use Modules\KO\Http\Livewire\MasterLibrary\Unit\UnitEdit;
use Modules\KO\Http\Livewire\ProposalVerification\AdminVerification\AdminVerification;
use Modules\KO\Http\Livewire\ProposalVerification\AdminVerification\AdminVerificationDetail;
use Modules\KO\Http\Livewire\ProposalVerification\CoordinatorVerification\CoordinatorVerification;
use Modules\KO\Http\Livewire\ProposalVerification\CoordinatorVerification\CoordinatorVerificationDetail;
use Modules\KO\Http\Livewire\RequestQR\ApprovedQR;
use Modules\KO\Http\Livewire\RequestQR\Detail;
use Modules\KO\Http\Livewire\RequestQR\RequestQR;
use Modules\KO\Http\Livewire\RevokeRequest\AdminRevokeRequest;
use Modules\KO\Http\Livewire\RevokeRequest\CoordinatorRevokeRequest;

//Route::get('/login', Login::class)->name('login');

Route::as('auth.')->prefix('login')->middleware('guest')->group(function () {
    Route::get('/', Login::class)->name('login');
});

Route::get('/logout', function () {
    Session::flush();
    return redirect(route('ko::auth.login'));
})->name('logout');

Route::middleware(['auth:ko'])->group(function () {
    Route::get('/', Dashboard::class)->name('dashboard');

    Route::prefix('master-library')->as('master-library.')->group(function () {

        Route::prefix('spip-category')->as('spip-category.')->group(function () {
            Route::get('/', SpipCategory::class)->name('index');
            Route::get('/detail/{id}', SpipCategoryDetail::class)->name('show');
        });

        Route::prefix('spip-type')->as('spip-type.')->group(function () {
            Route::get('/', SpipType::class)->name('index');
        });

        Route::prefix('spip-unit')->as('spip-unit.')->group(function () {
            Route::get('/', SpipUnit::class)->name('index');
            Route::get('/detail/{id}', SpipUnitDetail::class)->name('show');
        });

        Route::prefix('unit')->as('unit.')->group(function () {
            Route::get('/', Unit::class)->name('index');
            Route::get('/create', UnitCreate::class)->name('create');
            Route::get('/edit/{id}', UnitEdit::class)->name('edit');
            Route::get('/detail/{id}', UnitDetail::class)->name('show');
            //Route::get('/revoke-request', UnitRevokeRequest::class)->name('revoke-request');
        });

    });

    Route::prefix('revoke-request')->as('revoke-request.')->group(function () {
        Route::get('/admin', AdminRevokeRequest::class)->name('admin');
        Route::get('/coordinator', CoordinatorRevokeRequest::class)->name('coordinator');
    });

    Route::prefix('ko')->as('ko.')->group(function () {
        Route::get('/', Ko::class)->name('index');
        Route::get('/detail/{id}', KoDetail::class)->name('show');
        Route::get('/create-proposal', CreateProposal::class)->name('create.proposal');
        Route::get('/add-attachment/{id}', AddAttachment::class)->name('add.attachment');

        Route::get('/draft', KoDraft::class)->name('draft');
        Route::get('/draft/{id}/edit-proposal', \Modules\KO\Http\Livewire\Ko\Draft\EditProposal::class)->name('draft.edit.proposal');
        Route::get('/draft/{id}/edit-attachment', \Modules\KO\Http\Livewire\Ko\Draft\EditAttachment::class)->name('draft.edit.attachment');

        Route::get('/returned', KoReturned::class)->name('returned');
        Route::get('/returned/{id}/edit-proposal', \Modules\KO\Http\Livewire\Ko\Returned\EditProposal::class)->name('returned.edit.proposal');
        Route::get('/returned/{id}/edit-attachment', \Modules\KO\Http\Livewire\Ko\Returned\EditAttachment::class)->name('returned.edit.attachment');

        Route::get('/completed', KoCompleted::class)->name('completed');
    });

    Route::prefix('proposal-verification')->as('proposal-verification.')->group(function () {
        Route::prefix('admin-verification')->as('admin-verification.')->group(function () {
            Route::get('/', AdminVerification::class)->name('index');
            Route::get('/{id}', AdminVerificationDetail::class)->name('show');
        });

        Route::prefix('coordinator-verification')->as('coordinator-verification.')->group(function () {
            Route::get('/', CoordinatorVerification::class)->name('index');
            Route::get('/{id}', CoordinatorVerificationDetail::class)->name('show');
        });
    });

    Route::prefix('commissioning')->as('commissioning.')->group(function () {
        Route::get('/', Commissioning::class)->name('index');
        Route::get('/create/{id}', CreateCommissioning::class)->name('create');

        Route::get('/returned', ReturnedCommissioning::class)->name('returned');
        Route::get('/edit/{id}', EditCommissioning::class)->name('edit');

        Route::get('/commissioned', Commissioned::class)->name('commissioned');
        Route::get('/commissioned/detail/{id}', CommissionedDetail::class)->name('commissioned.show');
    });

    Route::prefix('commissioning-verification')->as('commissioning-verification.')->group(function () {
        Route::prefix('admin')->as('admin.')->group(function () {
            Route::get('/', \Modules\KO\Http\Livewire\CommissioningVerification\AdminVerification\AdminVerification::class)->name('index');
            Route::get('/{id}', \Modules\KO\Http\Livewire\CommissioningVerification\AdminVerification\AdminVerificationDetail::class)->name('show');
        });

        Route::prefix('coordinator')->as('coordinator.')->group(function () {
            Route::get('/', \Modules\KO\Http\Livewire\CommissioningVerification\CoordinatorVerification\CoordinatorVerification::class)->name('index');
            Route::get('/{id}', \Modules\KO\Http\Livewire\CommissioningVerification\CoordinatorVerification\CoordinatorVerificationDetail::class)->name('show');
        });
    });

    Route::prefix('request-qr')->as('request-qr.')->group(function () {
        Route::get('/', RequestQR::class)->name('index');
        Route::get('/coordinator-verification', \Modules\KO\Http\Livewire\RequestQR\CoordinatorVerification::class)->name('coordinator-verification');
        Route::get('/approved-qr', ApprovedQR::class)->name('approved');
        Route::get('/detail/{id}', Detail::class)->name('show');
    });

    Route::prefix('issue-report')->as('issue-report.')->group(function () {
        Route::get('/', IssueReport::class)->name('index');
        Route::get('/returned', ReturnedIssueReport::class)->name('returned');
        Route::get('/admin-verification', AdminVerificationIssueReport::class)->name('admin-verification');
        Route::get('/coordinator-verification', CoordinatorVerificationIssueReport::class)->name('coordinator-verification');
        Route::get('/solved', Solved::class)->name('solved');
    });

    Route::get('attachments/{id}/sas', [\Modules\KO\Http\Controllers\KOController::class, 'getAttachmentSasUri'])->name('attachments.sas-uri');
    Route::get('attachments/{id}/preview', [\Modules\KO\Http\Controllers\KOController::class, 'previewAttachment'])->name('attachments.preview');

});





