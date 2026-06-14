<?php

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use App\Models\Employee;
use App\Models\AreaManager;
use App\Models\Company;
use App\Models\Department;
use App\Models\Section;

$emails = [
    'maker' => 'fadjri.wivindi@alamtri.com',
    'reviewer' => 'zakaria.anoi@alamtri.com',
    'approver' => 'rahmad.siregar@alamtri.com'
];

foreach ($emails as $role => $email) {
    $user = User::where('email', $email)->first();
    if (!$user) {
        echo "$role ($email): User NOT found\n";
        continue;
    }
    
    $employee = $user->employee;
    $department = $user->department;
    
    echo "--- Role: $role ($email) ---\n";
    echo "User ID: " . $user->id . "\n";
    echo "User Name: " . $user->name . "\n";
    echo "Employee ID: " . ($employee ? $employee->id : 'None') . "\n";
    echo "Department: " . ($department ? $department->name . ' (' . $department->id . ')' : 'None') . "\n";
    
    // Check Spatie permissions on guard 'field-leadership'
    $permissions = $user->getAllPermissions()->where('guard_name', 'field-leadership')->pluck('name')->toArray();
    echo "Field Leadership Permissions: " . implode(', ', $permissions) . "\n";
    
    // Check if AreaManager record exists for this user
    $areaManagers = AreaManager::where('user_id', $user->id)->get();
    if ($areaManagers->count() > 0) {
        echo "Area Manager Sections:\n";
        foreach ($areaManagers as $am) {
            $section = Section::find($am->section_id);
            echo " - Section ID: {$am->section_id}, Section Name: " . ($section ? $section->name : 'Unknown') . ", AM ID: {$am->id}\n";
        }
    } else {
        echo "Area Manager: None\n";
    }
    echo "\n";
}

// Check companies owned or linked to user
echo "--- Companies linked to users (representing approval authority) ---\n";
$companies = Company::whereIn('user_id', User::whereIn('email', $emails)->pluck('id'))->get();
foreach ($companies as $comp) {
    $user = User::find($comp->user_id);
    echo "Company: {$comp->company_name} ({$comp->id}), Document Code: {$comp->document_code}, Linked User: " . ($user ? $user->email : 'None') . "\n";
}

