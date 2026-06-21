<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$count = Modules\Audit\Entities\Audit::where('title', 'like', 'Dummy Audit%')->count();
echo "Total dummy audits: $count\n";

foreach (Modules\Audit\Entities\Audit::where('title', 'like', 'Dummy Audit%')->get() as $a) {
    echo "ID: {$a->id}, Title: {$a->title}\n";
}
