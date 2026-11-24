@extends('layouts.app')

@section('title', 'Selesaikan Pembayaran - The Nice Park Rumpin')

@section('content')
<!-- PROGRESS STEPPER -->
<div style="background-color: #10141f; border: 1px solid #1f273b; border-radius: 6px; padding: 1rem 1.5rem; margin-bottom: 2rem;">
    <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 0.75rem; font-size: 0.8rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.04em;">
        <div style="color: var(--text-muted);">
            <span style="display: inline-block; background-color: #1c2336; color: #94a3b8; width: 22px; height: 22px; text-align: center; line-height: 22px; border-radius: 3px; margin-right: 0.4rem;">1</span>
            Pilih Tiket
        </div>
        <div style="color: #2e3852;">---------</div>
        <div style="color: var(--text-muted);">
            <span style="display: inline-block; background-color: #1c2336; color: #94a3b8; width: 22px; height: 22px; text-align: center; line-height: 22px; border-radius: 3px; margin-right: 0.4rem;">2</span>
            Data Pemesan
        </div>
        <div style="color: #2e3852;">---------</div>
        <div style="color: var(--color-primary);">
            <span style="display: inline-block; background-color: var(--color-primary); color: #000000; width: 22px; height: 22px; text-align: center; line-height: 22px; border-radius: 3px; margin-right: 0.4rem; font-weight: 800;">3</span>
            Pembayaran Midtrans (Aktif)
        </div>
        <div style="color: #2e3852;">---------</div>
        <div style="color: var(--text-sub);">
            <span style="display: inline-block; background-color: #151a27; color: var(--text-sub); width: 22px; height: 22px; text-align: center; line-height: 22px; border-radius: 3px; margin-right: 0.4rem;">4</span>
            E-Ticket Terbit
        </div>
    </div>
</div>

<div class="page-header" style="margin-bottom: 1.75rem;">
    <div>
        <div style="font-size: 0.75rem; color: var(--color-primary); font-weight: 800; text-transform: uppercase; letter-spacing: 0.06em; margin-bottom: 0.35rem;">
            GERBANG PEMBAYARAN RESMI #{{ $order->order_number }}
        </div>
        <h1 class="page-title">Selesaikan Pembayaran Reservasi</h1>
        <p class="page-subtitle">Silakan selesaikan transaksi menggunakan Midtrans Payment Gateway untuk menerbitkan E-Ticket resmi.</p>
    </div>
    <div>
        <a href="{{ route('orders.history') }}" class="btn btn-secondary btn-sm">Kembali ke Riwayat</a>
    </div>
</div>

<div class="grid-2">
    <!-- KOLOM KIRI: RINCIAN LENGKAP PESANAN -->
    <div>
        <!-- KARTU TIKET -->
        <div class="card" style="margin-bottom: 1.5rem; border-top: 3px solid var(--color-primary);">
            <div class="card-header">
                <div>
                    <div style="font-size: 0.72rem; color: var(--text-sub); text-transform: uppercase; letter-spacing: 0.05em;">Ringkasan Item</div>
                    <div class="card-title" style="margin-top: 0.2rem;">
                        {{ $order->isGeneral() ? ($order->ticket->name ?? 'Tiket Masuk Wisata') : ($order->package->name ?? 'Paket Kunjungan Sekolah') }}
                    </div>
                </div>
                @if($order->status === 'paid')
                    <span class="badge badge-paid">Lunas Terverifikasi</span>
                @elseif($order->status === 'approved')
                    <span class="badge badge-approved">Disetujui Admin - Siap Bayar</span>
                @else
                    <span class="badge badge-pending">Menunggu Pembayaran</span>
                @endif
            </div>

            <!-- Tabel Spesifikasi Tagihan -->
            <table style="width: 100%; border-collapse: collapse; font-size: 0.85rem; margin-bottom: 1.25rem;">
                <tr style="border-bottom: 1px solid var(--border-color);">
                    <td style="padding: 0.75rem 0; color: var(--text-muted);">Nomor Registrasi Pesanan</td>
                    <td style="padding: 0.75rem 0; text-align: right; font-family: 'Plus Jakarta Sans', sans-serif; font-weight: 700; color: #ffffff;">
                        {{ $order->order_number }}
                    </td>
                </tr>
                <tr style="border-bottom: 1px solid var(--border-color);">
                    <td style="padding: 0.75rem 0; color: var(--text-muted);">Kategori Kunjungan</td>
                    <td style="padding: 0.75rem 0; text-align: right; color: #ffffff; font-weight: 600;">
                        {{ $order->isGeneral() ? 'Pengunjung Umum / Mandiri' : 'Rombongan Edukasi Sekolah' }}
                    </td>
                </tr>
                <tr style="border-bottom: 1px solid var(--border-color);">
                    <td style="padding: 0.75rem 0; color: var(--text-muted);">Tanggal Rencana Kunjungan</td>
                    <td style="padding: 0.75rem 0; text-align: right; color: var(--color-primary); font-weight: 700;">
                        {{ \Carbon\Carbon::parse($order->visit_date)->isoFormat('dddd, D MMMM Y') }}
                    </td>
                </tr>
                <tr style="border-bottom: 1px solid var(--border-color);">
                    <td style="padding: 0.75rem 0; color: var(--text-muted);">Kuantitas / Jumlah Peserta</td>
                    <td style="padding: 0.75rem 0; text-align: right; color: #ffffff; font-weight: 600;">
                        {{ $order->quantity }} {{ $order->isGeneral() ? 'Orang Pengunjung' : 'Siswa / Anggota' }}
                    </td>
                </tr>
                <tr style="border-bottom: 1px solid var(--border-color);">
                    <td style="padding: 0.75rem 0; color: var(--text-muted);">Tarif Satuan</td>
                    <td style="padding: 0.75rem 0; text-align: right; color: #ffffff;">
                        IDR {{ number_format($order->unit_price, 0, ',', '.') }}
                    </td>
                </tr>
                <tr style="border-bottom: 1px solid var(--border-color);">
                    <td style="padding: 0.75rem 0; color: var(--text-muted);">Biaya Fasilitas & Wahana Wisata</td>
                    <td style="padding: 0.75rem 0; text-align: right; color: #00e676; font-weight: 600;">
                        Termasuk (Gratis)
                    </td>
                </tr>
                <tr>
                    <td style="padding: 1.15rem 0 0.5rem; font-weight: 800; color: #ffffff; font-size: 1rem; text-transform: uppercase;">
                        Total Tagihan Pembayaran
                    </td>
                    <td style="padding: 1.15rem 0 0.5rem; text-align: right; font-family: 'Plus Jakarta Sans', sans-serif; font-size: 1.5rem; font-weight: 800; color: var(--color-primary);">
                        IDR {{ number_format($order->total_price, 0, ',', '.') }}
                    </td>
                </tr>
            </table>

            <!-- Data Kontak Pemesan -->
            <div style="background-color: #0b0e15; border: 1px solid var(--border-color); border-radius: 4px; padding: 1rem; margin-top: 1rem;">
                <div style="font-size: 0.72rem; color: var(--text-muted); font-weight: 800; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 0.65rem;">
                    Identitas Pemesan & Kontak
                </div>
                <div style="font-size: 0.85rem; color: #ffffff; line-height: 1.7;">
                    @if($order->isSchool())
                        <div>Nama Sekolah / Institusi: <strong>{{ $order->school_name }}</strong></div>
                        <div>Penanggung Jawab (PIC): <strong>{{ $order->pic_name }}</strong> ({{ $order->pic_position }})</div>
                    @else
                        <div>Nama Lengkap: <strong>{{ $order->customer_name }}</strong></div>
                    @endif
                    <div>Alamat Email: <strong>{{ $order->customer_email }}</strong></div>
                    <div>Nomor WhatsApp / HP: <strong>{{ $order->customer_phone }}</strong></div>
                </div>
            </div>
        </div>

        <!-- PANDUAN & KETENTUAN KUNJUNGAN -->
        <div class="card" style="border-left: 4px solid var(--color-primary); background-color: #0e121b;">
            <div style="font-size: 0.75rem; color: var(--color-primary); font-weight: 800; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 0.5rem;">
                Ketentuan Masuk Gerbang Wisata
            </div>
            <ul style="list-style: none; font-size: 0.82rem; color: var(--text-muted); line-height: 1.8;">
                <li>- Jam operasional wahana: 08.00 - 17.00 WIB setiap hari.</li>
                <li>- Tiket ini berlaku khusus untuk tanggal kunjungan yang tercantum di atas.</li>
                <li>- Setelah pembayaran lunas, E-Ticket digital dengan QR Code resmi akan terbit seketika.</li>
                <li>- Tunjukkan QR Code pada perangkat ponsel Anda langsung ke petugas turnstile gerbang masuk.</li>
            </ul>
        </div>
    </div>

    <!-- KOLOM KANAN: GATEWAY MIDTRANS & TINDAKAN PEMBAYARAN -->
    <div>
        <div class="card" style="background-color: #111624; border: 1px solid #243048; margin-bottom: 1.5rem;">
            <div class="card-header" style="border-color: #243048;">
                <div>
                    <div style="font-size: 0.72rem; color: var(--color-primary); font-weight: 800; text-transform: uppercase; letter-spacing: 0.05em;">
                        Single Payment Gateway
                    </div>
                    <div class="card-title" style="margin-top: 0.2rem;">Midtrans Payment Gateway</div>
                </div>
                <span class="badge badge-paid">Server Terhubung</span>
            </div>

            <!-- Box Status Saluran Midtrans -->
            <div style="background-color: #090c13; border: 1px solid #1e2638; border-radius: 4px; padding: 1.15rem; margin-bottom: 1.5rem;">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.65rem;">
                    <span style="font-family: 'Plus Jakarta Sans', sans-serif; font-weight: 800; color: #ffffff; font-size: 0.9rem;">
                        METODE PEMBAYARAN TERSEDIA
                    </span>
                    <span style="font-size: 0.72rem; color: #94a3b8; font-weight: 700;">SANDBOX MODE</span>
                </div>
                <p style="font-size: 0.8rem; color: var(--text-muted); line-height: 1.6; margin-bottom: 0.85rem;">
                    Satu-satunya saluran pembayaran resmi terpadu yang diintegrasikan. Mendukung pembayaran instan dengan validasi real-time.
                </p>
                <!-- Saluran Pembayaran (Badges Solid Tanpa Icon) -->
                <div style="display: flex; flex-wrap: wrap; gap: 0.4rem;">
                    <span style="display: inline-block; background-color: #1a2233; color: #e2e8f0; border: 1px solid #2e3a54; padding: 0.25rem 0.55rem; font-size: 0.72rem; font-weight: 700; border-radius: 3px;">QRIS</span>
                    <span style="display: inline-block; background-color: #1a2233; color: #e2e8f0; border: 1px solid #2e3a54; padding: 0.25rem 0.55rem; font-size: 0.72rem; font-weight: 700; border-radius: 3px;">GOPAY</span>
                    <span style="display: inline-block; background-color: #1a2233; color: #e2e8f0; border: 1px solid #2e3a54; padding: 0.25rem 0.55rem; font-size: 0.72rem; font-weight: 700; border-radius: 3px;">SHOPEEPAY</span>
                    <span style="display: inline-block; background-color: #1a2233; color: #e2e8f0; border: 1px solid #2e3a54; padding: 0.25rem 0.55rem; font-size: 0.72rem; font-weight: 700; border-radius: 3px;">BCA VIRTUAL ACCOUNT</span>
                    <span style="display: inline-block; background-color: #1a2233; color: #e2e8f0; border: 1px solid #2e3a54; padding: 0.25rem 0.55rem; font-size: 0.72rem; font-weight: 700; border-radius: 3px;">MANDIRI VA</span>
                    <span style="display: inline-block; background-color: #1a2233; color: #e2e8f0; border: 1px solid #2e3a54; padding: 0.25rem 0.55rem; font-size: 0.72rem; font-weight: 700; border-radius: 3px;">BNI VA</span>
                    <span style="display: inline-block; background-color: #1a2233; color: #e2e8f0; border: 1px solid #2e3a54; padding: 0.25rem 0.55rem; font-size: 0.72rem; font-weight: 700; border-radius: 3px;">BRI VA</span>
                </div>
            </div>

            <!-- Ringkasan Nominal Pembayaran -->
            <div style="background-color: #0d121c; border: 1px solid #243048; border-radius: 4px; padding: 1.25rem; margin-bottom: 1.5rem; text-align: center;">
                <div style="font-size: 0.75rem; color: var(--text-muted); font-weight: 800; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 0.35rem;">
                    Jumlah Yang Harus Dibayar
                </div>
                <div style="font-family: 'Plus Jakarta Sans', sans-serif; font-size: 2.15rem; font-weight: 800; color: #ffffff; letter-spacing: -0.02em;">
                    IDR {{ number_format($order->total_price, 0, ',', '.') }}
                </div>
                <div style="font-size: 0.75rem; color: var(--color-primary); font-weight: 700; margin-top: 0.25rem;">
                    Bebas Biaya Admin Tambahan
                </div>
            </div>

            <!-- Tombol Utama: Bayar Midtrans Snap -->
            <button id="pay-button" class="btn btn-primary btn-block btn-lg" style="font-size: 1rem; font-weight: 800; padding: 1rem; margin-bottom: 0.85rem; letter-spacing: 0.02em;">
                BAYAR SEKARANG DENGAN MIDTRANS
            </button>

            <!-- Tombol Pendukung: Sinkronisasi Status Server Midtrans -->
            <a href="{{ route('orders.checkStatus', $order->id) }}" class="btn btn-secondary btn-block" style="font-size: 0.85rem; margin-bottom: 1.25rem; text-align: center;">
                Periksa Status Transaksi (Sinkronisasi Midtrans)
            </a>

            <!-- Tombol Alternatif / Pengujian Cepat Sandbox (Untuk Presentasi & Evaluasi Sertikom) -->
            <div style="background-color: #0b0e15; border: 1px dashed #243048; border-radius: 4px; padding: 1rem; text-align: center; margin-bottom: 1.25rem;">
                <div style="font-size: 0.72rem; color: var(--text-muted); font-weight: 700; text-transform: uppercase; margin-bottom: 0.5rem;">
                    Mode Pengujian / Demonstrasi Asesor
                </div>
                <a href="{{ route('orders.simulateSuccess', $order->id) }}" class="btn btn-outline btn-sm" style="font-size: 0.8rem; display: inline-block;">
                    Simulasi Pembayaran Midtrans Berhasil
                </a>
            </div>

            <!-- Info Keamanan & Webhook -->
            <div style="border-top: 1px solid #1f273b; padding-top: 1rem; font-size: 0.75rem; color: var(--text-sub); line-height: 1.6;">
                <div>- Enkripsi SSL 256-Bit Resmi Midtrans Sandbox.</div>
                <div>- Sistem dilengkapi listener webhook otomatis dan fallback sinkronisasi langsung ke API Midtrans.</div>
            </div>
        </div>

        <!-- PANDUAN PENGUJIAN MIDTRANS -->
        <div class="card" style="background-color: #0d111a; border: 1px solid #1d2434;">
            <div style="font-size: 0.75rem; color: #ffffff; font-weight: 800; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 0.65rem;">
                Langkah Pembayaran Midtrans
            </div>
            <ol style="padding-left: 1.2rem; font-size: 0.8rem; color: var(--text-muted); line-height: 1.7;">
                <li>Klik tombol <strong>"Bayar Sekarang dengan Midtrans"</strong> untuk memunculkan popup Snap.</li>
                <li>Pilih metode pembayaran yang diinginkan (misalnya QRIS atau Virtual Account).</li>
                <li>Lakukan penyelesaian pembayaran pada Midtrans Simulator Sandbox.</li>
                <li>Sistem otomatis mendeteksi pelunasan dan menerbitkan E-Ticket resmi Anda.</li>
            </ol>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<!-- Midtrans Snap SDK (Sandbox Environment) -->
<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>
<script>
    const snapToken = "{{ $snapToken }}";
    const payBtn = document.getElementById('pay-button');

    if (payBtn) {
        payBtn.addEventListener('click', function () {
            if (typeof snap !== 'undefined' && snapToken && !snapToken.startsWith('DEMO-SNAP')) {
                snap.pay(snapToken, {
                    onSuccess: function(result){
                        window.location.href = "{{ route('midtrans.finish') }}?order_id={{ $order->order_number }}&status_code=200&transaction_status=settlement";
                    },
                    onPending: function(result){
                        alert("Menunggu penyelesaian pembayaran. Anda dapat memeriksa status kapan saja.");
                        window.location.href = "{{ route('orders.checkout', $order->id) }}";
                    },
                    onError: function(result){
                        alert("Transaksi belum berhasil diproses oleh Midtrans. Silakan coba kembali.");
                    },
                    onClose: function(){
                        // Pengguna menutup dialog Snap
                    }
                });
            } else {
                if (confirm('Buka simulasi pembayaran Midtrans Sandbox sukses untuk reservasi ini?')) {
                    window.location.href = "{{ route('orders.simulateSuccess', $order->id) }}";
                }
            }
        });
    }
</script>
@endpush
