<?php
require __DIR__ . '/vendor/autoload.php';

$keyAlwi = 'SB-Mid-server-.ExlQQKtsHmMvgA~4k0tY8nF';
\Midtrans\Config::$serverKey = $keyAlwi;
\Midtrans\Config::$isProduction = false;

// Test with enabled_payments = ['qris']
try {
    $p1 = [
        'transaction_details' => ['order_id' => 'ALWI-QRIS-' . time(), 'gross_amount' => 50000],
        'enabled_payments' => ['qris'],
    ];
    $res1 = \Midtrans\Snap::createTransaction($p1);
    echo "1. Key Alwi with ['qris']:\nToken: {$res1->token}\nURL: {$res1->redirect_url}\n";
} catch (\Exception $e) {
    echo "1. Error: " . $e->getMessage() . "\n";
}

// Test with NO enabled_payments (all active channels)
try {
    $p2 = [
        'transaction_details' => ['order_id' => 'ALWI-ALL-' . time(), 'gross_amount' => 50000],
    ];
    $res2 = \Midtrans\Snap::createTransaction($p2);
    echo "\n2. Key Alwi WITHOUT enabled_payments (all channels):\nToken: {$res2->token}\nURL: {$res2->redirect_url}\n";
} catch (\Exception $e) {
    echo "2. Error: " . $e->getMessage() . "\n";
}
