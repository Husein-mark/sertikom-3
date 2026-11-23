@extends('layouts.app')

@section('title', 'Pemesanan ' . $ticket->name . ' - The Nice Park Rumpin')

@section('content')
<div class="page-header">
    <div>
        <div style="font-size: 0.75rem; color: var(--color-primary); text-transform: uppercase; margin-bottom: 0.35rem;">Katalog Tiket / Formulir Pembelian</div>
        <h1 class="page-title">Pemesanan {{ $ticket->name }}</h1>
        <p class="page-subtitle">Tentukan tanggal kunjungan dan jumlah tiket yang akan dipesan.</p>
    </div>
    <a href="{{ route('tickets.index') }}" class="btn btn-secondary btn-sm">Kembali ke Katalog</a>
</div>

<div class="grid-2">
    <!-- Kolom Kiri: Detail Tiket -->
    <div>
        <div class="card" style="margin-bottom: 1.5rem;">
            <div class="card-header">
                <div class="card-title">Informasi Tiket</div>
                <span class="badge badge-info">Reguler</span>
            </div>
            
            <div style="margin-bottom: 1.25rem;">
                <div style="font-size: 0.8rem; color: var(--text-muted); text-transform: uppercase;">Harga Satuan</div>
                <div style="font-family: 'Plus Jakarta Sans', sans-serif; font-size: 2rem; font-weight: 800; color: #ffffff;">
                    IDR {{ number_format($ticket->price, 0, ',', '.') }} 
                    <span style="font-size: 0.85rem; color: var(--text-sub); font-weight: 400;">/ orang</span>
                </div>
            </div>

            <p style="color: var(--text-muted); font-size: 0.9rem; line-height: 1.7; margin-bottom: 1.5rem;">
                {{ $ticket->description }}
            </p>

            <h4 style="font-size: 0.85rem; color: #ffffff; margin-bottom: 0.75rem; text-transform: uppercase;">Fasilitas & Cakupan Tiket</h4>
            <ul style="list-style: none; font-size: 0.85rem; color: var(--text-sub); line-height: 1.8; margin-bottom: 1.5rem;">
                @if($ticket->features)
                    @foreach(explode("\n", $ticket->features) as $feature)
                        @if(trim($feature))
                            <li>- {{ trim($feature) }}</li>
                        @endif
                    @endforeach
                @endif
            </ul>

            <h4 style="font-size: 0.85rem; color: #ffffff; margin-bottom: 0.5rem; text-transform: uppercase;">Ketentuan Kunjungan</h4>
            <ul style="list-style: none; font-size: 0.85rem; color: var(--text-sub); line-height: 1.8;">
                <li>- Tiket berlaku khusus pada tanggal yang dipilih.</li>
                <li>- E-ticket resmi wajib ditunjukkan kepada petugas saat kedatangan.</li>
                <li>- Non-refundable (tidak dapat diuangkan kembali).</li>
            </ul>
        </div>

        <div class="card">
            <h4 style="font-size: 0.85rem; color: #ffffff; margin-bottom: 0.5rem; text-transform: uppercase;">Metode Pembayaran Resmi</h4>
            <p style="font-size: 0.85rem; color: var(--text-muted); line-height: 1.6;">
                Pembayaran diproses secara eksklusif menggunakan <strong>Midtrans Payment Gateway</strong> (QRIS, Virtual Account, & Kartu) secara aman dan terverifikasi otomatis.
            </p>
        </div>
    </div>

    <!-- Kolom Kanan: Form Order -->
    <div>
        <div class="card" style="border-color: var(--border-color); background-color: #141923;">
            <div class="card-header">
                <div class="card-title">Form Data Pemesan</div>
            </div>

            <form action="{{ route('tickets.order', $ticket->id) }}" method="POST">
                @csrf
                <div class="form-group">
                    <label class="form-label" for="visit_date">Tanggal Kunjungan</label>
                    <input type="date" id="visit_date" name="visit_date" class="form-control" value="{{ old('visit_date', date('Y-m-d')) }}" min="{{ date('Y-m-d') }}" required />
                    <div class="form-hint">Pilih tanggal rencana kedatangan Anda.</div>
                </div>

                <div class="form-group">
                    <label class="form-label" for="quantity">Jumlah Tiket</label>
                    <input type="number" id="quantity" name="quantity" class="form-control" min="1" max="50" value="{{ old('quantity', 1) }}" required oninput="calculateTotal()" />
                </div>

                <div class="form-group">
                    <label class="form-label" for="customer_name">Nama Lengkap Pemesan</label>
                    <input type="text" id="customer_name" name="customer_name" class="form-control" placeholder="Nama sesuai identitas KTP" value="{{ old('customer_name', Auth::user()->name ?? '') }}" required />
                </div>

                <div class="form-group">
                    <label class="form-label" for="customer_email">Alamat Email Penerima E-Ticket</label>
                    <input type="email" id="customer_email" name="customer_email" class="form-control" placeholder="nama@email.com" value="{{ old('customer_email', Auth::user()->email ?? '') }}" required />
                </div>

                <div class="form-group">
                    <label class="form-label" for="customer_phone">Nomor Telepon / WhatsApp</label>
                    <input type="tel" id="customer_phone" name="customer_phone" class="form-control" placeholder="08xxxxxxxxxx" value="{{ old('customer_phone', Auth::user()->phone ?? '') }}" required />
                </div>

                <!-- Ringkasan Biaya -->
                <div style="background-color: #0c0f17; border: 1px solid var(--border-color); padding: 1.25rem; margin-bottom: 1.5rem; border-radius: 4px;">
                    <div style="display: flex; justify-content: space-between; font-size: 0.85rem; color: var(--text-muted); margin-bottom: 0.5rem;">
                        <span>Tarif Satuan:</span>
                        <span>IDR {{ number_format($ticket->price, 0, ',', '.') }}</span>
                    </div>
                    <div style="display: flex; justify-content: space-between; font-size: 0.85rem; color: var(--text-muted); margin-bottom: 0.5rem;">
                        <span>Biaya Transaksi:</span>
                        <span>IDR 0</span>
                    </div>
                    <div style="display: flex; justify-content: space-between; font-size: 1rem; color: #ffffff; font-weight: 700; border-top: 1px solid var(--border-color); padding-top: 0.75rem; margin-top: 0.5rem;">
                        <span>Total Pembayaran (Server):</span>
                        <span id="display-total" style="color: var(--color-primary); font-family: 'Plus Jakarta Sans', sans-serif;">
                            IDR {{ number_format($ticket->price, 0, ',', '.') }}
                        </span>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary btn-block btn-lg">Lanjut ke Pembayaran</button>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    const unitPrice = {{ (int) $ticket->price }};
    function calculateTotal() {
        const qty = parseInt(document.getElementById('quantity').value) || 1;
        const total = qty * unitPrice;
        document.getElementById('display-total').innerText = 'IDR ' + new Intl.NumberFormat('id-ID').format(total);
    }
</script>
@endpush
