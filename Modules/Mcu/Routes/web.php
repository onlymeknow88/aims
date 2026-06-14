<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Modules\Mcu\Http\Livewire\Auth\Login;
use Modules\Mcu\Http\Livewire\Docs\Publish;
use Modules\Mcu\Http\Livewire\Doctor\Dashboard as Doctor;
use Modules\Mcu\Http\Livewire\Doctor\Details as DoctorDetail;
use Modules\Mcu\Http\Livewire\Doctor\Lists as DoctorList;
use Modules\Mcu\Http\Livewire\Formula\Lists as FormulaList;
use Modules\Mcu\Http\Livewire\MedicalStaff\Add as MedicalStaffAdd;
use Modules\Mcu\Http\Livewire\MedicalStaff\Details as MedicalStaffDetails;
use Modules\Mcu\Http\Livewire\MedicalStaff\Edit as MedicalStaffEdit;
use Modules\Mcu\Http\Livewire\MedicalStaff\Lists as MedicalStaffList;
use Modules\Mcu\Http\Livewire\MedicalStaff\ListInReview as MedicalStaffListInReview;
use Modules\Mcu\Http\Livewire\MedicalStaff\ListReviewed as MedicalStaffListReviewed;
use Modules\Mcu\Http\Livewire\Patient\Details as PatientDetail;
use Modules\Mcu\Http\Livewire\Patient\Lists as Patient;
use Modules\Mcu\Http\Livewire\Provider\Lists as ProviderList;

Route::get('/', Login::class);

Route::prefix('login')->middleware('guest')->group(function () {
    Route::get('/', Login::class)->name('login');
});

// Route::get('/login', Login::class)->name('login');

Route::get('logout/', function () {
    Session::flush();
    return redirect(route('mcu::login'));
})->name('logout');

Route::middleware(['auth:mcu'])->group(function () {

    Route::get('index', 'Modules\Mcu\Http\Controllers\McuController@index')->name('index');

    Route::get('/medical-staff', MedicalStaffList::class)->name('medical-staff');
    Route::get('/medical-staff-in-review', MedicalStaffListInReview::class)->name('medical-staff-in-review');
    Route::get('/medical-staff-reviewed', MedicalStaffListReviewed::class)->name('medical-staff-reviewed');
    // Route::get('/medical-staff/{status}', MedicalStaffList::class)->name('medical-staff-list-filter');
    // Route::get('/medical-staff/', MedicalStaffList::class)->name('medical-staff');
    Route::get('/medical-staff/add', MedicalStaffAdd::class)->name('medical-staff-add');
    Route::get('/medical-staff/edit/{id}', MedicalStaffEdit::class)->name('medical-staff-edit');
    Route::get('/medical-staff/detail/{id}', MedicalStaffDetails::class)->name('medical-staff-detail');
    Route::get('/medical-staff/detail/pdf/{id}', [MedicalStaffDetails::class, 'pdf'])->name('pdf');

    Route::get('/print-skk/{id}', [Publish::class, 'printSkk'])->name('print-skk');
    Route::get('/print-reff/{id}', [Publish::class, 'printReff'])->name('print-reff');
    Route::get('/print-skks/{id}', [Publish::class, 'printSkkS'])->name('print-skks');

    Route::get('/doctor/', Doctor::class)->name('doctor');
    Route::get('/doctor/list', DoctorList::class)->name('doctor-list');
    Route::get('/doctor/detail/{id}', DoctorDetail::class)->name('doctor-detail');

    Route::get('/patient', PatientDetail::class)->name('patient');

    Route::get('/manage-formula/', FormulaList::class)->name('manage-formula');
    Route::get('/manage-provider/', ProviderList::class)->name('manage-provider');
    Route::get('/download-file/', Publish::class)->name('download-file');
    Route::get('/download-template-excel', [Publish::class, 'downloadTemplateExcel'])->name('download-template-excel');

    // Route::get('/company/', Company::class)->name('company');
    // Route::get('/master-data/', MasterData::class)->name('master-data');
    // Route::get('/patient/', Patient::class)->name('patient');
    // Route::get('/patient/detail/{id}', PatientDetail::class)->name('patient-detail');
});
