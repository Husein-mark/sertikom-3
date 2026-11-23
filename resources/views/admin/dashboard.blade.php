@extends('layouts.admin')

@section('title', 'Dashboard Administrator')
@section('page-title', 'Pusat Kendali Pengelola')

@section('content')
<!-- Stats Grid -->
<div class="stats-grid">
    <div class="stat-card stat-border-cyan">
        <div class="stat-label">Total Pesanan Masuk</div>
        <div class="stat-value">{{ $totalOrders }}</div>
        <div style="font-size: 0.75rem; color: var(--admin-muted); margin-top: 0.35rem;">Tiket Umum & Rombongan</div>
    </div>
    <div class="stat-card stat-border-green">
        <div class="stat-label">Pendapatan Terverifikasi</div>
        <div class="stat-value">IDR {{ number_format($totalRevenue, 0, ',', '.') }}</div>
        <div style="font-size: 0.75rem; color: var(--admin-muted); margin-top: 0.35rem;">Via Midtrans Sandbox</div>
    </div>
    <div class="stat-card stat-border-orange">
        <div class="stat-label">Pengajuan Sekolah Pending</div>
        <div class="stat-value">{{ $pendingSchoolCount }}</div>
        <div style="font-size: 0.75rem; color: var(--admin-muted); margin-top: 0.35rem;">Membutuhkan Persetujuan</div>
    </div>
    <div class="stat-card stat-border-blue">
        <div class="stat-label">Pesanan Lunas (E-Ticket)</div>
        <div class="stat-value">{{ $paidOrdersCount }}</div>
        <div style="font-size: 0.75rem; color: var(--admin-muted); margin-top: 0.35rem;">Siap Check-in Gerbang</div>
    </div>
</div>

<div class="grid-2">
    <!-- Pesanan Tiket Terbaru -->
    <div class="card">
        <div class="card-header">
            <div class="card-title">Transaksi Tiket Masuk Terbaru</div>
            <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary btn-sm">Lihat Semua</a>
        </div>
        <table class="data-table">
            <thead>
                <tr>
                    <th>No. Order</th>
                    <th>Nama</th>
                    <th>Total</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($recentOrders as $ro)
                    <tr>
                        <td style="font-family: 'Plus Jakarta Sans', sans-serif; font-weight: 700; color: #ffffff;">
                            <a href="{{ route('admin.orders.show', $ro->id) }}">{{ $ro->order_number }}</a>
                        </td>
                        <td>{{ $ro->customer_name }}</td>
                        <td>IDR {{ number_format($ro->total_price, 0, ',', '.') }}</td>
                        <td>
                            @if($ro->status === 'paid')
                                <span class="badge badge-paid">Lunas</span>
                            @elseif($ro->status === 'unpaid')
                                <span class="badge badge-pending">Menunggu Bayar</span>
                            @elseif($ro->status === 'approved')
                                <span class="badge badge-approved">Disetujui</span>
                            @elseif($ro->status === 'pending_approval')
                                <span class="badge badge-warning">Review</span>
                            @else
                                <span class="badge badge-secondary">{{ $ro->status }}</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" style="text-align: center; color: var(--admin-muted);">Belum ada data pesanan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Antrean Pengajuan Sekolah -->
    <div class="card">
        <div class="card-header">
            <div class="card-title">Permohonan Sekolah Perlu Ditinjau</div>
            <a href="{{ route('admin.school.index') }}" class="btn btn-secondary btn-sm">Kelola Antrean</a>
        </div>
        <table class="data-table">
            <thead>
                <tr>
                    <th>Nama Sekolah</th>
                    <th>Peserta</th>
                    <th>Tgl Kunjungan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pendingSchools as $ps)
                    <tr>
                        <td><strong>{{ $ps->school_name }}</strong></td>
                        <td>{{ $ps->quantity }} Siswa</td>
                        <td>{{ \Carbon\Carbon::parse($ps->visit_date)->format('d M Y') }}</td>
                        <td><a href="{{ route('admin.school.show', $ps->id) }}" class="btn btn-primary btn-sm">Review</a></td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" style="text-align: center; color: var(--admin-muted); padding: 1.5rem;">Tidak ada permohonan pending.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
