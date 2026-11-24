@extends('layouts.app')

@section('title', 'E-Ticket Resmi - ' . $order->order_number)

@section('content')
<div class="page-header">
    <div>
        <div style="font-size: 0.75rem; color: var(--color-primary); font-weight: 800; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 0.35rem;">
            TIKET ELEKTRONIK RESMI SAH
        </div>
        <h1 class="page-title">Digital Entry Pass Pengunjung</h1>
        <p class="page-subtitle">Tunjukkan bukti digital ini langsung pada turnstile / petugas gerbang masuk The Nice Park Rumpin.</p>
    </div>
    <div style="display: flex; gap: 0.75rem; flex-wrap: wrap;">
        <button onclick="window.print()" class="btn btn-secondary btn-sm">Cetak / Simpan PDF</button>
        <a href="{{ route('orders.history') }}" class="btn btn-primary btn-sm">Riwayat Pesanan</a>
    </div>
</div>

<!-- E-TICKET DIGITAL PASS CONTAINER -->
<div style="max-width: 820px; margin: 0 auto;">
    <div class="card" style="border: 2px solid var(--color-primary); background-color: #0d111a; padding: 2.25rem; border-radius: 8px;">
        
        <!-- HEADER TIKET -->
        <div style="display: flex; justify-content: space-between; align-items: flex-start; border-bottom: 2px solid #1f283d; padding-bottom: 1.5rem; margin-bottom: 1.75rem; flex-wrap: wrap; gap: 1rem;">
            <div>
                <div style="font-family: 'Plus Jakarta Sans', sans-serif; font-size: 1.5rem; font-weight: 800; color: #ffffff; letter-spacing: -0.02em;">
                    THE NICE PARK <span style="color: var(--color-primary);">RUMPIN</span>
                </div>
                <div style="font-size: 0.75rem; color: var(--text-sub); text-transform: uppercase; font-weight: 700; letter-spacing: 0.08em; margin-top: 0.25rem;">
                    OFFICIAL TOURISM & EDUCATION ELECTRONIC PASS
                </div>
            </div>
            <div style="text-align: right;">
                <span class="badge badge-paid" style="font-size: 0.8rem; padding: 0.4rem 0.85rem;">TERVERIFIKASI LUNAS</span>
                <div style="font-family: 'Plus Jakarta Sans', sans-serif; font-size: 0.85rem; font-weight: 800; color: #ffffff; margin-top: 0.5rem;">
                    KODE TIKET: {{ $order->eTicket->ticket_code ?? 'ETK-RESMI' }}
                </div>
            </div>
        </div>

        <!-- ISI KARTU TIKET: 2 KOLOM -->
        <div class="grid-2" style="margin-bottom: 1.75rem;">
            <!-- RINCIAN KUNJUNGAN -->
            <div style="background-color: #080b11; border: 1px solid #1c2438; border-radius: 6px; padding: 1.5rem;">
                <div style="margin-bottom: 1.25rem;">
                    <div style="font-size: 0.72rem; color: var(--text-muted); font-weight: 700; text-transform: uppercase; letter-spacing: 0.04em;">
                        Kategori Reservasi
                    </div>
                    <div style="font-size: 1.2rem; color: #ffffff; font-weight: 800; margin-top: 0.2rem;">
                        {{ $order->isGeneral() ? ($order->ticket->name ?? 'Tiket Masuk Wisata') : ($order->package->name ?? 'Paket Sekolah') }}
                    </div>
                </div>

                <div style="margin-bottom: 1.25rem;">
                    <div style="font-size: 0.72rem; color: var(--text-muted); font-weight: 700; text-transform: uppercase; letter-spacing: 0.04em;">
                        Tanggal Kunjungan Resmi
                    </div>
                    <div style="font-family: 'Plus Jakarta Sans', sans-serif; font-size: 1.25rem; color: var(--color-primary); font-weight: 800; margin-top: 0.2rem;">
                        {{ \Carbon\Carbon::parse($order->visit_date)->isoFormat('dddd, D MMMM Y') }}
                    </div>
                </div>

                <div style="margin-bottom: 1.25rem;">
                    <div style="font-size: 0.72rem; color: var(--text-muted); font-weight: 700; text-transform: uppercase; letter-spacing: 0.04em;">
                        Jumlah Peserta Masuk
                    </div>
                    <div style="font-size: 1.05rem; color: #ffffff; font-weight: 700; margin-top: 0.2rem;">
                        {{ $order->quantity }} {{ $order->isGeneral() ? 'Orang Pengunjung' : 'Siswa / Rombongan' }}
                    </div>
                </div>

                <div>
                    <div style="font-size: 0.72rem; color: var(--text-muted); font-weight: 700; text-transform: uppercase; letter-spacing: 0.04em;">
                        Pemegang Tiket / PIC
                    </div>
                    <div style="font-size: 0.95rem; color: #ffffff; font-weight: 600; margin-top: 0.2rem;">
                        {{ $order->customer_name }}
                        @if($order->school_name)
                            <span style="color: var(--text-muted);">({{ $order->school_name }})</span>
                        @endif
                    </div>
                </div>
            </div>

            <!-- AREA KODE VALIDASI / SIMULASI QR CODE (TANPA ICON / FLAT MONOCHROME MATRIX) -->
            <div style="background-color: #080b11; border: 1px solid #1c2438; border-radius: 6px; padding: 1.5rem; display: flex; flex-direction: column; align-items: center; justify-content: center; text-align: center;">
                <div style="font-size: 0.72rem; color: var(--text-muted); font-weight: 800; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 0.75rem;">
                    QR CODE GERBANG TURNSTILE
                </div>
                
                <!-- KOTAK QR FLAT MONOKROM MURNI -->
                <div style="width: 170px; height: 170px; background-color: #ffffff; padding: 10px; border-radius: 4px; display: flex; flex-direction: column; justify-content: space-between; margin-bottom: 0.85rem;">
                    <div style="display: flex; justify-content: space-between;">
                        <div style="width: 38px; height: 38px; background-color: #000000; border: 4px solid #ffffff;"></div>
                        <div style="width: 38px; height: 38px; background-color: #000000; border: 4px solid #ffffff;"></div>
                    </div>
                    <div style="text-align: center; font-family: monospace; font-size: 0.65rem; font-weight: 800; color: #000000; letter-spacing: 0.05em; padding: 4px 0;">
                        [VALID ENTRY PASS]
                    </div>
                    <div style="display: flex; justify-content: space-between;">
                        <div style="width: 38px; height: 38px; background-color: #000000; border: 4px solid #ffffff;"></div>
                        <div style="width: 38px; height: 38px; background-color: #000000; display: flex; align-items: center; justify-content: center; color: #ffffff; font-size: 0.6rem; font-weight: 700;">QR</div>
                    </div>
                </div>

                <div style="font-family: monospace; font-size: 0.85rem; font-weight: 800; color: #ffffff; letter-spacing: 0.05em;">
                    {{ $order->eTicket->qr_data ?? ('NP-' . $order->order_number) }}
                </div>
                <div style="font-size: 0.72rem; color: #6ee7b7; font-weight: 700; margin-top: 0.35rem;">
                    STATUS: AKTIF &amp; SIAP DIPINDAI
                </div>
            </div>
        </div>

        <!-- DETAIL LOG TRANSAKSI MIDTRANS -->
        <div style="background-color: #080b11; border: 1px solid #1c2438; border-radius: 6px; padding: 1.15rem 1.5rem; margin-bottom: 1.5rem; font-size: 0.82rem;">
            <div style="font-size: 0.72rem; color: var(--text-muted); font-weight: 800; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 0.5rem;">
                Verifikasi Pembayaran Midtrans
            </div>
            <div style="display: flex; justify-content: space-between; flex-wrap: wrap; gap: 0.75rem; color: #cbd5e1;">
                <div>Nomor Registrasi: <strong style="color: #ffffff;">{{ $order->order_number }}</strong></div>
                <div>Metode: <strong style="color: #ffffff;">Midtrans Gateway (QRIS/VA)</strong></div>
                <div>Total Dibayar: <strong style="color: var(--color-primary);">IDR {{ number_format($order->total_price, 0, ',', '.') }}</strong></div>
                <div>Waktu Pelunasan: <strong style="color: #ffffff;">{{ $order->latestPayment && $order->latestPayment->paid_at ? $order->latestPayment->paid_at->format('d M Y H:i') : now()->format('d M Y H:i') }} WIB</strong></div>
            </div>
        </div>

        <!-- SYARAT & KETENTUAN PENGGUNAAN -->
        <div style="border-top: 1px solid #1f283d; padding-top: 1.25rem; font-size: 0.75rem; color: var(--text-sub); line-height: 1.7;">
            <strong style="color: var(--text-muted);">Ketentuan Kunjungan Wisata:</strong> E-ticket ini sah dan berlaku untuk 1 kali akses masuk pada tanggal kunjungan yang ditentukan. Harap jaga kerahasiaan kode unik tiket Anda. Pengelola The Nice Park Rumpin berhak menolak akses jika kode tiket telah tercatat pernah digunakan di turnstile gerbang.
        </div>
    </div>
</div>
@endsection
