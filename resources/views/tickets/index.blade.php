@extends('layouts.app')

@section('title', 'Katalog Tiket Wisata - The Nice Park Rumpin')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Tiket Kunjungan Wisata</h1>
        <p class="page-subtitle">Silakan pilih kategori tiket masuk wisata The Nice Park Rumpin.</p>
    </div>
</div>

<div class="grid-3">
    @forelse($tickets as $index => $ticket)
        <div class="card {{ $index === 1 ? 'highlight' : '' }}" @if($index === 1) style="border-color: var(--color-primary); background-color: #141c2e;" @endif>
            <div style="font-size: 0.75rem; color: var(--color-primary); font-weight: 700; text-transform: uppercase; margin-bottom: 0.5rem;">
                @if($ticket->min_age && $ticket->max_age)
                    Usia {{ $ticket->min_age }} - {{ $ticket->max_age }} Tahun
                @elseif($ticket->min_age)
                    Usia {{ $ticket->min_age }}+ Tahun
                @else
                    Kategori Umum
                @endif
            </div>
            <h3 style="font-size: 1.25rem; color: #ffffff; margin-bottom: 0.5rem;">{{ $ticket->name }}</h3>
            <p style="color: var(--text-muted); font-size: 0.85rem; margin-bottom: 1.5rem;">{{ $ticket->description }}</p>
            
            <div style="margin-bottom: 1.5rem; padding-bottom: 1rem; border-bottom: 1px solid var(--border-color);">
                <span style="font-size: 0.85rem; color: var(--text-muted);">IDR</span>
                <span style="font-family: 'Plus Jakarta Sans', sans-serif; font-size: 1.75rem; font-weight: 800; color: #ffffff; margin-left: 0.25rem;">
                    {{ number_format($ticket->price, 0, ',', '.') }}
                </span>
                <span style="font-size: 0.8rem; color: var(--text-sub);">/ orang</span>
            </div>

            <ul style="list-style: none; margin-bottom: 2rem; font-size: 0.85rem; color: var(--text-muted);">
                @if($ticket->features)
                    @foreach(explode("\n", $ticket->features) as $feature)
                        @if(trim($feature))
                            <li style="padding: 0.35rem 0; border-bottom: 1px dashed var(--border-color);">- {{ trim($feature) }}</li>
                        @endif
                    @endforeach
                @endif
            </ul>

            <a href="{{ route('tickets.show', $ticket->id) }}" class="btn {{ $index === 1 ? 'btn-primary' : 'btn-secondary' }} btn-block">Pesan Tiket</a>
        </div>
    @empty
        <p style="color: var(--text-muted);">Belum ada tiket aktif saat ini.</p>
    @endforelse
</div>
@endsection
