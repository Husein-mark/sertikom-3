@extends('layouts.app')

@section('title', 'E-Ticket Resmi - ' . $order->order_number)

@section('content')
<div class="page-header">
    <div>
        <div style="font-size: 0.75rem; color: var(--color-primary); text-transform: uppercase; margin-bottom: 0.35rem;">Tiket Elektronik Sah</div>
        <h1 class="page-title">E-Ticket Pengunjung</h1>
        <p class="page-subtitle">Tunjukkan bukti digital ini kepada staf gerbang masuk The Nice Park Rumpin.</p>
    </div>
    <div style="display: flex; gap: 0.75rem;">
        <button onclick="window.print()" class="btn btn-secondary btn-sm">Cetak / Simpan PDF</button>
        <a href="{{ route('orders.history') }}" class="btn btn-primary btn-sm">Kembali ke Pesanan</a>
    </div>
</div>

<!-- E-Ticket Card Layout -->
<div style="max-width: 780px; margin: 0 auto;">
    <div class="card" style="border: 2px solid var(--color-primary); background-color: #0c0f17; padding: 2.5rem; position: relative;">
        <!-- Header Tiket -->
        <div style="display: flex; justify-content: space-between; align-items: flex-start; border-bottom: 1px solid var(--border-color); padding-bottom: 1.5rem; margin-bottom: 2rem;">
            <div>
                <div style="font-family: 'Plus Jakarta Sans', sans-serif; font-size: 1.5rem; font-weight: 800; color: #ffffff; letter-spacing: -0.02em;">
                    THE NICE PARK <span style="color: var(--color-primary);">RUMPIN</span>
                </div>
                <div style="font-size: 0.8rem; color: var(--text-sub); text-transform: uppercase; letter-spacing: 0.05em; margin-top: 0.25rem;">
                    Official Electronic Entry Pass
                </div>
            </div>
            <div style="text-align: right;">
                <span class="badge badge-paid" style="font-size: 0.8rem; padding: 0.35rem 0.8rem;">TERVERIFIKASI LUNAS</span>
                <div style="font-family: 'Plus Jakarta Sans', sans-serif; font-size: 0.85rem; font-weight: 700; color: var(--text-muted); margin-top: 0.5rem;">
                    KODE: {{ $order->eTicket->ticket_code ?? 'ETK-DEFAULT' }}
                </div>
            </div>
        </div>

        <!-- Body Tiket: 2 Kolom -->
        <div class="grid-2" style="margin-bottom: 2rem;">
            <!-- Rincian Kunjungan -->
            <div>
                <div style="margin-bottom: 1.25rem;">
                    <div style="font-size: 0.75rem; color: var(--text-sub); text-transform: uppercase;">Jenis Tiket / Paket</div>
                    <div style="font-size: 1.15rem; color: #ffffff; font-weight: 700;">
                        {{ $order->isGeneral() ? ($order->ticket->name ?? 'Tiket Masuk') : ($order->package->name ?? 'Paket Sekolah') }}
                    </div>
                </div>

                <div style="margin-bottom: 1.25rem;">
                    <div style="font-size: 0.75rem; color: var(--text-sub); text-transform: uppercase;">Tanggal Kedatangan</div>
                    <div style="font-size: 1.15rem; color: var(--color-primary); font-family: 'Plus Jakarta Sans', sans-serif; font-weight: 800;">
                        {{ \Carbon\Carbon::parse($order->visit_date)->isoFormat('dddd, D MMMM Y') }}
                    </div>
                </div>

                <div style="margin-bottom: 1.25rem;">
                    <div style="font-size: 0.75rem; color: var(--text-sub); text-transform: uppercase;">Jumlah Peserta</div>
                    <div style="font-size: 1rem; color: #ffffff; font-weight: 600;">
                        {{ $order->quantity }} {{ $order->isGeneral() ? 'Orang Pengunjung' : 'Siswa / Rombongan' }}
                    </div>
                </div>

                <div>
                    <div style="font-size: 0.75rem; color: var(--text-sub); text-transform: uppercase;">Nama Pemesan</div>
                    <div style="font-size: 0.95rem; color: #ffffff;">
                        {{ $order->customer_name }}
                        @if($order->school_name)
                            ({{ $order->school_name }})
                        @endif
                    </div>
                </div>
            </div>

            <!-- Kode Validasi / QR Placeholder -->
            <div style="display: flex; flex-direction: column; align-items: center; justify-content: center; background-color: #08090d; border: 1px solid var(--border-color); padding: 1.5rem; border-radius: 4px;">
                <div style="width: 150px; height: 150px; border: 2px dashed var(--color-primary); display: flex; align-items: center; justify-content: center; flex-direction: column; margin-bottom: 1rem; background-color: #121825;">
                    <div style="font-family: 'Plus Jakarta Sans', sans-serif; font-size: 0.85rem; font-weight: 800; color: var(--color-primary);">QR CODE</div>
                    <div style="font-size: 0.65rem; color: var(--text-sub); margin-top: 0.35rem;">VERIFIKASI RESMI</div>
                </div>
                <div style="font-family: 'Plus Jakarta Sans', sans-serif; font-size: 0.85rem; font-weight: 700; color: #ffffff; letter-spacing: 0.05em;">
                    {{ $order->eTicket->qr_data ?? ('NP-' . $order->order_number) }}
                </div>
                <div style="font-size: 0.7rem; color: var(--text-sub); margin-top: 0.35rem;">Scan pada pintu akses gerbang</div>
            </div>
        </div>

        <!-- Detail Transaksi Midtrans -->
        <div style="background-color: #08090d; border: 1px solid var(--border-color); padding: 1rem 1.25rem; font-size: 0.8rem; color: var(--text-muted); display: flex; justify-content: space-between; flex-wrap: wrap; gap: 0.5rem; margin-bottom: 1.5rem;">
            <div>Transaksi: <strong>{{ $order->order_number }}</strong></div>
            <div>Gateway: <strong>Midtrans (Lunas)</strong></div>
            <div>Waktu Verifikasi: <strong>{{ $order->latestPayment && $order->latestPayment->paid_at ? $order->latestPayment->paid_at->format('d M Y H:i') : now()->format('d M Y H:i') }} WIB</strong></div>
        </div>

        <!-- Ketentuan Penggunaan -->
        <div style="font-size: 0.75rem; color: var(--text-sub); line-height: 1.7; border-top: 1px solid var(--border-color); padding-top: 1.25rem;">
            Petunjuk: E-ticket ini sah dan berlaku untuk 1 kali akses masuk pada tanggal tercantum. Dilarang menggandakan tiket. Pengelola The Nice Park Rumpin berhak menolak tiket apabila kode identifikasi telah digunakan sebelumnya.
        </div>
    </div>
</div>
@endsection
