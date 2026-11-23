@extends('layouts.admin')

@section('title', 'Edit Tiket Wisata')
@section('page-title', 'Perbarui Data Tiket')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Edit {{ $ticket->name }}</h1>
        <p class="page-subtitle">Perbarui tarif dan cakupan fasilitas tiket.</p>
    </div>
    <a href="{{ route('admin.tickets.index') }}" class="btn btn-secondary btn-sm">Batal & Kembali</a>
</div>

<div style="max-width: 680px;">
    <div class="card">
        <form action="{{ route('admin.tickets.update', $ticket->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label class="form-label" for="name">Nama / Kategori Tiket</label>
                <input type="text" id="name" name="name" class="form-control" value="{{ old('name', $ticket->name) }}" required />
            </div>

            <div class="grid-2" style="gap: 1rem;">
                <div class="form-group">
                    <label class="form-label" for="price">Harga Satuan (IDR)</label>
                    <input type="number" id="price" name="price" class="form-control" value="{{ old('price', $ticket->price) }}" required />
                </div>
                <div class="form-group">
                    <label class="form-label" for="is_active">Status Penjualan</label>
                    <select id="is_active" name="is_active" class="form-control">
                        <option value="1" {{ old('is_active', $ticket->is_active ? '1' : '0') == '1' ? 'selected' : '' }}>Aktif (Dapat Dipesan)</option>
                        <option value="0" {{ old('is_active', $ticket->is_active ? '1' : '0') == '0' ? 'selected' : '' }}>Non-aktif</option>
                    </select>
                </div>
            </div>

            <div class="grid-2" style="gap: 1rem;">
                <div class="form-group">
                    <label class="form-label" for="min_age">Batas Usia Minimum</label>
                    <input type="number" id="min_age" name="min_age" class="form-control" value="{{ old('min_age', $ticket->min_age) }}" />
                </div>
                <div class="form-group">
                    <label class="form-label" for="max_age">Batas Usia Maksimum</label>
                    <input type="number" id="max_age" name="max_age" class="form-control" value="{{ old('max_age', $ticket->max_age) }}" />
                </div>
            </div>

            <div class="form-group">
                <label class="form-label" for="description">Deskripsi & Cakupan Akses</label>
                <textarea id="description" name="description" class="form-control" required>{{ old('description', $ticket->description) }}</textarea>
            </div>

            <div class="form-group">
                <label class="form-label" for="features">Daftar Fitur (Satu baris per fitur)</label>
                <textarea id="features" name="features" class="form-control">{{ old('features', $ticket->features) }}</textarea>
            </div>

            <div style="display: flex; gap: 1rem; margin-top: 1.5rem;">
                <button type="submit" class="btn btn-primary">Perbarui Tiket</button>
                <a href="{{ route('admin.tickets.index') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
