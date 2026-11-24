@extends('layouts.app')

@section('title', 'Paket Kunjungan Sekolah - The Nice Park Rumpin')

@section('content')
<div class="page-header">
    <div>
        <div style="font-size: 0.75rem; color: var(--color-primary); font-weight: 800; text-transform: uppercase; letter-spacing: 0.06em; margin-bottom: 0.35rem;">
            PROGRAM KUNJUNGAN KHUSUS SEKOLAH
        </div>
        <h1 class="page-title">Paket Rombongan Edukasi Sekolah</h1>
        <p class="page-subtitle">Program kunjungan lapangan dan edukasi satwa terpadu khusus institusi pendidikan TK, SD, SMP, &amp; SMA.</p>
    </div>
    <a href="{{ route('school.apply') }}" class="btn btn-primary btn-sm">Ajukan Permohonan Rombongan</a>
</div>

<!-- WORKFLOW KETERANGAN -->
<div style="background-color: var(--bg-card); border: 1px solid var(--border-card); border-left: 4px solid var(--color-primary); padding: 1.5rem; margin-bottom: 2.5rem; border-radius: 6px;">
    <div style="font-size: 0.75rem; font-weight: 800; color: var(--color-primary); margin-bottom: 0.4rem; text-transform: uppercase; letter-spacing: 0.05em;">
        PROSEDUR PENGAJUAN &amp; VERIFIKASI KUOTA ROMBONGAN
    </div>
    <p style="font-size: 0.85rem; color: var(--text-muted); line-height: 1.7;">
        Khusus paket rombongan sekolah, sistem mewajibkan pengelola memverifikasi ketersediaan kuota edukator dan slot tanggal. Tagihan pembayaran melalui Midtrans baru akan aktif setelah permohonan disetujui admin.
    </p>
</div>

<div class="grid-3">
    @forelse($packages as $index => $package)
        <div class="card {{ $index === 1 ? 'highlight' : '' }}" style="display: flex; flex-direction: column; @if($index === 1) border-color: var(--color-primary); background-color: #111724; @endif">
            <div style="font-size: 0.72rem; color: var(--color-primary); font-weight: 800; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 0.5rem;">
                MINIMAL {{ $package->min_students }} SISWA // DURASI: {{ $package->duration }}
            </div>
            <h3 style="font-family: 'Plus Jakarta Sans', sans-serif; font-size: 1.35rem; font-weight: 900; color: #ffffff; text-transform: uppercase; margin-bottom: 0.5rem;">
                {{ $package->name }}
            </h3>
            <p style="color: var(--text-muted); font-size: 0.85rem; line-height: 1.6; margin-bottom: 1.5rem;">
                {{ $package->description }}
            </p>
            
            <div style="margin-bottom: 1.5rem; padding-bottom: 1.25rem; border-bottom: 1px solid var(--border-color);">
                <span style="font-size: 0.82rem; color: var(--text-muted); font-weight: 700;">IDR</span>
                <span style="font-family: 'Plus Jakarta Sans', sans-serif; font-size: 1.95rem; font-weight: 900; color: #ffffff; margin-left: 0.25rem;">
                    {{ number_format($package->price_per_student, 0, ',', '.') }}
                </span>
                <span style="font-size: 0.8rem; color: var(--text-sub); font-weight: 600;">/ siswa</span>
            </div>

            <ul style="list-style: none; margin-bottom: 2rem; font-size: 0.82rem; color: #cbd5e1; flex: 1;">
                @if($package->features)
                    @foreach(explode("\n", $package->features) as $feature)
                        @if(trim($feature))
                            <li style="padding: 0.4rem 0; border-bottom: 1px solid #161c28; line-height: 1.5;">-- {{ trim($feature) }}</li>
                        @endif
                    @endforeach
                @endif
            </ul>

            <a href="{{ route('school.apply', ['package' => $package->id]) }}" class="btn {{ $index === 1 ? 'btn-primary' : 'btn-secondary' }} btn-block">
                Ajukan Paket Ini
            </a>
        </div>
    @empty
        <div style="grid-column: 1 / -1; background-color: var(--bg-card); border: 1px solid var(--border-card); padding: 3rem; text-align: center; border-radius: 6px;">
            <p style="color: var(--text-muted);">Belum ada paket sekolah aktif saat ini.</p>
        </div>
    @endforelse
</div>
@endsection
