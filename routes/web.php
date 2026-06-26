<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\TesController;
use App\Http\Controllers\ViewController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\ViewExcelController;
use App\Http\Livewire\Coe\Coe as Sap; //tes

use App\Http\Livewire\MainDashboard\Public\Index as indexPublic;

use App\Http\Livewire\MainDashboard\Public\KegiatanK3lh\Show  as KegiatanK3lkPublicShow;
use App\Http\Livewire\MainDashboard\Public\KegiatanK3lh\Index  as KegiatanK3lkPublicIndex;

use App\Http\Livewire\MainDashboard\Public\NewsAndUpdate\Show as NewsAndUpdateShow;
use App\Http\Livewire\MainDashboard\Public\NewsAndUpdate\Index as NewsAndUpdateIndex;

use App\Http\Livewire\MainDashboard\Public\IncidentNotification\Show as IncidentNotificationShow;
use App\Http\Livewire\MainDashboard\Public\IncidentNotification\Index as IncidentNotificationIndex;

use App\Http\Livewire\MainDashboard\Public\StrategicProject;

use App\Http\Livewire\MainDashboard\Auth\Login;
use App\Http\Livewire\MainDashboard\View\Index as IndexPage;

use App\Http\Livewire\MainDashboard\General\Create as CreateGeneral;
use App\Http\Livewire\MainDashboard\General\Create as EditGeneral;
use App\Http\Livewire\MainDashboard\General\Index as IndexGeneral;

use App\Http\Livewire\MainDashboard\Slideshow\Index as IndexSlideshow;
use App\Http\Livewire\MainDashboard\Slideshow\Create as CreateSlideshow;
use App\Http\Livewire\MainDashboard\Slideshow\Create as EditSlideshow;

use App\Http\Livewire\MainDashboard\Attachment\Index as IndexAttachment;
use App\Http\Livewire\MainDashboard\Attachment\Create as CreateAttachment;
use App\Http\Livewire\MainDashboard\Attachment\Create as EditAttachment;


use App\Http\Livewire\MainDashboard\K3lhAward\Index as IndexK3lhAward;
use App\Http\Livewire\MainDashboard\K3lhAward\Create as CreateK3lhAward;
use App\Http\Livewire\MainDashboard\K3lhAward\Create as EditK3lhAward;

use App\Http\Livewire\MainDashboard\K3lhActivities\Index as IndexK3lhActivities;
use App\Http\Livewire\MainDashboard\K3lhActivities\Create as CreateK3lhActivities;
use App\Http\Livewire\MainDashboard\K3lhActivities\Create as EditK3lhActivities;

use App\Http\Livewire\MainDashboard\NewsAndUpdate\Index as IndexNewsAndUpdate;
use App\Http\Livewire\MainDashboard\NewsAndUpdate\Create as CreateNewsAndUpdate;
use App\Http\Livewire\MainDashboard\NewsAndUpdate\Create as EditNewsAndUpdate;

use App\Http\Livewire\MainDashboard\IncidentNotification\Index as IndexIncidentNotification;
use App\Http\Livewire\MainDashboard\IncidentNotification\Create as CreateIncidentNotification;
use App\Http\Livewire\MainDashboard\IncidentNotification\Create as EditIncidentNotification;

use App\Http\Livewire\MainDashboard\StrategicProject\Index as IndexStrategicProject;
use App\Http\Livewire\MainDashboard\StrategicProject\Create as CreateStrategicProject;
use App\Http\Livewire\MainDashboard\StrategicProject\Create as EditStrategicProject;

use App\Http\Livewire\MainDashboard\SafetyPerformance\Index as IndexSafetyPerformance;
use App\Http\Livewire\MainDashboard\SafetyPerformance\Create as CreateSafetyPerformance;
use App\Http\Livewire\MainDashboard\SafetyPerformance\Create as EditSafetyPerformance;

use App\Http\Livewire\MainDashboard\Performance\Index as IndexPerformance;
use App\Http\Livewire\MainDashboard\Performance\Create as CreatePerformance;
use App\Http\Livewire\MainDashboard\Performance\Create as EditPerformance;

use App\Http\Livewire\MainDashboard\Banner\Index as IndexBanner;
use App\Http\Livewire\MainDashboard\Banner\Create as CreateBanner;
use App\Http\Livewire\MainDashboard\Banner\Create as EditBanner;

use App\Http\Livewire\MainDashboard\Production\Index as IndexProduction;
use App\Http\Livewire\MainDashboard\Production\Create as CreateProduction;
use App\Http\Livewire\MainDashboard\Production\Create as EditProduction;

use App\Http\Livewire\Dashboard\HomeNew;
use App\Http\Controllers\DashboardFileController;


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

Route::get('dashboard/files/stream', [DashboardFileController::class, 'streamFile'])->name('dashboard.files.stream');



// Route::get('/test', function () {
//     $permissions = DB::table('permissions')
//         ->select('name', DB::raw('SUBSTRING_INDEX(name, " - ", 1) as prefix'))
//         ->get();

//     $result = [];

//     foreach ($permissions as $permission) {
//         if (!isset($result[$permission->prefix])) {
//             $result[$permission->prefix] = [
//                 'prefix' => $permission->prefix,
//                 'data' => [],
//             ];
//         }

//         $result[$permission->prefix]['data'][] = $permission->name;
//     }

//     dd($result);
// });
//Auth

Route::get('/view-excel', [ViewExcelController::class, 'index'])->name('view-excel');

// Central Entry Point & Guard Bridge Routes
Route::get('/login', Login::class)->name('login')->middleware('guest');

use App\Http\Controllers\Auth\MicrosoftSSOController;
Route::prefix('auth/microsoft')->group(function () {
    Route::get('/redirect', [MicrosoftSSOController::class, 'redirect'])->name('auth.microsoft.redirect.central');
    Route::get('/{module}/redirect', [MicrosoftSSOController::class, 'redirect'])->name('auth.microsoft.redirect');
    Route::get('/callback', [MicrosoftSSOController::class, 'callback'])->name('auth.microsoft.callback');
});

// Redirect legacy module login URLs to central login
Route::redirect('/ko/login', '/login');
Route::redirect('/kpp/login', '/login');
Route::redirect('/audit/login', '/login');
Route::redirect('/sap/login', '/login');
Route::redirect('/csms/login', '/login');
Route::redirect('/coe/login', '/login');
Route::redirect('/kplh/login', '/login');
Route::redirect('/mcu/login', '/login');
Route::redirect('/pica/login', '/login');
Route::redirect('/ibpr-and-bowtie/login', '/login');
Route::redirect('/document-system/login', '/login');
Route::redirect('/field-leadership/login', '/login');
Route::redirect('/dashboard/login', '/login');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/logout', [AuthController::class, 'logout']); // Fallback support for GET logout

Route::controller(AuthController::class)->group(function () {
    //action
    Route::middleware(['web', 'AdminDashboard'])->group(function () {
        Route::post('/change-password', 'changePassword')->name('change-password');
        Route::post('/forgot-password', 'forgotPassword')->name('forgot-password');
        Route::post('/reset-password', 'resetPassword')->name('reset-password');
    });
});

//Dashboard public
Route::get('/', indexPublic::class)->name('dashboard-public');
Route::get('/kegiatan-k3lh', KegiatanK3lkPublicIndex::class)->name('k3lh_activities_public_index');
Route::get('/kegiatan-k3lh/{slug}', KegiatanK3lkPublicShow::class)->name('k3lh_activities_public_show');

Route::get('/news-and-update', NewsAndUpdateIndex::class)->name('news_and_update_public_index');
Route::get('/news-and-update/{slug}', NewsAndUpdateShow::class)->name('news_and_update_show');

Route::get('/strategic-project', StrategicProject::class)->name('strategic_project_public_index');
Route::get('/strategic-project/{slug}', StrategicProject::class)->name('strategic_project_public_show');

Route::get('/incident-notification', IncidentNotificationIndex::class)->name('incident_notification_public_index');
Route::get('/incident-notification/{slug}', IncidentNotificationShow::class)->name('incident_notification_public_show');


Route::prefix('dashboard')->group(function () {
    Route::get('/login', Login::class)->name('dashboard-login');
});

Route::middleware(['auth:dashboard'])->get('/profile/2fa', \App\Http\Livewire\Auth\TwoFactorSetup::class)->name('profile.2fa');

//User
Route::middleware(['auth:dashboard'])->prefix('dashboard')->group(function () {
    Route::get('/', IndexPage::class)->name('dashboard-setting');

    Route::prefix('slideshow')->group(function () {
        Route::get('/', IndexSlideshow::class)->name('slideshow_index');
        Route::get('/create', CreateSlideshow::class)->name('slideshow_create');
        Route::get('/{id}/edit', EditSlideshow::class)->name('slideshow_edit');
    });

    Route::prefix('attachment')->group(function () {
        Route::get('/', IndexAttachment::class)->name('attachment_index');
        Route::get('/create', CreateAttachment::class)->name('attachment_create');
        Route::get('/{id}/edit', EditAttachment::class)->name('attachment_edit');
    });

    Route::prefix('general')->group(function () {
        Route::get('/', IndexGeneral::class)->name('general_index');
        Route::get('/create', CreateGeneral::class)->name('general_create');
        Route::get('/{id}/edit', EditGeneral::class)->name('general_edit');
    });

    Route::prefix('k3lh-award')->group(function () {
        Route::get('/', IndexK3lhAward::class)->name('k3lh_award_index');
        Route::get('/create', CreateK3lhAward::class)->name('k3lh_award_create');
        // Edit mapping:
        Route::get('/{id}/edit', EditK3lhAward::class)->name('k3lh_award_edit');
    });

    Route::prefix('k3lh-activities')->group(function () {
        Route::get('/', IndexK3lhActivities::class)->name('k3lh_activities_index');
        Route::get('/create', CreateK3lhActivities::class)->name('k3lh_activities_create');
        Route::get('/{id}/edit', EditK3lhActivities::class)->name('k3lh_activities_edit');
    });

    Route::prefix('news-and-update')->group(function () {
        Route::get('/', IndexNewsAndUpdate::class)->name('news_and_update_index');
        Route::get('/create', CreateNewsAndUpdate::class)->name('news_and_update_create');
        Route::get('/{id}/edit', EditNewsAndUpdate::class)->name('news_and_update_edit');
    });

    Route::prefix('incident-notification')->group(function () {
        Route::get('/', IndexIncidentNotification::class)->name('incident_notification_index');
        Route::get('/create', CreateIncidentNotification::class)->name('incident_notification_create');
        Route::get('/{id}/edit', EditIncidentNotification::class)->name('incident_notification_edit');
    });

    Route::prefix('strategic_project')->group(function () {
        Route::get('/', IndexStrategicProject::class)->name('strategic_project_index');
        Route::get('/create', CreateStrategicProject::class)->name('strategic_project_create');
        Route::get('/{id}/edit', EditStrategicProject::class)->name('strategic_project_edit');
    });

    Route::prefix('safety_performance')->group(function () {
        Route::get('/', IndexSafetyPerformance::class)->name('safety_performance_index');
        Route::get('/create', CreateSafetyPerformance::class)->name('safety_performance_create');
        Route::get('/{id}/edit', EditSafetyPerformance::class)->name('safety_performance_edit');
    });

    Route::prefix('performance')->group(function () {
        Route::get('/', IndexPerformance::class)->name('performance_index');
        Route::get('/create', CreatePerformance::class)->name('performance_create');
        Route::get('/{id}/edit', EditPerformance::class)->name('performance_edit');
    });

    Route::prefix('banner')->group(function () {
        Route::get('/', IndexBanner::class)->name('banner_index');
        Route::get('/create', CreateBanner::class)->name('banner_create');
        Route::get('/{id}/edit', EditBanner::class)->name('banner_edit');
    });

    Route::prefix('production')->group(function () {
        Route::get('/', IndexProduction::class)->name('production_index');
        Route::get('/create', CreateProduction::class)->name('production_create');
        Route::get('/{id}/edit', EditProduction::class)->name('production_edit');
    });
});

Route::get('/dashboard-new', HomeNew::class)->name('dashboard-new');

Route::controller(TesController::class)->middleware(['web', 'AdminDashboard'])->group(function () {
    Route::get('/storage-link', 'storageLink');
});

Route::controller(ViewController::class)->group(function () {
    Route::get('/file/view', 'FileShow')->name('file_show');
});

// Override Filament logout route to prevent invalidating the main dashboard session
Route::domain(config('filament.domain'))
    ->middleware(config('filament.middleware.base'))
    ->name('filament.')
    ->group(function () {
        Route::prefix(config('filament.core_path'))->group(function () {
            Route::post('/logout', function (\Illuminate\Http\Request $request) {
                Auth::guard('admin')->logout();
                $request->session()->regenerateToken();
                return app(\Filament\Http\Responses\Auth\Contracts\LogoutResponse::class);
            })->name('auth.logout');
        });
    });
