<?php
require __DIR__ . '/vendor/autoload.php';
\Midtrans\Config::$serverKey = 'SB-Mid-server-.ExlQQKtsHmMvgA~4k0tY8nF';
\Midtrans\Config::$isProduction = false;

$tests = [
    'empty (all)' => [],
    'only qris' => ['qris'],
    'qris,gopay' => ['qris', 'gopay'],
];

foreach ($tests as $label => $channels) {
    $p = ['transaction_details' => ['order_id' => 'TEST-' . rand(1000,9999) . '-' . time(), 'gross_amount' => 50000]];
    if (!empty($channels)) {
        $p['enabled_payments'] = $channels;
    }
    $res = \Midtrans\Snap::createTransaction($p);
    $url = "https://app.sandbox.midtrans.com/snap/v1/transactions/{$res->token}";
    $json = json_decode(file_get_contents($url), true);
    $count = count($json['enabled_payments'] ?? []);
    echo "Test '$label': count={$count}\n";
    foreach ($json['enabled_payments'] ?? [] as $ep) {
        echo "   - {$ep['type']}" . (isset($ep['acquirer']) ? " ({$ep['acquirer']})" : "") . "\n";
    }
}
