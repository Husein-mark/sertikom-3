 <?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

$p = App\Models\Payment::where('midtrans_order_id', 'TRX-20261124-PSZVT')->first();
if ($p) {
    echo "Found payment for TRX-20261124-PSZVT:\n";
    echo "ID: {$p->id}\n";
    echo "Snap token: {$p->snap_token}\n";
    echo "Status: {$p->transaction_status}\n";
} else {
    echo "Payment TRX-20261124-PSZVT not found in DB\n";
}
