<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class SchoolAdminController extends Controller
{
    public function index(Request $request)
    {
        // Eager loading relasi package
        $query = Order::with(['package'])->where('type', 'school')->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $schools = $query->paginate(15)->withQueryString();

        return view('admin.school.index', compact('schools'));
    }

    public function show($id)
    {
        $order = Order::with(['package', 'user', 'latestPayment'])->where('type', 'school')->findOrFail($id);
        return view('admin.school.show', compact('order'));
    }

    /**
     * Setujui atau Tolak Permohonan Sekolah
     */
    public function updateStatus(Request $request, $id)
    {
        $order = Order::where('type', 'school')->findOrFail($id);

        $validated = $request->validate([
            'action' => ['required', 'in:approve,reject'],
            'admin_notes' => ['nullable', 'string'],
        ]);

        if ($validated['action'] === 'approve') {
            $order->update([
                'status' => 'approved', // Setelah disetujui, pelanggan dapat membayar lewat Midtrans
                'admin_notes' => $validated['admin_notes'] ?? 'Permohonan disetujui oleh pengelola.',
            ]);
            $msg = 'Permohonan sekolah berhasil disetujui. Tagihan pembayaran Midtrans sekarang aktif untuk pemesan.';
        } else {
            $order->update([
                'status' => 'rejected',
                'admin_notes' => $validated['admin_notes'] ?? 'Permohonan tidak dapat disetujui.',
            ]);
            $msg = 'Permohonan sekolah ditolak.';
        }

        return redirect()->route('admin.school.show', $order->id)->with('success', $msg);
    }
}
