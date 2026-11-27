
@extends('layouts.app')

@section('title', 'Pemesanan ' . $ticket->name . ' - The Nice Park Rumpin')

@section('content')

<style>
    
    /* STEPPER - MENYAMAKAN DESAIN CHECKOUT */
    .ticket-progress {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        width: 100%;
        padding: 12px 20px;
        margin-bottom: 30px;
        background: #0d0d10;
        border: 1px solid #24242b;
        border-radius: 7px;
        box-sizing: border-box;
    }

    .ticket-progress .progress-step {
        display: flex;
        align-items: center;
        gap: 8px;
        flex-shrink: 0;
        color: #a1a1aa;
        font-size: 12px;
        font-weight: 700;
        white-space: nowrap;
        text-transform: none;
        letter-spacing: 0;
    }

    .ticket-progress .step-circle {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 28px;
        height: 28px;
        flex-shrink: 0;
        border-radius: 50%;
        background: #1b1b20;
        color: #a1a1aa;
        font-size: 12px;
        font-weight: 700;
    }

    .ticket-progress .progress-step.active {
        color: #ff3b20;
    }

    .ticket-progress .progress-step.active .step-circle {
        background: #ff3b20;
        color: #ffffff;
    }

    .ticket-progress .progress-line {
        flex: 1;
        min-width: 20px;
        height: 1px;
        background: #222228;
    }

    /* HP: tetap satu baris dan dapat digeser */
    @media (max-width: 700px) {
        .ticket-progress {
            justify-content: flex-start;
            overflow-x: auto;
        }

        .ticket-progress .progress-line {
            min-width: 25px;
        }
    }


    /* FASILITAS 2 KOLOM */
    .ticket-feature-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        column-gap: 2rem;
        row-gap: 0;
        list-style: none;
        padding: 0;
        margin: 0 0 1.5rem;
        font-size: 0.82rem;
        color: #cbd5e1;
        line-height: 1.8;
    }

    .ticket-feature-grid li {
        border-bottom: 1px solid #161c28;
        padding: 0.55rem 0;
    }

    /* KETENTUAN 2 KOLOM */
    .ticket-terms-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 0.5rem 2rem;
        list-style: none;
        padding: 0;
        margin: 0;
        font-size: 0.8rem;
        color: var(--text-sub);
        line-height: 1.7;
    }

    /* FORM 2 KOLOM */
    .ticket-form-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 1.1rem 1.5rem;
    }

    .ticket-form-grid .form-group {
        min-width: 0;
        margin-bottom: 0;
    }

    .ticket-form-grid .full-width {
        grid-column: 1 / -1;
    }

    /* RINGKASAN PEMBAYARAN */
    .ticket-payment-summary {
        background-color: #06080d;
        border: 1px solid var(--border-color);
        padding: 1.25rem;
        margin-top: 1.5rem;
        margin-bottom: 1.5rem;
        border-radius: 4px;
    }

    /* RESPONSIVE */
    @media (max-width: 600px) {
        .ticket-feature-grid,
        .ticket-terms-grid,
        .ticket-form-grid {
            grid-template-columns: 1fr;
        }

        .ticket-form-grid .full-width {
            grid-column: auto;
        }

        .booking-stepper {
            padding: 1rem;
        }
    }
</style>

<!-- PROGRESS STEPPER -->
<div class="ticket-progress">

    <div class="progress-step">
        <span class="step-circle">1</span>
        <span>Pilih Tiket</span>
    </div>

    <div class="progress-line"></div>

    <div class="progress-step active">
        <span class="step-circle">2</span>
        <span>Data Pemesan</span>
    </div>

    <div class="progress-line"></div>

    <div class="progress-step">
        <span class="step-circle">3</span>
        <span>Pembayaran</span>
    </div>

    <div class="progress-line"></div>

    <div class="progress-step">
        <span class="step-circle">4</span>
        <span>E-Ticket</span>
    </div>

</div>



<!-- HEADER HALAMAN -->
<div class="page-header" style="margin-bottom: 1.75rem;">
    <div>
        <div style="font-size: 0.75rem; color: var(--color-primary); font-weight: 800; text-transform: uppercase; letter-spacing: 0.06em; margin-bottom: 0.35rem;">
            FORMULIR PEMESANAN TIKET
        </div>

        <h1 class="page-title">
            Pemesanan {{ $ticket->name }}
        </h1>

        <p class="page-subtitle">
            Tentukan tanggal kunjungan dan jumlah tiket yang ingin Anda pesan.
        </p>
    </div>

    <div>
        <a href="{{ route('tickets.index') }}" class="btn btn-secondary btn-sm">
            Kembali ke Katalog
        </a>
    </div>
</div>

<div class="ticket-order-layout">

    <!-- INFORMASI PAKET TIKET -->
    <div class="card" style="border-top: 3px solid var(--color-primary);">

        <div class="card-header">
            <div>
                <div style="font-size: 0.72rem; color: var(--text-sub); text-transform: uppercase; font-weight: 700; letter-spacing: 0.04em;">
                    INFORMASI TIKET WISATA
                </div>

                <div class="card-title" style="margin-top: 0.2rem;">
                    {{ $ticket->name }}
                </div>
            </div>

            <span class="badge badge-info">Tiket Reguler</span>
        </div>

        <!-- HARGA TIKET -->
        <div style="margin-bottom: 1.25rem;">
            <div style="font-size: 0.72rem; color: var(--text-muted); text-transform: uppercase; font-weight: 700;">
                Tarif Resmi Masuk
            </div>

            <div style="font-family: 'Plus Jakarta Sans', sans-serif; font-size: 2.15rem; font-weight: 900; color: #ffffff; margin-top: 0.2rem;">
                IDR {{ number_format($ticket->price, 0, ',', '.') }}

                <span style="font-size: 0.85rem; color: var(--text-sub); font-weight: 600;">
                    / orang
                </span>
            </div>
        </div>

        <!-- DESKRIPSI -->
        <p style="color: var(--text-muted); font-size: 0.88rem; line-height: 1.7; margin-bottom: 1.5rem;">
            {{ $ticket->description }}
        </p>

        <!-- FASILITAS -->
        <div style="font-size: 0.75rem; color: var(--color-primary); font-weight: 800; text-transform: uppercase; margin-bottom: 0.65rem;">
            FASILITAS &amp; CAKUPAN TIKET
        </div>

        <ul class="ticket-feature-grid">
            @if($ticket->features)
                @foreach(explode("\n", $ticket->features) as $feature)
                    @if(trim($feature))
                        <li> {{ trim($feature) }}</li>
                    @endif
                @endforeach
            @endif
        </ul>

        <!-- KETENTUAN -->
        <div style="font-size: 0.75rem; color: var(--text-muted); font-weight: 800; text-transform: uppercase; margin-bottom: 0.65rem;">
            KETENTUAN KUNJUNGAN
        </div>

        <ul class="ticket-terms-grid">
            <li> Tiket berlaku khusus pada tanggal kunjungan yang dipilih.</li>
            <li> E-ticket resmi dengan QR Code wajib dipindai saat di pintu masuk gerbang.</li>
            <li> Pembayaran diproses secara instan melalui Midtrans Payment Gateway.</li>
        </ul>

    </div>

    <!-- FORM PEMESANAN -->
    <div class="card" style="border: 1px solid var(--border-card); background-color: #0d111a;">

        <div class="card-header">
            <div>
                <div style="font-size: 0.72rem; color: var(--color-primary); font-weight: 700; text-transform: uppercase; letter-spacing: 0.04em;">
                    DATA PENGUNJUNG
                </div>

                <div class="card-title" style="margin-top: 0.2rem;">
                    Formulir Data Pemesan
                </div>
            </div>
        </div>

        <form action="{{ route('tickets.order', $ticket->id) }}" method="POST">
            @csrf

            <div class="ticket-form-grid">

                <!-- TANGGAL KUNJUNGAN -->
                <div class="form-group">
                    <label class="form-label" for="visit_date">
                        Tanggal Rencana Kunjungan
                    </label>

                    <input
                        type="date"
                        id="visit_date"
                        name="visit_date"
                        class="form-control"
                        value="{{ old('visit_date', date('Y-m-d')) }}"
                        min="{{ date('Y-m-d') }}"
                        required
                    />

                    <div class="form-hint">
                        Pilih tanggal rencana kedatangan Anda ke The Nice Park Rumpin.
                    </div>
                </div>

                <!-- JUMLAH TIKET -->
                <div class="form-group">
                    <label class="form-label" for="quantity">
                        Kuantitas / Jumlah Tiket
                    </label>

                    <input
                        type="number"
                        id="quantity"
                        name="quantity"
                        class="form-control"
                        min="1"
                        max="50"
                        value="{{ old('quantity', 1) }}"
                        required
                        oninput="calculateTotal()"
                    />
                </div>

                <!-- NAMA PEMESAN -->
                <div class="form-group">
                    <label class="form-label" for="customer_name">
                        Nama Lengkap Pemesan
                    </label>

                    <input
                        type="text"
                        id="customer_name"
                        name="customer_name"
                        class="form-control"
                        placeholder="Nama sesuai identitas KTP"
                        value="{{ old('customer_name', Auth::user()->name ?? '') }}"
                        required
                    />
                </div>

                <!-- EMAIL -->
                <div class="form-group">
                    <label class="form-label" for="customer_email">
                        Alamat Email Penerima E-Ticket
                    </label>

                    <input
                        type="email"
                        id="customer_email"
                        name="customer_email"
                        class="form-control"
                        placeholder="nama@email.com"
                        value="{{ old('customer_email', Auth::user()->email ?? '') }}"
                        required
                    />
                </div>

                <!-- NOMOR TELEPON -->
                <div class="form-group full-width">
                    <label class="form-label" for="customer_phone">
                        Nomor WhatsApp / Telepon
                    </label>

                    <input
                        type="tel"
                        id="customer_phone"
                        name="customer_phone"
                        class="form-control"
                        placeholder="08xxxxxxxxxx"
                        value="{{ old('customer_phone', Auth::user()->phone ?? '') }}"
                        required
                    />
                </div>

            </div>

            <!-- RINGKASAN BIAYA -->
            <div class="ticket-payment-summary">

                <div style="display: flex; justify-content: space-between; font-size: 0.85rem; color: var(--text-muted); margin-bottom: 0.5rem; gap: 1rem;">
                    <span>Tarif Tiket Satuan:</span>

                    <span style="color: #ffffff; font-weight: 700;">
                        IDR {{ number_format($ticket->price, 0, ',', '.') }}
                    </span>
                </div>

                <div style="display: flex; justify-content: space-between; font-size: 0.85rem; color: var(--text-muted); margin-bottom: 0.5rem; gap: 1rem;">
                    <span>Biaya Layanan Gerbang:</span>

                    <span style="color: #00e676; font-weight: 700;">
                        Termasuk (Rp 0)
                    </span>
                </div>

                <div style="display: flex; justify-content: space-between; font-size: 1.05rem; color: #ffffff; font-weight: 800; border-top: 1px solid var(--border-color); padding-top: 0.85rem; margin-top: 0.5rem; gap: 1rem;">
                    <span>Total Tagihan (Server):</span>

                    <span id="display-total" style="color: var(--color-primary); font-family: 'Plus Jakarta Sans', sans-serif;">
                        IDR {{ number_format($ticket->price, 0, ',', '.') }}
                    </span>
                </div>

            </div>

            <!-- TOMBOL PEMESANAN -->
            <button
                type="submit"
                class="btn btn-primary btn-block btn-lg"
                style="letter-spacing: 0.04em;"
            >
                Lanjut ke Pembayaran Midtrans
            </button>

        </form>
    </div>

</div>
@endsection

@push('scripts')
<script>
    const unitPrice = {{ (int) $ticket->price }};

    function calculateTotal() {
        const qty = parseInt(document.getElementById('quantity').value) || 1;
        const total = qty * unitPrice;

        document.getElementById('display-total').innerText =
            'IDR ' + new Intl.NumberFormat('id-ID').format(total);
    }
</script>
@endpush
