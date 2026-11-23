<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class TicketController extends Controller
{
    public function index()
    {
        $tickets = Ticket::where('is_active', true)->get();
        return view('tickets.index', compact('tickets'));
    }

    public function show($id)
    {
        $ticket = Ticket::where('is_active', true)->findOrFail($id);
        return view('tickets.show', compact('ticket'));
    }

    /**
     * Memproses pemesanan tiket umum (Perhitungan total di server)
     */
    public function storeOrder(Request $request, $id)
    {
        $ticket = Ticket::where('is_active', true)->findOrFail($id);

        $validated = $request->validate([
            'visit_date' => ['required', 'date', 'after_or_equal:today'],
            'quantity' => ['required', 'integer', 'min:1', 'max:50'],
            'customer_name' => ['required', 'string', 'max:255'],
            'customer_email' => ['required', 'email', 'max:255'],
            'customer_phone' => ['required', 'string', 'max:20'],
        ], [
            'visit_date.required' => 'Tanggal kunjungan wajib ditentukan.',
            'visit_date.after_or_equal' => 'Tanggal kunjungan minimal adalah hari ini.',
            'quantity.required' => 'Jumlah tiket wajib diisi.',
            'quantity.min' => 'Jumlah tiket minimal 1.',
            'customer_name.required' => 'Nama pemesan wajib diisi.',
            'customer_email.required' => 'Alamat email wajib diisi.',
            'customer_phone.required' => 'Nomor telepon wajib diisi.',
        ]);

        // Perhitungan total harga dilakukan murni di SERVER untuk keamanan
        $quantity = (int) $validated['quantity'];
        $unitPrice = (int) $ticket->price;
        $totalPrice = $quantity * $unitPrice;

        // Generate nomor order unik
        $orderNumber = 'TRX-' . date('Ymd') . '-' . strtoupper(Str::random(5));

        $order = Order::create([
            'order_number' => $orderNumber,
            'user_id' => Auth::id(), // null jika guest atau sesuai user login
            'type' => 'general',
            'ticket_id' => $ticket->id,
            'visit_date' => $validated['visit_date'],
            'quantity' => $quantity,
            'unit_price' => $unitPrice,
            'total_price' => $totalPrice,
            'status' => 'unpaid', // Tiket umum langsung unpaid -> siap bayar Midtrans
            'customer_name' => $validated['customer_name'],
            'customer_email' => $validated['customer_email'],
            'customer_phone' => $validated['customer_phone'],
        ]);

        return redirect()->route('orders.checkout', $order->id)->with('success', 'Pesanan berhasil dibuat. Silakan selesaikan pembayaran.');
    }
}
