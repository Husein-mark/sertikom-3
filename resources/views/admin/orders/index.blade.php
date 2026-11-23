@extends('layouts.admin')

@section('title', 'Daftar Seluruh Pesanan')
@section('page-title', 'Manajemen Transaksi Pesanan')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Seluruh Transaksi & Pesanan</h1>
        <p class="page-subtitle">Monitoring status transaksi tiket umum dan paket sekolah melalui Midtrans.</p>
    </div>
</div>

<!-- Filter Bar -->
<form action="{{ route('admin.orders.index') }}" method="GET" class="filter-bar">
    <input type="text" name="search" class="form-control" placeholder="Cari No. Order / Nama / Email / Sekolah..." value="{{ request('search') }}" style="max-width: 280px;" />
    
    <select name="status" class="form-control" style="max-width: 180px;">
        <option value="">Semua Status</option>
        <option value="paid" {{ request('status') === 'paid' ? 'selected' : '' }}>Lunas (Midtrans)</option>
        <option value="unpaid" {{ request('status') === 'unpaid' ? 'selected' : '' }}>Menunggu Bayar</option>
        <option value="approved" {{ request('status') === 'approved' ? 'selected' : '' }}>Disetujui Admin</option>
        <option value="pending_approval" {{ request('status') === 'pending_approval' ? 'selected' : '' }}>Menunggu Review</option>
        <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>Ditolak</option>
    </select>

    <select name="type" class="form-control" style="max-width: 160px;">
        <option value="">Semua Kategori</option>
        <option value="general" {{ request('type') === 'general' ? 'selected' : '' }}>Tiket Umum</option>
        <option value="school" {{ request('type') === 'school' ? 'selected' : '' }}>Paket Sekolah</option>
    </select>

    <button type="submit" class="btn btn-primary btn-sm">Filter</button>
    @if(request()->hasAny(['search', 'status', 'type']))
        <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary btn-sm">Reset</a>
    @endif
</form>

<div class="table-wrapper">
    <table class="data-table">
        <thead>
            <tr>
                <th>No. Order</th>
                <th>Pemesan</th>
                <th>Kategori</th>
                <th>Item / Paket</th>
                <th>Tgl Kunjungan</th>
                <th>Qty</th>
                <th>Total Tagihan</th>
                <th>Status Bayar</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($orders as $o)
                <tr>
                    <td style="font-family: 'Plus Jakarta Sans', sans-serif; font-weight: 700; color: #ffffff;">
                        {{ $o->order_number }}
                    </td>
                    <td>
                        <div style="font-weight: 600; color: #ffffff;">{{ $o->customer_name }}</div>
                        <div style="font-size: 0.75rem; color: var(--admin-sub);">{{ $o->customer_email }}</div>
                    </td>
                    <td>
                        @if($o->isGeneral())
                            <span class="badge badge-info">Umum</span>
                        @else
                            <span class="badge" style="background-color: #312e81; color: #a5b4fc; border-color: #4338ca;">Sekolah</span>
                        @endif
                    </td>
                    <td>
                        @if($o->isGeneral())
                            {{ $o->ticket->name ?? 'Tiket Masuk' }}
                        @else
                            <strong>{{ $o->school_name }}</strong><br />
                            <span style="font-size: 0.75rem; color: var(--admin-sub);">{{ $o->package->name ?? 'Paket Sekolah' }}</span>
                        @endif
                    </td>
                    <td>{{ \Carbon\Carbon::parse($o->visit_date)->format('d M Y') }}</td>
                    <td>{{ $o->quantity }} {{ $o->isGeneral() ? 'Orang' : 'Siswa' }}</td>
                    <td style="font-family: 'Plus Jakarta Sans', sans-serif; font-weight: 700; color: #ffffff;">
                        IDR {{ number_format($o->total_price, 0, ',', '.') }}
                    </td>
                    <td>
                        @if($o->status === 'paid')
                            <span class="badge badge-paid">Lunas (Midtrans)</span>
                        @elseif($o->status === 'unpaid')
                            <span class="badge badge-pending">Pending Midtrans</span>
                        @elseif($o->status === 'approved')
                            <span class="badge badge-approved">Disetujui Admin</span>
                        @elseif($o->status === 'pending_approval')
                            <span class="badge badge-warning">Review Admin</span>
                        @elseif($o->status === 'rejected')
                            <span class="badge badge-danger">Ditolak</span>
                        @else
                            <span class="badge badge-secondary">{{ $o->status }}</span>
                        @endif
                    </td>
                    <td>
                        @if($o->isSchool() && $o->status === 'pending_approval')
                            <a href="{{ route('admin.school.show', $o->id) }}" class="btn btn-primary btn-sm">Tinjau</a>
                        @else
                            <a href="{{ route('admin.orders.show', $o->id) }}" class="btn btn-secondary btn-sm">Detail</a>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="9" style="text-align: center; color: var(--admin-muted); padding: 2.5rem;">Tidak ada data pesanan yang sesuai filter.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div style="margin-top: 1.5rem;">
    {{ $orders->links() }}
</div>
@endsection
