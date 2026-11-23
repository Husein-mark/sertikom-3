@extends('layouts.admin')

@section('title', 'Pengajuan Paket Sekolah')
@section('page-title', 'Persetujuan Paket Rombongan Sekolah')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Permohonan Kunjungan Sekolah</h1>
        <p class="page-subtitle">Tinjau permohonan tanggal, kuota rombongan, dan setujui atau tolak pengajuan.</p>
    </div>
</div>

<!-- Filter Tab Status -->
<div style="display: flex; gap: 0.5rem; margin-bottom: 1.5rem;">
    <a href="{{ route('admin.school.index') }}" class="btn {{ empty(request('status')) ? 'btn-primary' : 'btn-secondary' }} btn-sm">Semua Pengajuan</a>
    <a href="{{ route('admin.school.index', ['status' => 'pending_approval']) }}" class="btn {{ request('status') === 'pending_approval' ? 'btn-primary' : 'btn-secondary' }} btn-sm">Menunggu Persetujuan</a>
    <a href="{{ route('admin.school.index', ['status' => 'approved']) }}" class="btn {{ request('status') === 'approved' ? 'btn-primary' : 'btn-secondary' }} btn-sm">Disetujui Admin</a>
    <a href="{{ route('admin.school.index', ['status' => 'rejected']) }}" class="btn {{ request('status') === 'rejected' ? 'btn-primary' : 'btn-secondary' }} btn-sm">Ditolak</a>
</div>

<div class="table-wrapper">
    <table class="data-table">
        <thead>
            <tr>
                <th>No. Berkas</th>
                <th>Nama Institusi Sekolah</th>
                <th>Paket Edukasi</th>
                <th>Rencana Tanggal</th>
                <th>Peserta</th>
                <th>Total Biaya</th>
                <th>Status Admin</th>
                <th>Aksi Review</th>
            </tr>
        </thead>
        <tbody>
            @forelse($schools as $s)
                <tr>
                    <td style="font-family: 'Plus Jakarta Sans', sans-serif; font-weight: 700; color: #ffffff;">
                        {{ $s->order_number }}
                    </td>
                    <td>
                        <div style="font-weight: 600; color: #ffffff;">{{ $s->school_name }}</div>
                        <div style="font-size: 0.75rem; color: var(--admin-sub);">PIC: {{ $s->pic_name }} ({{ $s->pic_phone }})</div>
                    </td>
                    <td>{{ $s->package->name ?? 'Paket Sekolah' }}</td>
                    <td style="color: var(--admin-primary); font-family: 'Plus Jakarta Sans', sans-serif; font-weight: 700;">
                        {{ \Carbon\Carbon::parse($s->visit_date)->format('d M Y') }}
                    </td>
                    <td>{{ $s->quantity }} Siswa</td>
                    <td style="font-family: 'Plus Jakarta Sans', sans-serif; font-weight: 700; color: #ffffff;">
                        IDR {{ number_format($s->total_price, 0, ',', '.') }}
                    </td>
                    <td>
                        @if($s->status === 'pending_approval')
                            <span class="badge badge-warning">Menunggu Review</span>
                        @elseif($s->status === 'approved')
                            <span class="badge badge-approved">Disetujui Admin</span>
                        @elseif($s->status === 'rejected')
                            <span class="badge badge-rejected">Ditolak</span>
                        @elseif($s->status === 'paid')
                            <span class="badge badge-paid">Lunas</span>
                        @else
                            <span class="badge badge-secondary">{{ $s->status }}</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('admin.school.show', $s->id) }}" class="btn btn-primary btn-sm">Tinjau & Validasi</a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" style="text-align: center; color: var(--admin-muted); padding: 2.5rem;">Belum ada pengajuan rombongan sekolah.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div style="margin-top: 1.5rem;">
    {{ $schools->links() }}
</div>
@endsection
