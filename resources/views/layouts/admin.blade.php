<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>@yield('title', 'Admin Portal') - The Nice Park Rumpin</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}" />
    @stack('styles')
</head>
<body class="admin-body">

    <!-- SIDEBAR -->
    <aside class="admin-sidebar">
        <div class="sidebar-brand">
            NICEPARK <span>ADMIN</span>
        </div>
        <nav class="sidebar-nav">
            <div class="nav-section-label">Ringkasan</div>
            <a href="{{ route('admin.dashboard') }}" class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">Dashboard</a>

            <div class="nav-section-label">Katalog Wisata</div>
            <a href="{{ route('admin.tickets.index') }}" class="nav-item {{ request()->routeIs('admin.tickets*') ? 'active' : '' }}">Kelola Tiket Umum</a>
            <a href="{{ route('admin.packages.index') }}" class="nav-item {{ request()->routeIs('admin.packages*') ? 'active' : '' }}">Kelola Paket Sekolah</a>

            <div class="nav-section-label">Transaksi & Verifikasi</div>
            <a href="{{ route('admin.orders.index') }}" class="nav-item {{ request()->routeIs('admin.orders*') ? 'active' : '' }}">Semua Pesanan</a>
            <a href="{{ route('admin.school.index') }}" class="nav-item {{ request()->routeIs('admin.school*') ? 'active' : '' }}">Pengajuan Sekolah</a>

            <div class="nav-section-label">Akses Keluar</div>
            <a href="{{ url('/') }}" class="nav-item" target="_blank">Lihat Website</a>
            <a href="#" class="nav-item" onclick="event.preventDefault(); document.getElementById('admin-logout-form').submit();">Keluar Sesi</a>
            <form id="admin-logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </nav>
        <div class="sidebar-footer">
            <div style="font-size: 0.75rem; color: var(--admin-sub);">Nice Park Admin v1.0</div>
        </div>
    </aside>

    <!-- MAIN WRAPPER -->
    <div class="admin-main">
        <!-- TOPBAR -->
        <header class="admin-topbar">
            <div class="topbar-title font-tech">@yield('page-title', 'Dashboard')</div>
            <div class="topbar-right">
                <div class="topbar-user">
                    Petugas: <strong>{{ Auth::user()->name ?? 'Administrator' }}</strong>
                </div>
            </div>
        </header>

        <!-- CONTENT -->
        <main class="admin-content">
            @if(session('success'))
                <div style="background-color: #064e3b; border: 1px solid #059669; color: #a7f3d0; padding: 0.85rem 1.25rem; border-radius: 4px; margin-bottom: 1.5rem; font-size: 0.9rem;">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div style="background-color: #450a0a; border: 1px solid #dc2626; color: #fca5a5; padding: 0.85rem 1.25rem; border-radius: 4px; margin-bottom: 1.5rem; font-size: 0.9rem;">
                    {{ session('error') }}
                </div>
            @endif

            @if($errors->any())
                <div style="background-color: #450a0a; border: 1px solid #dc2626; color: #fca5a5; padding: 0.85rem 1.25rem; border-radius: 4px; margin-bottom: 1.5rem; font-size: 0.85rem;">
                    <strong style="display: block; margin-bottom: 0.35rem;">Terjadi kesalahan pada data yang diisi:</strong>
                    <ul style="padding-left: 1.25rem;">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @yield('content')
        </main>
    </div>

    @stack('scripts')
</body>
</html>
