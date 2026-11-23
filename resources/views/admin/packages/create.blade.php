@extends('layouts.admin')

@section('title', 'Tambah Paket Sekolah')
@section('page-title', 'Tambah Paket Kunjungan')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Tambah Paket Sekolah Baru</h1>
        <p class="page-subtitle">Formulir pembuatan program edukasi untuk rombongan sekolah.</p>
    </div>
    <a href="{{ route('admin.packages.index') }}" class="btn btn-secondary btn-sm">Batal & Kembali</a>
</div>

<div style="max-width: 680px;">
    <div class="card">
        <form action="{{ route('admin.packages.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label class="form-label" for="name">Nama Paket Edukasi</label>
                <input type="text" id="name" name="name" class="form-control" placeholder="Contoh: Paket Konservasi Lingkungan" value="{{ old('name') }}" required />
            </div>

            <div class="grid-2" style="gap: 1rem;">
                <div class="form-group">
                    <label class="form-label" for="price_per_student">Tarif per Siswa (IDR)</label>
                    <input type="number" id="price_per_student" name="price_per_student" class="form-control" placeholder="75000" value="{{ old('price_per_student') }}" required />
                </div>
                <div class="form-group">
                    <label class="form-label" for="min_students">Minimal Jumlah Siswa</label>
                    <input type="number" id="min_students" name="min_students" class="form-control" placeholder="20" value="{{ old('min_students', 20) }}" required />
                </div>
            </div>

            <div class="grid-2" style="gap: 1rem;">
                <div class="form-group">
                    <label class="form-label" for="duration">Estimasi Durasi Kegiatan</label>
                    <input type="text" id="duration" name="duration" class="form-control" placeholder="Misal: 4 Jam / Full Day" value="{{ old('duration', '4 Jam') }}" required />
                </div>
                <div class="form-group">
                    <label class="form-label" for="is_active">Status Paket</label>
                    <select id="is_active" name="is_active" class="form-control">
                        <option value="1" {{ old('is_active', '1') == '1' ? 'selected' : '' }}>Aktif (Dapat Diajukan)</option>
                        <option value="0" {{ old('is_active') == '0' ? 'selected' : '' }}>Non-aktif</option>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label" for="description">Rincian Fasilitas & Modul</label>
                <textarea id="description" name="description" class="form-control" placeholder="Fasilitator pendamping, modul konservasi, konsumsi..." required>{{ old('description') }}</textarea>
            </div>

            <div class="form-group">
                <label class="form-label" for="features">Fasilitas Poin (Satu baris per poin)</label>
                <textarea id="features" name="features" class="form-control" placeholder="Pemandu Tur Bersertifikat&#10;Makan Siang & Air Mineral&#10;Sertifikat Kunjungan">{{ old('features') }}</textarea>
            </div>

            <div style="display: flex; gap: 1rem; margin-top: 1.5rem;">
                <button type="submit" class="btn btn-primary">Simpan Paket</button>
                <a href="{{ route('admin.packages.index') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
