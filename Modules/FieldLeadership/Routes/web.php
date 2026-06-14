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
use Modules\FieldLeadership\Http\Livewire\Dashboard\DashboardPage;
use Modules\FieldLeadership\Http\Livewire\Listing\Approval\DetailRequestApprovalPage;
use Modules\FieldLeadership\Http\Livewire\Listing\Document\Active\ActiveFieldLeadershipPage;
use Modules\FieldLeadership\Http\Livewire\Listing\Document\Active\CreateActiveFieldLeadershipPage;
use Modules\FieldLeadership\Http\Livewire\Listing\Document\Active\DetailActiveFieldLeadershipPage;
use Modules\FieldLeadership\Http\Livewire\Listing\Document\Active\EditActiveFieldLeadershipPage;
use Modules\FieldLeadership\Http\Livewire\Listing\Document\Draft\DraftFieldLeadershipPage;
use Modules\FieldLeadership\Http\Livewire\Listing\Pja\DraftPjaPage;
use Modules\FieldLeadership\Http\Livewire\Listing\Pja\EditPjaPage;
use Modules\FieldLeadership\Http\Livewire\Listing\Pja\RequestReviewPjaPage;
use Modules\FieldLeadership\Http\Livewire\MasterLibrary\Category\CategoryPage;
use Modules\FieldLeadership\Http\Livewire\MasterLibrary\LimitParameter\LimitParameterPage;
use Modules\FieldLeadership\Http\Livewire\MasterLibrary\PotencyConsequence\PotencyConsequencePage;
use Modules\FieldLeadership\Http\Livewire\MasterLibrary\TypeKtaTta\TypeKtaTtaPage;
use Modules\FieldLeadership\Http\Livewire\Listing\Approval\RequestReviewApprovalPage;
use Modules\FieldLeadership\Http\Livewire\Listing\Pja\DetailPjaPage;
use Modules\FieldLeadership\Http\Livewire\Login\LoginPage;

// Login
Route::get('/login', LoginPage::class)->name('login');
Route::get('/logout', function () {
    Session::flush();
    return redirect(route('field-leadership::login'));
})->name('logout');

Route::middleware(['auth:field-leadership'])->group(function () {
    // Dashboard
    Route::get('/', DashboardPage::class)->name('dashboard');
    // Route::get('/', ActiveFieldLeadershipPage::class)->name('dashboard');
    // Listing
    Route::prefix('listing')->as('listing.')->group(function () {

        // Active
        Route::prefix('active')->as('active.')->group(function () {
            Route::get('/', ActiveFieldLeadershipPage::class)->name('index');
            Route::get('/create', CreateActiveFieldLeadershipPage::class)->name('create');
            Route::get('/edit/{id}', EditActiveFieldLeadershipPage::class)->name('edit');
            Route::get('/detail/{id}', DetailActiveFieldLeadershipPage::class)->name('detail');
        });

        // Draft
        Route::prefix('draft')->as('draft.')->group(function () {
            Route::get('/', DraftFieldLeadershipPage::class)->name('index');
        });

        // Request Review For PJA
        Route::prefix('request-review-pja')->as('request-review-pja.')->group(function () {
            Route::get('/', RequestReviewPjaPage::class)->name('index');
            Route::get('/draft', DraftPjaPage::class)->name('draft');
            Route::get('/detail/{id}', DetailPjaPage::class)->name('detail');
            Route::get('/edit/{id}', EditPjaPage::class)->name('edit');
        });

        // Request Review For Reviewer
        Route::prefix('request-review-reviewer')->as('request-review-reviewer.')->group(function () {
            Route::get('/', RequestReviewApprovalPage::class)->name('index');
            Route::get('/detail/{id}', DetailRequestApprovalPage::class)->name('detail');
        });
    });

    // Master
    Route::prefix('master-library')->as('master-library.')->group(function () {

        // Category
        Route::prefix('category')->as('category.')->group(function () {
            Route::get('/', CategoryPage::class)->name('index');
        });

        // Limit Parameter
        Route::prefix('limit-parameter')->as('limit-parameter.')->group(function () {
            Route::get('/', LimitParameterPage::class)->name('index');
        });

        // Potency & Consequence
        Route::prefix('potency-consequence')->as('potency-consequence.')->group(function () {
            Route::get('/', PotencyConsequencePage::class)->name('index');
        });

        // Type KTA/TTA
        Route::prefix('type-kta-tta')->as('type-kta-tta.')->group(function () {
            Route::get('/', TypeKtaTtaPage::class)->name('index');
        });
    });
});
