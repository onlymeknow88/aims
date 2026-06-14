<?php

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use App\Models\Company;
use App\Models\Department;
use App\Models\Section;
use App\Models\AreaLocation;
use App\Models\AreaManager;
use App\Enums\CompanyType;
use App\Enums\FieldLeadership\FieldLeadershipType;
use Modules\FieldLeadership\Entities\FieldLeadership;
use Modules\FieldLeadership\Entities\FieldLeadershipRisk;
use Modules\FieldLeadership\Entities\FieldLeadershipMember;
use Modules\FieldLeadership\Entities\FieldLeadershipActivity;
use Modules\FieldLeadership\Entities\FieldLeadershipCategory;
use Modules\FieldLeadership\Entities\FieldLeadershipKtaAndTta;
use Modules\FieldLeadership\Entities\FieldLeadershipPotencyAndConsequnce;
use Illuminate\Support\Facades\DB;

// =========================================================================
// 1. VERIFY AND RESOLVE THE SPECIFIED WORKFLOW USERS
// =========================================================================
$makerUser = User::where('email', 'fadjri.wivindi@alamtri.com')->first();
$reviewerUser = User::where('email', 'zakaria.anoi@alamtri.com')->first();
$approverUser = User::where('email', 'rahmad.siregar@alamtri.com')->first();

if (!$makerUser || !$reviewerUser || !$approverUser) {
    die("Error: One of the required users is missing in the database.\n");
}

echo "=================================================================\n";
echo "FIELD LEADERSHIP WORKFLOW SIMULATION\n";
echo "=================================================================\n";
echo "Maker    : {$makerUser->name} ({$makerUser->email})\n";
echo "Reviewer : {$reviewerUser->name} ({$reviewerUser->email})\n";
echo "Approver : {$approverUser->name} ({$approverUser->email}) [KTT]\n";
echo "-----------------------------------------------------------------\n\n";

// =========================================================================
// 2. RESOLVE DATABASE RELATIONSHIPS
// =========================================================================
$company    = Company::find('a1f078e5-ed47-4e84-b3c1-9f659cc93a4e'); // PT Maruwai Coal
$department = Department::find('a1f07935-ad83-4169-98da-d10cc36552eb'); // IT
$section    = Section::find('a1f0862e-4909-4c80-8884-eed6e8c0ce38'); // IT
$location   = AreaLocation::find('a1f685cb-e900-43c0-9992-1bc10bbdcabe'); // Tower
$pja        = AreaManager::find('a1f685e3-e386-4f54-8dba-2181866dac8b'); // Zakaria Anoi (IT PJA)

$categoryKta = FieldLeadershipCategory::where('name', 'Kondisi Tidak Aman')->first();
$typeKta     = FieldLeadershipKtaAndTta::where('type', 'KTA')->first();
$potencyMed  = FieldLeadershipPotencyAndConsequnce::where('code', 'M')->first();

// Ensure KTT Approver is linked to the company
if ($company->user_id !== $approverUser->id) {
    $company->update(['user_id' => $approverUser->id]);
    echo "✓ Linked company {$company->company_name} to KTT: {$approverUser->email}\n";
}

// Clean previous simulation document if exists
$simId = 'f1a00000-beef-4000-8000-000000000000';
DB::statement('SET FOREIGN_KEY_CHECKS=0;');
FieldLeadershipActivity::where('fl_id', $simId)->delete();
FieldLeadershipRisk::where('fl_id', $simId)->delete();
FieldLeadershipMember::where('fl_id', $simId)->delete();
FieldLeadership::where('id', $simId)->delete();
DB::statement('SET FOREIGN_KEY_CHECKS=1;');

// =========================================================================
// STEP 1: CREATE AND SUBMIT FIELD LEADERSHIP (Maker: Fadjri Wivindi)
// =========================================================================
echo "[STEP 1] Maker creates and submits document...\n";

$fl = FieldLeadership::create([
    'id' => $simId,
    'number' => 'FL-MAC-SIMULATE-0001',
    'date' => now()->toDateString(),
    'ccow_id' => $company->id,
    'company_id' => $company->id,
    'detail_company' => CompanyType::Internal,
    'department_id' => $department->id,
    'section_id' => $section->id,
    'area_location_id' => $location->id,
    'detail_location' => 'Server Room (Simulation)',
    'personil_on_review' => 1,
    'personil_on_review_name' => $makerUser->name,
    'pja_id' => $pja->id, // Zakaria Anoi
    'type' => 'Regular',
    'job' => 'Pengecekan Kebersihan & Kerapian Server',
    'status' => FieldLeadershipType::Open,
    'published' => 'Publish',
    'requested' => FieldLeadershipType::RequestedPja,
    'created_by' => $makerUser->employee->id, // Fadjri Wivindi
]);

// Add Maker as member
FieldLeadershipMember::create([
    'fl_id' => $fl->id,
    'type' => CompanyType::Internal,
    'employee_id' => $makerUser->employee->id,
]);

// Add Risk finding
FieldLeadershipRisk::create([
    'fl_id' => $fl->id,
    'risk_condition' => 'Penumpukan kardus bekas dekat rack server.',
    'category_id' => $categoryKta->id,
    'type_id' => $typeKta->id,
    'potency_id' => $potencyMed->id,
    'repair_action' => 'Pindahkan kardus ke gudang logistik.',
    'due_date' => now()->addDays(3)->toDateString(),
    'type_action' => 'Administrasi',
    'supervisor' => 'Supervisor IT Support',
    'status' => FieldLeadershipType::Open,
]);

// Log activity
FieldLeadershipActivity::create([
    'fl_id' => $fl->id,
    'description' => 'Document submitted by Maker ' . $makerUser->name,
    'user_id' => $makerUser->id,
]);

echo "→ Document Created: {$fl->number}\n";
echo "→ Current Status  : " . $fl->status . "\n";
echo "→ Requested State : " . $fl->requested . "\n";
echo "→ PJA (Reviewer)  : " . $fl->pja->user->name . " (" . $fl->pja->user->email . ")\n\n";


// =========================================================================
// STEP 2: REVIEW DOCUMENT (Reviewer/PJA: Zakaria Anoi)
// =========================================================================
echo "[STEP 2] PJA Reviewer reviews and submits to Approval...\n";

// PJA logs in and reviews
// Changes status to On Review Approval
$fl->update([
    'status' => FieldLeadershipType::OnReviewApproval,
    'requested' => FieldLeadershipType::RequestedApproval,
]);

// Log PJA activity
FieldLeadershipActivity::create([
    'fl_id' => $fl->id,
    'description' => 'Reviewed and sent to KTT for approval by PJA ' . $reviewerUser->name,
    'user_id' => $reviewerUser->id,
]);

echo "→ Current Status  : " . $fl->status . "\n";
echo "→ Requested State : " . $fl->requested . "\n";
echo "→ Company KTT     : " . $fl->company->user->name . " (" . $fl->company->user->email . ") [rahmad.siregar@alamtri.com]\n\n";


// =========================================================================
// STEP 3: APPROVE DOCUMENT (KTT/Approver: Rahmad Siregar)
// =========================================================================
echo "[STEP 3] KTT Approver approves and closes the document...\n";

// KTT logs in and approves
$fl->update([
    'status' => FieldLeadershipType::Close,
    'requested' => FieldLeadershipType::Approved,
]);

// Log Approval activity
FieldLeadershipActivity::create([
    'fl_id' => $fl->id,
    'description' => 'Field Leadership Case Closed / Approved by KTT ' . $approverUser->name,
    'user_id' => $approverUser->id,
]);

echo "→ Current Status  : " . $fl->status . "\n";
echo "→ Requested State : " . $fl->requested . "\n";
echo "→ Workflow Result : SUCCESS / CLOSED\n\n";

echo "-----------------------------------------------------------------\n";
echo "ACTIVITY LOGS RECORDED:\n";
foreach (FieldLeadershipActivity::where('fl_id', $fl->id)->get() as $act) {
    $user = User::find($act->user_id);
    echo " - [{$act->created_at}] ({$user->name}): {$act->description}\n";
}
echo "=================================================================\n";
