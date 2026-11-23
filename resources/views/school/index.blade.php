@extends('layouts.app')

@section('title', 'Paket Kunjungan Sekolah - The Nice Park Rumpin')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Paket Rombongan Sekolah</h1>
        <p class="page-subtitle">Program edukasi lingkungan dan satwa khusus institusi pendidikan TK, SD, SMP, & SMA.</p>
    </div>
    <a href="{{ route('school.apply') }}" class="btn btn-primary btn-sm">Ajukan Permohonan</a>
</div>

<!-- Workflow Keterangan -->
<div style="background-color: var(--bg-card); border: 1px solid var(--border-color); padding: 1.5rem; margin-bottom: 2.5rem; border-radius: 6px;">
    <div style="font-family: 'Plus Jakarta Sans', sans-serif; font-size: 0.85rem; font-weight: 700; color: var(--color-primary); margin-bottom: 0.5rem; text-transform: uppercase;">
        Aturan & Mekanisme Pengajuan
    </div>
    <p style="font-size: 0.85rem; color: var(--text-muted); line-height: 1.7;">
        Khusus paket sekolah, sistem mewajibkan pengelola melakukan verifikasi ketersediaan kuota edukator dan slot tanggal. Tagihan pembayaran melalui Midtrans baru akan aktif setelah permohonan disetujui admin.
    </p>
</div>

<div class="grid-3">
    @forelse($packages as $index => $package)
        <div class="card {{ $index === 1 ? 'highlight' : '' }}" @if($index === 1) style="border-color: var(--color-primary); background-color: #141c2e;" @endif>
            <div style="font-size: 0.75rem; color: var(--color-primary); font-weight: 700; text-transform: uppercase; margin-bottom: 0.5rem;">
                Minimal {{ $package->min_students }} Siswa (Durasi: {{ $package->duration }})
            </div>
            <h3 style="font-size: 1.25rem; color: #ffffff; margin-bottom: 0.5rem;">{{ $package->name }}</h3>
            <p style="color: var(--text-muted); font-size: 0.85rem; margin-bottom: 1.5rem;">{{ $package->description }}</p>
            
            <div style="margin-bottom: 1.5rem; padding-bottom: 1rem; border-bottom: 1px solid var(--border-color);">
                <span style="font-size: 0.85rem; color: var(--text-muted);">IDR</span>
                <span style="font-family: 'Plus Jakarta Sans', sans-serif; font-size: 1.75rem; font-weight: 800; color: #ffffff; margin-left: 0.25rem;">
                    {{ number_format($package->price_per_student, 0, ',', '.') }}
                </span>
                <span style="font-size: 0.8rem; color: var(--text-sub);">/ siswa</span>
            </div>

            <ul style="list-style: none; margin-bottom: 2rem; font-size: 0.85rem; color: var(--text-muted);">
                @if($package->features)
                    @foreach(explode("\n", $package->features) as $feature)
                        @if(trim($feature))
                            <li style="padding: 0.35rem 0; border-bottom: 1px dashed var(--border-color);">- {{ trim($feature) }}</li>
                        @endif
                    @endforeach
                @endif
            </ul>

            <a href="{{ route('school.apply', ['package' => $package->id]) }}" class="btn {{ $index === 1 ? 'btn-primary' : 'btn-secondary' }} btn-block">Ajukan Paket Ini</a>
        </div>
    @empty
        <p style="color: var(--text-muted);">Belum ada paket sekolah aktif saat ini.</p>
    @endforelse
</div>
@endsection
