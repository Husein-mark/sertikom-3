@extends('layouts.app')

@section('title', 'Form Pengajuan Kunjungan Sekolah - The Nice Park Rumpin')

@section('content')
<div class="page-header">
    <div>
        <div style="font-size: 0.75rem; color: var(--color-primary); text-transform: uppercase; margin-bottom: 0.35rem;">Paket Sekolah / Permohonan Reservasi</div>
        <h1 class="page-title">Pengajuan Kunjungan Sekolah</h1>
        <p class="page-subtitle">Lengkapi identitas sekolah dan rencana kegiatan untuk ditinjau oleh tim pengelola.</p>
    </div>
    <a href="{{ route('school.index') }}" class="btn btn-secondary btn-sm">Kembali ke Pilihan Paket</a>
</div>

<div class="grid-2">
    <!-- Form Pengajuan -->
    <div>
        <div class="card">
            <div class="card-header">
                <div class="card-title">Data Lembaga & Kunjungan</div>
            </div>

            <form action="{{ route('school.storeApply') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label class="form-label" for="school_name">Nama Sekolah / Lembaga Pendidikan</label>
                    <input type="text" id="school_name" name="school_name" class="form-control" placeholder="Contoh: SMA Negeri 1 Bogor" value="{{ old('school_name') }}" required />
                </div>

                <div class="form-group">
                    <label class="form-label" for="school_address">Alamat Lengkap Sekolah</label>
                    <textarea id="school_address" name="school_address" class="form-control" placeholder="Jalan, kelurahan, kecamatan, kota/kabupaten" required>{{ old('school_address') }}</textarea>
                </div>

                <div class="grid-2" style="gap: 1rem;">
                    <div class="form-group">
                        <label class="form-label" for="pic_name">Nama Penanggung Jawab / PIC</label>
                        <input type="text" id="pic_name" name="pic_name" class="form-control" placeholder="Nama Guru / Pembimbing" value="{{ old('pic_name', Auth::user()->name ?? '') }}" required />
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="pic_position">Jabatan PIC</label>
                        <input type="text" id="pic_position" name="pic_position" class="form-control" placeholder="Contoh: Wakasek Kesiswaan" value="{{ old('pic_position') }}" required />
                    </div>
                </div>

                <div class="grid-2" style="gap: 1rem;">
                    <div class="form-group">
                        <label class="form-label" for="pic_phone">No. WhatsApp PIC</label>
                        <input type="tel" id="pic_phone" name="pic_phone" class="form-control" placeholder="08xxxxxxxxxx" value="{{ old('pic_phone', Auth::user()->phone ?? '') }}" required />
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="pic_email">Email Resmi Sekolah</label>
                        <input type="email" id="pic_email" name="pic_email" class="form-control" placeholder="sekolah@email.com" value="{{ old('pic_email', Auth::user()->email ?? '') }}" required />
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label" for="package_id">Pilihan Paket Kunjungan</label>
                    <select id="package_id" name="package_id" class="form-control" required onchange="updatePackagePrice()">
                        @foreach($packages as $pkg)
                            <option value="{{ $pkg->id }}" data-price="{{ $pkg->price_per_student }}" data-min="{{ $pkg->min_students }}" data-name="{{ $pkg->name }}" {{ ($selectedPackage && $selectedPackage->id == $pkg->id) ? 'selected' : '' }}>
                                {{ $pkg->name }} (IDR {{ number_format($pkg->price_per_student, 0, ',', '.') }} / siswa - Min. {{ $pkg->min_students }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="grid-2" style="gap: 1rem;">
                    <div class="form-group">
                        <label class="form-label" for="visit_date">Tanggal Kunjungan Rencana</label>
                        <input type="date" id="visit_date" name="visit_date" class="form-control" value="{{ old('visit_date', date('Y-m-d', strtotime('+3 days'))) }}" min="{{ date('Y-m-d', strtotime('+1 day')) }}" required />
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="student_count">Estimasi Jumlah Peserta Siswa</label>
                        <input type="number" id="student_count" name="student_count" class="form-control" min="1" value="{{ old('student_count', $selectedPackage->min_students ?? 25) }}" required oninput="updatePackagePrice()" />
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label" for="notes">Catatan / Kebutuhan Khusus (Opsional)</label>
                    <textarea id="notes" name="notes" class="form-control" placeholder="Misal: Kebutuhan konsumsi khusus, permintaan materi edukasi tertentu">{{ old('notes') }}</textarea>
                </div>

                <div class="form-group" style="display: flex; align-items: flex-start; gap: 0.5rem; margin-bottom: 1.5rem;">
                    <input type="checkbox" id="terms" required style="margin-top: 0.3rem; accent-color: var(--color-primary);" />
                    <label for="terms" style="font-size: 0.8rem; color: var(--text-muted); cursor: pointer;">
                        Saya menyatakan data yang diisi adalah benar atas nama perwakilan sekolah dan memahami bahwa pembayaran baru dapat dilakukan setelah permohonan disetujui pengelola.
                    </label>
                </div>

                <button type="submit" class="btn btn-primary btn-block btn-lg">Kirim Formulir Pengajuan</button>
            </form>
        </div>
    </div>

    <!-- Informasi Alur & Simulasi Biaya -->
    <div>
        <div class="card" style="margin-bottom: 1.5rem;">
            <div class="card-header">
                <div class="card-title">Simulasi Estimasi Biaya</div>
            </div>
            <div style="font-size: 0.85rem; color: var(--text-muted); line-height: 1.8;">
                <div style="display: flex; justify-content: space-between; margin-bottom: 0.5rem;">
                    <span>Paket Terpilih:</span>
                    <strong id="summary-package" style="color: #ffffff;">{{ $selectedPackage->name ?? '-' }}</strong>
                </div>
                <div style="display: flex; justify-content: space-between; margin-bottom: 0.5rem;">
                    <span>Tarif per Peserta:</span>
                    <strong id="summary-rate" style="color: #ffffff;">IDR {{ number_format($selectedPackage->price_per_student ?? 0, 0, ',', '.') }}</strong>
                </div>
                <div style="display: flex; justify-content: space-between; margin-bottom: 0.5rem;">
                    <span>Jumlah Siswa:</span>
                    <strong id="summary-count" style="color: #ffffff;">{{ $selectedPackage->min_students ?? 25 }} Siswa</strong>
                </div>
                <div style="display: flex; justify-content: space-between; padding-top: 0.75rem; border-top: 1px solid var(--border-color); font-size: 1rem; color: #ffffff;">
                    <span>Estimasi Total:</span>
                    <strong id="summary-total" style="color: var(--color-primary); font-family: 'Plus Jakarta Sans', sans-serif;">
                        IDR {{ number_format(($selectedPackage->price_per_student ?? 0) * ($selectedPackage->min_students ?? 25), 0, ',', '.') }}
                    </strong>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <div class="card-title">Tahapan Setelah Pengajuan</div>
            </div>
            <ol style="padding-left: 1.25rem; font-size: 0.85rem; color: var(--text-muted); line-height: 1.8;">
                <li style="margin-bottom: 0.5rem;">Pengajuan masuk ke antrean verifikasi administrator The Nice Park Rumpin.</li>
                <li style="margin-bottom: 0.5rem;">Admin memeriksa kesesuaian tanggal dan kuota fasilitator.</li>
                <li style="margin-bottom: 0.5rem;">Status disetujui / ditolak diperbarui pada dashboard akun pemesan dalam waktu maksimal 1x24 jam kerja.</li>
                <li style="margin-bottom: 0.5rem;">Setelah status <strong>Disetujui</strong>, tombol pelunasan Midtrans akan aktif pada menu Riwayat Pesanan.</li>
                <li>E-ticket rombongan resmi diterbitkan setelah transaksi tuntas.</li>
            </ol>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function updatePackagePrice() {
        const select = document.getElementById('package_id');
        const selectedOption = select.options[select.selectedIndex];
        const price = parseInt(selectedOption.getAttribute('data-price')) || 0;
        const name = selectedOption.getAttribute('data-name') || '';
        const count = parseInt(document.getElementById('student_count').value) || 0;
        const total = price * count;

        document.getElementById('summary-package').innerText = name;
        document.getElementById('summary-rate').innerText = 'IDR ' + new Intl.NumberFormat('id-ID').format(price);
        document.getElementById('summary-count').innerText = count + ' Siswa';
        document.getElementById('summary-total').innerText = 'IDR ' + new Intl.NumberFormat('id-ID').format(total);
    }
</script>
@endpush
