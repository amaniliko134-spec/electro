<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

try {
    /** @var Iankumu\Mpesa\Mpesa $m */
    $m = $app->make(Iankumu\Mpesa\Mpesa::class);
    $phone = '254700000000';
    $amount = 1;
    $accountRef = 'TESTINV123';
    echo "Calling STK push...\n";
    $response = $m->stkpush($phone, $amount, $accountRef, null, Iankumu\Mpesa\Mpesa::PAYBILL, 'C2B');
    echo "HTTP Status: " . $response->status() . "\n";
    echo "Body: " . $response->body() . "\n";
} catch (Exception $e) {
    echo "EX:" . $e->getMessage() . PHP_EOL;
}
