<?php

require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

// Set up test email details
$testEmail = 'fadjri.wivindi@alamtri.com'; // Ganti dengan email tujuan testing Anda
$otp = rand(100000, 999999);

echo "Mencoba mengirimkan email OTP ke {$testEmail}...\n";

try {
    $body = view('emails.otp', ['otp' => $otp])->render();

    $result = sendPowerAutomateEmail([
        'SendTo' => $testEmail,
        'Title' => 'Test Kode OTP Login AIMS - '.$otp,
        'MsgBody' => $body,
        'AttchmentPath' => '',
        'AttchmentName' => '',
        'SendCC' => '',
        'Key' => '!234$'
    ]);

    print_r($result);
} catch (\Exception $e) {
    echo 'Error: '.$e->getMessage()."\n";
}
