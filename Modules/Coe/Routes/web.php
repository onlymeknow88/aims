<?php

use Illuminate\Support\Facades\Route;
use Modules\Coe\Http\Livewire\Add;
use Modules\Coe\Http\Livewire\Home;
use Modules\Coe\Http\Livewire\Auth\Login;
use Modules\Coe\Http\Livewire\CallendarView;
use Modules\Coe\Http\Livewire\Category;
use Modules\Coe\Http\Livewire\Dashboard;
use Modules\Coe\Http\Livewire\Edit;
use Modules\Coe\Http\Livewire\InvitedEx;
use Modules\Coe\Http\Livewire\Lists;

Route::get('/', Home::class);

Route::prefix('login')->middleware('guest')->group(function () {
    Route::get('/', Login::class)->name('login');
});

Route::get('logout/', function () {
    Session::flush();
    return redirect(route('login'));
})->name('logout');

Route::middleware(['auth:coe'])->group(function () {
    Route::get('/dashboard', Dashboard::class)->name('dashboard');
    Route::get('/list', Lists::class)->name('list');
    Route::get('/calendar', CallendarView::class)->name('callendar');
    Route::get('/add-event', Add::class)->name('add-event');
    Route::get('/edit-event/{event}', Edit::class)->name('edit-event');
    Route::get('/category', Category::class)->name('category');
});

Route::get('/inv', InvitedEx::class)->name('inv');
Route::get('/attachment/{id}', [CallendarView::class, 'attachment'])->name('attachment');
