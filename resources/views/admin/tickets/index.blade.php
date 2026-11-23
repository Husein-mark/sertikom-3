@extends('layouts.admin')

@section('title', 'Kelola Tiket Wisata')
@section('page-title', 'Manajemen Tiket Umum')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Daftar Tiket Wisata</h1>
        <p class="page-subtitle">Kelola harga dan ketersediaan kategori tiket masuk umum.</p>
    </div>
    <a href="{{ route('admin.tickets.create') }}" class="btn btn-primary btn-sm">Tambah Tiket Baru</a>
</div>

<div class="table-wrapper">
    <table class="data-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Kategori Tiket</th>
                <th>Rentang Usia</th>
                <th>Harga Satuan</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($tickets as $t)
                <tr>
                    <td>{{ $t->id }}</td>
                    <td><strong>{{ $t->name }}</strong></td>
                    <td>
                        @if($t->min_age && $t->max_age)
                            {{ $t->min_age }} - {{ $t->max_age }} Tahun
                        @elseif($t->min_age)
                            {{ $t->min_age }}+ Tahun
                        @else
                            Umum
                        @endif
                    </td>
                    <td style="font-family: 'Plus Jakarta Sans', sans-serif; font-weight: 700; color: #ffffff;">
                        IDR {{ number_format($t->price, 0, ',', '.') }}
                    </td>
                    <td>
                        @if($t->is_active)
                            <span class="badge badge-success">Aktif</span>
                        @else
                            <span class="badge badge-danger">Non-aktif</span>
                        @endif
                    </td>
                    <td>
                        <div style="display: flex; gap: 0.5rem;">
                            <a href="{{ route('admin.tickets.edit', $t->id) }}" class="btn btn-secondary btn-sm">Edit</a>
                            <form action="{{ route('admin.tickets.destroy', $t->id) }}" method="POST" onsubmit="return confirm('Hapus kategori tiket ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" style="text-align: center; color: var(--admin-muted); padding: 2rem;">Belum ada data tiket.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
