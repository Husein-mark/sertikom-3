@extends('layouts.admin')

@section('title', 'Edit Paket Sekolah')
@section('page-title', 'Perbarui Data Paket')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Edit {{ $package->name }}</h1>
        <p class="page-subtitle">Perbarui ketentuan harga dan fasilitas paket rombongan.</p>
    </div>
    <a href="{{ route('admin.packages.index') }}" class="btn btn-secondary btn-sm">Batal & Kembali</a>
</div>

<div style="max-width: 680px;">
    <div class="card">
        <form action="{{ route('admin.packages.update', $package->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label class="form-label" for="name">Nama Paket Edukasi</label>
                <input type="text" id="name" name="name" class="form-control" value="{{ old('name', $package->name) }}" required />
            </div>

            <div class="grid-2" style="gap: 1rem;">
                <div class="form-group">
                    <label class="form-label" for="price_per_student">Tarif per Siswa (IDR)</label>
                    <input type="number" id="price_per_student" name="price_per_student" class="form-control" value="{{ old('price_per_student', $package->price_per_student) }}" required />
                </div>
                <div class="form-group">
                    <label class="form-label" for="min_students">Minimal Jumlah Siswa</label>
                    <input type="number" id="min_students" name="min_students" class="form-control" value="{{ old('min_students', $package->min_students) }}" required />
                </div>
            </div>

            <div class="grid-2" style="gap: 1rem;">
                <div class="form-group">
                    <label class="form-label" for="duration">Estimasi Durasi Kegiatan</label>
                    <input type="text" id="duration" name="duration" class="form-control" value="{{ old('duration', $package->duration) }}" required />
                </div>
                <div class="form-group">
                    <label class="form-label" for="is_active">Status Paket</label>
                    <select id="is_active" name="is_active" class="form-control">
                        <option value="1" {{ old('is_active', $package->is_active ? '1' : '0') == '1' ? 'selected' : '' }}>Aktif (Dapat Diajukan)</option>
                        <option value="0" {{ old('is_active', $package->is_active ? '1' : '0') == '0' ? 'selected' : '' }}>Non-aktif</option>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label" for="description">Rincian Fasilitas & Modul</label>
                <textarea id="description" name="description" class="form-control" required>{{ old('description', $package->description) }}</textarea>
            </div>

            <div class="form-group">
                <label class="form-label" for="features">Fasilitas Poin (Satu baris per poin)</label>
                <textarea id="features" name="features" class="form-control">{{ old('features', $package->features) }}</textarea>
            </div>

            <div style="display: flex; gap: 1rem; margin-top: 1.5rem;">
                <button type="submit" class="btn btn-primary">Perbarui Paket</button>
                <a href="{{ route('admin.packages.index') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
