<?php

require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$id = 'a20f2a24-9614-4c22-91e8-9c0fca963843';
$b = Modules\CSMS\Entities\Bidding::find($id);

if ($b) {
    echo "Bidding ID: " . $b->id . "\n";
    echo "Bidding company_id: " . var_export($b->company_id, true) . "\n";
    echo "Bidding parent_company: " . var_export($b->parent_company ? $b->parent_company->company_name : null, true) . "\n";
} else {
    echo "Bidding not found\n";
}
