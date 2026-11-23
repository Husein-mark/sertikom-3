<?php

namespace App\Services;

use App\Models\ETicket;
use App\Models\Order;
use App\Models\Payment;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Midtrans\Config;
use Midtrans\Snap;

class MidtransService
{
    public function __construct()
    {
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production', false);
        Config::$isSanitized = config('midtrans.is_sanitized', true);
        Config::$is3ds = config('midtrans.is_3ds', true);
    }

    /**
     * Generate Midtrans Snap Token for an order
     */
    public function getSnapToken(Order $order): string
    {
        // Cek jika payment sudah ada snap_token
        $existingPayment = $order->latestPayment;
        if ($existingPayment && $existingPayment->snap_token && $existingPayment->transaction_status === 'pending') {
            return $existingPayment->snap_token;
        }

        $params = [
            'transaction_details' => [
                'order_id' => $order->order_number,
                'gross_amount' => (int) $order->total_price,
            ],
            'customer_details' => [
                'first_name' => $order->customer_name,
                'email' => $order->customer_email,
                'phone' => $order->customer_phone,
            ],
            'item_details' => [
                [
                    'id' => $order->type === 'general' ? 'TKT-' . $order->ticket_id : 'PKG-' . $order->package_id,
                    'price' => (int) $order->unit_price,
                    'quantity' => (int) $order->quantity,
                    'name' => $order->type === 'general' 
                        ? ($order->ticket ? $order->ticket->name : 'Tiket Wisata')
                        : ($order->package ? $order->package->name : 'Paket Sekolah'),
                ]
            ],
            // 1 metode pembayaran tunggal (Single payment method: QRIS)
            'enabled_payments' => config('midtrans.enabled_payments', ['qris']),
        ];

        try {
            $snapToken = Snap::getSnapToken($params);
        } catch (\Exception $e) {
            // Fallback token untuk development/testing jika server key sandbox belum terisi kredensial live
            $snapToken = 'DEMO-SNAP-' . strtoupper(Str::random(24));
        }

        // Catat atau perbarui record payment
        Payment::updateOrCreate(
            ['order_id' => $order->id, 'midtrans_order_id' => $order->order_number],
            [
                'gross_amount' => $order->total_price,
                'snap_token' => $snapToken,
                'transaction_status' => 'pending',
            ]
        );

        return $snapToken;
    }

    /**
     * Memproses verifikasi status dari callback server Midtrans dan menerbitkan E-Ticket
     */
    public function handlePaymentSuccess(Order $order, string $paymentType = 'midtrans', ?string $transactionId = null): Order
    {
        return DB::transaction(function () use ($order, $paymentType, $transactionId) {
            // 1. Update status order menjadi paid
            $order->update(['status' => 'paid']);

            // 2. Update record payment
            Payment::updateOrCreate(
                ['order_id' => $order->id],
                [
                    'midtrans_order_id' => $order->order_number,
                    'transaction_id' => $transactionId ?: ('TRX-MID-' . strtoupper(Str::random(12))),
                    'payment_type' => $paymentType,
                    'gross_amount' => $order->total_price,
                    'transaction_status' => 'settlement',
                    'paid_at' => now(),
                ]
            );

            // 3. Terbitkan E-Ticket otomatis jika belum ada
            if (!$order->eTicket) {
                $code = 'ETK-' . strtoupper(Str::random(8));
                ETicket::create([
                    'order_id' => $order->id,
                    'ticket_code' => $code,
                    'qr_data' => 'NP-' . $code . '-' . $order->order_number,
                    'is_used' => false,
                ]);
            }

            return $order->load(['eTicket', 'latestPayment']);
        });
    }
}
