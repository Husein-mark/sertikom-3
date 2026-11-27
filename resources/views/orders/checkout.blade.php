
@extends('layouts.app')

@section('title', 'Selesaikan Pembayaran - The Nice Park Rumpin')

@push('styles')
<style>


    .checkout-page {
        width: 100%;
    }

    .checkout-page .checkout-stepper {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        padding: 14px 18px;
        margin-bottom: 28px;
        background: var(--bg-card);
        border: 1px solid var(--border-card);
        border-radius: var(--radius-md);
        overflow-x: auto;
    }

    .checkout-page .step-item {
        display: flex;
        align-items: center;
        gap: 8px;
        white-space: nowrap;
        font-size: 0.75rem;
        font-weight: 700;
        color: var(--text-muted);
    }

    .checkout-page .step-number {
        width: 25px;
        height: 25px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        background: var(--bg-card-active);
        color: var(--text-muted);
    }

    .checkout-page .step-item.active {
        color: var(--color-primary);
    }

    .checkout-page .step-item.active .step-number {
        background: var(--color-primary);
        color: var(--color-primary-text);
    }

    .checkout-page .step-line {
        height: 1px;
        flex: 1;
        min-width: 15px;
        background: var(--border-color);
    }

    .checkout-page .checkout-heading {
        margin-bottom: 24px;
    }

    .checkout-page .checkout-heading h1 {
        font-size: clamp(1.4rem, 3vw, 1.9rem);
        margin-bottom: 5px;
    }

    .checkout-page .checkout-heading p {
        color: var(--text-muted);
        font-size: 0.85rem;
    }

    .checkout-page .checkout-layout {
        display: grid;
        grid-template-columns: minmax(0, 1.25fr) minmax(300px, 0.75fr);
        gap: 22px;
        align-items: start;
    }

    .checkout-page .checkout-card {
        background: var(--bg-card);
        border: 1px solid var(--border-card);
        border-radius: var(--radius-md);
        padding: 20px;
    }

    .checkout-page .checkout-card + .checkout-card {
        margin-top: 16px;
    }

    .checkout-page .checkout-card-heading {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 12px;
        margin-bottom: 18px;
        padding-bottom: 14px;
        border-bottom: 1px solid var(--border-color);
    }

    .checkout-page .checkout-card-heading h3 {
        font-size: 1rem;
        margin: 0;
    }

    .checkout-page .checkout-label {
        color: var(--text-muted);
        font-size: 0.72rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        margin-bottom: 5px;
    }

    .checkout-page .checkout-value {
        color: var(--text-main);
        font-size: 0.87rem;
        font-weight: 600;
    }

    .checkout-page .checkout-info-row {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 15px;
        padding: 12px 0;
        border-bottom: 1px solid var(--border-color);
    }

    .checkout-page .checkout-info-row:last-child {
        border-bottom: none;
    }

    .checkout-page .checkout-info-row > :last-child {
        text-align: right;
    }

    .checkout-page .checkout-summary {
        position: sticky;
        top: 90px;
    }

    .checkout-page .checkout-total {
        padding: 20px 0;
        margin: 15px 0;
        border-top: 1px solid var(--border-color);
        border-bottom: 1px solid var(--border-color);
    }

    .checkout-page .checkout-total-amount {
        font-family: var(--font-display);
        font-size: clamp(1.6rem, 3vw, 2rem);
        font-weight: 800;
        color: var(--color-primary);
        letter-spacing: -0.03em;
        margin-top: 5px;
    }

    .checkout-page .payment-badges {
        display: flex;
        flex-wrap: wrap;
        gap: 7px;
        margin-top: 12px;
    }

    .checkout-page .payment-badges span {
        background: var(--bg-input);
        border: 1px solid var(--border-color);
        border-radius: var(--radius-sm);
        color: var(--text-main);
        padding: 6px 10px;
        font-size: 0.7rem;
        font-weight: 600;
    }

    .checkout-page .checkout-pay-button {
        width: 100%;
        margin-top: 12px;
        padding: 14px;
        font-weight: 800;
        font-family: inherit;
        font-size: 0.88rem;
    }

    .checkout-page .checkout-secondary-button {
        display: block;
        width: 100%;
        text-align: center;
        margin-top: 10px;
        font-size: 0.8rem;
    }

    .checkout-page .checkout-note {
        color: var(--text-muted);
        font-size: 0.75rem;
        line-height: 1.7;
        margin-top: 15px;
    }

    .checkout-page .checkout-contact {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 18px;
    }

    /* =========================================
       MIDTRANS RIGHT SIDE PANEL
    ========================================= */

    .checkout-page .midtrans-overlay {
        position: fixed;
        inset: 0;
        background: rgba(0, 0, 0, 0.72);
        z-index: 9998;
        opacity: 0;
        visibility: hidden;
        transition: opacity 0.3s ease, visibility 0.3s ease;
    }

    .checkout-page .midtrans-overlay.active {
        opacity: 1;
        visibility: visible;
    }

    .checkout-page .midtrans-drawer {
        position: fixed;
        top: 0;
        right: 0;
        width: min(480px, 100%);
        height: 100dvh;
        background: var(--bg-card);
        border-left: 1px solid var(--border-card);
        z-index: 9999;
        transform: translateX(100%);
        transition: transform 0.35s ease;
        display: flex;
        flex-direction: column;
    }

    .checkout-page .midtrans-drawer.active {
        transform: translateX(0);
    }

    .checkout-page .midtrans-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 18px 20px;
        border-bottom: 1px solid var(--border-color);
        flex-shrink: 0;
    }

    .checkout-page .midtrans-header h3 {
        font-size: 1rem;
        margin: 0;
    }

    .checkout-page .midtrans-header p {
        font-size: 0.72rem;
        color: var(--text-muted);
        margin-top: 3px;
    }

    .checkout-page .midtrans-close {
        background: var(--bg-input);
        border: 1px solid var(--border-color);
        color: var(--text-main);
        border-radius: var(--radius-sm);
        padding: 7px 12px;
        font-family: inherit;
        font-size: 0.78rem;
        cursor: pointer;
    }

    .checkout-page .midtrans-body {
        flex: 1;
        overflow-y: auto;
        padding: 12px;
    }

    .checkout-page #snap-container {
        width: 100%;
        min-height: 550px;
    }

    @media (max-width: 768px) {
        .checkout-page .checkout-layout {
            grid-template-columns: 1fr;
        }

        .checkout-page .checkout-summary {
            position: static;
        }

        .checkout-page .checkout-contact {
            grid-template-columns: 1fr;
        }

        .checkout-page .checkout-stepper {
            justify-content: flex-start;
        }

        .checkout-page .step-line {
            min-width: 15px;
        }
    }

    @media (max-width: 480px) {
        .checkout-page .checkout-card {
            padding: 15px;
        }

        .checkout-page .checkout-info-row {
            gap: 8px;
            font-size: 0.78rem;
        }

        .checkout-page .checkout-info-row .checkout-value {
            font-size: 0.78rem;
        }
    }
</style>
@endpush

@section('content')

<div class="checkout-page">

    <!-- PROGRESS -->
    <div class="checkout-stepper">
        <div class="step-item">
            <span class="step-number">1</span>
            Pilih Tiket
        </div>

        <div class="step-line"></div>

        <div class="step-item">
            <span class="step-number">2</span>
            Data Pemesan
        </div>

        <div class="step-line"></div>

        <div class="step-item active">
            <span class="step-number">3</span>
            Pembayaran
        </div>

        <div class="step-line"></div>

        <div class="step-item">
            <span class="step-number">4</span>
            E-Ticket
        </div>
    </div>

    <!-- HEADER -->
    <div class="checkout-heading">
        <div style="display:flex; justify-content:space-between; align-items:flex-start; gap:15px; flex-wrap:wrap;">
            <div>
                <div class="checkout-label" style="color:var(--color-primary);">
                    PEMBAYARAN RESERVASI #{{ $order->order_number }}
                </div>

                <h1>Selesaikan Pembayaran</h1>

                <p>
                    Periksa kembali pesanan sebelum melanjutkan pembayaran.
                </p>
            </div>

            <a href="{{ route('orders.history') }}" class="btn btn-secondary btn-sm">
                Kembali ke Riwayat
            </a>
        </div>
    </div>

    <!-- MAIN CHECKOUT -->
    <div class="checkout-layout">

        <!-- KOLOM KIRI -->
        <div>

            <!-- DETAIL PESANAN -->
            <div class="checkout-card">

                <div class="checkout-card-heading">
                    <div>
                        <div class="checkout-label">Detail Pesanan</div>

                        <h3>
                            {{ $order->isGeneral()
                                ? ($order->ticket->name ?? 'Tiket Masuk Wisata')
                                : ($order->package->name ?? 'Paket Kunjungan Sekolah') }}
                        </h3>
                    </div>

                    @if($order->status === 'paid')
                        <span class="badge badge-paid">Lunas</span>
                    @elseif($order->status === 'approved')
                        <span class="badge badge-approved">Disetujui Admin</span>
                    @else
                        <span class="badge badge-pending">Menunggu Pembayaran</span>
                    @endif
                </div>

                <div class="checkout-info-row">
                    <div class="checkout-label">Nomor Pesanan</div>
                    <div class="checkout-value">{{ $order->order_number }}</div>
                </div>

                <div class="checkout-info-row">
                    <div class="checkout-label">Kategori Kunjungan</div>
                    <div class="checkout-value">
                        {{ $order->isGeneral()
                            ? 'Pengunjung Umum / Mandiri'
                            : 'Rombongan Edukasi Sekolah' }}
                    </div>
                </div>

                <div class="checkout-info-row">
                    <div class="checkout-label">Tanggal Kunjungan</div>
                    <div class="checkout-value" style="color:var(--color-primary);">
                        {{ \Carbon\Carbon::parse($order->visit_date)->isoFormat('dddd, D MMMM Y') }}
                    </div>
                </div>

                <div class="checkout-info-row">
                    <div class="checkout-label">Jumlah Peserta</div>
                    <div class="checkout-value">
                        {{ $order->quantity }}
                        {{ $order->isGeneral() ? 'Orang' : 'Siswa / Anggota' }}
                    </div>
                </div>

                <div class="checkout-info-row">
                    <div class="checkout-label">Tarif Satuan</div>
                    <div class="checkout-value">
                        IDR {{ number_format($order->unit_price, 0, ',', '.') }}
                    </div>
                </div>

                <div class="checkout-info-row">
                    <div class="checkout-label">Fasilitas & Wahana</div>
                    <div class="checkout-value">Termasuk</div>
                </div>

            </div>

            <!-- IDENTITAS PEMESAN -->
            <div class="checkout-card">

                <div class="checkout-card-heading">
                    <div>
                        <div class="checkout-label">Informasi Kontak</div>
                        <h3>Identitas Pemesan</h3>
                    </div>
                </div>

                <div class="checkout-contact">

                    @if($order->isSchool())

                        <div>
                            <div class="checkout-label">Nama Sekolah</div>
                            <div class="checkout-value">{{ $order->school_name }}</div>
                        </div>

                        <div>
                            <div class="checkout-label">Penanggung Jawab</div>
                            <div class="checkout-value">{{ $order->pic_name }}</div>
                        </div>

                        <div>
                            <div class="checkout-label">Jabatan</div>
                            <div class="checkout-value">{{ $order->pic_position }}</div>
                        </div>

                    @else

                        <div>
                            <div class="checkout-label">Nama Lengkap</div>
                            <div class="checkout-value">{{ $order->customer_name }}</div>
                        </div>

                    @endif

                    <div>
                        <div class="checkout-label">Email</div>
                        <div class="checkout-value">{{ $order->customer_email }}</div>
                    </div>

                    <div>
                        <div class="checkout-label">Nomor WhatsApp</div>
                        <div class="checkout-value">{{ $order->customer_phone }}</div>
                    </div>

                </div>
            </div>

            <!-- KETENTUAN -->
            <div class="checkout-card">
                <div class="checkout-label" style="color:var(--color-primary);">
                    Ketentuan Kunjungan
                </div>

                <div class="checkout-note">
                    <div>- Jam operasional wahana: 08.00 - 17.00 WIB.</div>
                    <div>- Tiket berlaku sesuai tanggal kunjungan.</div>
                    <div>- E-Ticket digital akan diterbitkan setelah pembayaran terverifikasi.</div>
                    <div>- Tunjukkan QR Code kepada petugas saat memasuki area wisata.</div>
                </div>
            </div>

        </div>

        <!-- KOLOM KANAN: RINGKASAN PEMBAYARAN -->
        <div class="checkout-summary">

            <div class="checkout-card">

                <div class="checkout-card-heading">
                    <div>
                        <div class="checkout-label">Ringkasan Pembayaran</div>
                        <h3>Detail Tagihan</h3>
                    </div>

                    <span class="badge badge-paid">Midtrans</span>
                </div>

                <div class="checkout-info-row">
                    <div class="checkout-label">Subtotal</div>
                    <div class="checkout-value">
                        IDR {{ number_format($order->total_price, 0, ',', '.') }}
                    </div>
                </div>

                <div class="checkout-info-row">
                    <div class="checkout-label">Biaya Admin</div>
                    <div class="checkout-value">Termasuk</div>
                </div>

                <div class="checkout-total">
                    <div class="checkout-label">Total yang Harus Dibayar</div>

                    <div class="checkout-total-amount">
                        IDR {{ number_format($order->total_price, 0, ',', '.') }}
                    </div>

                    <div style="font-size:.73rem; color:var(--text-muted); margin-top:5px;">
                        Bebas biaya admin tambahan
                    </div>
                </div>

                <div>
                    <div class="checkout-label">Metode Pembayaran</div>

                    <div class="payment-badges">
                        <span>QRIS</span>
                        <span>GoPay</span>
                        <span>ShopeePay</span>
                        <span>BCA VA</span>
                        <span>Mandiri VA</span>
                        <span>BNI VA</span>
                        <span>BRI VA</span>
                    </div>
                </div>

                <!-- TOMBOL BAYAR -->
                <button
                    type="button"
                    id="pay-button"
                    class="btn btn-primary checkout-pay-button"
                >
                    BAYAR SEKARANG
                </button>

                <!-- CEK STATUS -->
                <a
                    href="{{ route('orders.checkStatus', $order->id) }}"
                    class="btn btn-secondary checkout-secondary-button"
                >
                    Periksa Status Transaksi
                </a>

                <!-- SIMULASI SANDBOX -->
                <div style="border-top:1px solid var(--border-color); margin-top:18px; padding-top:15px;">
                    <div class="checkout-label">
                        Mode Pengujian / Demonstrasi
                    </div>

                    <a
                        href="{{ route('orders.simulateSuccess', $order->id) }}"
                        class="btn btn-outline btn-sm"
                        style="display:block; text-align:center; margin-top:10px;"
                    >
                        Simulasi Pembayaran Berhasil
                    </a>
                </div>

                <div class="checkout-note">
                    Transaksi diproses melalui Midtrans Payment Gateway.
                    Status pembayaran dapat diperiksa kembali melalui sistem.
                </div>

            </div>

        </div>

    </div>

    <!-- MIDTRANS OVERLAY -->
    <div class="midtrans-overlay" id="midtrans-overlay"></div>

    <!-- MIDTRANS PANEL KANAN -->
    <div class="midtrans-drawer" id="midtrans-drawer">

        <div class="midtrans-header">
            <div>
                <h3>Pembayaran Midtrans</h3>
                <p>Selesaikan pembayaran pesanan Anda</p>
            </div>

            <button
                type="button"
                class="midtrans-close"
                id="close-midtrans"
            >
                Tutup
            </button>
        </div>

        <div class="midtrans-body">
            <div id="snap-container"></div>
        </div>

    </div>

</div>

@endsection

@push('scripts')

<!-- MIDTRANS SNAP SDK SANDBOX -->
<script
    src="https://app.sandbox.midtrans.com/snap/snap.js"
    data-client-key="{{ config('midtrans.client_key') }}">
</script>

<script>
document.addEventListener('DOMContentLoaded', function () {

    const snapToken = @json($snapToken);

    const payButton = document.getElementById('pay-button');
    const drawer = document.getElementById('midtrans-drawer');
    const overlay = document.getElementById('midtrans-overlay');
    const closeButton = document.getElementById('close-midtrans');

    let snapEmbedded = false;

    function openMidtrans() {
        drawer.classList.add('active');
        overlay.classList.add('active');
        document.body.style.overflow = 'hidden';
    }

    function closeMidtrans() {
        drawer.classList.remove('active');
        overlay.classList.remove('active');
        document.body.style.overflow = '';
    }

    closeButton.addEventListener('click', closeMidtrans);
    overlay.addEventListener('click', closeMidtrans);

    payButton.addEventListener('click', function () {

        // Jika token demo atau tidak tersedia,
        // pertahankan fitur simulasi Sandbox sebelumnya.
        if (
            typeof snap === 'undefined' ||
            !snapToken ||
            snapToken.startsWith('DEMO-SNAP')
        ) {
            if (confirm('Token Midtrans belum tersedia. Buka simulasi pembayaran untuk pesanan ini?')) {
                window.location.href =
                    @json(route('orders.simulateSuccess', $order->id));
            }

            return;
        }

        openMidtrans();

        // Embedded Snap hanya dipasang sekali.
        if (snapEmbedded) {
            return;
        }

        snapEmbedded = true;

        try {

            snap.embed(snapToken, {

                embedId: 'snap-container',

                onSuccess: function(result) {

                    window.location.href =
                        @json(route('midtrans.finish')) +
                        '?order_id=' + encodeURIComponent(@json($order->order_number)) +
                        '&status_code=200&transaction_status=settlement';

                },

                onPending: function(result) {

                    alert('Pembayaran masih menunggu penyelesaian.');

                    window.location.href =
                        @json(route('orders.checkout', $order->id));

                },

                onError: function(result) {

                    alert('Transaksi belum berhasil diproses oleh Midtrans. Silakan coba kembali.');

                    snapEmbedded = false;

                },

                onClose: function() {

                    closeMidtrans();

                }

            });

        } catch (error) {

            console.error('Midtrans Embed Error:', error);

            alert('Terjadi kesalahan saat membuka pembayaran Midtrans.');

            snapEmbedded = false;
            closeMidtrans();

        }

    });

});
</script>

@endpush
