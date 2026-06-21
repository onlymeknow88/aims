<?php

require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$id = 'a20f2a24-9614-4c22-91e8-9c0fca963843';
$b = Modules\CSMS\Entities\Bidding::find($id);

if ($b) {
    $c = App\Models\Company::where('company_name', $b->company_name)->first();
    if ($c) {
        $b->company_id = $c->id;
        $b->save();
        echo "Successfully linked Bidding ID {$b->id} to Company ID {$c->id} ('{$c->company_name}').\n";
    } else {
        echo "Company '{$b->company_name}' not found to link.\n";
    }
} else {
    echo "Bidding not found.\n";
}
