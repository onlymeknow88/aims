<?php

// use App\Http\Livewire\Pica\Listing\FieldLeadership\DetailFieldLeadershipPage;
// use App\Http\Livewire\Pica\Listing\FieldLeadership\EditFieldLeadershipPage;
// use App\Http\Livewire\Pica\Listing\FieldLeadership\FieldLeadershipPage;
// use App\Http\Livewire\Pica\LoginPage\LoginPage;

// use App\Http\Livewire\Mcu\Auth\Login;
// use App\Http\Livewire\Mcu\Company\Dashboard as Company;
// use App\Http\Livewire\Mcu\Docs\PrintSKK;
// use App\Http\Livewire\Mcu\Doctor\Dashboard as Doctor;
// use App\Http\Livewire\Mcu\Doctor\Details as DoctorDetail;
// use App\Http\Livewire\Mcu\Doctor\Tables as DoctorTable;
// use App\Http\Livewire\Mcu\Formula\Settings as FormulaSettings;
// use App\Http\Livewire\Mcu\MasterData;
// use App\Http\Livewire\Mcu\MedicalStaff\Forms as MedicalStaffForms;
// use App\Http\Livewire\Mcu\MedicalStaff\Dashboard as MedicalStaffDashboard;
// use App\Http\Livewire\Mcu\MedicalStaff\Details as MedicalStaffDetails;
// use App\Http\Livewire\Mcu\MedicalStaff\Tables as MedicalStaffTable;
// use App\Http\Livewire\Mcu\Patient\Dashboard as Patient;
// use App\Http\Livewire\Mcu\Patient\Details as PatientDetail;
// use Illuminate\Support\Facades\Route;

// Route::middleware(['auth.mcu'])->group(function () {
// dd(Session::get('login_email'));
// if (Session::get('login_status')) {
// Route::get('/medical-staff/', MedicalStaffDashboard::class)->name('medical-staff');

// Route::get('/', Login::class)->name('login');
// Route::get('/login', Login::class)->name('login');
// Route::get('logout/', function () {
//     Session::flush();
//     return redirect(route('mcu::login'));
// })->name('logout');
// Route::get('/medical-staff/', MedicalStaffTable::class)->name('medical-staff');
// Route::get('/medical-staff/list', MedicalStaffTable::class)->name('medical-staff-list');
// Route::get('/medical-staff/f/{type}', MedicalStaffForms::class)->name('medical-staff-f');
// Route::get('/medical-staff/e/{type}', MedicalStaffForms::class)->name('medical-staff-e');
// Route::get('/medical-staff/detail/{id}', MedicalStaffDetails::class)->name('medical-staff-detail');

// Route::get('/print-skk/{id}', PrintSKK::class)->name('print-skk');

// Route::get('/doctor/', Doctor::class)->name('doctor');
// Route::get('/doctor/list', DoctorTable::class)->name('doctor-list');
// Route::get('/doctor/detail/{id}', DoctorDetail::class)->name('doctor-detail');

// Route::get('/patient/', Patient::class)->name('patient');
// Route::get('/patient/detail/{id}', PatientDetail::class)->name('patient-detail');

// Route::get('/company/', Company::class)->name('company');

// Route::get('/formula-settings/', FormulaSettings::class)->name('formula-settings');

// Route::get('/master-data/', MasterData::class)->name('master-data');
// }
// });
