<?php

use Modules\CSMS\Http\Livewire\Dashboard\DashboardPage;
use Modules\CSMS\Http\Livewire\Bidding\Lists as BiddingLists;
use Modules\CSMS\Http\Livewire\Bidding\Create as BiddingCreate;
use Modules\CSMS\Http\Livewire\Bidding\Edit as BiddingEdit;
use Modules\CSMS\Http\Livewire\Bidding\Detail as BiddingDetail;
use Modules\CSMS\Http\Livewire\Bidding\ListsOnGoing as BiddingListsOnGoing;
use Modules\CSMS\Http\Livewire\Bidding\ListsDraft as BiddingListsDraft;

use Modules\CSMS\Http\Livewire\PostBidding\Lists as PostBiddingLists;
use Modules\CSMS\Http\Livewire\PostBidding\Create as PostBiddingCreate;
use Modules\CSMS\Http\Livewire\PostBidding\Edit as PostBiddingEdit;
use Modules\CSMS\Http\Livewire\PostBidding\Detail as PostBiddingDetail;
use Modules\CSMS\Http\Livewire\PostBidding\ListsOnGoing as PostBiddingListsOnGoing;
use Modules\CSMS\Http\Livewire\PostBidding\ListsDraft as PostBiddingListsDraft;
use Modules\CSMS\Http\Livewire\PostBidding\Inactive as PostBiddingListsInactive;
use Modules\CSMS\Http\Livewire\PostBidding\Obsolate as PostBiddingListsObsolate;

use Modules\CSMS\Http\Livewire\Renewal\Lists as RenewalLists;
use Modules\CSMS\Http\Livewire\Renewal\Create as RenewalCreate;
use Modules\CSMS\Http\Livewire\Renewal\Edit as RenewalEdit;
use Modules\CSMS\Http\Livewire\Renewal\Lists as RenewalDetail;
use Modules\CSMS\Http\Livewire\Renewal\Lists as RenewalListsOnGoing;
use Modules\CSMS\Http\Livewire\Renewal\Lists as RenewalListsDraft;

use Modules\CSMS\Http\Livewire\Inactive\Lists as InactiveLists;
use Modules\CSMS\Http\Livewire\Inactive\Create as InactiveCreate;
use Modules\CSMS\Http\Livewire\Inactive\Edit as InactiveEdit;
use Modules\CSMS\Http\Livewire\Inactive\Lists as InactiveDetail;
use Modules\CSMS\Http\Livewire\Inactive\Lists as InactiveListsOnGoing;
use Modules\CSMS\Http\Livewire\Inactive\Lists as InactiveListsDraft;

use Modules\CSMS\Http\Livewire\Pica\Lists as PicaLists;
use Modules\CSMS\Http\Livewire\Login\LoginPage;
use Modules\CSMS\Http\Livewire\Pjo\Active\Lists as PjoListsActive;
use Modules\CSMS\Http\Livewire\Pjo\Active\Create as PjoCreate;
use Modules\CSMS\Http\Livewire\Pjo\Active\Edit as PjoEdit;
use Modules\CSMS\Http\Livewire\Pjo\Active\Detail as PjoDetail;
use Modules\CSMS\Http\Livewire\Pjo\OnGoing\Lists as PjoListsOnGoing;
use Modules\CSMS\Http\Livewire\Pjo\Draft\Lists as PjoListsDraft;
use Modules\CSMS\Http\Livewire\MemoKTT\Lists as MemoKTTLists;
use Modules\CSMS\Http\Livewire\MemoKTT\Create as MemoKTTCreate;
use Modules\CSMS\Http\Livewire\MemoKTT\Edit as MemoKTTEdit;
use Modules\CSMS\Http\Livewire\Letter\Lists as LetterLists;
use Modules\CSMS\Http\Livewire\Letter\Create as LetterCreate;
use Modules\CSMS\Http\Livewire\Letter\Edit as LetterEdit;
use Modules\CSMS\Http\Livewire\Dictionary\Lists as DictionaryLists;
use Modules\CSMS\Http\Livewire\Dictionary\Create as DictionaryCreate;
use Modules\CSMS\Http\Livewire\Dictionary\Edit as DictionaryEdit;

use Modules\CSMS\Http\Livewire\Approval\Biddings as ApprovalBiddings;
use Modules\CSMS\Http\Livewire\Approval\PostBiddings as ApprovalPostBiddings;


Route::get('/login', LoginPage::class)->name('login');
Route::get('/logout', function () {
    Session::flush();
    return redirect(route('csms::login'));
})->name('logout');

Route::middleware(['auth:csms'])->group(function () {
    /* Dashboard */
    Route::get('/', DashboardPage::class)->name('dashboard');

    Route::prefix('bidding')->as('bidding.')->group(function () {
        Route::get('lists/', BiddingLists::class)->name('index');
        Route::get('create/', BiddingCreate::class)->name('create');
        Route::get('edit/{bidding}', BiddingEdit::class)->name('edit');
        Route::get('detail/{bidding}', BiddingDetail::class)->name('detail');
        Route::get('download-attachment/{id}', [BiddingDetail::class, 'downloadFile'])->name('download-file');
        Route::get('ongoing', BiddingListsOnGoing::class)->name('ongoing');
        Route::get('draft', BiddingListsDraft::class)->name('draft');
    });

    Route::prefix('post-bidding')->as('post-bidding.')->group(function () {
        Route::get('lists/', PostBiddingLists::class)->name('index');
        Route::get('create/', PostBiddingCreate::class)->name('create');
        Route::get('edit/{bidding}', PostBiddingEdit::class)->name('edit');
        Route::get('detail/{bidding}', PostBiddingDetail::class)->name('detail');
        Route::get('ongoing', PostBiddingListsOnGoing::class)->name('ongoing');
        Route::get('draft', PostBiddingListsDraft::class)->name('draft');
        Route::get('inactive', PostBiddingListsInactive::class)->name('inactive');
        Route::get('obsolate', PostBiddingListsObsolate::class)->name('obsolate');
        Route::get('certificate/{id}', [PostBiddingDetail::class, 'certificate'])->name('certificate');
    });

    Route::prefix('renewal')->as('renewal.')->group(function () {
        Route::get('lists/', RenewalLists::class)->name('index');
        Route::get('create/{id}', RenewalCreate::class)->name('create');
        Route::get('edit/{id}', RenewalEdit::class)->name('edit');
        Route::get('detail/{id}', RenewalDetail::class)->name('detail');
        Route::get('ongoing', RenewalListsOnGoing::class)->name('ongoing');
        Route::get('draft', RenewalListsDraft::class)->name('draft');
    });

    Route::prefix('inactive')->as('inactive.')->group(function () {
        Route::get('lists/', InactiveLists::class)->name('index');
        Route::get('create/', InactiveCreate::class)->name('create');
        Route::get('edit/{id}', InactiveEdit::class)->name('edit');
        Route::get('detail/{id}', InactiveDetail::class)->name('detail');
        Route::get('ongoing', InactiveListsOnGoing::class)->name('ongoing');
        Route::get('draft', InactiveListsDraft::class)->name('draft');
    });

    Route::get('pica-lists/', PicaLists::class)->name('pica');

    /* PJO */
    Route::prefix('pjo')->as('pjo.')->group(function () {
        Route::get('lists/', PjoListsActive::class)->name('index');
        Route::get('create/', PjoCreate::class)->name('create');
        Route::get('edit/{id}', PjoEdit::class)->name('edit');
        Route::get('detail/{id}', PjoDetail::class)->name('detail');
        Route::get('ongoing', PjoListsOnGoing::class)->name('ongoing');
        Route::get('draft', PjoListsDraft::class)->name('draft');
    });

    /* Memo KTT */
    Route::prefix('memo')->as('memo.')->group(function () {
        Route::get('lists/', MemoKTTLists::class)->name('index');
        Route::get('create/', MemoKTTCreate::class)->name('create');
        Route::get('edit/{id}', MemoKTTEdit::class)->name('edit');
    });

    /* Surat Edaran */
    Route::prefix('letter')->as('letter.')->group(function () {
        Route::get('lists/', LetterLists::class)->name('index');
        Route::get('create/', LetterCreate::class)->name('create');
        Route::get('edit/{id}', LetterEdit::class)->name('edit');
    });

    /* Kamus */
    Route::prefix('dictionary')->as('dictionary.')->group(function () {
        Route::get('lists/', DictionaryLists::class)->name('index');
        Route::get('create/', DictionaryCreate::class)->name('create');
        Route::get('edit/{id}', DictionaryEdit::class)->name('edit');
    });

    /* Approval */
    Route::prefix('approval')->as('approval.')->group(function () {
        Route::get('bidding/', ApprovalBiddings::class)->name('bidding');
        Route::get('post-bidding/', ApprovalPostBiddings::class)->name('post-bidding');
    });
});
