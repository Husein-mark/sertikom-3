
@extends('layouts.app')

@section('title', 'Form Pengajuan Kunjungan Sekolah - The Nice Park Rumpin')

@section('content')

<style>
    /* STEPPER */
    .school-progress {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        width: 100%;
        padding: 12px 20px;
        margin-bottom: 30px;
        background: #0d0d10;
        border: 1px solid #24242b;
        border-radius: 7px;
        box-sizing: border-box;
    }

    .school-progress .progress-step {
        display: flex;
        align-items: center;
        gap: 8px;
        flex-shrink: 0;
        color: #a1a1aa;
        font-size: 12px;
        font-weight: 700;
        white-space: nowrap;
        text-transform: none;
        letter-spacing: 0;
    }

    .school-progress .step-circle {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 28px;
        height: 28px;
        flex-shrink: 0;
        border-radius: 50%;
        background: #1b1b20;
        color: #a1a1aa;
        font-size: 12px;
        font-weight: 700;
    }

    .school-progress .progress-step.active {
        color: #ff3b20;
    }

    .school-progress .progress-step.active .step-circle {
        background: #ff3b20;
        color: #ffffff;
    }

    .school-progress .progress-line {
        flex: 1;
        min-width: 20px;
        height: 1px;
        background: #222228;
    }

    /* LAYOUT HALAMAN */
    .school-apply-layout {
        display: flex;
        flex-direction: column;
        gap: 22px;
        width: 100%;
    }

    /* INFORMASI PAKET */
    .school-info-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 18px;
        width: 100%;
    }

    .school-info-grid .card {
        height: 100%;
        margin: 0;
    }

    .school-summary-row {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 15px;
        padding: 10px 0;
        border-bottom: 1px solid var(--border-color);
        font-size: 0.84rem;
        color: var(--text-muted);
    }

    .school-summary-row strong {
        color: #ffffff;
        text-align: right;
    }

    .school-total-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 15px;
        padding-top: 14px;
        margin-top: 5px;
        font-size: 0.95rem;
        color: #ffffff;
        font-weight: 800;
    }

    .school-total-row strong {
        color: var(--color-primary);
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 1.1rem;
        text-align: right;
    }

    .school-process-list {
        padding-left: 1.2rem;
        margin: 0;
        font-size: 0.82rem;
        color: var(--text-muted);
        line-height: 1.8;
    }

    .school-process-list li {
        padding-left: 3px;
        margin-bottom: 7px;
    }

    /* FORM 2 KOLOM */
    .school-form-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 17px 22px;
    }

    .school-form-grid .form-group {
        min-width: 0;
        margin-bottom: 0;
    }

    .school-form-grid .full-width {
        grid-column: 1 / -1;
    }

    .school-form-card {
        border: 1px solid var(--border-card);
        background-color: #0d0d10;
    }

    .school-form-card .card-header {
        margin-bottom: 1.25rem;
    }

    /* RESPONSIVE */
    @media (max-width: 750px) {
        .school-progress {
            justify-content: flex-start;
            overflow-x: auto;
        }

        .school-progress .progress-line {
            min-width: 25px;
        }

        .school-info-grid {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 600px) {
        .school-form-grid {
            grid-template-columns: 1fr;
        }

        .school-form-grid .full-width {
            grid-column: auto;
        }
    }
</style>

<!-- PROGRESS STEPPER -->
<div class="school-progress">

    <div class="progress-step">
        <span class="step-circle">1</span>
        <span>Pilih Paket</span>
    </div>

    <div class="progress-line"></div>

    <div class="progress-step active">
        <span class="step-circle">2</span>
        <span>Data Rombongan</span>
    </div>

    <div class="progress-line"></div>

    <div class="progress-step">
        <span class="step-circle">3</span>
        <span>Verifikasi Admin</span>
    </div>

    <div class="progress-line"></div>

    <div class="progress-step">
        <span class="step-circle">4</span>
        <span>Pembayaran & E-Ticket</span>
    </div>

</div>

<!-- HEADER -->
<div class="page-header" style="margin-bottom: 1.75rem;">
    <div>
        <div style="font-size: 0.75rem; color: var(--color-primary); text-transform: uppercase; margin-bottom: 0.35rem;">
            Paket Sekolah / Permohonan Reservasi
        </div>

        <h1 class="page-title">Pengajuan Kunjungan Sekolah</h1>

        <p class="page-subtitle">
            Lengkapi identitas sekolah dan rencana kegiatan untuk ditinjau oleh tim pengelola.
        </p>
    </div>

    <a href="{{ route('school.index') }}" class="btn btn-secondary btn-sm">
        Kembali ke Pilihan Paket
    </a>
</div>

<div class="school-apply-layout">

    <!-- INFORMASI PAKET DAN SIMULASI BIAYA -->
    <div class="school-info-grid">

        <!-- SIMULASI BIAYA -->
        <div class="card" style="border-top: 3px solid var(--color-primary);">

            <div class="card-header">
                <div>
                    <div style="font-size: 0.72rem; color: var(--color-primary); font-weight: 800; text-transform: uppercase; letter-spacing: 0.04em;">
                        INFORMASI PAKET ROMBONGAN
                    </div>

                    <div class="card-title" style="margin-top: 0.2rem;">
                        Simulasi Estimasi Biaya
                    </div>
                </div>
            </div>

            <div style="font-size: 0.85rem; line-height: 1.8;">

                <div class="school-summary-row">
                    <span>Paket Terpilih:</span>

                    <strong id="summary-package">
                        {{ $selectedPackage->name ?? '-' }}
                    </strong>
                </div>

                <div class="school-summary-row">
                    <span>Tarif per Peserta:</span>

                    <strong id="summary-rate">
                        IDR {{ number_format($selectedPackage->price_per_student ?? 0, 0, ',', '.') }}
                    </strong>
                </div>

                <div class="school-summary-row">
                    <span>Minimum Peserta:</span>

                    <strong id="summary-minimum">
                        {{ $selectedPackage->min_students ?? 25 }} Siswa
                    </strong>
                </div>

                <div class="school-summary-row">
                    <span>Jumlah Siswa:</span>

                    <strong id="summary-count">
                        {{ $selectedPackage->min_students ?? 25 }} Siswa
                    </strong>
                </div>

                <div class="school-total-row">
                    <span>Estimasi Total:</span>

                    <strong id="summary-total">
                        IDR {{ number_format(($selectedPackage->price_per_student ?? 0) * ($selectedPackage->min_students ?? 25), 0, ',', '.') }}
                    </strong>
                </div>

            </div>

            <div style="font-size: 0.74rem; color: var(--text-muted); margin-top: 1rem; line-height: 1.6;">
                * Biaya di atas merupakan estimasi awal dan dapat mengikuti hasil verifikasi pengelola.
            </div>

        </div>

        <!-- TAHAPAN PENGAJUAN -->
        <div class="card">

            <div class="card-header">
                <div>
                    <div style="font-size: 0.72rem; color: var(--color-primary); font-weight: 800; text-transform: uppercase; letter-spacing: 0.04em;">
                        ALUR RESERVASI
                    </div>

                    <div class="card-title" style="margin-top: 0.2rem;">
                        Tahapan Setelah Pengajuan
                    </div>
                </div>
            </div>

            <ol class="school-process-list">
                <li>
                    Pengajuan masuk ke antrean verifikasi administrator The Nice Park Rumpin.
                </li>

                <li>
                    Admin memeriksa kesesuaian tanggal dan kuota fasilitator.
                </li>

                <li>
                    Status disetujui atau ditolak diperbarui pada dashboard akun pemesan dalam waktu maksimal 1x24 jam kerja.
                </li>

                <li>
                    Setelah status <strong>Disetujui</strong>, tombol pelunasan Midtrans akan aktif pada menu Riwayat Pesanan.
                </li>

                <li>
                    E-ticket rombongan resmi diterbitkan setelah transaksi tuntas.
                </li>
            </ol>

        </div>

    </div>

    <!-- FORM PENGAJUAN -->
    <div class="card school-form-card">

        <div class="card-header">
            <div>
                <div style="font-size: 0.72rem; color: var(--color-primary); font-weight: 800; text-transform: uppercase; letter-spacing: 0.04em;">
                    DATA PENGUNJUNG
                </div>

                <div class="card-title" style="margin-top: 0.2rem;">
                    Data Lembaga & Kunjungan
                </div>
            </div>
        </div>

        <form action="{{ route('school.storeApply') }}" method="POST">
            @csrf

            <div class="school-form-grid">

                <!-- NAMA SEKOLAH -->
                <div class="form-group full-width">
                    <label class="form-label" for="school_name">
                        Nama Sekolah / Lembaga Pendidikan
                    </label>

                    <input
                        type="text"
                        id="school_name"
                        name="school_name"
                        class="form-control"
                        placeholder="Contoh: SMA Negeri 1 Bogor"
                        value="{{ old('school_name') }}"
                        required
                    />
                </div>

                <!-- ALAMAT SEKOLAH -->
                <div class="form-group full-width">
                    <label class="form-label" for="school_address">
                        Alamat Lengkap Sekolah
                    </label>

                    <textarea
                        id="school_address"
                        name="school_address"
                        class="form-control"
                        placeholder="Jalan, kelurahan, kecamatan, kota/kabupaten"
                        required
                    >{{ old('school_address') }}</textarea>
                </div>

                <!-- NAMA PIC -->
                <div class="form-group">
                    <label class="form-label" for="pic_name">
                        Nama Penanggung Jawab / PIC
                    </label>

                    <input
                        type="text"
                        id="pic_name"
                        name="pic_name"
                        class="form-control"
                        placeholder="Nama Guru / Pembimbing"
                        value="{{ old('pic_name', Auth::user()->name ?? '') }}"
                        required
                    />
                </div>

                <!-- JABATAN PIC -->
                <div class="form-group">
                    <label class="form-label" for="pic_position">
                        Jabatan PIC
                    </label>

                    <input
                        type="text"
                        id="pic_position"
                        name="pic_position"
                        class="form-control"
                        placeholder="Contoh: Wakasek Kesiswaan"
                        value="{{ old('pic_position') }}"
                        required
                    />
                </div>

                <!-- NOMOR TELEPON -->
                <div class="form-group">
                    <label class="form-label" for="pic_phone">
                        No. WhatsApp PIC
                    </label>

                    <input
                        type="tel"
                        id="pic_phone"
                        name="pic_phone"
                        class="form-control"
                        placeholder="08xxxxxxxxxx"
                        value="{{ old('pic_phone', Auth::user()->phone ?? '') }}"
                        required
                    />
                </div>

                <!-- EMAIL -->
                <div class="form-group">
                    <label class="form-label" for="pic_email">
                        Email Resmi Sekolah
                    </label>

                    <input
                        type="email"
                        id="pic_email"
                        name="pic_email"
                        class="form-control"
                        placeholder="sekolah@email.com"
                        value="{{ old('pic_email', Auth::user()->email ?? '') }}"
                        required
                    />
                </div>

                <!-- PILIHAN PAKET -->
                <div class="form-group full-width">
                    <label class="form-label" for="package_id">
                        Pilihan Paket Kunjungan
                    </label>

                    <select
                        id="package_id"
                        name="package_id"
                        class="form-control"
                        required
                        onchange="updatePackagePrice()"
                    >
                        @foreach($packages as $pkg)
                            <option
                                value="{{ $pkg->id }}"
                                data-price="{{ $pkg->price_per_student }}"
                                data-min="{{ $pkg->min_students }}"
                                data-name="{{ $pkg->name }}"
                                {{ ($selectedPackage && $selectedPackage->id == $pkg->id) ? 'selected' : '' }}
                            >
                                {{ $pkg->name }}
                                (IDR {{ number_format($pkg->price_per_student, 0, ',', '.') }} / siswa - Min. {{ $pkg->min_students }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- TANGGAL KUNJUNGAN -->
                <div class="form-group">
                    <label class="form-label" for="visit_date">
                        Tanggal Kunjungan Rencana
                    </label>

                    <input
                        type="date"
                        id="visit_date"
                        name="visit_date"
                        class="form-control"
                        value="{{ old('visit_date', date('Y-m-d', strtotime('+3 days'))) }}"
                        min="{{ date('Y-m-d', strtotime('+1 day')) }}"
                        required
                    />
                </div>

                <!-- JUMLAH SISWA -->
                <div class="form-group">
                    <label class="form-label" for="student_count">
                        Estimasi Jumlah Peserta Siswa
                    </label>

                    <input
                        type="number"
                        id="student_count"
                        name="student_count"
                        class="form-control"
                        min="1"
                        value="{{ old('student_count', $selectedPackage->min_students ?? 25) }}"
                        required
                        oninput="updatePackagePrice()"
                    />
                </div>

                <!-- CATATAN -->
                <div class="form-group full-width">
                    <label class="form-label" for="notes">
                        Catatan / Kebutuhan Khusus (Opsional)
                    </label>

                    <textarea
                        id="notes"
                        name="notes"
                        class="form-control"
                        placeholder="Misal: Kebutuhan konsumsi khusus, permintaan materi edukasi tertentu"
                    >{{ old('notes') }}</textarea>
                </div>

                <!-- PERSETUJUAN -->
                <div class="form-group full-width" style="display: flex; align-items: flex-start; gap: 0.5rem; margin-bottom: 0.5rem;">
                    <input
                        type="checkbox"
                        id="terms"
                        required
                        style="margin-top: 0.3rem; accent-color: var(--color-primary);"
                    />

                    <label for="terms" style="font-size: 0.8rem; color: var(--text-muted); cursor: pointer;">
                        Saya menyatakan data yang diisi adalah benar atas nama perwakilan sekolah dan memahami bahwa pembayaran baru dapat dilakukan setelah permohonan disetujui pengelola.
                    </label>
                </div>

            </div>

            <!-- TOMBOL SUBMIT -->
            <button type="submit" class="btn btn-primary btn-block btn-lg" style="margin-top: 1rem;">
                Kirim Formulir Pengajuan
            </button>

        </form>

    </div>

</div>

@endsection

@push('scripts')
<script>
    function updatePackagePrice() {
        const select = document.getElementById('package_id');
        const selectedOption = select.options[select.selectedIndex];

        const price = parseInt(selectedOption.getAttribute('data-price')) || 0;
        const minimum = parseInt(selectedOption.getAttribute('data-min')) || 1;
        const name = selectedOption.getAttribute('data-name') || '';

        const count = parseInt(document.getElementById('student_count').value) || 0;
        const total = price * count;

        document.getElementById('summary-package').innerText = name;

        document.getElementById('summary-rate').innerText =
            'IDR ' + new Intl.NumberFormat('id-ID').format(price);

        document.getElementById('summary-minimum').innerText =
            minimum + ' Siswa';

        document.getElementById('summary-count').innerText =
            count + ' Siswa';

        document.getElementById('summary-total').innerText =
            'IDR ' + new Intl.NumberFormat('id-ID').format(total);
    }

    document.addEventListener('DOMContentLoaded', function () {
        updatePackagePrice();
    });
</script>
@endpush
