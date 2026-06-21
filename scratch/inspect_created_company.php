<?php

require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$c = App\Models\Company::where('company_name', 'PT Maju Mundur')->first();
if ($c) {
    echo "ID: " . $c->id . "\n";
    echo "Name: " . $c->company_name . "\n";
    echo "Parent Company ID: " . var_export($c->parent_company_id, true) . "\n";
    
    $parent = App\Models\Company::find($c->parent_company_id);
    echo "Parent Name: " . ($parent ? $parent->company_name : 'No Parent Found') . "\n";
} else {
    echo "Company PT Maju Mundur not found in DB\n";
}
