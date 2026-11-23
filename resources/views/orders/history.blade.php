@extends('layouts.app')

@section('title', 'Riwayat Pesanan - The Nice Park Rumpin')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Riwayat Pesanan Saya</h1>
        <p class="page-subtitle">Daftar transaksi pemesanan tiket umum dan pengajuan paket sekolah.</p>
    </div>
    <div style="display: flex; gap: 0.75rem;">
        <a href="{{ route('tickets.index') }}" class="btn btn-primary btn-sm">Beli Tiket Baru</a>
        <a href="{{ route('school.apply') }}" class="btn btn-secondary btn-sm">Ajukan Sekolah</a>
    </div>
</div>

<!-- Tabs Status Filter -->
<div style="display: flex; gap: 0.5rem; margin-bottom: 1.5rem; border-bottom: 1px solid var(--border-color); padding-bottom: 0.75rem; overflow-x: auto;">
    <a href="{{ route('orders.history') }}" class="btn {{ empty($status) ? 'btn-primary' : 'btn-secondary' }} btn-sm">Semua Pesanan</a>
    <a href="{{ route('orders.history', ['status' => 'unpaid']) }}" class="btn {{ $status === 'unpaid' ? 'btn-primary' : 'btn-secondary' }} btn-sm">Siap Dibayar</a>
    <a href="{{ route('orders.history', ['status' => 'pending_approval']) }}" class="btn {{ $status === 'pending_approval' ? 'btn-primary' : 'btn-secondary' }} btn-sm">Menunggu Persetujuan</a>
    <a href="{{ route('orders.history', ['status' => 'paid']) }}" class="btn {{ $status === 'paid' ? 'btn-primary' : 'btn-secondary' }} btn-sm">Berhasil / E-Ticket</a>
</div>

<!-- Tabel Riwayat Pesanan -->
<div class="table-wrapper">
    <table class="data-table">
        <thead>
            <tr>
                <th>No. Pesanan</th>
                <th>Kategori</th>
                <th>Detail Pemesanan</th>
                <th>Tgl Kunjungan</th>
                <th>Jumlah</th>
                <th>Total Biaya</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($orders as $order)
                <tr>
                    <td style="font-family: 'Plus Jakarta Sans', sans-serif; font-weight: 700; color: #ffffff;">
                        {{ $order->order_number }}
                    </td>
                    <td>
                        @if($order->isGeneral())
                            <span class="badge badge-info">Umum</span>
                        @else
                            <span class="badge" style="background-color: #312e81; color: #a5b4fc; border-color: #4338ca;">Sekolah</span>
                        @endif
                    </td>
                    <td>
                        @if($order->isGeneral())
                            {{ $order->ticket->name ?? 'Tiket Masuk' }}
                        @else
                            <strong>{{ $order->school_name }}</strong><br />
                            <span style="font-size: 0.78rem; color: var(--text-muted);">{{ $order->package->name ?? 'Paket Sekolah' }}</span>
                        @endif
                    </td>
                    <td>{{ \Carbon\Carbon::parse($order->visit_date)->format('d M Y') }}</td>
                    <td>{{ $order->quantity }} {{ $order->isGeneral() ? 'Orang' : 'Siswa' }}</td>
                    <td style="font-family: 'Plus Jakarta Sans', sans-serif; font-weight: 700; color: #ffffff;">
                        IDR {{ number_format($order->total_price, 0, ',', '.') }}
                    </td>
                    <td>
                        @if($order->status === 'paid')
                            <span class="badge badge-paid">Lunas</span>
                        @elseif($order->status === 'unpaid')
                            <span class="badge badge-pending">Menunggu Bayar</span>
                        @elseif($order->status === 'approved')
                            <span class="badge badge-approved">Disetujui Admin</span>
                        @elseif($order->status === 'pending_approval')
                            <span class="badge badge-warning">Menunggu Review</span>
                        @elseif($order->status === 'rejected')
                            <span class="badge badge-danger">Ditolak</span>
                        @else
                            <span class="badge badge-secondary">{{ ucfirst($order->status) }}</span>
                        @endif
                    </td>
                    <td>
                        @if($order->status === 'paid')
                            <a href="{{ route('orders.eticket', $order->id) }}" class="btn btn-primary btn-sm">Lihat E-Ticket</a>
                        @elseif(in_array($order->status, ['unpaid', 'approved']))
                            <a href="{{ route('orders.checkout', $order->id) }}" class="btn btn-primary btn-sm">Bayar Midtrans</a>
                        @elseif($order->status === 'pending_approval')
                            <span style="font-size: 0.78rem; color: var(--text-sub);">Menunggu Admin</span>
                        @elseif($order->status === 'rejected')
                            <span style="font-size: 0.78rem; color: var(--color-danger);">Ditolak</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" style="text-align: center; padding: 3rem; color: var(--text-muted);">
                        Belum ada riwayat pesanan. Silakan pesan tiket umum atau ajukan rombongan sekolah.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
