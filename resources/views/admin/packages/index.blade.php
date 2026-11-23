@extends('layouts.admin')

@section('title', 'Kelola Paket Kunjungan Sekolah')
@section('page-title', 'Manajemen Paket Sekolah')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Paket Rombongan Sekolah</h1>
        <p class="page-subtitle">Daftar paket edukasi resmi untuk institusi sekolah.</p>
    </div>
    <a href="{{ route('admin.packages.create') }}" class="btn btn-primary btn-sm">Tambah Paket Baru</a>
</div>

<div class="table-wrapper">
    <table class="data-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama Paket</th>
                <th>Tarif / Siswa</th>
                <th>Min. Siswa</th>
                <th>Durasi</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($packages as $p)
                <tr>
                    <td>{{ $p->id }}</td>
                    <td><strong>{{ $p->name }}</strong></td>
                    <td style="font-family: 'Plus Jakarta Sans', sans-serif; font-weight: 700; color: #ffffff;">
                        IDR {{ number_format($p->price_per_student, 0, ',', '.') }}
                    </td>
                    <td>{{ $p->min_students }} Siswa</td>
                    <td>{{ $p->duration }}</td>
                    <td>
                        @if($p->is_active)
                            <span class="badge badge-success">Aktif</span>
                        @else
                            <span class="badge badge-danger">Non-aktif</span>
                        @endif
                    </td>
                    <td>
                        <div style="display: flex; gap: 0.5rem;">
                            <a href="{{ route('admin.packages.edit', $p->id) }}" class="btn btn-secondary btn-sm">Edit</a>
                            <form action="{{ route('admin.packages.destroy', $p->id) }}" method="POST" onsubmit="return confirm('Hapus paket sekolah ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" style="text-align: center; color: var(--admin-muted); padding: 2rem;">Belum ada data paket sekolah.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
