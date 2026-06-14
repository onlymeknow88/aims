<?php

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use App\Models\Company;
use App\Models\Department;
use App\Models\AreaManager;
use Modules\DocumentSystem\Entities\Document;
use Modules\DocumentSystem\Entities\Attachment;
use Modules\DocumentSystem\Entities\Activity;
use Modules\DocumentSystem\Entities\InvitedPeople;
use Modules\DocumentSystem\Entities\Mapping;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

// =========================================================================
// 1. VERIFY AND RESOLVE THE SPECIFIED WORKFLOW USERS
// =========================================================================
$makerUser = User::where('email', 'fadjri.wivindi@alamtri.com')->first();
$crsUser = User::where('email', 'aprilya.haloho@alamtri.com')->first();
$pjaUser = User::where('email', 'zakaria.anoi@alamtri.com')->first();

if (!$makerUser || !$crsUser || !$pjaUser) {
    die("Error: One of the required users is missing in the database. Please run DocumentSystemDummySeederTableSeeder first.\n");
}

echo "=================================================================\n";
echo "DOCUMENT SYSTEM WORKFLOW SIMULATION\n";
echo "=================================================================\n";
echo "Maker (Originator) : {$makerUser->name} ({$makerUser->email})\n";
echo "Reviewer (CRS)      : {$crsUser->name} ({$crsUser->email})\n";
echo "Approver (PJA)      : {$pjaUser->name} ({$pjaUser->email})\n";
echo "-----------------------------------------------------------------\n\n";

// =========================================================================
// 2. RESOLVE DATABASE RELATIONSHIPS
// =========================================================================
$company = Company::where('id', 'a1f078e5-ed47-4e84-b3c1-9f659cc93a4e')->first() ?? Company::first();
$department = Department::where('name', 'IT')->first() ?? Department::first();
$mapping = Mapping::first();
$areaManager = AreaManager::where('user_id', $pjaUser->id)->first();

if (!$mapping || !$areaManager) {
    die("Error: Base config mapping or Area Manager (PJA) is missing in the database.\n");
}

// Clean previous simulation document if exists
echo "[CLEANUP] Clearing old simulation data...\n";
DB::statement('SET FOREIGN_KEY_CHECKS=0;');
$oldDocs = Document::where('sop_number', '099')->get();
foreach ($oldDocs as $od) {
    Attachment::where('document_id', $od->id)->delete();
    Activity::where('document_id', $od->id)->delete();
    InvitedPeople::where('document_id', $od->id)->delete();
    $od->forceDelete();
}
DB::statement('SET FOREIGN_KEY_CHECKS=1;');
echo "✓ Old simulation data cleared.\n\n";

// =========================================================================
// STEP 1: CREATE DOCUMENT AS DRAFT (Maker)
// =========================================================================
echo "[STEP 1] Maker uploads new SOP and saves as Draft...\n";

$document = Document::create([
    'id' => (string) Str::uuid(),
    'department_id' => $department->id,
    'department_code_id' => DB::table('department_codes')->where('department_id', $department->id)->value('id'),
    'mapping_id' => $mapping->id,
    'area_manager_id' => $areaManager->id,
    'user_id' => $makerUser->id,
    'created_by' => $makerUser->id,
    'upload_type' => 'document',
    'document_level' => Document::SOP_DOC_TYPE,
    'prefix_code' => 'MAC-IT-',
    'status' => Document::DRAFT,
    'revision' => '0',
    'title' => 'Working at Heights Procedure (Simulation)',
    'description' => 'SOP describing safety procedures for working at heights (above 1.8 meters) using personal fall arrest systems.',
    'sop_number' => '099',
    'document_number' => 'MAC-IT-099',
    'file_path' => 'uploads/documents/sop_wah_simulation.pdf',
    'doc_created' => now()->toDateString(),
    'is_obsolate' => 0,
]);

// Create mock attachment
Attachment::create([
    'id' => (string) Str::uuid(),
    'document_id' => $document->id,
    'file_path' => 'uploads/documents/sop_wah_simulation.pdf',
]);

// Log draft creation activity
Activity::create([
    'id' => (string) Str::uuid(),
    'document_id' => $document->id,
    'user_id' => $makerUser->id,
    'description' => 'Draft Created by Maker',
    'status_document' => Document::DRAFT,
]);

echo "→ Document Number : " . $document->fixDocumentNumber . "\n";
echo "→ Current Status  : Draft\n\n";

// =========================================================================
// STEP 2: SUBMIT FOR REVIEW (Maker)
// =========================================================================
echo "[STEP 2] Maker submits document to CRS for compliance review...\n";

// Invite CRS
InvitedPeople::create([
    'id' => (string) Str::uuid(),
    'user_id' => $crsUser->id,
    'document_id' => $document->id,
    'user_type' => InvitedPeople::USER_INSIDE_OFFICE,
    'is_notify_email' => true,
    'email' => $crsUser->email,
]);

$document->update([
    'status' => Document::WAITNG_REVIEW,
]);

// Log submission activity
Activity::create([
    'id' => (string) Str::uuid(),
    'document_id' => $document->id,
    'user_id' => $makerUser->id,
    'description' => 'Document submitted for review',
    'status_document' => Document::WAITNG_REVIEW,
]);

echo "→ Current Status  : Waiting Review\n";
echo "→ Invited Reviewer: {$crsUser->name}\n\n";

// =========================================================================
// STEP 3: CRS REVIEW & FORWARD (CRS Reviewer)
// =========================================================================
echo "[STEP 3] CRS Reviewer approves formatting/compliance and routes to PJA...\n";

// Update status to Rooting Review
$document->update([
    'status' => Document::ROOTING_REVIEW,
]);

// Log CRS activity
Activity::create([
    'id' => (string) Str::uuid(),
    'document_id' => $document->id,
    'user_id' => $crsUser->id,
    'description' => 'Approved Level 1 by CRS Compliance',
    'status_document' => Document::ROOTING_REVIEW,
]);

echo "→ Current Status  : Rooting Approval\n";
echo "→ Target Approver : " . $document->areaManager->user->name . " (" . $document->areaManager->user->email . ")\n\n";

// =========================================================================
// STEP 4: PJA FINAL SIGN-OFF & ACTIVE (PJA Approver)
// =========================================================================
echo "[STEP 4] PJA Approver signs off, publishing the document globally...\n";

// Update status to Active
$document->update([
    'status' => Document::ACTIVE,
]);

// Log PJA activity
Activity::create([
    'id' => (string) Str::uuid(),
    'document_id' => $document->id,
    'user_id' => $pjaUser->id,
    'description' => 'Approved Level 2 & Published by PJA',
    'status_document' => Document::ACTIVE,
]);

echo "→ Final Status    : Active\n";
echo "→ Workflow Result : SUCCESS / PUBLISHED\n\n";

echo "-----------------------------------------------------------------\n";
echo "ACTIVITY LOGS RECORDED:\n";
foreach ($document->activities()->orderBy('created_at')->get() as $act) {
    echo " - [{$act->created_at}] ({$act->user->name}): {$act->description}\n";
}
echo "=================================================================\n";
echo "SIMULATION COMPLETED WITH NO ERRORS!\n";
echo "=================================================================\n";
