<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Modules\Kplh\Http\Livewire\Lists as Lists;
use Modules\Kplh\Http\Livewire\AreaJetty\Add as AddAJ;
use Modules\Kplh\Http\Livewire\AreaJetty\Edit as EditAJ;
use Modules\Kplh\Http\Livewire\AreaJetty\Lists as ListsAJ;
use Modules\Kplh\Http\Livewire\AreaMaintank\Add as AddAM;
use Modules\Kplh\Http\Livewire\AreaMaintank\Edit as EditAM;
use Modules\Kplh\Http\Livewire\AreaMaintank\Lists as ListsAM;
use Modules\Kplh\Http\Livewire\Auth\Login;
use Modules\Kplh\Http\Livewire\Dashboard;
use Modules\Kplh\Http\Livewire\FoodHygiene\Add as AddFH;
use Modules\Kplh\Http\Livewire\FoodHygiene\Edit as EditFH;
use Modules\Kplh\Http\Livewire\FoodHygiene\Lists as ListsFH;
use Modules\Kplh\Http\Livewire\K3\Apab\Add as AddApab;
use Modules\Kplh\Http\Livewire\K3\Apab\Edit as EditApab;
use Modules\Kplh\Http\Livewire\K3\Apar\Add as AddApar;
use Modules\Kplh\Http\Livewire\K3\Apar\Edit as EditApar;
use Modules\Kplh\Http\Livewire\K3\Ew\Add as AddEw;
use Modules\Kplh\Http\Livewire\K3\Ew\Edit as EditEw;
use Modules\Kplh\Http\Livewire\K3\Hr\Add as AddHr;
use Modules\Kplh\Http\Livewire\K3\Hr\Edit as EditHr;
use Modules\Kplh\Http\Livewire\K3\Hydrant\Add as AddHydrant;
use Modules\Kplh\Http\Livewire\K3\Hydrant\Edit as EditHydrant;
use Modules\Kplh\Http\Livewire\K3\Lists as ListsK3;
use Modules\Kplh\Http\Livewire\PJA\Approval;
use Modules\Kplh\Http\Livewire\PJA\DetailApproval;
use Modules\Kplh\Http\Livewire\WeeklyWorkplace\Add as AddWW;
use Modules\Kplh\Http\Livewire\WeeklyWorkplace\Edit as EditWW;
use Modules\Kplh\Http\Livewire\WeeklyWorkplace\Lists as ListsWW;

Route::get('/', Login::class);

Route::prefix('login')->middleware('guest')->group(function () {
    Route::get('/', Login::class)->name('login');
});

Route::get('logout/', function () {
    Session::flush();
    return redirect(route('kplh::login'));
})->name('logout');

Route::middleware(['auth:kplh'])->group(function () {
    Route::get('/dashboard', Dashboard::class)->name('dashboard');

    Route::get('/lists', Lists::class)->name('lists');

    Route::get('/list-fh', ListsFH::class)->name('list-food-hygiene');
    Route::get('/add-fh', AddFH::class)->name('add-food-hygiene');
    Route::get('/edit-fh/{id}', EditFH::class)->name('edit-food-hygiene');

    Route::get('/list-area-maintank', ListsAM::class)->name('list-area-maintank');
    Route::get('/add-area-maintank', AddAM::class)->name('add-area-maintank');
    Route::get('/edit-area-maintank/{id}', EditAM::class)->name('edit-area-maintank');

    Route::get('/list-area-jetty', ListsAJ::class)->name('list-area-jetty');
    Route::get('/add-area-jetty', AddAJ::class)->name('add-area-jetty');
    Route::get('/edit-area-jetty/{id}', EditAJ::class)->name('edit-area-jetty');

    Route::get('/list-workplace', ListsWW::class)->name('list-workplace');
    Route::get('/add-workplace', AddWW::class)->name('add-workplace');
    Route::get('/edit-workplace/{id}', EditWW::class)->name('edit-workplace');

    Route::get('/list-k3', ListsK3::class)->name('list-k3');

    Route::get('/add-k3-apar', AddApar::class)->name('add-k3-apar');
    Route::get('/edit-k3-apar/{id}', EditApar::class)->name('edit-k3-apar');

    Route::get('/add-k3-apab', AddApab::class)->name('add-k3-apab');
    Route::get('/edit-k3-apab/{id}', EditApab::class)->name('edit-k3-apab');

    Route::get('/add-k3-hydrant', AddHydrant::class)->name('add-k3-hydrant');
    Route::get('/edit-k3-hydrant/{id}', EditHydrant::class)->name('edit-k3-hydrant');

    Route::get('/add-k3-hose-rail', AddHr::class)->name('add-k3-hose-rail');
    Route::get('/edit-k3-hose-rail/{id}', EditHr::class)->name('edit-k3-hose-rail');

    Route::get('/add-k3-eye-wash', AddEw::class)->name('add-k3-eye-wash');
    Route::get('/edit-k3-eye-wash/{id}', EditEw::class)->name('edit-k3-eye-wash');

    Route::get('/approval', Approval::class)->name('approval');
    Route::get('/detail-approval/{id}', DetailApproval::class)->name('detail-approval');
    Route::get('/detail/{id}', DetailApproval::class)->name('detail');
});

Route::get('/download-file/{criteria}/{file}', [DetailApproval::class, 'downloadFile'])->name('download-file');
Route::get('/check-file/{file}', [DetailApproval::class, 'checkFile'])->name('check-file');
