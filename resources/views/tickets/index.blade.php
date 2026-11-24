@extends('layouts.app')

@section('title', 'Katalog Tiket Wisata - The Nice Park Rumpin')

@section('content')
<div class="page-header">
    <div>
        <div style="font-size: 0.75rem; color: var(--color-primary); font-weight: 800; text-transform: uppercase; letter-spacing: 0.06em; margin-bottom: 0.35rem;">
            KATALOG TIKET MASUK RESMI
        </div>
        <h1 class="page-title">Pilihan Tiket Kunjungan Wisata</h1>
        <p class="page-subtitle">Pilih tier tiket pengunjung untuk mendapatkan akses langsung ke wahana alam, edukasi satwa, dan rekreasi.</p>
    </div>
</div>

<div class="grid-3">
    @forelse($tickets as $index => $ticket)
        <div class="card {{ $index === 1 ? 'highlight' : '' }}" style="display: flex; flex-direction: column; @if($index === 1) border-color: var(--color-primary); background-color: #111724; @endif">
            <div style="font-family: 'JetBrains Mono', monospace; font-size: 0.72rem; color: var(--color-primary); font-weight: 800; text-transform: uppercase; letter-spacing: 0.06em; margin-bottom: 0.5rem;">
                @if($ticket->min_age && $ticket->max_age)
                    [ USIA {{ $ticket->min_age }} - {{ $ticket->max_age }} TAHUN ]
                @elseif($ticket->min_age)
                    [ USIA {{ $ticket->min_age }}+ TAHUN ]
                @else
                    [ KATEGORI UMUM ]
                @endif
            </div>
            <h3 style="font-family: 'Plus Jakarta Sans', sans-serif; font-size: 1.35rem; font-weight: 900; color: #ffffff; text-transform: uppercase; margin-bottom: 0.5rem;">
                {{ $ticket->name }}
            </h3>
            <p style="color: var(--text-muted); font-size: 0.85rem; line-height: 1.6; margin-bottom: 1.5rem;">
                {{ $ticket->description }}
            </p>
            
            <div style="margin-bottom: 1.5rem; padding-bottom: 1.25rem; border-bottom: 1px solid var(--border-color);">
                <span style="font-size: 0.82rem; color: var(--text-muted); font-weight: 700;">IDR</span>
                <span style="font-family: 'Plus Jakarta Sans', sans-serif; font-size: 1.95rem; font-weight: 900; color: #ffffff; margin-left: 0.25rem;">
                    {{ number_format($ticket->price, 0, ',', '.') }}
                </span>
                <span style="font-size: 0.8rem; color: var(--text-sub); font-weight: 600;">/ orang</span>
            </div>

            <ul style="list-style: none; margin-bottom: 2rem; font-size: 0.82rem; color: #cbd5e1; flex: 1;">
                @if($ticket->features)
                    @foreach(explode("\n", $ticket->features) as $feature)
                        @if(trim($feature))
                            <li style="padding: 0.4rem 0; border-bottom: 1px solid #161c28; line-height: 1.5;">-- {{ trim($feature) }}</li>
                        @endif
                    @endforeach
                @endif
            </ul>

            <a href="{{ route('tickets.show', $ticket->id) }}" class="btn {{ $index === 1 ? 'btn-primary' : 'btn-secondary' }} btn-block">
                Pesan Tiket Ini
            </a>
        </div>
    @empty
        <div style="grid-column: 1 / -1; background-color: var(--bg-card); border: 1px solid var(--border-card); padding: 3rem; text-align: center; border-radius: 6px;">
            <p style="color: var(--text-muted);">Belum ada tiket aktif saat ini.</p>
        </div>
    @endforelse
</div>
@endsection
