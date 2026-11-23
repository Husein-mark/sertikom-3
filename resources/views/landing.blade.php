<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>The Nice Park Rumpin - Official Event & Tourism Ticketing</title>
    <link rel="stylesheet" href="{{ asset('css/landing.css') }}" />
</head>
<body>

    <!-- NAVBAR -->
    <nav class="navbar">
        <div class="container nav-container">
            <a href="{{ url('/') }}" class="brand-logo">NICEPARK <span>RUMPIN</span></a>
            <ul class="nav-links">
                <li><a href="{{ url('/') }}">Beranda</a></li>
                <li><a href="{{ route('tickets.index') }}">Tiket Wisata</a></li>
                <li><a href="{{ route('school.index') }}">Paket Sekolah</a></li>
                <li><a href="{{ route('orders.history') }}">Pesanan Saya</a></li>
            </ul>
            <div class="nav-actions">
                @auth
                    @if(Auth::user()->isAdmin())
                        <a href="{{ route('admin.dashboard') }}" class="btn btn-primary btn-sm">Portal Admin</a>
                    @else
                        <a href="{{ route('orders.history') }}" class="btn btn-secondary btn-sm">{{ Auth::user()->name }}</a>
                    @endif
                    <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                        @csrf
                        <button type="submit" class="btn btn-secondary btn-sm">Keluar</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="btn btn-secondary btn-sm">Masuk</a>
                    <a href="{{ route('register') }}" class="btn btn-primary btn-sm">Daftar Akun</a>
                @endauth
            </div>
        </div>
    </nav>

    <!-- HERO (TICKET FAIRY ESPORTS STYLE) -->
    <section class="hero">
        <div class="container">
            <div class="hero-tag">Official Ticketing Operating System</div>
            <h1 class="hero-title">
                Sistem Reservasi Wisata &<br />
                Edukasi <span>The Nice Park</span> Rumpin
            </h1>
            <p class="hero-desc">
                Infrastruktur pemesanan tiket digital modern dengan verifikasi gerbang instan, alur persetujuan rombongan sekolah terpadu, dan transaksi aman melalui Midtrans.
            </p>
            <div class="hero-actions">
                <a href="{{ route('tickets.index') }}" class="btn btn-primary btn-lg">Pesan Tiket Sekarang</a>
                <a href="{{ route('school.index') }}" class="btn btn-secondary btn-lg">Ajukan Paket Sekolah</a>
            </div>

            <!-- METRICS BAR (TICKET FAIRY HIGHLIGHTS) -->
            <div class="hero-stats">
                <div class="stat-box">
                    <div class="stat-val">100<span>%</span></div>
                    <div class="stat-lbl">Digital E-Ticket</div>
                </div>
                <div class="stat-box">
                    <div class="stat-val">MIDTRANS</div>
                    <div class="stat-lbl">Single Payment Gateway</div>
                </div>
                <div class="stat-box">
                    <div class="stat-val">&lt; 1<span>s</span></div>
                    <div class="stat-lbl">Validasi QR di Gerbang</div>
                </div>
                <div class="stat-box">
                    <div class="stat-val">24<span>/7</span></div>
                    <div class="stat-lbl">Reservasi Mandiri</div>
                </div>
            </div>
        </div>
    </section>

    <!-- TIKET UMUM (PASS TIERS) -->
    <section class="section" id="tickets">
        <div class="container">
            <div class="section-head">
                <div class="section-tag">Tier Akses Pengunjung</div>
                <h2 class="section-title">Pilihan Tiket Masuk</h2>
                <p class="section-subtitle">Akses langsung ke seluruh wahana dan arena alam. E-ticket diterbitkan otomatis setelah pembayaran lunas.</p>
            </div>

            <div class="cards-grid">
                @forelse($tickets as $index => $ticket)
                    <div class="item-card {{ $index === 1 ? 'highlight' : '' }}">
                        <div class="card-tag">
                            @if($ticket->min_age && $ticket->max_age)
                                Usia {{ $ticket->min_age }} - {{ $ticket->max_age }} Tahun
                            @elseif($ticket->min_age)
                                Usia {{ $ticket->min_age }}+ Tahun
                            @else
                                Kategori Umum
                            @endif
                        </div>
                        <div class="card-name">{{ $ticket->name }}</div>
                        <p class="card-summary">{{ $ticket->description }}</p>
                        <div class="card-price-box">
                            <span class="price-currency">IDR</span>
                            <span class="price-number">{{ number_format($ticket->price, 0, ',', '.') }}</span>
                            <span class="price-unit">/ orang</span>
                        </div>
                        <ul class="card-features-list">
                            @if($ticket->features)
                                @foreach(explode("\n", $ticket->features) as $feature)
                                    @if(trim($feature))
                                        <li>{{ trim($feature) }}</li>
                                    @endif
                                @endforeach
                            @endif
                        </ul>
                        <a href="{{ route('tickets.show', $ticket->id) }}" class="btn {{ $index === 1 ? 'btn-primary' : 'btn-secondary' }} btn-block">Pesan Tiket Ini</a>
                    </div>
                @empty
                    <p style="color: var(--text-muted);">Belum ada tiket aktif saat ini.</p>
                @endforelse
            </div>
        </div>
    </section>

    <!-- PAKET SEKOLAH (GROUP ACCREDITATION FLOW) -->
    <section class="section" id="school">
        <div class="container">
            <div class="section-head">
                <div class="section-tag">Group & Institutional Accreditation</div>
                <h2 class="section-title">Paket Rombongan Sekolah</h2>
                <p class="section-subtitle">Sistem reservasi terakreditasi khusus sekolah. Pengelola meninjau dan menyetujui kuota sebelum pembayaran dibuka.</p>
            </div>

            <!-- Workflow Alur Pengajuan -->
            <div class="steps-row">
                <div class="step-card">
                    <div class="step-num">Step 01</div>
                    <div class="step-title">Pengajuan Data Sekolah</div>
                    <p class="step-text">Pengisian formulir resmi institusi, rencana tanggal kunjungan, dan jumlah peserta siswa.</p>
                </div>
                <div class="step-card">
                    <div class="step-num">Step 02</div>
                    <div class="step-title">Review Tim Pengelola</div>
                    <p class="step-text">Admin pengelola memverifikasi ketersediaan edukator dan menyetujui atau menolak berkas.</p>
                </div>
                <div class="step-card">
                    <div class="step-num">Step 03</div>
                    <div class="step-title">Pelunasan via Midtrans</div>
                    <p class="step-text">Setelah disetujui, tombol tagihan pembayaran Midtrans aktif pada akun pemesan.</p>
                </div>
                <div class="step-card">
                    <div class="step-num">Step 04</div>
                    <div class="step-title">E-Ticket Rombongan Sah</div>
                    <p class="step-text">E-ticket dengan kode validasi resmi diterbitkan dan siap dipindai di pintu gerbang masuk.</p>
                </div>
            </div>

            <div class="cards-grid">
                @forelse($packages as $index => $package)
                    <div class="item-card {{ $index === 1 ? 'highlight' : '' }}">
                        <div class="card-tag">Minimal {{ $package->min_students }} Siswa (Durasi: {{ $package->duration }})</div>
                        <div class="card-name">{{ $package->name }}</div>
                        <p class="card-summary">{{ $package->description }}</p>
                        <div class="card-price-box">
                            <span class="price-currency">IDR</span>
                            <span class="price-number">{{ number_format($package->price_per_student, 0, ',', '.') }}</span>
                            <span class="price-unit">/ siswa</span>
                        </div>
                        <ul class="card-features-list">
                            @if($package->features)
                                @foreach(explode("\n", $package->features) as $feature)
                                    @if(trim($feature))
                                        <li>{{ trim($feature) }}</li>
                                    @endif
                                @endforeach
                            @endif
                        </ul>
                        <a href="{{ route('school.apply', ['package' => $package->id]) }}" class="btn {{ $index === 1 ? 'btn-primary' : 'btn-secondary' }} btn-block">Ajukan Paket Sekolah</a>
                    </div>
                @empty
                    <p style="color: var(--text-muted);">Belum ada paket aktif saat ini.</p>
                @endforelse
            </div>
        </div>
    </section>

    <!-- INFORMASI UMUM -->
    <section class="section" id="info">
        <div class="container">
            <div class="section-head">
                <div class="section-tag">Ketentuan & Operasional</div>
                <h2 class="section-title">Informasi Kunjungan</h2>
            </div>

            <div class="info-row">
                <div class="info-item">
                    <h4>Jam Operasional</h4>
                    <p>Senin - Jumat: 08.00 - 17.00 WIB<br />Sabtu - Minggu: 07.00 - 18.00 WIB</p>
                </div>
                <div class="info-item">
                    <h4>Lokasi Kawasan</h4>
                    <p>Jl. Raya Rumpin, Kecamatan Rumpin, Kabupaten Bogor, Jawa Barat 16730.</p>
                </div>
                <div class="info-item">
                    <h4>Satu Saluran Pembayaran</h4>
                    <p>Seluruh transaksi diselesaikan melalui Midtrans Payment Gateway (QRIS, VA, Kartu).</p>
                </div>
                <div class="info-item">
                    <h4>Validasi Gerbang</h4>
                    <p>E-ticket langsung dipindai oleh petugas gerbang masuk dalam hitungan detik.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- FOOTER -->
    <footer class="footer">
        <div class="container">
            <div class="footer-grid">
                <div class="footer-brand">
                    <h4>THE NICE PARK RUMPIN</h4>
                    <p>Pusat rekreasi alam terbuka, edukasi botani & satwa, dan kegiatan gathering rombongan di Rumpin, Bogor.</p>
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
                    <h5>Administrasi</h5>
                    <ul>
                        <li><a href="{{ route('login') }}">Login Akun</a></li>
                        <li><a href="{{ route('register') }}">Pendaftaran</a></li>
                        <li><a href="{{ route('admin.dashboard') }}">Portal Pengelola</a></li>
                    </ul>
                </div>
            </div>
            <div class="footer-bottom">
                <div>Hak Cipta 2026 The Nice Park Rumpin. Seluruh hak dilindungi undang-undang.</div>
                <div>Payment Gateway: <strong>Midtrans Sandbox</strong></div>
            </div>
        </div>
    </footer>

</body>
</html>
