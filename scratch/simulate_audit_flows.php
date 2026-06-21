<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Modules\Audit\Entities\Audit;
use Modules\Audit\Enums\BundleStatusEnum;
use Illuminate\Support\Facades\Log;

echo "=== MEMULAI SIMULASI AUDIT FLOWS & VALIDASI HUBUNGAN DATABASE ===\n\n";

$audits = Audit::where('title', 'like', 'Dummy Audit%')->get();

if ($audits->isEmpty()) {
    echo "Peringatan: Tidak ada data audit dummy ditemukan. Silakan jalankan seeder terlebih dahulu.\n";
    exit(1);
}

$hasErrors = false;

foreach ($audits as $index => $audit) {
    echo sprintf("[%d] Menguji Paket Audit: %s (%s) - Status: %s\n", $index + 1, $audit->audit_number, $audit->audit_category, $audit->status);
    
    // 1. Cek Hubungan Company
    try {
        if ($audit->company) {
            echo "   ✓ Company: " . $audit->company->company_name . "\n";
        } else {
            throw new Exception("Hubungan Company mengembalikan NULL");
        }
    } catch (Exception $e) {
        echo "   ❌ ERROR pada hubungan Company: " . $e->getMessage() . "\n";
        $hasErrors = true;
    }

    // 2. Cek Hubungan Tim Audit (Auditors)
    try {
        $auditorsCount = $audit->auditors()->count();
        echo sprintf("   ✓ Tim Audit: %d anggota terdaftar\n", $auditorsCount);
        if ($auditorsCount === 0 && $audit->status !== BundleStatusEnum::DRAFT) {
            echo "     ⚠️ Warning: Tim audit kosong untuk status " . $audit->status . "\n";
        }
    } catch (Exception $e) {
        echo "   ❌ ERROR pada hubungan Tim Audit: " . $e->getMessage() . "\n";
        $hasErrors = true;
    }

    // 3. Cek Hubungan Audit Plan
    try {
        $plan = $audit->audit_plan;
        if ($plan) {
            echo "   ✓ Audit Plan ditemukan (ID: " . $plan->id . ")\n";
            $detail = $plan->detail;
            if ($detail) {
                echo "     ✓ Detail Audit Plan ditemukan\n";
            } else {
                throw new Exception("Detail Audit Plan mengembalikan NULL");
            }
        } else {
            throw new Exception("Audit Plan mengembalikan NULL");
        }
    } catch (Exception $e) {
        echo "   ❌ ERROR pada hubungan Audit Plan: " . $e->getMessage() . "\n";
        $hasErrors = true;
    }

    // 4. Cek Hubungan Implementation Activities
    try {
        $activity = $audit->implementation_activity;
        if ($activity) {
            echo "   ✓ Implementation Activity ditemukan (ID: " . $activity->id . ")\n";
        } else {
            throw new Exception("Implementation Activity mengembalikan NULL");
        }
    } catch (Exception $e) {
        echo "   ❌ ERROR pada hubungan Implementation Activity: " . $e->getMessage() . "\n";
        $hasErrors = true;
    }

    // 5. Cek Hubungan Kriteria Audit, Metode Sampel, dan Penilaian Lokasi
    try {
        $module = $audit->criteria_module;
        if ($module) {
            $criteriaCount = $module->criteria()->count();
            echo sprintf("   ✓ Kriteria Module ditemukan dengan %d kriteria\n", $criteriaCount);
            
            // Check sub criteria sample methods
            $subCriteriaIds = \Modules\Audit\Entities\AuditSubCriteria::whereIn(
                'audit_criteria_id', 
                $module->criteria()->pluck('id')
            )->pluck('id');
            
            $sampleMethodsCount = DB::table('audit_sub_criteria_sample_methods')
                ->whereIn('audit_sub_criteria_id', $subCriteriaIds)
                ->count();
                
            $locAssessmentsCount = DB::table('audit_sub_criteria_locations')
                ->whereIn('audit_sub_criteria_id', $subCriteriaIds)
                ->count();

            $confirmancesCount = DB::table('audit_criteria_confirmances')
                ->whereIn('audit_sub_criteria_id', $subCriteriaIds)
                ->count();

            $nonConfirmancesCount = DB::table('audit_criteria_non_confirmances')
                ->whereIn('audit_sub_criteria_id', $subCriteriaIds)
                ->count();
                
            echo sprintf("     ✓ %d sub-kriteria memiliki metode dan sampel audit terhubung\n", $sampleMethodsCount);
            echo sprintf("     ✓ %d sub-kriteria memiliki penilaian lokasi terhubung\n", $locAssessmentsCount);
            echo sprintf("     ✓ %d sub-kriteria memiliki temuan Conformance terhubung\n", $confirmancesCount);
            echo sprintf("     ✓ %d sub-kriteria memiliki temuan Non-Conformance (NCR) terhubung\n", $nonConfirmancesCount);
        } else {
            throw new Exception("Criteria Module mengembalikan NULL");
        }
    } catch (Exception $e) {
        echo "   ❌ ERROR pada hubungan Kriteria: " . $e->getMessage() . "\n";
        $hasErrors = true;
    }

    // 5.5 Cek Hubungan Lokasi Audit
    try {
        $locationsCount = $audit->locations()->count();
        echo sprintf("   ✓ Lokasi Audit: %d lokasi terdaftar\n", $locationsCount);
    } catch (Exception $e) {
        echo "   ❌ ERROR pada hubungan Lokasi: " . $e->getMessage() . "\n";
        $hasErrors = true;
    }

    // 6. Cek Hubungan Laporan Implementasi
    try {
        $report = $audit->implementation_report;
        if ($report) {
            echo "   ✓ Implementation Report Module ditemukan (ID: " . $report->id . ")\n";
            $detail = $report->detail;
            if ($detail) {
                echo sprintf("     ✓ Detail Laporan ter-sync dengan: %d eligibilities, %d safety performances, %d adjustment factors\n",
                    $detail->eligibilities()->count(),
                    $detail->safety_performances()->count(),
                    $detail->adjustment_factors()->count()
                );
            } else {
                throw new Exception("Detail Laporan Implementasi mengembalikan NULL");
            }
        } else {
            throw new Exception("Implementation Report Module mengembalikan NULL");
        }
    } catch (Exception $e) {
        echo "   ❌ ERROR pada hubungan Laporan Implementasi: " . $e->getMessage() . "\n";
        $hasErrors = true;
    }

    // 7. Cek Surat Pemberitahuan & Berkas Lampiran untuk Status Lanjutan
    if ($audit->status !== BundleStatusEnum::DRAFT) {
        try {
            $noticeCount = $audit->notice_letters()->count();
            echo sprintf("   ✓ Notice Letter: %d dokumen terunggah\n", $noticeCount);
            if ($noticeCount === 0) {
                echo "     ⚠️ Warning: Notice Letter kosong untuk status non-Draft\n";
            }
        } catch (Exception $e) {
            echo "   ❌ ERROR pada hubungan Notice Letter: " . $e->getMessage() . "\n";
            $hasErrors = true;
        }
    }

    if (in_array($audit->status, [BundleStatusEnum::NEED_REVIEW, BundleStatusEnum::IN_REVIEW, BundleStatusEnum::APPROVED])) {
        try {
            echo sprintf("   ✓ Absensi Rapat Pembukaan: %d berkas\n", $audit->opening_attendances()->count());
            echo sprintf("   ✓ Absensi Rapat Penutupan: %d berkas\n", $audit->closing_attendances()->count());
            echo sprintf("   ✓ Tanggapan Auditee: %d berkas\n", $audit->response_audits()->count());
            echo sprintf("   ✓ Laporan Hasil Akhir: %d berkas\n", $audit->report_results()->count());
        } catch (Exception $e) {
            echo "   ❌ ERROR pada dokumen pelengkap/lampiran: " . $e->getMessage() . "\n";
            $hasErrors = true;
        }
    }

    echo "\n";
}

if ($hasErrors) {
    echo "=== SIMULASI SELESAI DENGAN BEBERAPA ERROR ===\n";
    exit(1);
} else {
    echo "=== SIMULASI SELESAI: SEMUA DATA DUMMY VALID & BEBAS DARI ERROR HUBUNGAN ===\n";
    exit(0);
}
