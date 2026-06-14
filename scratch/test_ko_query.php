<?php

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use App\Models\Company;
use App\Models\Department;
use App\Enums\CompanyType;
use App\Enums\KO\KoStatus;
use Modules\KO\Entities\KoSpipCategory;
use Modules\KO\Entities\KoSpipType;
use Modules\KO\Entities\KoSpipUnit;
use Modules\KO\Entities\KoBrand;
use Modules\KO\Entities\KoUnit;
use Modules\KO\Entities\KoProposal;
use Modules\KO\Entities\KoAttachment;
use Modules\KO\Entities\KoCommissioning;
use Modules\KO\Entities\KoCommissioningField;
use Modules\KO\Entities\KoCommissioningItem;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

// =========================================================================
// 1. VERIFY AND RESOLVE THE SPECIFIED WORKFLOW USERS
// =========================================================================
$makerUser = User::where('email', 'fadjri.wivindi@alamtri.com')->first();
$adminUser = User::where('email', 'ko.admin@alamtri.com')->first();
$coordinatorUser = User::where('email', 'ko.coordinator@alamtri.com')->first();

if (!$makerUser || !$adminUser || !$coordinatorUser) {
    die("Error: One of the required users is missing in the database. Please run KODummySeeder first.\n");
}

echo "=================================================================\n";
echo "KELAYAKAN OPERASIONAL (KO) WORKFLOW SIMULATION\n";
echo "=================================================================\n";
echo "Maker       : {$makerUser->name} ({$makerUser->email})\n";
echo "Inspector   : {$adminUser->name} ({$adminUser->email})\n";
echo "Coordinator : {$coordinatorUser->name} ({$coordinatorUser->email})\n";
echo "-----------------------------------------------------------------\n\n";

// =========================================================================
// 2. RESOLVE DATABASE RELATIONSHIPS
// =========================================================================
$company = Company::where('id', 'a1f078e5-ed47-4e84-b3c1-9f659cc93a4e')->first() ?? Company::first();
$department = Department::where('company_id', $company->id)->first() ?? Department::first();

$spipCategory = KoSpipCategory::first();
$spipUnit = KoSpipUnit::first();
$brand = KoBrand::first();

if (!$spipUnit || !$brand) {
    die("Error: Missing base SPIP configuration (run KODummySeeder first).\n");
}

// Clean previous simulation document if exists
echo "[CLEANUP] Clearing old simulation data...\n";
DB::statement('SET FOREIGN_KEY_CHECKS=0;');
$oldProposals = KoProposal::where('number', 'KO-SIMULATE-0001')->get();
foreach ($oldProposals as $op) {
    KoAttachment::where('ko_proposal_id', $op->id)->delete();
    $comm = KoCommissioning::where('ko_proposal_id', $op->id)->first();
    if ($comm) {
        KoCommissioningItem::where('ko_commissioning_id', $comm->id)->delete();
        $comm->delete();
    }
    $op->delete();
}
KoUnit::where('call_sign', 'CS-SIMULATE-01')->delete();
DB::statement('SET FOREIGN_KEY_CHECKS=1;');
echo "✓ Old simulation data cleared.\n\n";

// =========================================================================
// STEP 1: CREATE PROPOSAL AS DRAFT (Maker)
// =========================================================================
echo "[STEP 1] Maker creates unit registry and registers proposal as Draft...\n";

$unit = KoUnit::create([
    'id' => (string) Str::uuid(),
    'ko_spip_unit_id' => $spipUnit->id,
    'call_sign' => 'CS-SIMULATE-01',
    'identity_number' => 'B 9999 SIM',
    'ko_brand_id' => $brand->id,
    'serial_number' => 'SN-SIMULATE-99999',
    'model_unit' => 'Hilux Double Cabin 4x4',
    'production_year' => 2024,
    'commissioning_count' => 0,
    'is_revoked' => 0,
]);

$proposal = KoProposal::create([
    'id' => (string) Str::uuid(),
    'number' => 'KO-SIMULATE-0001',
    'ccow_id' => $company->id,
    'company_id' => $company->id,
    'department_id' => $department->id,
    'area' => 'Lampunut',
    'ko_unit_id' => $unit->id,
    'applicant_email' => $makerUser->email,
    'pjo_id' => $coordinatorUser->id,
    'internal_komisioning_schedule' => now()->addDays(5)->format('Y-m-d'),
    'commissioning_period' => 1,
    'status' => KoStatus::Draft()->value,
]);

echo "→ Proposal Created: {$proposal->number}\n";
echo "→ Current Status  : {$proposal->status}\n\n";

// =========================================================================
// STEP 2: SUBMIT PROPOSAL FOR ADMIN VERIFICATION (Maker)
// =========================================================================
echo "[STEP 2] Maker uploads attachments and submits proposal to Admin...\n";

$attachments = KoAttachment::create([
    'id' => (string) Str::uuid(),
    'ko_proposal_id' => $proposal->id,
    'stnk' => 'uploads/attachments/sim_stnk.pdf',
    'nota_pajak' => 'uploads/attachments/sim_pajak.pdf',
    'surat_pengantar' => 'uploads/attachments/sim_pengantar.pdf',
]);

$proposal->update([
    'status' => KoStatus::AdminProposalVerification()->value,
]);

echo "→ Attachments Linked: " . ($proposal->koAttachment ? 'Yes' : 'No') . "\n";
echo "→ Current Status  : {$proposal->status}\n\n";

// =========================================================================
// STEP 3: ADMIN ADMINISTRATIVE VERIFICATION (Admin / Inspector)
// =========================================================================
echo "[STEP 3] Admin Safety verifies documents and forwards to Coordinator...\n";

$proposal->update([
    'status' => KoStatus::CoordinatorProposalVerification()->value,
    'admin_proposal_verified' => true,
]);

echo "→ Admin Verified  : Yes\n";
echo "→ Current Status  : {$proposal->status}\n\n";

// =========================================================================
// STEP 4: COORDINATOR PROPOSAL APPROVAL (Coordinator / PJO)
// =========================================================================
echo "[STEP 4] Coordinator approves proposal and schedules physical commissioning...\n";

$proposal->update([
    'status' => KoStatus::Commissioning()->value,
]);

echo "→ Current Status  : {$proposal->status}\n\n";

// =========================================================================
// STEP 5: PHYSICAL COMMISSIONING FIELD TEST (Admin / Inspector)
// =========================================================================
echo "[STEP 5] Inspector conducts physical field test, passes the unit, and uploads checklists...\n";

$commissioning = KoCommissioning::create([
    'id' => (string) Str::uuid(),
    'ko_proposal_id' => $proposal->id,
    'date' => now()->format('Y-m-d'),
    'commissioning_completion_date' => now()->format('Y-m-d'),
    'smu_odo_meter' => '1000',
    'engine_status' => 'New',
    'expired_date' => now()->addYear()->format('Y-m-d'),
    'status' => 'Lulus',
    'created_by' => $adminUser->name,
]);

// Seed check items
$fields = KoCommissioningField::limit(3)->get();
foreach ($fields as $idx => $f) {
    KoCommissioningItem::create([
        'id' => (string) Str::uuid(),
        'ko_commissioning_id' => $commissioning->id,
        'ko_commissioning_field_id' => $f->id,
        'condition' => 'Baik',
        'note' => 'Checked OK - Item ' . ($idx + 1),
    ]);
}

$proposal->update([
    'status' => KoStatus::CommissionerCommissioningVerification()->value,
]);

echo "→ Commissioning Record Linked: Yes (Status: {$commissioning->status})\n";
echo "→ Checklist Items Added      : " . KoCommissioningItem::where('ko_commissioning_id', $commissioning->id)->count() . "\n";
echo "→ Current Status             : {$proposal->status}\n\n";

// =========================================================================
// STEP 6: COORDINATOR FINAL APPROVAL & QR CODE ACTIVATION (Coordinator)
// =========================================================================
echo "[STEP 6] Coordinator reviews commissioning results and approves final transition to Completed...\n";

$proposal->update([
    'status' => KoStatus::Completed()->value,
    'next_commissioning' => now()->addYear()->format('Y-m-d'),
    'temporary_qr_status' => 'Approved',
]);

$unit->update([
    'commissioning_count' => $unit->commissioning_count + 1,
]);

echo "→ Unit Commissioning Count : {$unit->commissioning_count}\n";
echo "→ Final Proposal Status    : {$proposal->status}\n";
echo "→ QR Code Generated        : " . ($proposal->getQrCode() ? 'Yes' : 'No') . "\n";
echo "→ Workflow Result          : SUCCESS / COMPLETED\n\n";

echo "=================================================================\n";
echo "SIMULATION LOGS COMPLETED WITH NO ERRORS!\n";
echo "=================================================================\n";
