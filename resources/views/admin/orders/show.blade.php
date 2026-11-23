@extends('layouts.admin')

@section('title', 'Detail Pesanan ' . $order->order_number)
@section('page-title', 'Rincian Transaksi #' . $order->order_number)

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Transaksi {{ $order->order_number }}</h1>
        <p class="page-subtitle">Informasi lengkap pemesan, pembayaran Midtrans, dan penerbitan tiket.</p>
    </div>
    <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary btn-sm">Kembali ke Daftar Pesanan</a>
</div>

<div class="grid-2">
    <!-- Informasi Pemesan & Tiket -->
    <div>
        <div class="card" style="margin-bottom: 1.5rem;">
            <div class="card-header">
                <div class="card-title">Informasi Pelanggan</div>
                <span class="badge {{ $order->isGeneral() ? 'badge-info' : 'badge-primary' }}">
                    {{ $order->isGeneral() ? 'Kategori Umum' : 'Rombongan Sekolah' }}
                </span>
            </div>
            <table style="width: 100%; border-collapse: collapse; font-size: 0.85rem;">
                @if($order->isSchool())
                    <tr style="border-bottom: 1px solid var(--admin-border);">
                        <td style="padding: 0.6rem 0; color: var(--admin-muted);">Nama Sekolah</td>
                        <td style="padding: 0.6rem 0; text-align: right; font-weight: 700; color: #ffffff;">{{ $order->school_name }}</td>
                    </tr>
                    <tr style="border-bottom: 1px solid var(--admin-border);">
                        <td style="padding: 0.6rem 0; color: var(--admin-muted);">Alamat Sekolah</td>
                        <td style="padding: 0.6rem 0; text-align: right; color: #ffffff;">{{ $order->school_address }}</td>
                    </tr>
                    <tr style="border-bottom: 1px solid var(--admin-border);">
                        <td style="padding: 0.6rem 0; color: var(--admin-muted);">Penanggung Jawab (PIC)</td>
                        <td style="padding: 0.6rem 0; text-align: right; color: #ffffff;">{{ $order->pic_name }} ({{ $order->pic_position }})</td>
                    </tr>
                @else
                    <tr style="border-bottom: 1px solid var(--admin-border);">
                        <td style="padding: 0.6rem 0; color: var(--admin-muted);">Nama Pemesan</td>
                        <td style="padding: 0.6rem 0; text-align: right; font-weight: 600; color: #ffffff;">{{ $order->customer_name }}</td>
                    </tr>
                @endif
                <tr style="border-bottom: 1px solid var(--admin-border);">
                    <td style="padding: 0.6rem 0; color: var(--admin-muted);">Alamat Email</td>
                    <td style="padding: 0.6rem 0; text-align: right; color: #ffffff;">{{ $order->customer_email }}</td>
                </tr>
                <tr style="border-bottom: 1px solid var(--admin-border);">
                    <td style="padding: 0.6rem 0; color: var(--admin-muted);">Nomor Telepon</td>
                    <td style="padding: 0.6rem 0; text-align: right; color: #ffffff;">{{ $order->customer_phone }}</td>
                </tr>
                <tr>
                    <td style="padding: 0.6rem 0; color: var(--admin-muted);">Waktu Pemesanan</td>
                    <td style="padding: 0.6rem 0; text-align: right; color: #ffffff;">{{ $order->created_at->format('d M Y, H:i') }} WIB</td>
                </tr>
            </table>
        </div>

        <div class="card">
            <div class="card-header">
                <div class="card-title">Rincian Item Tiket</div>
            </div>
            <table style="width: 100%; border-collapse: collapse; font-size: 0.85rem;">
                <tr style="border-bottom: 1px solid var(--admin-border);">
                    <td style="padding: 0.6rem 0; color: var(--admin-muted);">Item Tiket / Paket</td>
                    <td style="padding: 0.6rem 0; text-align: right; color: #ffffff; font-weight: 600;">
                        {{ $order->isGeneral() ? ($order->ticket->name ?? 'Tiket Masuk') : ($order->package->name ?? 'Paket Sekolah') }}
                    </td>
                </tr>
                <tr style="border-bottom: 1px solid var(--admin-border);">
                    <td style="padding: 0.6rem 0; color: var(--admin-muted);">Tanggal Kunjungan</td>
                    <td style="padding: 0.6rem 0; text-align: right; color: var(--admin-primary); font-family: 'Plus Jakarta Sans', sans-serif; font-weight: 700;">
                        {{ \Carbon\Carbon::parse($order->visit_date)->isoFormat('D MMMM Y') }}
                    </td>
                </tr>
                <tr style="border-bottom: 1px solid var(--admin-border);">
                    <td style="padding: 0.6rem 0; color: var(--admin-muted);">Jumlah Peserta</td>
                    <td style="padding: 0.6rem 0; text-align: right; color: #ffffff;">
                        {{ $order->quantity }} {{ $order->isGeneral() ? 'Orang' : 'Siswa' }}
                    </td>
                </tr>
                <tr style="border-bottom: 1px solid var(--admin-border);">
                    <td style="padding: 0.6rem 0; color: var(--admin-muted);">Tarif Satuan</td>
                    <td style="padding: 0.6rem 0; text-align: right; color: #ffffff;">
                        IDR {{ number_format($order->unit_price, 0, ',', '.') }}
                    </td>
                </tr>
                <tr>
                    <td style="padding: 0.8rem 0; font-weight: 700; color: #ffffff;">Total Biaya (Server)</td>
                    <td style="padding: 0.8rem 0; text-align: right; font-family: 'Plus Jakarta Sans', sans-serif; font-size: 1.25rem; font-weight: 800; color: var(--admin-primary);">
                        IDR {{ number_format($order->total_price, 0, ',', '.') }}
                    </td>
                </tr>
            </table>
        </div>
    </div>

    <!-- Status Verifikasi & Midtrans Gateway -->
    <div>
        <div class="card" style="margin-bottom: 1.5rem;">
            <div class="card-header">
                <div class="card-title">Status Pembayaran Gateway</div>
                @if($order->status === 'paid')
                    <span class="badge badge-paid">TERVERIFIKASI LUNAS</span>
                @elseif($order->status === 'approved')
                    <span class="badge badge-approved">DISETUJUI ADMIN</span>
                @elseif($order->status === 'pending_approval')
                    <span class="badge badge-warning">MENUNGGU REVIEW</span>
                @elseif($order->status === 'rejected')
                    <span class="badge badge-danger">DITOLAK</span>
                @else
                    <span class="badge badge-pending">MENUNGGU BAYAR</span>
                @endif
            </div>
            <div style="font-size: 0.85rem; line-height: 1.8;">
                <div style="display: flex; justify-content: space-between; border-bottom: 1px solid var(--admin-border); padding: 0.5rem 0;">
                    <span style="color: var(--admin-muted);">Payment Gateway:</span>
                    <strong style="color: #ffffff;">Midtrans Sandbox (1 Saluran)</strong>
                </div>
                <div style="display: flex; justify-content: space-between; border-bottom: 1px solid var(--admin-border); padding: 0.5rem 0;">
                    <span style="color: var(--admin-muted);">Metode Bayar:</span>
                    <strong style="color: #ffffff;">{{ $order->latestPayment->payment_type ?? 'Midtrans Snap' }}</strong>
                </div>
                <div style="display: flex; justify-content: space-between; border-bottom: 1px solid var(--admin-border); padding: 0.5rem 0;">
                    <span style="color: var(--admin-muted);">Midtrans Order ID:</span>
                    <strong style="font-family: 'Plus Jakarta Sans', sans-serif; color: #ffffff;">{{ $order->order_number }}</strong>
                </div>
                <div style="display: flex; justify-content: space-between; padding: 0.5rem 0;">
                    <span style="color: var(--admin-muted);">Waktu Lunas:</span>
                    <strong style="color: #ffffff;">
                        {{ $order->latestPayment && $order->latestPayment->paid_at ? $order->latestPayment->paid_at->format('d M Y H:i') . ' WIB' : '-' }}
                    </strong>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <div class="card-title">Tindakan Administrator</div>
            </div>
            <div style="display: flex; flex-direction: column; gap: 0.75rem;">
                @if($order->isPaid())
                    <a href="{{ route('orders.eticket', $order->id) }}" target="_blank" class="btn btn-secondary btn-block">Pratinjau E-Ticket Pengunjung</a>
                @elseif(in_array($order->status, ['unpaid', 'approved']))
                    <form action="{{ route('admin.orders.verify', $order->id) }}" method="POST" onsubmit="return confirm('Konfirmasi verifikasi manual pembayaran ini?')">
                        @csrf
                        <button type="submit" class="btn btn-success btn-block">
                            Verifikasi Pembayaran Manual & Terbitkan E-Ticket
                        </button>
                    </form>
                @endif

                @if($order->isSchool() && $order->status === 'pending_approval')
                    <a href="{{ route('admin.school.show', $order->id) }}" class="btn btn-primary btn-block">Buka Formulir Review Pengajuan Sekolah</a>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
