<?php

// Route::get('/login', Login::class)->name('login');
// // Route::get('/dashboard', Dashboard::class)->name('dashboard');

// Route::middleware(['auth:kpp'])->group(function () {
//     Route::get('/', Dashboard::class)->name('dashboard');

// 	Route::get('/rules', Rule::class)->name('rules');
// 	Route::get('/rules/detail', DetailRule::class)->name('rules.detail');
// 	Route::get('/rules/edit', EditRule::class)->name('rules.edit');
// 	Route::get('/rules/create', CreateRule::class)->name('rules.create');

// 	// Master
// 	Route::prefix('master-library')->as('master-library.')->group(function () {

// 		// Status
// 		Route::prefix('status')->as('status.')->group(function () {
// 			Route::get('/', Status::class)->name('index');
// 		});

// 		// Agency Authority
// 		Route::prefix('agency-authority')->as('agency-authority.')->group(function () {
// 			Route::get('/', AgencyAuthority::class)->name('index');
// 		});

// 		// Extraction Status
// 		Route::prefix('extraction-status')->as('extraction-status.')->group(function () {
// 			Route::get('/', ExtractionStatus::class)->name('index');
// 		});

// 		// Type
// 		Route::prefix('type')->as('type.')->group(function () {
// 			Route::get('/', Type::class)->name('index');
// 		});

// 	});

// 	// Obedience
// 	Route::prefix('obedience')->as('obedience.')->group(function () {

// 		Route::get('/', Obedience::class)->name('obedience.index');
// 		Route::get('/create', CreateObedience::class)->name('obedience.create');
// 		Route::get('/edit', EditObedience::class)->name('obedience.edit');

// 	});
// });
