<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Package;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class SchoolPackageController extends Controller
{
    public function index()
    {
        $packages = Package::where('is_active', true)->get();
        return view('school.index', compact('packages'));
    }

    public function apply(Request $request)
    {
        $packages = Package::where('is_active', true)->get();
        $selectedPackageId = $request->query('package');
        $selectedPackage = $packages->firstWhere('id', $selectedPackageId) ?? $packages->first();

        return view('school.apply', compact('packages', 'selectedPackage'));
    }

    public function storeApply(Request $request)
    {
        $validated = $request->validate([
            'school_name' => ['required', 'string', 'max:255'],
            'school_address' => ['required', 'string'],
            'pic_name' => ['required', 'string', 'max:255'],
            'pic_position' => ['required', 'string', 'max:255'],
            'pic_phone' => ['required', 'string', 'max:20'],
            'pic_email' => ['required', 'email', 'max:255'],
            'package_id' => ['required', 'exists:packages,id'],
            'visit_date' => ['required', 'date', 'after:today'],
            'student_count' => ['required', 'integer', 'min:1'],
            'notes' => ['nullable', 'string'],
        ], [
            'school_name.required' => 'Nama institusi sekolah wajib diisi.',
            'school_address.required' => 'Alamat sekolah wajib diisi.',
            'pic_name.required' => 'Nama penanggung jawab wajib diisi.',
            'pic_position.required' => 'Jabatan penanggung jawab wajib diisi.',
            'pic_phone.required' => 'Nomor WhatsApp penanggung jawab wajib diisi.',
            'pic_email.required' => 'Email resmi sekolah wajib diisi.',
            'package_id.required' => 'Pilihan paket wajib ditentukan.',
            'visit_date.required' => 'Rencana tanggal kunjungan wajib diisi.',
            'visit_date.after' => 'Tanggal pengajuan sekolah minimal H+1 dari hari ini.',
            'student_count.required' => 'Estimasi jumlah peserta wajib diisi.',
        ]);

        $package = Package::findOrFail($validated['package_id']);

        if ($validated['student_count'] < $package->min_students) {
            return back()->withErrors([
                'student_count' => "Minimal peserta untuk {$package->name} adalah {$package->min_students} siswa."
            ])->withInput();
        }

        // Perhitungan total estimasi biaya murni di server
        $quantity = (int) $validated['student_count'];
        $unitPrice = (int) $package->price_per_student;
        $totalPrice = $quantity * $unitPrice;

        $orderNumber = 'SCH-' . date('Ymd') . '-' . strtoupper(Str::random(5));

        $order = Order::create([
            'order_number' => $orderNumber,
            'user_id' => Auth::id(),
            'type' => 'school',
            'package_id' => $package->id,
            'visit_date' => $validated['visit_date'],
            'quantity' => $quantity,
            'unit_price' => $unitPrice,
            'total_price' => $totalPrice,
            'status' => 'pending_approval', // Khusus paket sekolah: Menunggu persetujuan admin terlebih dahulu
            'customer_name' => $validated['pic_name'],
            'customer_email' => $validated['pic_email'],
            'customer_phone' => $validated['pic_phone'],
            'school_name' => $validated['school_name'],
            'school_address' => $validated['school_address'],
            'pic_name' => $validated['pic_name'],
            'pic_position' => $validated['pic_position'],
            'pic_phone' => $validated['pic_phone'],
            'pic_email' => $validated['pic_email'],
            'notes' => $validated['notes'] ?? null,
        ]);

        return redirect()->route('orders.history')->with('success', 'Pengajuan paket sekolah berhasil dikirim! Menunggu peninjauan dan persetujuan dari pihak pengelola.');
    }
}
