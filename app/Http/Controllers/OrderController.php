<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Services\MidtransService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    protected MidtransService $midtransService;

    public function __construct(MidtransService $midtransService)
    {
        $this->midtransService = $midtransService;
    }

    /**
     * Halaman Checkout Pembayaran Midtrans (Single Payment Gateway)
     */
    public function checkout($id)
    {
        // Eager load item relation
        $order = Order::with(['ticket', 'package', 'latestPayment'])->findOrFail($id);

        // Otorisasi: Paket sekolah yang belum disetujui admin tidak boleh dibayar
        if ($order->isSchool() && $order->status === 'pending_approval') {
            return redirect()->route('orders.history')->with('error', 'Pengajuan ini masih menunggu peninjauan dan persetujuan dari pengelola.');
        }

        if ($order->status === 'rejected') {
            return redirect()->route('orders.history')->with('error', 'Pengajuan kunjungan sekolah ini ditolak oleh pengelola.');
        }

        // Jika sudah lunas, langsung ke e-ticket
        if ($order->isPaid()) {
            return redirect()->route('orders.eticket', $order->id);
        }

        // Generate Midtrans Snap Token
        $snapToken = $this->midtransService->getSnapToken($order);

        return view('orders.checkout', compact('order', 'snapToken'));
    }

    /**
     * Riwayat Pesanan Pelanggan (Optimasi Eager Loading N+1 Query)
     */
    public function history(Request $request)
    {
        $userId = Auth::id();
        
        // Eager Loading relasi ticket, package, eTicket, latestPayment untuk mencegah N+1 Query
        $query = Order::with(['ticket', 'package', 'eTicket', 'latestPayment'])
            ->latest();

        if ($userId) {
            $query->where('user_id', $userId);
        }

        // Filter tab
        $status = $request->query('status');
        if ($status === 'unpaid') {
            $query->whereIn('status', ['unpaid', 'approved']);
        } elseif ($status === 'pending_approval') {
            $query->where('status', 'pending_approval');
        } elseif ($status === 'paid') {
            $query->where('status', 'paid');
        }

        $orders = $query->get();

        return view('orders.history', compact('orders', 'status'));
    }

    /**
     * Tampilan E-Ticket Resmi (Hanya Terbit Jika Pembayaran Terverifikasi Server)
     */
    public function eticket($id)
    {
        // Eager load eTicket dan payment
        $order = Order::with(['ticket', 'package', 'eTicket', 'latestPayment'])->findOrFail($id);

        // Verifikasi ketat server: E-ticket hanya tampil jika status PAID
        if (!$order->isPaid()) {
            return redirect()->route('orders.checkout', $order->id)->with('error', 'E-Ticket belum aktif karena pembayaran belum terverifikasi lunas.');
        }

        // Jika eTicket record belum tergenerate, buat sekarang via service
        if (!$order->eTicket) {
            $order = $this->midtransService->handlePaymentSuccess($order, 'midtrans');
        }

        return view('orders.eticket', compact('order'));
    }

    /**
     * Simulasi Pembayaran Sukses Sandbox Midtrans (untuk keperluan demo presentasi)
     */
    public function simulateSuccess($id)
    {
        $order = Order::findOrFail($id);

        // Khusus sekolah harus approved terlebih dahulu
        if ($order->isSchool() && $order->status === 'pending_approval') {
            return redirect()->route('orders.history')->with('error', 'Pengajuan sekolah belum disetujui admin.');
        }

        // Proses sukses dan terbitkan e-ticket di server
        $this->midtransService->handlePaymentSuccess($order, 'midtrans_sandbox');

        return redirect()->route('orders.eticket', $order->id)->with('success', 'Pembayaran Midtrans berhasil diverifikasi! E-ticket resmi telah diterbitkan.');
    }

    /**
     * Webhook Notifikasi Server Midtrans (Callback resmi dari API Midtrans)
     */
    public function handleMidtransNotification(Request $request)
    {
        $payload = $request->all();
        $orderNumber = $payload['order_id'] ?? null;
        $transactionStatus = $payload['transaction_status'] ?? null;
        $fraudStatus = $payload['fraud_status'] ?? null;
        $paymentType = $payload['payment_type'] ?? 'midtrans';
        $transactionId = $payload['transaction_id'] ?? null;

        if (!$orderNumber) {
            return response()->json(['message' => 'Order ID is required'], 400);
        }

        $order = Order::where('order_number', $orderNumber)->first();
        if (!$order) {
            return response()->json(['message' => 'Order not found'], 404);
        }

        // Evaluasi status dari Midtrans
        if ($transactionStatus == 'capture') {
            if ($fraudStatus == 'accept') {
                $this->midtransService->handlePaymentSuccess($order, $paymentType, $transactionId);
            }
        } elseif ($transactionStatus == 'settlement') {
            $this->midtransService->handlePaymentSuccess($order, $paymentType, $transactionId);
        } elseif (in_array($transactionStatus, ['cancel', 'deny', 'expire'])) {
            $order->update(['status' => 'cancelled']);
        } elseif ($transactionStatus == 'pending') {
            $order->update(['status' => 'unpaid']);
        }

        return response()->json(['status' => 'success', 'message' => 'Notification processed successfully']);
    }
}
