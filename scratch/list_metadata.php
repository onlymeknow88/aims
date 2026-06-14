<?php

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Company;
use App\Models\Department;
use App\Models\Section;
use App\Models\AreaLocation;
use Modules\FieldLeadership\Entities\FieldLeadershipCategory;
use Modules\FieldLeadership\Entities\FieldLeadershipKtaAndTta;
use Modules\FieldLeadership\Entities\FieldLeadershipPotencyAndConsequnce;

echo "--- Companies ---\n";
foreach (Company::all() as $c) {
    echo "ID: {$c->id}, Name: {$c->company_name}, Type: {$c->type}, DocCode: {$c->document_code}\n";
}

echo "\n--- Departments ---\n";
foreach (Department::all() as $d) {
    echo "ID: {$d->id}, Name: {$d->name}, Company: {$d->company_id}\n";
}

echo "\n--- Sections ---\n";
foreach (Section::all() as $s) {
    echo "ID: {$s->id}, Name: {$s->name}, Dept: {$s->department_id}\n";
}

echo "\n--- Locations ---\n";
foreach (AreaLocation::all() as $l) {
    echo "ID: {$l->id}, Name: {$l->name}, Section: {$l->section_id}\n";
}

echo "\n--- Categories ---\n";
foreach (FieldLeadershipCategory::all() as $cat) {
    echo "ID: {$cat->id}, Name: {$cat->name}\n";
}

echo "\n--- KTA/TTA Types ---\n";
foreach (FieldLeadershipKtaAndTta::all()->take(5) as $t) {
    echo "ID: {$t->id}, Name: {$t->name}, Type: {$t->type}\n";
}

echo "\n--- Potencies ---\n";
foreach (FieldLeadershipPotencyAndConsequnce::all() as $p) {
    echo "ID: {$p->id}, Name: {$p->name}, Code: {$p->code}\n";
}
