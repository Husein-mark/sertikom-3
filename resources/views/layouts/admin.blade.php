<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>@yield('title', 'Admin Portal') - The Nice Park Rumpin</title>
    <!-- Wix Official Design Typography -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Wix+Madefor+Display:wght@600;700;800;900&family=Wix+Madefor+Text:wght@400;500;600;700&family=JetBrains+Mono:wght@500;700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('css/app.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/dashboard-pro.css') }}" />
    @stack('styles')
</head>
<body class="dashboard-pro-body">

<div class="dash-layout">

    <!-- 1. COMPACT ICON SIDEBAR -->
    <aside class="dash-sidebar">
        <!-- Brand Glyph -->
        <a href="{{ route('admin.dashboard') }}" class="dash-brand-icon" title="The Nice Park Admin">
            P
        </a>

        <!-- Main Nav Icons -->
        <nav class="dash-nav">
            <a href="{{ route('admin.dashboard') }}" class="dash-nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" title="Dashboard Admin">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="3" y="3" width="7" height="7"></rect>
                    <rect x="14" y="3" width="7" height="7"></rect>
                    <rect x="14" y="14" width="7" height="7"></rect>
                    <rect x="3" y="14" width="7" height="7"></rect>
                </svg>
            </a>

            <a href="{{ route('admin.tickets.index') }}" class="dash-nav-item {{ request()->routeIs('admin.tickets*') ? 'active' : '' }}" title="Kelola Tiket Umum">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M2 9a3 3 0 0 1 0 6v2a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-2a3 3 0 0 1 0-6V7a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2z"></path>
                    <path d="M13 5v2"></path>
                    <path d="M13 17v2"></path>
                    <path d="M13 11v2"></path>
                </svg>
            </a>

            <a href="{{ route('admin.packages.index') }}" class="dash-nav-item {{ request()->routeIs('admin.packages*') ? 'active' : '' }}" title="Kelola Paket Sekolah">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M22 10v6M2 10l10-5 10 5-10 5z"></path>
                    <path d="M6 12v5c3 3 9 3 12 0v-5"></path>
                </svg>
            </a>

            <a href="{{ route('admin.orders.index') }}" class="dash-nav-item {{ request()->routeIs('admin.orders*') ? 'active' : '' }}" title="Semua Pesanan Masuk">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                    <polyline points="14 2 14 8 20 8"></polyline>
                    <line x1="16" y1="13" x2="8" y2="13"></line>
                    <line x1="16" y1="17" x2="8" y2="17"></line>
                    <polyline points="10 9 9 9 8 9"></polyline>
                </svg>
            </a>

            <a href="{{ route('admin.school.index') }}" class="dash-nav-item {{ request()->routeIs('admin.school*') ? 'active' : '' }}" title="Pengajuan Sekolah">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                    <circle cx="9" cy="7" r="4"></circle>
                    <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                    <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                </svg>
            </a>

            <a href="{{ url('/') }}" class="dash-nav-item" target="_blank" title="Buka Website">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path>
                    <polyline points="15 3 21 3 21 9"></polyline>
                    <line x1="10" y1="14" x2="21" y2="3"></line>
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

    <!-- 2. MAIN CONTENT WRAPPER -->
    <div class="dash-main">

        <!-- TOPBAR -->
        <header class="dash-topbar">
            <!-- Breadcrumbs Left -->
            <div class="dash-breadcrumbs">
                <span class="crumb-muted">Portal Administrator</span>
                <span class="crumb-sep">/</span>
                <span class="crumb-active">@yield('page-title', 'Dashboard')</span>
            </div>

            <!-- Quick Navigation Center -->
            <div class="dash-filter-pills">
                <a href="{{ route('admin.dashboard') }}" class="dash-pill {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    Ringkasan
                </a>
                <a href="{{ route('admin.orders.index') }}" class="dash-pill {{ request()->routeIs('admin.orders*') ? 'active' : '' }}">
                    Transaksi
                </a>
                <a href="{{ route('admin.school.index') }}" class="dash-pill {{ request()->routeIs('admin.school*') ? 'active' : '' }}">
                    Rombongan Sekolah
                </a>
                <a href="{{ route('admin.tickets.index') }}" class="dash-pill {{ request()->routeIs('admin.tickets*') ? 'active' : '' }}">
                    Katalog Tiket
                </a>
            </div>

            <!-- User Menu Right -->
            <div class="dash-user-menu">
                <div class="dash-avatar" style="background: linear-gradient(135deg, #ff3b20 0%, #751206 100%);">
                    ADM
                </div>
                <div class="dash-user-name">
                    {{ Auth::user()->name ?? 'Administrator' }}
                </div>
            </div>
        </header>

        <!-- FLASH MESSAGES -->
        @if(session('success'))
            <div style="margin: 1.5rem 2rem 0 2rem; background: rgba(16, 185, 129, 0.12); border: 1px solid rgba(16, 185, 129, 0.3); color: #34d399; padding: 0.85rem 1.25rem; border-radius: 12px; font-size: 0.85rem;">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div style="margin: 1.5rem 2rem 0 2rem; background: rgba(239, 68, 68, 0.12); border: 1px solid rgba(239, 68, 68, 0.3); color: #f87171; padding: 0.85rem 1.25rem; border-radius: 12px; font-size: 0.85rem;">
                {{ session('error') }}
            </div>
        @endif

        <!-- PAGE CONTENT -->
        @yield('content')
    </div>

</div>

@stack('scripts')
</body>
</html>
