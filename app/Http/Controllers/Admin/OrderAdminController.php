<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Services\MidtransService;
use Illuminate\Http\Request;

class OrderAdminController extends Controller
{
    protected MidtransService $midtransService;

    public function __construct(MidtransService $midtransService)
    {
        $this->midtransService = $midtransService;
    }

    public function index(Request $request)
    {
        // Eager Loading relasi untuk mengatasi N+1 Query
        $query = Order::with(['ticket', 'package', 'latestPayment'])->latest();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('order_number', 'like', "%{$search}%")
                  ->orWhere('customer_name', 'like', "%{$search}%")
                  ->orWhere('customer_email', 'like', "%{$search}%")
                  ->orWhere('school_name', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        $orders = $query->paginate(15)->withQueryString();

        return view('admin.orders.index', compact('orders'));
    }

    public function show($id)
    {
        // Eager load seluruh relasi
        $order = Order::with(['ticket', 'package', 'payments', 'latestPayment', 'eTicket', 'user'])->findOrFail($id);
        return view('admin.orders.show', compact('order'));
    }

    /**
     * Verifikasi Manual Pembayaran (jika diperlukan admin)
     */
    public function verifyPayment($id)
    {
        $order = Order::findOrFail($id);
        $this->midtransService->handlePaymentSuccess($order, 'manual_admin_verification');

        return redirect()->route('admin.orders.show', $order->id)->with('success', 'Pembayaran berhasil diverifikasi secara manual oleh admin. E-ticket telah aktif.');
    }
}
