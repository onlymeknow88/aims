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

use Modules\Audit\Http\Controllers\AnotherAttachmentController;
use Modules\Audit\Http\Controllers\ClosingAttendanceController;
use Modules\Audit\Http\Controllers\NoticeLetterController;
use Modules\Audit\Http\Controllers\GlossaryController;
use Modules\Audit\Http\Controllers\OpeningAttendanceController;
use Modules\Audit\Http\Controllers\ReportResultController;
use Modules\Audit\Http\Controllers\ResponseAuditController;
use Modules\Audit\Http\Controllers\TestController;
use Modules\Audit\Http\Controllers\AuditFileController;


use Modules\Audit\Http\Livewire\Auth\Login;
use Modules\Audit\Http\Livewire\Dashboard\Index as DashboardIndex;
use Modules\Audit\Http\Livewire\Smkp\AnotherAttachment\Index as AnotherAttachmentIndex;
use Modules\Audit\Http\Livewire\Smkp\Bundle\Create as CreateSMKP;
use Modules\Audit\Http\Livewire\Smkp\Bundle\Detail as DetailSMKP;
use Modules\Audit\Http\Livewire\Smkp\Bundle\Index as SMKPIndex;
use Modules\Audit\Http\Livewire\Smkp\ClosingAttendance\Index as ClosingAttendanceIndex;
use Modules\Audit\Http\Livewire\Smkp\CriteriaAudit\Detail as CriteriaAuditDetail;
use Modules\Audit\Http\Livewire\Smkp\CriteriaAudit\Index as CriteriaAuditIndex;
use Modules\Audit\Http\Livewire\Smkp\ConfirmanceCriteriaAudit\Index as  ConfirmanceCriteriaAuditIndex;
use Modules\Audit\Http\Livewire\Smkp\ConfirmanceCriteriaAudit\Export as ConfirmanceCriteriaAuditExport;
use Modules\Audit\Http\Livewire\Smkp\FixRecomendationAudit\Index as FixRecomendationAuditIndex;
use Modules\Audit\Http\Livewire\smkp\NonConfirmanceCriteriaAudit\Index as NonConfirmanceCriteriaAuditIndex;
use Modules\Audit\Http\Livewire\smkp\NonConfirmanceCriteriaAudit\Detail as NonConfirmanceCriteriaAuditDetail;
use Modules\Audit\Http\Livewire\smkp\NonConfirmanceCriteriaAudit\FixPlan as NonConfirmanceCriteriaAuditFixplan;
use Modules\Audit\Http\Livewire\Smkp\ImplementationReport\Index as ImplementationReportIndex;
use Modules\Audit\Http\Livewire\Smkp\ImplementationSchedule\Index as ImplementationScheduleIndex;
use Modules\Audit\Http\Livewire\Smkp\MethodAndSample\Detail as MethodAndSampleDetail;
use Modules\Audit\Http\Livewire\Smkp\MethodAndSample\Index as MethodAndSampleIndex;
use Modules\Audit\Http\Livewire\Smkp\NoticeLetter\Index as NoticeLetterIndex;
use Modules\Audit\Http\Livewire\Smkp\OpeningAttendance\Index as OpeningAttendanceIndex;
use Modules\Audit\Http\Livewire\Smkp\Plan\Index as AuditPlanIndex;
use Modules\Audit\Http\Livewire\Smkp\ReportResult\Index as ReportResultIndex;
use Modules\Audit\Http\Livewire\Smkp\ResponseAudit\Index as ResponseAuditIndex;
use Modules\Audit\Http\Livewire\MasterData\Manday\Index as MandayIndex;
use Modules\Audit\Http\Livewire\MasterData\Manday\Create as CreateMandays;
use Modules\Audit\Http\Livewire\MasterData\Manday\Edit as EditMandays;
use Modules\Audit\Http\Livewire\Smkp\Dashboard\Index as SMKPDashboardIndex;
use Modules\Audit\Http\Livewire\Smkp\Glossary\Index as SMKPGlossaryIndex;

use Modules\Audit\Http\Livewire\Iso45001\Bundle\Index as ISO45001Index;
use Modules\Audit\Http\Livewire\Iso45001\Bundle\Create as ISO45001Create;
use Modules\Audit\Http\Livewire\Iso45001\Bundle\Detail as ISO45001Detail;
use Modules\Audit\Http\Livewire\iso\CriteriaAudit\Index as ISOCriteriaAuditIndex;
use Modules\Audit\Http\Livewire\Iso45001\CriteriaAudit\Index as ISO45001CriteriaAuditIndex;
use Modules\Audit\Http\Livewire\Iso45001\CriteriaAudit\Detail as ISO45001CriteriaAuditDetail;
use Modules\Audit\Http\Livewire\Iso45001\NoticeLetter\Index as Iso45001NoticeLetterIndex;
use Modules\Audit\Http\Livewire\Iso45001\Plan\Index as Iso45001AuditPlanIndex;
use Modules\Audit\Http\Livewire\Iso45001\ImplementationSchedule\Index as Iso45001ImplementationScheduleIndex;
use Modules\Audit\Http\Livewire\Iso45001\ConfirmanceCriteriaAudit\Index as  Iso45001ConfirmanceCriteriaAuditIndex;
use Modules\Audit\Http\Livewire\Iso45001\NonConfirmanceCriteriaAudit\Index as Iso45001NonConfirmanceCriteriaAuditIndex;
use Modules\Audit\Http\Livewire\Iso45001\NonConfirmanceCriteriaAudit\Detail as Iso45001NonConfirmanceCriteriaAuditDetail;
use Modules\Audit\Http\Livewire\Iso45001\FixRecomendationAudit\Index as Iso45001FixRecomendationAuditIndex;
use Modules\Audit\Http\Livewire\Iso45001\NonConfirmanceCriteriaAudit\FixPlan as Iso45001NonConfirmanceCriteriaAuditFixplan;
use Modules\Audit\Http\Livewire\Iso45001\Glossary\Index as ISO45001GlossaryIndex;

use Modules\Audit\Http\Livewire\Iso45001\OpeningAttendance\Index as Iso45001OpeningAttendanceIndex;
use Modules\Audit\Http\Livewire\Iso45001\ClosingAttendance\Index as Iso45001ClosingAttendanceIndex;
use Modules\Audit\Http\Livewire\Iso45001\ResponseAudit\Index as Iso45001ResponseAuditIndex;
use Modules\Audit\Http\Livewire\Iso45001\ReportResult\Index as Iso45001ReportResultIndex;
use Modules\Audit\Http\Livewire\Iso45001\AnotherAttachment\Index as Iso45001AnotherAttachmentIndex;
use Modules\Audit\Http\Livewire\Iso45001\Dashboard\Index as ISO45001DashboardIndex;


use Modules\Audit\Http\Livewire\Smk3\Bundle\Index as SMK3Index;
use Modules\Audit\Http\Livewire\Smk3\Bundle\Create as SMK3Create;
use Modules\Audit\Http\Livewire\Smk3\Bundle\Detail as SMK3Detail;
use Modules\Audit\Http\Livewire\Smk3\CriteriaAudit\Index as SMK3CriteriaAuditIndex;
use Modules\Audit\Http\Livewire\Smk3\CriteriaAudit\Detail as SMK3CriteriaAuditDetail;
use Modules\Audit\Http\Livewire\Smk3\NoticeLetter\Index as SMK3NoticeLetterIndex;
use Modules\Audit\Http\Livewire\Smk3\Plan\Index as SMK3AuditPlanIndex;
use Modules\Audit\Http\Livewire\Smk3\ImplementationSchedule\Index as SMK3ImplementationScheduleIndex;
use Modules\Audit\Http\Livewire\Smk3\ConfirmanceCriteriaAudit\Index as  SMK3ConfirmanceCriteriaAuditIndex;
use Modules\Audit\Http\Livewire\Smk3\NonConfirmanceCriteriaAudit\Index as SMK3NonConfirmanceCriteriaAuditIndex;
use Modules\Audit\Http\Livewire\Smk3\NonConfirmanceCriteriaAudit\Detail as SMK3NonConfirmanceCriteriaAuditDetail;
use Modules\Audit\Http\Livewire\Smk3\FixRecomendationAudit\Index as SMK3FixRecomendationAuditIndex;
use Modules\Audit\Http\Livewire\Smk3\NonConfirmanceCriteriaAudit\FixPlan as SMK3NonConfirmanceCriteriaAuditFixplan;
use Modules\Audit\Http\Livewire\Smk3\OpeningAttendance\Index as SMK3OpeningAttendanceIndex;
use Modules\Audit\Http\Livewire\Smk3\ClosingAttendance\Index as SMK3ClosingAttendanceIndex;
use Modules\Audit\Http\Livewire\Smk3\ResponseAudit\Index as SMK3ResponseAuditIndex;
use Modules\Audit\Http\Livewire\Smk3\ReportResult\Index as SMK3ReportResultIndex;
use Modules\Audit\Http\Livewire\Smk3\AnotherAttachment\Index as SMK3AnotherAttachmentIndex;
use Modules\Audit\Http\Livewire\Smk3\Dashboard\Index as SMK3DashboardIndex;
use Modules\Audit\Http\Livewire\Smk3\Glossary\Index as SMK3GlossaryIndex;

use Modules\Audit\Http\Livewire\Iso9001\Bundle\Index as ISO9001Index;
use Modules\Audit\Http\Livewire\Iso9001\Bundle\Create as ISO9001Create;
use Modules\Audit\Http\Livewire\Iso9001\Bundle\Detail as ISO9001Detail;
use Modules\Audit\Http\Livewire\Iso9001\CriteriaAudit\Index as ISO9001CriteriaAuditIndex;
use Modules\Audit\Http\Livewire\Iso9001\CriteriaAudit\Detail as ISO9001CriteriaAuditDetail;
use Modules\Audit\Http\Livewire\Iso9001\NoticeLetter\Index as ISO9001NoticeLetterIndex;
use Modules\Audit\Http\Livewire\Iso9001\Plan\Index as ISO9001AuditPlanIndex;
use Modules\Audit\Http\Livewire\Iso9001\ImplementationSchedule\Index as ISO9001ImplementationScheduleIndex;
use Modules\Audit\Http\Livewire\Iso9001\ConfirmanceCriteriaAudit\Index as  ISO9001ConfirmanceCriteriaAuditIndex;
use Modules\Audit\Http\Livewire\Iso9001\NonConfirmanceCriteriaAudit\Index as ISO9001NonConfirmanceCriteriaAuditIndex;
use Modules\Audit\Http\Livewire\Iso9001\NonConfirmanceCriteriaAudit\Detail as ISO9001NonConfirmanceCriteriaAuditDetail;
use Modules\Audit\Http\Livewire\Iso9001\FixRecomendationAudit\Index as ISO9001FixRecomendationAuditIndex;
use Modules\Audit\Http\Livewire\Iso9001\NonConfirmanceCriteriaAudit\FixPlan as ISO9001NonConfirmanceCriteriaAuditFixplan;
use Modules\Audit\Http\Livewire\Iso9001\OpeningAttendance\Index as ISO9001OpeningAttendanceIndex;
use Modules\Audit\Http\Livewire\Iso9001\ClosingAttendance\Index as ISO9001ClosingAttendanceIndex;
use Modules\Audit\Http\Livewire\Iso9001\ResponseAudit\Index as ISO9001ResponseAuditIndex;
use Modules\Audit\Http\Livewire\Iso9001\ReportResult\Index as ISO9001ReportResultIndex;
use Modules\Audit\Http\Livewire\Iso9001\AnotherAttachment\Index as ISO9001AnotherAttachmentIndex;
use Modules\Audit\Http\Livewire\Iso9001\Dashboard\Index as ISO9001DashboardIndex;
use Modules\Audit\Http\Livewire\Iso9001\Glossary\Index as ISO9001GlossaryIndex;


use Modules\Audit\Http\Livewire\Iso14001\Bundle\Index as ISO14001Index;
use Modules\Audit\Http\Livewire\Iso14001\Bundle\Create as ISO14001Create;
use Modules\Audit\Http\Livewire\Iso14001\Bundle\Detail as ISO14001Detail;
use Modules\Audit\Http\Livewire\Iso14001\CriteriaAudit\Index as ISO14001CriteriaAuditIndex;
use Modules\Audit\Http\Livewire\Iso14001\CriteriaAudit\Detail as ISO14001CriteriaAuditDetail;
use Modules\Audit\Http\Livewire\Iso14001\NoticeLetter\Index as ISO14001NoticeLetterIndex;
use Modules\Audit\Http\Livewire\Iso14001\Plan\Index as ISO14001AuditPlanIndex;
use Modules\Audit\Http\Livewire\Iso14001\ImplementationSchedule\Index as ISO14001ImplementationScheduleIndex;
use Modules\Audit\Http\Livewire\Iso14001\ConfirmanceCriteriaAudit\Index as  ISO14001ConfirmanceCriteriaAuditIndex;
use Modules\Audit\Http\Livewire\Iso14001\NonConfirmanceCriteriaAudit\Index as ISO14001NonConfirmanceCriteriaAuditIndex;
use Modules\Audit\Http\Livewire\Iso14001\NonConfirmanceCriteriaAudit\Detail as ISO14001NonConfirmanceCriteriaAuditDetail;
use Modules\Audit\Http\Livewire\Iso14001\FixRecomendationAudit\Index as ISO14001FixRecomendationAuditIndex;
use Modules\Audit\Http\Livewire\Iso14001\NonConfirmanceCriteriaAudit\FixPlan as ISO14001NonConfirmanceCriteriaAuditFixplan;
use Modules\Audit\Http\Livewire\Iso14001\OpeningAttendance\Index as ISO14001OpeningAttendanceIndex;
use Modules\Audit\Http\Livewire\Iso14001\ClosingAttendance\Index as ISO14001ClosingAttendanceIndex;
use Modules\Audit\Http\Livewire\Iso14001\ResponseAudit\Index as ISO14001ResponseAuditIndex;
use Modules\Audit\Http\Livewire\Iso14001\ReportResult\Index as ISO14001ReportResultIndex;
use Modules\Audit\Http\Livewire\Iso14001\AnotherAttachment\Index as ISO14001AnotherAttachmentIndex;
use Modules\Audit\Http\Livewire\Iso14001\Dashboard\Index as ISO14001DashboardIndex;
use Modules\Audit\Http\Livewire\Iso14001\Glossary\Index as ISO14001GlossaryIndex;

Route::as('audit::')->group(function () {
    Route::middleware('guest:audit')->group(function () {
        Route::prefix('auth')->as('auth.')->group(function () {
            Route::get('login', Login::class)->name('login');
        });
    });
    Route::middleware('auth:audit')->group(function () {

        Route::get("/", DashboardIndex::class)->name('dashboard');
        Route::get('files/{id}/sas', [AuditFileController::class, 'getFileSasUri'])->name('files.sas-uri');
        Route::get('files/{id}/preview', [AuditFileController::class, 'previewFile'])->name('files.preview');
        Route::get("/glossary/smkp", SMKPGlossaryIndex::class)->name('glossary-smkp');
        Route::get("/glossary/smk3", SMK3GlossaryIndex::class)->name('glossary-smk3');
        Route::get("/glossary/iso45001", ISO45001GlossaryIndex::class)->name('glossary-iso45001');
        Route::get("/glossary/iso14001", ISO14001GlossaryIndex::class)->name('glossary-iso14001');
        Route::get("/glossary/iso9001", ISO9001GlossaryIndex::class)->name('glossary-iso9001');
        Route::get('/glossary/download/{id}', [GlossaryController::class, 'download'])->name('glossary.download');


        Route::prefix('/iso14001')->as('iso14001.')->group(function () {
            Route::get('', ISO14001Index::class)->name('index');
            Route::get('/dashboard', ISO14001DashboardIndex::class)->name('dashboard');
            Route::get('create', ISO14001Create::class)->name('create');
            Route::prefix('detail/{id}')->as('detail.')->group(function () {
                Route::get('', ISO14001Detail::class)->name('index');
                Route::get('/criteria-audit', ISO14001CriteriaAuditIndex::class)->name('criteria-audit.index');
                Route::get('/criteria-audit/{criteria_id}',ISO14001CriteriaAuditDetail::class)->name('criteria-audit.detail');
                Route::get('/notice-letter', ISO14001NoticeLetterIndex::class)->name('notice-letter.index');
                Route::get('/notice-letter/download/{notice_id}', [NoticeLetterController::class, 'download'])->name('notice-letter.download');
                Route::get('/audit-plan', ISO14001AuditPlanIndex::class)->name('audit-plan');
                Route::get('/implementation-schedule', ISO14001ImplementationScheduleIndex::class)->name('implementation-schedule.index');
                Route::get('/implementation-schedule-export-word', [ISO14001ImplementationScheduleIndex::class,'generateWord'])->name('implementation-schedule.export-word');
                Route::get('/criteria-audit-conformance', ISO14001ConfirmanceCriteriaAuditIndex::class)->name('criteria-audit-conformance.index');
                Route::get('/criteria-audit-conformance-export', [ISO14001ConfirmanceCriteriaAuditIndex::class,'generatePDF'])->name('criteria-audit-conformance.export');
                Route::get('/criteria-audit-conformance-export-word', [ISO14001ConfirmanceCriteriaAuditIndex::class,'generateWord'])->name('criteria-audit-conformance.export-word');

                Route::get('/criteria-audit-non-conformance', ISO14001NonConfirmanceCriteriaAuditIndex::class)->name('criteria-audit-non-conformance.index');
                Route::get('/criteria-audit-non-conformance-export', [ISO14001NonConfirmanceCriteriaAuditIndex::class,'generatePDF'])->name('criteria-audit-non-conformance.export');
                Route::get('/criteria-audit-non-conformance-export-word', [ISO14001NonConfirmanceCriteriaAuditIndex::class,'generateWord'])->name('criteria-audit-non-conformance.export-word');
                Route::get('/criteria-audit-non-conformance/fix-plan', ISO14001NonConfirmanceCriteriaAuditFixplan::class)->name('criteria-audit-non-conformance.fix-plan');
                Route::get('/criteria-audit-non-conformance-fix-plan-export', [ISO14001NonConfirmanceCriteriaAuditFixplan::class,'generatePDF'])->name('criteria-audit-non-conformance.fix-plan.export');

                Route::get('/criteria-audit-non-conformance/{non_conformance_id}', ISO14001NonConfirmanceCriteriaAuditDetail::class)->name('criteria-audit-non-conformance.detail');
                Route::get('/criteria-audit-non-conformance/{non_conformance_id}/export', [ISO14001NonConfirmanceCriteriaAuditDetail::class,'generatePDF'])->name('criteria-audit-non-conformance.detail.export');
                Route::get('/criteria-audit-non-conformance/{non_conformance_id}/fix-export', [ISO14001NonConfirmanceCriteriaAuditDetail::class,'exportFixPDF'])->name('criteria-audit-non-conformance.detail.fix-export');

                Route::get('/audit-fix-recommendation', ISO14001FixRecomendationAuditIndex::class)->name('fix-recommendation-audit.index');
                Route::get('/audit-fix-recommendation-export', [ISO14001FixRecomendationAuditIndex::class,'generatePDF'])->name('audit-fix-recommendation.export');
                Route::get('/audit-fix-recommendation-export-word', [ISO14001FixRecomendationAuditIndex::class,'generateWord'])->name('audit-fix-recommendation.export-word');
                Route::get('/opening-attendance', ISO14001OpeningAttendanceIndex::class)->name('opening-attendance.index');
                Route::get('/opening-attendance/download/{notice_id}', [OpeningAttendanceController::class, 'download'])->name('opening-attendance.download');
                Route::get('/closing-attendance', ISO14001ClosingAttendanceIndex::class)->name('closing-attendance.index');
                Route::get('/closing-attendance/download/{notice_id}', [ClosingAttendanceController::class, 'download'])->name('closing-attendance.download');
                Route::get('/response-audit', ISO14001ResponseAuditIndex::class)->name('response-audit.index');
                Route::get('/response-audit/download/{notice_id}', [ResponseAuditController::class, 'download'])->name('response-audit.download');
                Route::get('/report-result',ISO14001ReportResultIndex::class)->name('report-result.index');
                Route::get('/report-result/download/{notice_id}', [ReportResultController::class, 'download'])->name('report-result.download');
                Route::get('/another-attachment', ISO14001AnotherAttachmentIndex::class)->name('another-attachment.index');
                Route::get('/another-attachment/download/{notice_id}', [AnotherAttachmentController::class, 'download'])->name('another-attachment.download');


            });
        });

        Route::prefix('/iso9001')->as('iso9001.')->group(function () {
            Route::get('', ISO9001Index::class)->name('index');
            Route::get('/dashboard', ISO9001DashboardIndex::class)->name('dashboard');
            Route::get('create', ISO9001Create::class)->name('create');
            Route::prefix('detail/{id}')->as('detail.')->group(function () {
                Route::get('', ISO9001Detail::class)->name('index');
                Route::get('/criteria-audit', ISO9001CriteriaAuditIndex::class)->name('criteria-audit.index');
                Route::get('/criteria-audit/{criteria_id}',ISO9001CriteriaAuditDetail::class)->name('criteria-audit.detail');
                Route::get('/notice-letter', ISO9001NoticeLetterIndex::class)->name('notice-letter.index');
                Route::get('/notice-letter/download/{notice_id}', [NoticeLetterController::class, 'download'])->name('notice-letter.download');

                Route::get('/audit-plan', ISO9001AuditPlanIndex::class)->name('audit-plan');
                Route::get('/implementation-schedule', ISO9001ImplementationScheduleIndex::class)->name('implementation-schedule.index');
                Route::get('/implementation-schedule-export-word', [ISO9001ImplementationScheduleIndex::class,'generateWord'])->name('implementation-schedule.export-word');
                Route::get('/criteria-audit-conformance', ISO9001ConfirmanceCriteriaAuditIndex::class)->name('criteria-audit-conformance.index');
                Route::get('/criteria-audit-conformance-export', [ISO9001ConfirmanceCriteriaAuditIndex::class,'generatePDF'])->name('criteria-audit-conformance.export');
                Route::get('/criteria-audit-conformance-export-word', [ISO9001ConfirmanceCriteriaAuditIndex::class,'generateWord'])->name('criteria-audit-conformance.export-word');

                Route::get('/criteria-audit-non-conformance', ISO9001NonConfirmanceCriteriaAuditIndex::class)->name('criteria-audit-non-conformance.index');
                Route::get('/criteria-audit-non-conformance-export', [Iso9001NonConfirmanceCriteriaAuditIndex::class,'generatePDF'])->name('criteria-audit-non-conformance.export');
                Route::get('/criteria-audit-non-conformance-export-word', [Iso9001NonConfirmanceCriteriaAuditIndex::class,'generateWord'])->name('criteria-audit-non-conformance.export-word');

                Route::get('/criteria-audit-non-conformance/fix-plan', Iso9001NonConfirmanceCriteriaAuditIndex::class)->name('criteria-audit-non-conformance.fix-plan');
                Route::get('/criteria-audit-non-conformance-fix-plan-export', [Iso9001NonConfirmanceCriteriaAuditIndex::class,'generatePDF'])->name('criteria-audit-non-conformance.fix-plan.export');
                Route::get('/criteria-audit-non-conformance-fix-plan-export-word', [Iso9001NonConfirmanceCriteriaAuditIndex::class,'generateWord'])->name('criteria-audit-non-conformance.fix-plan.export-word');

                Route::get('/criteria-audit-non-conformance/{non_conformance_id}', ISO9001NonConfirmanceCriteriaAuditDetail::class)->name('criteria-audit-non-conformance.detail');
                Route::get('/criteria-audit-non-conformance/{non_conformance_id}/export', [ISO9001NonConfirmanceCriteriaAuditDetail::class,'generatePDF'])->name('criteria-audit-non-conformance.detail.export');
                Route::get('/criteria-audit-non-conformance/{non_conformance_id}/fix-export', [ISO9001NonConfirmanceCriteriaAuditDetail::class,'exportFixPDF'])->name('criteria-audit-non-conformance.detail.fix-export');

                Route::get('/audit-fix-recommendation', ISO9001FixRecomendationAuditIndex::class)->name('fix-recommendation-audit.index');
                Route::get('/audit-fix-recommendation-export', [ISO9001FixRecomendationAuditIndex::class,'generatePDF'])->name('audit-fix-recommendation.export');
                Route::get('/audit-fix-recommendation-export-word', [ISO9001FixRecomendationAuditIndex::class,'generateWord'])->name('audit-fix-recommendation.export-word');
                Route::get('/opening-attendance', ISO9001OpeningAttendanceIndex::class)->name('opening-attendance.index');
                Route::get('/opening-attendance/download/{notice_id}', [OpeningAttendanceController::class, 'download'])->name('opening-attendance.download');
                Route::get('/closing-attendance', ISO9001ClosingAttendanceIndex::class)->name('closing-attendance.index');
                Route::get('/closing-attendance/download/{notice_id}', [ClosingAttendanceController::class, 'download'])->name('closing-attendance.download');
                Route::get('/response-audit', ISO9001ResponseAuditIndex::class)->name('response-audit.index');
                Route::get('/response-audit/download/{notice_id}', [ResponseAuditController::class, 'download'])->name('response-audit.download');
                Route::get('/report-result',ISO9001ReportResultIndex::class)->name('report-result.index');
                Route::get('/report-result/download/{notice_id}', [ReportResultController::class, 'download'])->name('report-result.download');
                Route::get('/another-attachment', ISO9001AnotherAttachmentIndex::class)->name('another-attachment.index');
                Route::get('/another-attachment/download/{notice_id}', [AnotherAttachmentController::class, 'download'])->name('another-attachment.download');


            });
        });

        Route::prefix('/smk3')->as('smk3.')->group(function () {
            Route::get('', SMK3Index::class)->name('index');
            Route::get('/dashboard', SMK3DashboardIndex::class)->name('dashboard');
            Route::get('create', SMK3Create::class)->name('create');
            Route::prefix('detail/{id}')->as('detail.')->group(function () {
                Route::get('', SMK3Detail::class)->name('index');
                Route::get('/smk3-criteria-audit', SMK3CriteriaAuditIndex::class)->name('criteria-audit.index');
                Route::get('/smk3-criteria-audit/{criteria_id}', SMK3CriteriaAuditDetail::class)->name('criteria-audit.detail');
                Route::get('/notice-letter', SMK3NoticeLetterIndex::class)->name('notice-letter.index');
                Route::get('/notice-letter/download/{notice_id}', [NoticeLetterController::class, 'download'])->name('notice-letter.download');

                Route::get('/audit-plan', SMK3AuditPlanIndex::class)->name('audit-plan');
                Route::get('/implementation-schedule', SMK3ImplementationScheduleIndex::class)->name('implementation-schedule.index');
                Route::get('/implementation-schedule-export-word', [SMK3ImplementationScheduleIndex::class,'generateWord'])->name('implementation-schedule.export-word');
                Route::get('/criteria-audit-confirmance', SMK3ConfirmanceCriteriaAuditIndex::class)->name('criteria-audit-confirmance.index');
                Route::get('/criteria-audit-conformance-export', [SMK3ConfirmanceCriteriaAuditIndex::class,'generatePDF'])->name('criteria-audit-conformance.export');
                Route::get('/criteria-audit-conformance-export-word', [SMK3ConfirmanceCriteriaAuditIndex::class,'generateWord'])->name('criteria-audit-conformance.export-word');

                Route::get('/criteria-audit-non-conformance', SMK3NonConfirmanceCriteriaAuditIndex::class)->name('criteria-audit-non-conformance.index');
                Route::get('/criteria-audit-non-conformance-export', [SMK3NonConfirmanceCriteriaAuditIndex::class,'generatePDF'])->name('criteria-audit-non-conformance.export');
                Route::get('/criteria-audit-non-conformance-export-word', [SMK3NonConfirmanceCriteriaAuditIndex::class,'generateWord'])->name('criteria-audit-non-conformance.export-word');

                Route::get('/criteria-audit-non-conformance/fix-plan', SMK3NonConfirmanceCriteriaAuditFixplan::class)->name('criteria-audit-non-conformance.fix-plan');
                Route::get('/criteria-audit-non-conformance-fix-plan-export', [SMK3NonConfirmanceCriteriaAuditFixplan::class,'generatePDF'])->name('criteria-audit-non-conformance.fix-plan.export');
                Route::get('/criteria-audit-non-conformance-fix-plan-export-word', [SMK3NonConfirmanceCriteriaAuditFixplan::class,'generateWord'])->name('audit-fix-recommendation.export-word');


                Route::get('/criteria-audit-non-conformance/{non_conformance_id}', SMK3NonConfirmanceCriteriaAuditDetail::class)->name('criteria-audit-non-conformance.detail');
                Route::get('/criteria-audit-non-conformance/{non_conformance_id}/export', [SMK3NonConfirmanceCriteriaAuditDetail::class,'generatePDF'])->name('criteria-audit-non-conformance.detail.export');
                Route::get('/criteria-audit-non-conformance/{non_conformance_id}/fix-export', [SMK3NonConfirmanceCriteriaAuditDetail::class,'exportFixPDF'])->name('criteria-audit-non-conformance.detail.fix-export');

                Route::get('/audit-fix-recommendation', SMK3FixRecomendationAuditIndex::class)->name('fix-recommendation-audit.index');
                Route::get('/audit-fix-recommendation-export', [SMK3FixRecomendationAuditIndex::class,'generatePDF'])->name('audit-fix-recommendation.export');
                Route::get('/audit-fix-recommendation-export-word', [SMK3FixRecomendationAuditIndex::class,'generateWord'])->name('criteria-audit-non-conformance.fix-plan.export-word');
                Route::get('/opening-attendance', SMK3OpeningAttendanceIndex::class)->name('opening-attendance.index');
                Route::get('/opening-attendance/download/{notice_id}', [OpeningAttendanceController::class, 'download'])->name('opening-attendance.download');
                Route::get('/closing-attendance', SMK3ClosingAttendanceIndex::class)->name('closing-attendance.index');
                Route::get('/closing-attendance/download/{notice_id}', [ClosingAttendanceController::class, 'download'])->name('closing-attendance.download');
                Route::get('/response-audit', SMK3ResponseAuditIndex::class)->name('response-audit.index');
                Route::get('/response-audit/download/{notice_id}', [ResponseAuditController::class, 'download'])->name('response-audit.download');
                Route::get('/report-result', SMK3ReportResultIndex::class)->name('report-result.index');
                Route::get('/report-result/download/{notice_id}', [ReportResultController::class, 'download'])->name('report-result.download');
                Route::get('/another-attachment', SMK3AnotherAttachmentIndex::class)->name('another-attachment.index');
                Route::get('/another-attachment/download/{notice_id}', [AnotherAttachmentController::class, 'download'])->name('another-attachment.download');


            });
        });

        Route::prefix('/iso45001')->as('iso45001.')->group(function () {
            Route::get('', ISO45001Index::class)->name('index');
            Route::get('/dashboard', ISO45001DashboardIndex::class)->name('dashboard');
            Route::get('create', ISO45001Create::class)->name('create');
            Route::prefix('detail/{id}')->as('detail.')->group(function () {
                Route::get('', ISO45001Detail::class)->name('index');
                Route::get('/iso45001-criteria-audit', ISO45001CriteriaAuditIndex::class)->name('criteria-audit.index');
                Route::get('/iso45001-criteria-audit/{criteria_id}', ISO45001CriteriaAuditDetail::class)->name('criteria-audit.detail');
                Route::get('/notice-letter', Iso45001NoticeLetterIndex::class)->name('notice-letter.index');
                Route::get('/notice-letter/download/{notice_id}', [NoticeLetterController::class, 'download'])->name('notice-letter.download');

                Route::get('/audit-plan', Iso45001AuditPlanIndex::class)->name('audit-plan');
                Route::get('/implementation-schedule', Iso45001ImplementationScheduleIndex::class)->name('implementation-schedule.index');
                Route::get('/implementation-schedule-export-word', [Iso45001ImplementationScheduleIndex::class,'generateWord'])->name('implementation-schedule.export-word');
                Route::get('/criteria-audit-confirmance', Iso45001ConfirmanceCriteriaAuditIndex::class)->name('criteria-audit-confirmance.index');
                Route::get('/criteria-audit-conformance-export', [Iso45001ConfirmanceCriteriaAuditIndex::class,'generatePDF'])->name('criteria-audit-conformance.export');
                Route::get('/criteria-audit-conformance-export-word', [Iso45001ConfirmanceCriteriaAuditIndex::class,'generateWord'])->name('criteria-audit-conformance.export-word');

                Route::get('/criteria-audit-non-conformance', Iso45001NonConfirmanceCriteriaAuditIndex::class)->name('criteria-audit-non-conformance.index');
                Route::get('/criteria-audit-non-conformance-export', [Iso45001NonConfirmanceCriteriaAuditIndex::class,'generatePDF'])->name('criteria-audit-non-conformance.export');
                Route::get('/criteria-audit-non-conformance-export', [Iso45001NonConfirmanceCriteriaAuditIndex::class,'generateWord'])->name('criteria-audit-non-conformance.export-word');

                Route::get('/criteria-audit-non-conformance/fix-plan', Iso45001NonConfirmanceCriteriaAuditFixplan::class)->name('criteria-audit-non-conformance.fix-plan');
                Route::get('/criteria-audit-non-conformance-fix-plan-export', [Iso45001NonConfirmanceCriteriaAuditFixplan::class,'generatePDF'])->name('criteria-audit-non-conformance.fix-plan.export');
                Route::get('/criteria-audit-non-conformance-fix-plan-export-word', [Iso45001NonConfirmanceCriteriaAuditFixplan::class,'generateWord'])->name('criteria-audit-non-conformance.fix-plan.export-word');


                Route::get('/criteria-audit-non-conformance/{non_conformance_id}', Iso45001NonConfirmanceCriteriaAuditDetail::class)->name('criteria-audit-non-conformance.detail');
                Route::get('/criteria-audit-non-conformance/{non_conformance_id}/export', [Iso45001NonConfirmanceCriteriaAuditDetail::class,'generatePDF'])->name('criteria-audit-non-conformance.detail.export');
                Route::get('/criteria-audit-non-conformance/{non_conformance_id}/fix-export', [Iso45001NonConfirmanceCriteriaAuditDetail::class,'exportFixPDF'])->name('criteria-audit-non-conformance.detail.fix-export');

                Route::get('/audit-fix-recommendation', Iso45001FixRecomendationAuditIndex::class)->name('fix-recommendation-audit.index');
                Route::get('/audit-fix-recommendation-export', [Iso45001FixRecomendationAuditIndex::class,'generatePDF'])->name('audit-fix-recommendation.export');
                Route::get('/audit-fix-recommendation-export-word', [Iso45001FixRecomendationAuditIndex::class,'generatePDF'])->name('audit-fix-recommendation.export-word');

                Route::get('/opening-attendance', Iso45001OpeningAttendanceIndex::class)->name('opening-attendance.index');
                Route::get('/opening-attendance/download/{notice_id}', [OpeningAttendanceController::class, 'download'])->name('opening-attendance.download');

                Route::get('/closing-attendance', Iso45001ClosingAttendanceIndex::class)->name('closing-attendance.index');
                Route::get('/closing-attendance/download/{notice_id}', [ClosingAttendanceController::class, 'download'])->name('closing-attendance.download');

                Route::get('/response-audit', Iso45001ResponseAuditIndex::class)->name('response-audit.index');
                Route::get('/response-audit/download/{notice_id}', [ResponseAuditController::class, 'download'])->name('response-audit.download');

                Route::get('/report-result', Iso45001ReportResultIndex::class)->name('report-result.index');
                Route::get('/report-result/download/{notice_id}', [ReportResultController::class, 'download'])->name('report-result.download');

                Route::get('/another-attachment', Iso45001AnotherAttachmentIndex::class)->name('another-attachment.index');
                Route::get('/another-attachment/download/{notice_id}', [AnotherAttachmentController::class, 'download'])->name('another-attachment.download');

            });
        });


        Route::prefix('/smkp')->as('smkp.')->group(function () {
            Route::get('', SMKPIndex::class)->name('index');
            Route::get('/dashboard', SMKPDashboardIndex::class)->name('dashboard');

            Route::get('create', CreateSMKP::class)->name('create');
            Route::prefix('detail/{id}')->as('detail.')->group(function () {
                Route::get('', DetailSMKP::class)->name('index');
                Route::get('/dashboard', DashboardIndex::class)->name('dashboard');

                Route::get('/location', \Modules\Audit\Http\Livewire\Smkp\Location\Index::class)->name('master-location');

                Route::get('/audit-plan', AuditPlanIndex::class)->name('audit-plan');

                Route::get('/notice-letter', NoticeLetterIndex::class)->name('notice-letter.index');
                Route::get('/notice-letter/download/{notice_id}', [NoticeLetterController::class, 'download'])->name('notice-letter.download');

                Route::get('/implementation-report', ImplementationReportIndex::class)->name('implementation-report.index');
                Route::get('/implementation-report-export-word', [ImplementationReportIndex::class,'generateWord'])->name('implementation-report.export-word');

                Route::get('/implementation-schedule', ImplementationScheduleIndex::class)->name('implementation-schedule.index');
                Route::get('/implementation-schedule-export-word', [ImplementationScheduleIndex::class,'generateWord'])->name('implementation-schedule.export-word');

                Route::get('/method-and-sample', MethodAndSampleIndex::class)->name('method-and-sample.index');
                Route::get('/method-and-sample/{criteria_id}', MethodAndSampleDetail::class)->name('method-and-sample.detail');

                Route::get('/criteria-audit', CriteriaAuditIndex::class)->name('criteria-audit.index');
                Route::get('/criteria-audit-export-xls', [CriteriaAuditIndex::class,"generateXLS"])->name('criteria-audit.export-xls');
                Route::get('/criteria-audit-export-pdf', [CriteriaAuditIndex::class,"generatePDF"])->name('criteria-audit.export-pdf');
                Route::get('/criteria-audit/{criteria_id}', CriteriaAuditDetail::class)->name('criteria-audit.detail');

                Route::get('/criteria-audit-confirmance', ConfirmanceCriteriaAuditIndex::class)->name('criteria-audit-confirmance.index');
                Route::get('/criteria-audit-conformance-export', [ConfirmanceCriteriaAuditIndex::class,'generatePDF'])->name('criteria-audit-conformance.export');
                Route::get('/criteria-audit-conformance-export-word', [ConfirmanceCriteriaAuditIndex::class,'generateWord'])->name('criteria-audit-conformance.export-word');

                Route::get('/audit-fix-recommendation', FixRecomendationAuditIndex::class)->name('fix-recommendation-audit.index');
                Route::get('/audit-fix-recommendation-export', [FixRecomendationAuditIndex::class,'generatePDF'])->name('audit-fix-recommendation.export');
                Route::get('/audit-fix-recommendation-export-word', [FixRecomendationAuditIndex::class,'generateWord'])->name('audit-fix-recommendation.export-word');

                Route::get('/criteria-audit-non-conformance', NonConfirmanceCriteriaAuditIndex::class)->name('criteria-audit-non-conformance.index');
                Route::get('/criteria-audit-non-conformance-export', [NonConfirmanceCriteriaAuditIndex::class,'generatePDF'])->name('criteria-audit-non-conformance.export');
                Route::get('/criteria-audit-non-conformance-export-word', [NonConfirmanceCriteriaAuditIndex::class,'generateWord'])->name('criteria-audit-non-conformance.export-word');

                Route::get('/criteria-audit-non-conformance/fix-plan', NonConfirmanceCriteriaAuditFixplan::class)->name('criteria-audit-non-conformance.fix-plan');
                Route::get('/criteria-audit-non-conformance-fix-plan-export', [NonConfirmanceCriteriaAuditFixplan::class,'generatePDF'])->name('criteria-audit-non-conformance.fix-plan.export');
                Route::get('/criteria-audit-non-conformance-fix-plan-export-word', [NonConfirmanceCriteriaAuditFixplan::class,'generateWord'])->name('criteria-audit-non-conformance.fix-plan.export-word');

                Route::get('/criteria-audit-non-conformance/{non_conformance_id}', NonConfirmanceCriteriaAuditDetail::class)->name('criteria-audit-non-conformance.detail');
                Route::get('/criteria-audit-non-conformance/{non_conformance_id}/export', [NonConfirmanceCriteriaAuditDetail::class,'generatePDF'])->name('criteria-audit-non-conformance.detail.export');
                Route::get('/criteria-audit-non-conformance/{non_conformance_id}/fix-export', [NonConfirmanceCriteriaAuditDetail::class,'exportFixPDF'])->name('criteria-audit-non-conformance.detail.fix-export');

                Route::get('/opening-attendance', OpeningAttendanceIndex::class)->name('opening-attendance.index');
                Route::get('/opening-attendance/download/{notice_id}', [OpeningAttendanceController::class, 'download'])->name('opening-attendance.download');

                Route::get('/closing-attendance', ClosingAttendanceIndex::class)->name('closing-attendance.index');
                Route::get('/closing-attendance/download/{notice_id}', [ClosingAttendanceController::class, 'download'])->name('closing-attendance.download');

                Route::get('/response-audit', ResponseAuditIndex::class)->name('response-audit.index');
                Route::get('/response-audit/download/{notice_id}', [ResponseAuditController::class, 'download'])->name('response-audit.download');

                Route::get('/report-result', ReportResultIndex::class)->name('report-result.index');
                Route::get('/report-result/download/{notice_id}', [ReportResultController::class, 'download'])->name('report-result.download');

                Route::get('/another-attachment', AnotherAttachmentIndex::class)->name('another-attachment.index');
                Route::get('/another-attachment/download/{notice_id}', [AnotherAttachmentController::class, 'download'])->name('another-attachment.download');
            });
        });

        Route::prefix("/smkp/mandays")->as('smkp.mandays.')->group(function(){
            Route::get('', MandayIndex::class)->name('index');
            Route::get('create', CreateMandays::class)->name('create');
            Route::get('edit/{id}', EditMandays::class)->name('edit');

        });

    });
});


Route::prefix('tests')->group(function () {
    Route::get('mandays', function (\Illuminate\Http\Request $request) {
        $manPower = (int)$request->get('manPower');
        $risk = (int)$request->get('severity');
        $auditor = (int)$request->get('auditor');
        $adjustment = (int)$request->get('adjustment');

        if ($auditor <= 0) {
            return;
        }
        $manDays = \Modules\Audit\Entities\AuditManDays::where('minimum_people', '<=', $manPower)
            ->where('maximum_people', '>=', $manPower)
            ->with(['severities' => function ($severity) use ($risk) {
                $severity->where('id', $risk);
            }])
            ->whereHas('severities', function ($severity) use ($risk) {
                $severity->where('id', $risk);
            })
            ->first();
        if ($manDays->severities->count() == 0):
            return;
        endif;
        $totalMandays = $manDays->severities[0]->pivot->value;

        $adjustmentFactor = 0;
        if ($adjustment > 0):
            $adjustmentFactor = $totalMandays / 10;
        endif;
        $finalMandays = ($totalMandays + $adjustmentFactor) / $auditor;
        $result = [
            'manPower' => $manPower,
            'category' => $manDays->id,
            'severity' => $manDays->severities[0]->name,
            'auditor' => $auditor,
            'manDays' => $totalMandays,
            'adjustment' => $adjustment,
            'adjustmentFactor' => $adjustmentFactor,
            'finalManDays' => $finalMandays,
            'fistStep' => round((10 / 100) * $finalMandays, 1),
            'secondStep' => round((90 / 100) * $finalMandays, 1),
        ];
        dd($result);
    });
});

Route::get("/test/info",[TestController::class, 'info']);
Route::get("/test/pdf",[TestController::class, 'pdf']);

