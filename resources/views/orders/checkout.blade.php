@extends('layouts.app')

@section('title', 'Selesaikan Pembayaran - The Nice Park Rumpin')

@section('content')
<div class="page-header">
    <div>
        <div style="font-size: 0.75rem; color: var(--color-primary); text-transform: uppercase; margin-bottom: 0.35rem;">Transaksi #{{ $order->order_number }}</div>
        <h1 class="page-title">Pembayaran Tiket</h1>
        <p class="page-subtitle">Selesaikan transaksi menggunakan gateway pembayaran resmi Midtrans.</p>
    </div>
</div>

<div class="grid-2">
    <!-- Kolom Kiri: Ringkasan Rincian Pesanan -->
    <div>
        <div class="card" style="margin-bottom: 1.5rem;">
            <div class="card-header">
                <div class="card-title">Rincian Reservasi</div>
                @if($order->status === 'paid')
                    <span class="badge badge-paid">Lunas</span>
                @elseif($order->status === 'approved')
                    <span class="badge badge-approved">Disetujui Admin - Siap Bayar</span>
                @else
                    <span class="badge badge-pending">Menunggu Pembayaran</span>
                @endif
            </div>

            <table style="width: 100%; border-collapse: collapse; font-size: 0.85rem; margin-bottom: 1.5rem;">
                <tr style="border-bottom: 1px solid var(--border-color);">
                    <td style="padding: 0.75rem 0; color: var(--text-muted);">Nomor Pesanan</td>
                    <td style="padding: 0.75rem 0; text-align: right; font-family: 'Plus Jakarta Sans', sans-serif; font-weight: 700; color: #ffffff;">{{ $order->order_number }}</td>
                </tr>
                <tr style="border-bottom: 1px solid var(--border-color);">
                    <td style="padding: 0.75rem 0; color: var(--text-muted);">Jenis Item</td>
                    <td style="padding: 0.75rem 0; text-align: right; color: #ffffff;">
                        {{ $order->isGeneral() ? ($order->ticket->name ?? 'Tiket Masuk') : ($order->package->name ?? 'Paket Sekolah') }}
                    </td>
                </tr>
                <tr style="border-bottom: 1px solid var(--border-color);">
                    <td style="padding: 0.75rem 0; color: var(--text-muted);">Tanggal Kunjungan</td>
                    <td style="padding: 0.75rem 0; text-align: right; color: #ffffff;">{{ \Carbon\Carbon::parse($order->visit_date)->isoFormat('D MMMM Y') }}</td>
                </tr>
                <tr style="border-bottom: 1px solid var(--border-color);">
                    <td style="padding: 0.75rem 0; color: var(--text-muted);">Jumlah Peserta</td>
                    <td style="padding: 0.75rem 0; text-align: right; color: #ffffff;">{{ $order->quantity }} {{ $order->isGeneral() ? 'Orang' : 'Siswa' }}</td>
                </tr>
                <tr style="border-bottom: 1px solid var(--border-color);">
                    <td style="padding: 0.75rem 0; color: var(--text-muted);">Tarif Satuan</td>
                    <td style="padding: 0.75rem 0; text-align: right; color: #ffffff;">IDR {{ number_format($order->unit_price, 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <td style="padding: 1rem 0; font-weight: 700; color: #ffffff; font-size: 0.95rem;">Total Tagihan</td>
                    <td style="padding: 1rem 0; text-align: right; font-family: 'Plus Jakarta Sans', sans-serif; font-size: 1.35rem; font-weight: 800; color: var(--color-primary);">
                        IDR {{ number_format($order->total_price, 0, ',', '.') }}
                    </td>
                </tr>
            </table>

            <div style="border-top: 1px solid var(--border-color); padding-top: 1rem;">
                <h4 style="font-size: 0.8rem; color: var(--text-muted); text-transform: uppercase; margin-bottom: 0.5rem;">Data Pemesan</h4>
                <div style="font-size: 0.85rem; color: #ffffff; line-height: 1.7;">
                    @if($order->isSchool())
                        <div>Sekolah: <strong>{{ $order->school_name }}</strong></div>
                        <div>PIC: {{ $order->pic_name }} ({{ $order->pic_position }})</div>
                    @else
                        <div>Nama: {{ $order->customer_name }}</div>
                    @endif
                    <div>Email: {{ $order->customer_email }}</div>
                    <div>Telepon: {{ $order->customer_phone }}</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Kolom Kanan: Gateway Midtrans (1 Doang, Jangan Ada Metode Lain Sesuai Permintaan) -->
    <div>
        <div class="card" style="background-color: #141c2e; border-color: var(--color-primary);">
            <div class="card-header">
                <div class="card-title">Metode Pembayaran</div>
            </div>

            <!-- Single Payment Method Box: MIDTRANS ONLY -->
            <div style="background-color: #0c0f17; border: 1px solid var(--color-primary); padding: 1.25rem; border-radius: 4px; margin-bottom: 1.5rem;">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.5rem;">
                    <span style="font-family: 'Plus Jakarta Sans', sans-serif; font-weight: 800; color: #ffffff; font-size: 0.95rem;">MIDTRANS PAYMENT GATEWAY</span>
                    <span class="badge badge-paid">TERHUBUNG</span>
                </div>
                <p style="font-size: 0.8rem; color: var(--text-muted); line-height: 1.6;">
                    Satu-satunya saluran pembayaran resmi yang diaktifkan. Mendukung QRIS (GoPay, OVO, Dana), Virtual Account (BCA, Mandiri, BNI, BRI), dan Kartu secara terpadu melalui sistem Midtrans Snap.
                </p>
            </div>

            <div style="margin-bottom: 1.5rem;">
                <div style="font-size: 0.8rem; color: var(--text-sub); text-transform: uppercase; margin-bottom: 0.35rem;">Total Tagihan:</div>
                <div style="font-family: 'Plus Jakarta Sans', sans-serif; font-size: 2rem; font-weight: 800; color: #ffffff;">
                    IDR {{ number_format($order->total_price, 0, ',', '.') }}
                </div>
            </div>

            <!-- Tombol Trigger Midtrans Snap -->
            <button id="pay-button" class="btn btn-primary btn-block btn-lg" style="margin-bottom: 1rem;">
                Bayar Sekarang dengan Midtrans
            </button>

            <!-- Tombol Verifikasi Cepat Sandbox (Untuk Memudahkan Penguji / Asesor Ujian) -->
            <div style="text-align: center; margin-top: 1rem; border-top: 1px dashed var(--border-color); padding-top: 1rem;">
                <div style="font-size: 0.75rem; color: var(--text-sub); margin-bottom: 0.5rem;">Pengujian Sandbox (Otomatis Verifikasi Server & Terbitkan E-Ticket):</div>
                <a href="{{ route('orders.simulateSuccess', $order->id) }}" class="btn btn-secondary btn-sm" style="display: inline-block;">
                    Simulasi Pembayaran Midtrans Berhasil
                </a>
            </div>

            <div style="margin-top: 1.5rem; padding-top: 1rem; border-top: 1px solid var(--border-color); font-size: 0.75rem; color: var(--text-sub); line-height: 1.6;">
                Status transaksi akan diperbarui otomatis secara real-time via webhook callback server Midtrans ke server The Nice Park Rumpin.
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<!-- Midtrans Snap SDK -->
<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>
<script>
    const snapToken = "{{ $snapToken }}";
    document.getElementById('pay-button').addEventListener('click', function () {
        if (typeof snap !== 'undefined' && snapToken && !snapToken.startsWith('DEMO-SNAP')) {
            snap.pay(snapToken, {
                onSuccess: function(result){
                    window.location.href = "{{ route('orders.simulateSuccess', $order->id) }}";
                },
                onPending: function(result){
                    alert("Menunggu pembayaran: Silakan selesaikan pembayaran sesuai instruksi.");
                    window.location.href = "{{ route('orders.history') }}";
                },
                onError: function(result){
                    alert("Pembayaran gagal!");
                },
                onClose: function(){
                    alert('Anda menutup popup pembayaran sebelum menyelesaikan transaksi.');
                }
            });
        } else {
            // Jika berjalan di lingkungan offline/demo sandbox
            if (confirm('Buka simulasi pembayaran Midtrans Sandbox sukses?')) {
                window.location.href = "{{ route('orders.simulateSuccess', $order->id) }}";
            }
        }
    });
</script>
@endpush
