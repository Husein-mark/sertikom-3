<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>@yield('title', 'The Nice Park Rumpin')</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}" />
    @stack('styles')
</head>
<body>

    <!-- NAVBAR -->
    <nav class="navbar">
        <div class="container nav-container">
            <a href="{{ url('/') }}" class="brand-logo">NICEPARK <span>RUMPIN</span></a>
            <ul class="nav-menu">
                <li><a href="{{ url('/') }}" class="{{ request()->is('/') ? 'active' : '' }}">Beranda</a></li>
                <li><a href="{{ route('tickets.index') }}" class="{{ request()->is('tickets*') ? 'active' : '' }}">Tiket Wisata</a></li>
                <li><a href="{{ route('school.index') }}" class="{{ request()->is('school*') ? 'active' : '' }}">Paket Sekolah</a></li>
                <li><a href="{{ route('orders.history') }}" class="{{ request()->is('orders*') ? 'active' : '' }}">Pesanan Saya</a></li>
            </ul>
            <div class="nav-actions">
                @auth
                    @if(Auth::user()->isAdmin())
                        <a href="{{ route('admin.dashboard') }}" class="btn btn-outline btn-sm">Portal Admin</a>
                    @else
                        <span style="font-size: 0.85rem; color: var(--text-muted); margin-right: 0.5rem;">Halo, <strong>{{ Auth::user()->name }}</strong></span>
                    @endif
                    <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                        @csrf
                        <button type="submit" class="btn btn-secondary btn-sm">Keluar</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="btn btn-secondary btn-sm">Masuk</a>
                    <a href="{{ route('register') }}" class="btn btn-primary btn-sm">Daftar</a>
                @endauth
            </div>
        </div>
    </nav>

    <!-- CONTENT -->
    <main class="page-wrapper">
        <div class="container">
            <!-- FLASH MESSAGES -->
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
        </div>
    </main>

    <!-- FOOTER -->
    <footer class="footer">
        <div class="container">
            <div class="footer-grid">
                <div class="footer-brand">
                    <h4>THE NICE PARK RUMPIN</h4>
                    <p>Sistem reservasi tiket wisata mandiri dan verifikasi permohonan kunjungan rombongan edukasi sekolah.</p>
                </div>
                <div class="footer-col">
                    <h5>Navigasi</h5>
                    <ul>
                        <li><a href="{{ url('/') }}">Beranda</a></li>
                        <li><a href="{{ route('tickets.index') }}">Katalog Tiket</a></li>
                        <li><a href="{{ route('school.index') }}">Paket Sekolah</a></li>
                        <li><a href="{{ route('orders.history') }}">Riwayat Pesanan</a></li>
                    </ul>
                </div>
                <div class="footer-col">
                    <h5>Layanan</h5>
                    <ul>
                        @guest
                            <li><a href="{{ route('login') }}">Login Pengguna</a></li>
                            <li><a href="{{ route('register') }}">Registrasi Akun</a></li>
                        @else
                            <li><a href="{{ route('orders.history') }}">Pesanan Saya</a></li>
                        @endguest
                        <li><a href="{{ route('admin.dashboard') }}">Portal Pengelola</a></li>
                    </ul>
                </div>
            </div>
            <div class="footer-bottom">
                <div>Hak Cipta 2026 The Nice Park Rumpin.</div>
                <div>Metode Pembayaran: Midtrans Gateway</div>
            </div>
        </div>
    </footer>

    @stack('scripts')
</body>
</html>
