@extends('layouts.admin')

@section('title', 'Tambah Tiket Wisata')
@section('page-title', 'Tambah Kategori Tiket')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Tambah Tiket Baru</h1>
        <p class="page-subtitle">Formulir penambahan kategori tiket umum.</p>
    </div>
    <a href="{{ route('admin.tickets.index') }}" class="btn btn-secondary btn-sm">Batal & Kembali</a>
</div>

<div style="max-width: 680px;">
    <div class="card">
        <form action="{{ route('admin.tickets.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label class="form-label" for="name">Nama / Kategori Tiket</label>
                <input type="text" id="name" name="name" class="form-control" placeholder="Contoh: Tiket Dewasa" value="{{ old('name') }}" required />
            </div>

            <div class="grid-2" style="gap: 1rem;">
                <div class="form-group">
                    <label class="form-label" for="price">Harga Satuan (IDR)</label>
                    <input type="number" id="price" name="price" class="form-control" placeholder="55000" value="{{ old('price') }}" required />
                </div>
                <div class="form-group">
                    <label class="form-label" for="is_active">Status Penjualan</label>
                    <select id="is_active" name="is_active" class="form-control">
                        <option value="1" {{ old('is_active', '1') == '1' ? 'selected' : '' }}>Aktif (Dapat Dipesan)</option>
                        <option value="0" {{ old('is_active') == '0' ? 'selected' : '' }}>Non-aktif</option>
                    </select>
                </div>
            </div>

            <div class="grid-2" style="gap: 1rem;">
                <div class="form-group">
                    <label class="form-label" for="min_age">Batas Usia Minimum</label>
                    <input type="number" id="min_age" name="min_age" class="form-control" placeholder="13" value="{{ old('min_age') }}" />
                </div>
                <div class="form-group">
                    <label class="form-label" for="max_age">Batas Usia Maksimum</label>
                    <input type="number" id="max_age" name="max_age" class="form-control" placeholder="59" value="{{ old('max_age') }}" />
                </div>
            </div>

            <div class="form-group">
                <label class="form-label" for="description">Deskripsi & Cakupan Akses</label>
                <textarea id="description" name="description" class="form-control" placeholder="Akses seluruh wahana utama..." required>{{ old('description') }}</textarea>
            </div>

            <div class="form-group">
                <label class="form-label" for="features">Daftar Fitur (Satu baris per fitur)</label>
                <textarea id="features" name="features" class="form-control" placeholder="Akses Semua Wahana&#10;Spot Foto Eksklusif&#10;Rest Area">{{ old('features') }}</textarea>
            </div>

            <div style="display: flex; gap: 1rem; margin-top: 1.5rem;">
                <button type="submit" class="btn btn-primary">Simpan Tiket</button>
                <a href="{{ route('admin.tickets.index') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
