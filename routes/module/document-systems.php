<?php
//
//use Illuminate\Support\Facades\Route;
//
//Route::get('/login', \App\Http\Livewire\Auth\Login::class)->name('login');
//Route::post('/login', [\App\Http\Livewire\Auth\Login::class, 'login'])->name('web.login');
//Route::middleware('auth')->group(function () {
//    Route::prefix('maker')->group(function () {
//        Route::get('/', \App\Http\Livewire\DocumentSystems\Maker\Maker::class)->name('maker');
//        Route::get('/detail-maker/{id}/{type}', \App\Http\Livewire\DocumentSystems\Maker\DetailMaker::class)->name('detail-maker');
//        // Route::get('/edit-maker/{id}', DetailMaker::class)->name('edit-maker');
//        Route::get('add-maker', \App\Http\Livewire\DocumentSystems\Maker\AddnewMaker::class)->name('add-maker');
//        Route::post('/files', [\App\Http\Livewire\DocumentSystems\Maker\AddnewMaker::class, 'saveFile'])->name('maker.files');
//        Route::get('edit-maker/{id}', \App\Http\Livewire\DocumentSystems\Maker\AddnewMaker::class)->name('edit-maker');
//        Route::post('/revision/{id}', [\App\Http\Livewire\DocumentSystems\Maker\DetailMaker::class, 'uploadTmpFile'])->name('maker.revision.upload-file');
//    });
//
//    Route::post('/logout', [\App\Http\Livewire\Auth\Login::class, 'logout'])->name('web.logout');
//    Route::get('/', \App\Http\Livewire\Dashboard\Home::class)->name('dashboard');
//    Route::get('/document-systems', \App\Http\Livewire\DocumentSystems\DashboardDocummentSystems::class)->name('document-systems');
//    Route::post('/document-systems/autocomplete-peoples', [\App\Http\Controllers\Controller::class, 'invitedPeopleList'])->name('document-systems.invited_people_list');
//    Route::post('/document-systems/autocomplete-sop', [\App\Http\Controllers\Controller::class, 'autocompleteSop'])->name('document-systems.autocomplete_sop');
//    Route::get('/document-systems/export', [\App\Http\Livewire\DocumentSystems\Maker\TableMaker::class, 'export'])->name('document-systems.export');
//    Route::get('/document-systems/obsolate', \App\Http\Livewire\DocumentSystems\Obsolate\Index::class)->name('document-systems.obsolate');
//    Route::get('/document-systems/draft', \App\Http\Livewire\DocumentSystems\Draft\Index::class)->name('document-systems.draft');
//
//    Route::prefix('jsa')->group(function () {
////        Route::get('/active', \App\Http\Livewire\Jsa\Active::class)->name('jsa.active');
////        Route::get('/draft', \App\Http\Livewire\Jsa\Draft::class)->name('jsa.draft');
////        Route::get('/create', \App\Http\Livewire\Jsa\Create::class)->name('jsa.create');
////        Route::get('/obsolate', \App\Http\Livewire\Jsa\Obsolate::class)->name('jsa.obsolate');
////        Route::get('edit/{id}', \App\Http\Livewire\Jsa\Create::class)->name('jsa.edit');
////        Route::get('/detail/{id}/{type}', \App\Http\Livewire\Jsa\Detail::class)->name('jsa.detail');
////        Route::post('/files', [\App\Http\Livewire\Jsa\Create::class, 'saveFile'])->name('jsa.files');
////        Route::post('/files/renew', [\App\Http\Livewire\Jsa\Detail::class, 'saveFile'])->name('jsa.files.renew-document');
//    });
//
//    Route::prefix('ptw')->group(function () {
//        Route::get('/active', \App\Http\Livewire\Ptw\Active::class)->name('ptw.active');
//        Route::get('/create', \App\Http\Livewire\Ptw\Create::class)->name('ptw.create');
//        Route::get('edit/{id}', \App\Http\Livewire\Ptw\Create::class)->name('ptw.edit');
//        Route::get('/detail/{id}/{type}', \App\Http\Livewire\Ptw\Detail::class)->name('ptw.detail');
//        Route::post('/files', [\App\Http\Livewire\Ptw\Create::class, 'saveFile'])->name('ptw.files');
//        Route::post('/files/renew', [\App\Http\Livewire\Ptw\Detail::class, 'saveFile'])->name('ptw.files.renew-document');
//    });
//
//    Route::prefix('master')->group(function () {
//        Route::prefix('modules')->group(function () {
//            Route::get('/', \App\Http\Livewire\DocumentSystems\Master\ModuleIndex::class)->name('master.index');
//        });
//        Route::get('/categories', \App\Http\Livewire\DocumentSystems\Master\CategoriesIndex::class)->name('master.categories.index');
//        Route::get('/mapping', \App\Http\Livewire\DocumentSystems\Master\MappingIndex::class)->name('master.mapping.index');
//        Route::get('/document-system', \App\Http\Livewire\DocumentSystems\Master\DocumentSystem::class)->name('master.document-system');
//    });
//
//    Route::prefix('audit')->group(function () {
//        Route::prefix('manage-criteria')->group(function () {
//           Route::get('/criteria', \App\Http\Livewire\Audit\ManageCriteria\Criteria\Index::class)->name('audit.manage-criteria.criteria');
//           Route::prefix('sub-criteria')->group(function () {
//               Route::get('/', \App\Http\Livewire\Audit\ManageCriteria\SubCriteria\Index::class)->name('audit.manage-criteria.sub-criteria');
//               Route::get('/create', \App\Http\Livewire\Audit\ManageCriteria\SubCriteria\Create::class)->name('audit.manage-criteria.sub-criteria.create');
//               Route::get('/edit/{id}', \App\Http\Livewire\Audit\ManageCriteria\SubCriteria\Create::class)->name('audit.manage-criteria.sub-criteria.edit');
//               Route::get('/detail/{id}', \App\Http\Livewire\Audit\ManageCriteria\SubCriteria\Detail::class)->name('audit.manage-criteria.sub-criteria.detail');
//           });
//           Route::prefix('criteria-attribute')->group(function () {
//              Route::get('/create/{sub_criteria_id}', \App\Http\Livewire\Audit\ManageCriteria\SubCriteriaAttribute\Create::class)->name('audit.manage-criteria.sub-criteria-attribute.create');
//           });
//        });
//
//        Route::get('/list', \App\Http\Livewire\Audit\List\Index::class)->name('audit.list.index');
//        Route::get('/list/detail/{list_id}', \App\Http\Livewire\Audit\List\Detail::class)->name('audit.list.detail');
//
//        Route::get('/notification-letter/create/{list_id}', \App\Http\Livewire\Audit\NotificationLetter\Create::class)->name('audit.notification-letter.create');
//    });
//});
