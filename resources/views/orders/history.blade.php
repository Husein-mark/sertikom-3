<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Dashboard Pengguna - The Nice Park Rumpin</title>
    <!-- Wix Official Design Typography -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Wix+Madefor+Display:wght@600;700;800;900&family=Wix+Madefor+Text:wght@400;500;600;700&family=JetBrains+Mono:wght@500;700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('css/dashboard-pro.css') }}" />
</head>
<body class="dashboard-pro-body">

<div class="dash-layout">

    <!-- 1. COMPACT ICON SIDEBAR -->
    <aside class="dash-sidebar">
        <!-- Brand Glyph -->
        <a href="{{ url('/') }}" class="dash-brand-icon" title="The Nice Park Rumpin">
            P
        </a>

        <!-- Main Nav Icons -->
        <nav class="dash-nav">
            <a href="{{ route('orders.history') }}" class="dash-nav-item active" title="Dashboard">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="3" y="3" width="7" height="7"></rect>
                    <rect x="14" y="3" width="7" height="7"></rect>
                    <rect x="14" y="14" width="7" height="7"></rect>
                    <rect x="3" y="14" width="7" height="7"></rect>
                </svg>
            </a>

            <a href="{{ route('tickets.index') }}" class="dash-nav-item" title="Katalog Tiket Wisata">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M2 9a3 3 0 0 1 0 6v2a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-2a3 3 0 0 1 0-6V7a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2z"></path>
                    <path d="M13 5v2"></path>
                    <path d="M13 17v2"></path>
                    <path d="M13 11v2"></path>
                </svg>
            </a>

            <a href="{{ route('school.index') }}" class="dash-nav-item" title="Paket Sekolah & Rombongan">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M22 10v6M2 10l10-5 10 5-10 5z"></path>
                    <path d="M6 12v5c3 3 9 3 12 0v-5"></path>
                </svg>
            </a>

            <a href="{{ url('/') }}" class="dash-nav-item" title="Halaman Utama Website">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                    <polyline points="9 22 9 12 15 12 15 22"></polyline>
                </svg>
            </a>
        </nav>

        <!-- Sidebar Bottom (Logout) -->
        <div class="dash-sidebar-bottom">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="dash-nav-item" style="background: none; border: none; cursor: pointer;" title="Keluar Sesi">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                        <polyline points="16 17 21 12 16 7"></polyline>
                        <line x1="21" y1="12" x2="9" y2="12"></line>
                    </svg>
                </button>
            </form>
        </div>
    </aside>

    <!-- 2. MAIN CONTENT AREA -->
    <div class="dash-main">

        <!-- TOPBAR -->
        <header class="dash-topbar">
            <!-- Breadcrumbs Left -->
            <div class="dash-breadcrumbs">
                <span class="crumb-muted">Akun Pengguna</span>
                <span class="crumb-sep">/</span>
                <span class="crumb-active">Dashboard</span>
            </div>

            <!-- Filter Pills Center -->
            @php
                $totalOrders = $orders->count();
                $paidOrders = $orders->where('status', 'paid')->count();
                $unpaidOrders = $orders->whereIn('status', ['unpaid', 'approved'])->count();
                $pendingOrders = $orders->where('status', 'pending_approval')->count();
                $totalPaidAmount = $orders->where('status', 'paid')->sum('total_price');
            @endphp
            <div class="dash-filter-pills">
                <a href="{{ route('orders.history') }}" class="dash-pill {{ empty($status) ? 'active' : '' }}">
                    Semua ({{ $totalOrders }})
                </a>
                <a href="{{ route('orders.history', ['status' => 'unpaid']) }}" class="dash-pill {{ $status === 'unpaid' ? 'active' : '' }}">
                    Siap Bayar ({{ $unpaidOrders }})
                </a>
                <a href="{{ route('orders.history', ['status' => 'pending_approval']) }}" class="dash-pill {{ $status === 'pending_approval' ? 'active' : '' }}">
                    Menunggu Review ({{ $pendingOrders }})
                </a>
                <a href="{{ route('orders.history', ['status' => 'paid']) }}" class="dash-pill {{ $status === 'paid' ? 'active' : '' }}">
                    Lunas ({{ $paidOrders }})
                </a>
            </div>

            <!-- User Menu Right -->
            <div class="dash-user-menu">
                <div class="dash-avatar">
                    {{ strtoupper(substr(Auth::user()->name ?? 'A', 0, 1)) }}
                </div>
                <div class="dash-user-name">
                    {{ Auth::user()->name ?? 'Alwi' }}
                </div>
            </div>
        </header>

        <!-- FLASH NOTIFICATIONS -->
        @if(session('success'))
            <div style="margin: 1.5rem 2rem 0 2rem; background: rgba(16, 185, 129, 0.12); border: 1px solid rgba(16, 185, 129, 0.3); color: #34d399; padding: 0.85rem 1.25rem; border-radius: 12px; font-size: 0.85rem;">
                {{ session('success') }}
            </div>
        @endif

        <!-- DASHBOARD BODY (2 COLUMNS: LEFT 68% / RIGHT 32%) -->
        <main class="dash-body">

            <!-- LEFT COLUMN -->
            <div class="dash-col-left">

                <!-- HERO OVERVIEW CARD (Matching Screenshot Layout, Clean, NO White Corner Cards) -->
                <div class="hero-overview-card">
                    <div class="hero-overview-header">
                        <span class="hero-overview-label">Total Pembayaran Lunas</span>
                        <span class="hero-currency-tag">IDR &bull; RESMI</span>
                    </div>

                    <div class="hero-overview-value">
                        IDR {{ number_format($totalPaidAmount, 0, ',', '.') }}
                    </div>

                    <div class="hero-overview-actions">
                        <a href="{{ route('tickets.index') }}" class="dash-btn-primary">
                            <span>+</span> Pesan Tiket Baru
                        </a>
                        <a href="{{ route('school.apply') }}" class="dash-btn-ghost">
                            Ajukan Rombongan Sekolah
                        </a>
                    </div>
                </div>

                <!-- RECENT ACTIVITY TABLE CARD -->
                <div class="activity-card">
                    <div class="activity-header">
                        <div class="activity-title">Riwayat Reservasi &amp; Tiket</div>
                        <span style="font-size: 0.75rem; color: var(--d-muted);">Total: {{ $orders->count() }} Data</span>
                    </div>

                    <div style="overflow-x: auto;">
                        <table class="dash-table">
                            <thead>
                                <tr>
                                    <th>No. Order</th>
                                    <th>Tgl Kunjungan</th>
                                    <th>Kategori &amp; Nama</th>
                                    <th>Status</th>
                                    <th>Total Biaya</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($orders as $order)
                                    <tr>
                                        <td style="font-family: 'JetBrains Mono', monospace; font-size: 0.78rem; color: #a5a5b5;">
                                            {{ $order->order_number }}
                                        </td>
                                        <td style="color: #cbd5e1; font-size: 0.82rem;">
                                            {{ \Carbon\Carbon::parse($order->visit_date)->isoFormat('D MMM Y') }}
                                        </td>
                                        <td>
                                            @if($order->isGeneral())
                                                <div style="font-weight: 600; color: #ffffff;">{{ $order->ticket->name ?? 'Tiket Masuk' }}</div>
                                                <div style="font-size: 0.72rem; color: var(--d-muted);">{{ $order->quantity }} Pengunjung Umum</div>
                                            @else
                                                <div style="font-weight: 600; color: #ffffff;">{{ $order->school_name }}</div>
                                                <div style="font-size: 0.72rem; color: var(--d-muted);">{{ $order->package->name ?? 'Paket Sekolah' }} ({{ $order->quantity }} Siswa)</div>
                                            @endif
                                        </td>
                                        <td>
                                            @if($order->status === 'paid')
                                                <span class="status-badge paid">&bull; Lunas</span>
                                            @elseif(in_array($order->status, ['unpaid', 'approved']))
                                                <span class="status-badge unpaid">&bull; Siap Bayar</span>
                                            @elseif($order->status === 'pending_approval')
                                                <span class="status-badge pending">&bull; Review Admin</span>
                                            @elseif($order->status === 'rejected')
                                                <span class="status-badge rejected">&bull; Ditolak</span>
                                            @else
                                                <span class="status-badge" style="background: rgba(255,255,255,0.08); color: #fff;">{{ ucfirst($order->status) }}</span>
                                            @endif
                                        </td>
                                        <td style="font-family: 'Wix Madefor Display', sans-serif; font-weight: 700; color: #ffffff;">
                                            IDR {{ number_format($order->total_price, 0, ',', '.') }}
                                        </td>
                                        <td>
                                            @if($order->status === 'paid')
                                                <a href="{{ route('orders.eticket', $order->id) }}" class="dash-btn-primary" style="padding: 0.4rem 0.95rem; font-size: 0.75rem;">
                                                    Buka E-Ticket
                                                </a>
                                            @elseif(in_array($order->status, ['unpaid', 'approved']))
                                                <a href="{{ route('orders.checkout', $order->id) }}" class="dash-btn-primary" style="padding: 0.4rem 0.95rem; font-size: 0.75rem;">
                                                    Bayar Midtrans
                                                </a>
                                            @elseif($order->status === 'pending_approval')
                                                <span style="font-size: 0.72rem; color: var(--d-sub);">Menunggu Kuota</span>
                                            @else
                                                <span style="font-size: 0.72rem; color: var(--d-muted);">-</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" style="text-align: center; padding: 3rem 1rem; color: var(--d-muted);">
                                            <div style="font-weight: 700; color: #ffffff; margin-bottom: 0.35rem;">Belum Ada Riwayat Pesanan</div>
                                            <div style="font-size: 0.8rem; margin-bottom: 1rem;">Mulai jelajahi tiket wisata alam terbuka dan edukasi The Nice Park Rumpin.</div>
                                            <a href="{{ route('tickets.index') }}" class="dash-btn-primary" style="padding: 0.5rem 1.25rem;">Pesan Tiket Sekarang</a>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- UPCOMING VISIT STRIP (Bottom Left) -->
                @php
                    $nextVisit = $orders->where('visit_date', '>=', now()->toDateString())->sortBy('visit_date')->first();
                @endphp
                <div class="upcoming-strip">
                    <div class="upcoming-item">
                        <span class="upcoming-label">Jadwal Kunjungan Terdekat</span>
                        <div class="upcoming-val">
                            @if($nextVisit)
                                {{ \Carbon\Carbon::parse($nextVisit->visit_date)->isoFormat('dddd, D MMMM Y') }}
                            @else
                                Belum Ada Jadwal Aktif
                            @endif
                        </div>
                    </div>

                    <div class="upcoming-item">
                        <span class="upcoming-label">Jumlah Tiket / Peserta</span>
                        <div class="upcoming-val">
                            {{ $nextVisit ? $nextVisit->quantity . ' Orang' : '-' }}
                        </div>
                    </div>

                    <div class="upcoming-item">
                        <span class="upcoming-label">Status Validasi</span>
                        <div class="upcoming-val" style="color: {{ $nextVisit && $nextVisit->status === 'paid' ? '#34d399' : '#fbbf24' }};">
                            {{ $nextVisit ? ($nextVisit->status === 'paid' ? 'Siap Scan di Gerbang' : 'Perlu Pelunasan') : 'Tersedia' }}
                        </div>
                    </div>
                </div>

            </div>

            <!-- RIGHT COLUMN (3 WIDGETS) -->
            <div class="dash-col-right">

                <!-- WIDGET 1: E-Ticket Siap Pakai & Progress Bar -->
                <div class="dash-widget">
                    <div class="dash-widget-title">E-Ticket QR Siap Pakai</div>
                    <div class="dash-widget-val">{{ $paidOrders }} Tiket</div>
                    <div style="font-size: 0.75rem; color: var(--d-muted); margin-bottom: 0.5rem;">
                        Tingkat penyelesaian: {{ $totalOrders > 0 ? round(($paidOrders / $totalOrders) * 100) : 0 }}% selesai
                    </div>

                    <!-- 10-Segment Progress Bar in Red/Orange Accent -->
                    @php
                        $fillCount = $totalOrders > 0 ? min(10, max(0, round(($paidOrders / $totalOrders) * 10))) : 0;
                    @endphp
                    <div class="dash-segments-bar">
                        @for($i = 0; $i < 10; $i++)
                            <div class="dash-segment {{ $i < $fillCount ? 'fill' : '' }}"></div>
                        @endfor
                    </div>
                </div>

                <!-- WIDGET 2: Total Reservasi & Mini Bar Chart -->
                <div class="dash-widget">
                    <div class="dash-widget-title">Aktivitas Transaksi</div>
                    <div class="dash-widget-val">{{ $totalOrders }} Pesanan</div>
                    <div style="font-size: 0.75rem; color: var(--d-muted);">
                        Termasuk pemesanan tiket perorangan dan rombongan sekolah.
                    </div>

                    <!-- Mini Visual Chart Bars -->
                    <div class="dash-chart-bars">
                        <div class="dash-bar" style="height: 30%;"></div>
                        <div class="dash-bar" style="height: 55%;"></div>
                        <div class="dash-bar" style="height: 40%;"></div>
                        <div class="dash-bar" style="height: 75%;"></div>
                        <div class="dash-bar" style="height: 60%;"></div>
                        <div class="dash-bar" style="height: 90%;"></div>
                        <div class="dash-bar" style="height: 100%;"></div>
                        <div class="dash-bar" style="height: 65%;"></div>
                        <div class="dash-bar" style="height: 80%;"></div>
                        <div class="dash-bar" style="height: 95%;"></div>
                    </div>
                </div>

                <!-- WIDGET 3: Panduan Check-in E-Ticket QR -->
                <div class="dash-info-card">
                    <div class="dash-info-badge">
                        <span>✦</span> PANDUAN RESMI
                    </div>
                    <div class="dash-info-title">
                        Check-in Gerbang Otomatis
                    </div>
                    <div class="dash-info-text">
                        Tunjukkan kode QR e-ticket yang telah lunas langsung dari layar HP Anda kepada petugas gerbang masuk The Nice Park Rumpin tanpa perlu antre di loket.
                    </div>
                    <a href="{{ route('tickets.index') }}" class="dash-btn-primary" style="width: 100%; box-sizing: border-box; justify-content: center; font-size: 0.8rem; padding: 0.65rem 1rem;">
                        Pesan Tiket Tambahan &rarr;
                    </a>
                </div>

            </div>

        </main>
    </div>

</div>

</body>
</html>
