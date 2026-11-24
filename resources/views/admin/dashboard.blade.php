@extends('layouts.admin')

@section('title', 'Dashboard Administrator')
@section('page-title', 'Dashboard')

@section('content')
<main class="dash-body">

    <!-- LEFT COLUMN -->
    <div class="dash-col-left">

        <!-- HERO OVERVIEW CARD (Matching Screenshot, Clean, NO White Corner Cards) -->
        <div class="hero-overview-card">
            <div class="hero-overview-header">
                <span class="hero-overview-label">Total Pendapatan Terverifikasi</span>
                <span class="hero-currency-tag">MIDTRANS SANDBOX</span>
            </div>

            <div class="hero-overview-value">
                IDR {{ number_format($totalRevenue, 0, ',', '.') }}
            </div>

            <div class="hero-overview-actions">
                <a href="{{ route('admin.tickets.index') }}" class="dash-btn-primary">
                    <span>+</span> Kelola Tiket Umum
                </a>
                <a href="{{ route('admin.school.index') }}" class="dash-btn-ghost">
                    Review Rombongan Sekolah ({{ $pendingSchoolCount }} Pending)
                </a>
            </div>
        </div>

        <!-- RECENT ORDERS TABLE CARD -->
        <div class="activity-card">
            <div class="activity-header">
                <div class="activity-title">Transaksi Tiket Masuk Terbaru</div>
                <a href="{{ route('admin.orders.index') }}" style="font-size: 0.78rem; color: var(--d-primary); text-decoration: none; font-weight: 600;">Lihat Semua &rarr;</a>
            </div>

            <div style="overflow-x: auto;">
                <table class="dash-table">
                    <thead>
                        <tr>
                            <th>No. Order</th>
                            <th>Nama Pemesan</th>
                            <th>Kategori</th>
                            <th>Status Transaksi</th>
                            <th>Total Biaya</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentOrders as $ro)
                            <tr>
                                <td style="font-family: 'JetBrains Mono', monospace; font-size: 0.78rem; color: #a5a5b5;">
                                    <a href="{{ route('admin.orders.show', $ro->id) }}" style="color: #ffffff; text-decoration: none;">
                                        {{ $ro->order_number }}
                                    </a>
                                </td>
                                <td style="font-weight: 600; color: #ffffff;">
                                    {{ $ro->customer_name }}
                                </td>
                                <td>
                                    @if($ro->isGeneral())
                                        <span style="font-size: 0.78rem; color: #38bdf8;">Tiket Umum</span>
                                    @else
                                        <span style="font-size: 0.78rem; color: #c084fc;">Sekolah: {{ $ro->school_name }}</span>
                                    @endif
                                </td>
                                <td>
                                    @if($ro->status === 'paid')
                                        <span class="status-badge paid">&bull; Lunas</span>
                                    @elseif($ro->status === 'unpaid')
                                        <span class="status-badge unpaid">&bull; Menunggu Bayar</span>
                                    @elseif($ro->status === 'approved')
                                        <span class="status-badge paid" style="background: rgba(56, 189, 248, 0.12); color: #38bdf8; border-color: rgba(56, 189, 248, 0.3);">&bull; Disetujui</span>
                                    @elseif($ro->status === 'pending_approval')
                                        <span class="status-badge pending">&bull; Review Admin</span>
                                    @else
                                        <span class="status-badge rejected">&bull; Ditolak</span>
                                    @endif
                                </td>
                                <td style="font-family: 'Wix Madefor Display', sans-serif; font-weight: 700; color: #ffffff;">
                                    IDR {{ number_format($ro->total_price, 0, ',', '.') }}
                                </td>
                                <td>
                                    <a href="{{ route('admin.orders.show', $ro->id) }}" class="dash-btn-ghost" style="padding: 0.35rem 0.85rem; font-size: 0.75rem;">
                                        Detail
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" style="text-align: center; padding: 2rem 1rem; color: var(--d-muted);">
                                    Belum ada transaksi pesanan masuk.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- UPCOMING / ANTREAN SEKOLAH STRIP -->
        <div class="upcoming-strip">
            <div class="upcoming-item">
                <span class="upcoming-label">Pengajuan Sekolah Pending</span>
                <div class="upcoming-val" style="color: {{ $pendingSchoolCount > 0 ? '#fbbf24' : '#34d399' }};">
                    {{ $pendingSchoolCount }} Permohonan
                </div>
            </div>

            <div class="upcoming-item">
                <span class="upcoming-label">Total Pesanan Masuk</span>
                <div class="upcoming-val">
                    {{ $totalOrders }} Transaksi
                </div>
            </div>

            <div class="upcoming-item">
                <span class="upcoming-label">Tiket Terbit (Lunas)</span>
                <div class="upcoming-val" style="color: #34d399;">
                    {{ $paidOrdersCount }} E-Ticket
                </div>
            </div>

            <div class="upcoming-item" style="justify-content: center;">
                <a href="{{ route('admin.school.index') }}" class="dash-btn-primary" style="padding: 0.5rem 1.15rem; font-size: 0.78rem;">
                    Buka Antrean &rarr;
                </a>
            </div>
        </div>

    </div>

    <!-- RIGHT COLUMN (3 WIDGETS) -->
    <div class="dash-col-right">

        <!-- WIDGET 1: Pesanan Lunas & Progress Bar -->
        <div class="dash-widget">
            <div class="dash-widget-title">E-Ticket Lunas Terbit</div>
            <div class="dash-widget-val">{{ $paidOrdersCount }} Pesanan</div>
            <div style="font-size: 0.75rem; color: var(--d-muted); margin-bottom: 0.5rem;">
                Rasio pelunasan: {{ $totalOrders > 0 ? round(($paidOrdersCount / $totalOrders) * 100) : 0 }}% dari total pesanan
            </div>

            <!-- Segmented Progress Bar in Wix Red/Orange -->
            @php
                $ratio = $totalOrders > 0 ? min(10, max(0, round(($paidOrdersCount / $totalOrders) * 10))) : 0;
            @endphp
            <div class="dash-segments-bar">
                @for($i = 0; $i < 10; $i++)
                    <div class="dash-segment {{ $i < $ratio ? 'fill' : '' }}"></div>
                @endfor
            </div>
        </div>

        <!-- WIDGET 2: Total Volume & Equalizer Bars -->
        <div class="dash-widget">
            <div class="dash-widget-title">Volume Transaksi Masuk</div>
            <div class="dash-widget-val">{{ $totalOrders }} Pesanan</div>
            <div style="font-size: 0.75rem; color: var(--d-muted);">
                Tiket masuk umum dan reservasi paket kunjungan edukasi sekolah.
            </div>

            <!-- Mini Chart Bars -->
            <div class="dash-chart-bars">
                <div class="dash-bar" style="height: 35%;"></div>
                <div class="dash-bar" style="height: 60%;"></div>
                <div class="dash-bar" style="height: 45%;"></div>
                <div class="dash-bar" style="height: 85%;"></div>
                <div class="dash-bar" style="height: 50%;"></div>
                <div class="dash-bar" style="height: 95%;"></div>
                <div class="dash-bar" style="height: 100%;"></div>
                <div class="dash-bar" style="height: 70%;"></div>
                <div class="dash-bar" style="height: 85%;"></div>
                <div class="dash-bar" style="height: 90%;"></div>
            </div>
        </div>

        <!-- WIDGET 3: Pusat Kendali Pengelola & Integrasi Midtrans -->
        <div class="dash-info-card">
            <div class="dash-info-badge">
                <span>✦</span> PUSAT PENGELOLA
            </div>
            <div class="dash-info-title">
                Verifikasi Gateway &amp; Tiket
            </div>
            <div class="dash-info-text">
                Semua transaksi terintegrasi langsung dengan Midtrans Payment Gateway. Tiket hanya berstatus lunas setelah callback webhook terverifikasi valid di server.
            </div>
            <a href="{{ route('admin.orders.index') }}" class="dash-btn-primary" style="width: 100%; box-sizing: border-box; justify-content: center; font-size: 0.8rem; padding: 0.65rem 1rem;">
                Kelola Semua Pesanan &rarr;
            </a>
        </div>

    </div>

</main>
@endsection
