<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
// bootstrap the application
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

try {
    $m = $app->make(Iankumu\Mpesa\Mpesa::class);
    $token = $m->generateAccessToken('C2B');
    echo "TOKEN:" . $token . PHP_EOL;
} catch (Exception $e) {
    echo "EX:" . $e->getMessage() . PHP_EOL;
}
