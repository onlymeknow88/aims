<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

foreach (Modules\Audit\Entities\Audit::where('title', 'like', 'Dummy Audit%')->get() as $a) {
    echo $a->title . ": " . $a->id . "\n";
}
