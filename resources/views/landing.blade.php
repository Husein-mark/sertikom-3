<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>The Nice Park Rumpin</title>
    <!-- Wix Official Design Typography -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Wix+Madefor+Display:wght@500;600;700;800;900&family=Wix+Madefor+Text:wght@400;500;600;700&family=JetBrains+Mono:wght@400;600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('css/landing.css') }}" />
</head>
<body>

    <!-- NAVBAR (SINGLE CLEAN NAVBAR, NO TOP BAR, NO LOGO ICON, LOGIN INTEGRATED) -->
    <nav class="navbar">
        <div class="container nav-container">
            <a href="{{ url('/') }}" class="brand-logo">Nice Park Rumpin</a>

            <ul class="nav-links">
                <li><a href="#tickets">Katalog Tiket</a></li>
                <li><a href="#school">Paket Sekolah</a></li>
                <li><a href="#keunggulan">Fasilitas</a></li>
                <li><a href="#lokasi">Lokasi &amp; Info</a></li>
                @auth
                    @if(Auth::user()->isAdmin())
                        <li><a href="{{ route('admin.dashboard') }}">Portal Admin</a></li>
                    @endif
                    <li><a href="{{ route('orders.history') }}">{{ Auth::user()->name }}</a></li>
                    <li>
                        <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                            @csrf
                            <button type="submit" class="nav-link-btn">Keluar</button>
                        </form>
                    </li>
                @else
                    <li><a href="{{ route('login') }}">Log In</a></li>
                @endauth
            </ul>
        </div>
    </nav>

    <!-- 3. HERO SECTION WITH VIDEO / PHOTO BACKGROUND -->
    <section class="hero-wix">
        <!-- Background Media Container (Photo / Video Background) -->
        <div class="hero-media-wrapper">
            <video id="heroVideo" class="hero-video" autoplay muted loop playsinline poster="https://images.unsplash.com/photo-1507525428034-b723cf961d3e?auto=format&fit=crop&w=1920&q=80">
                <source src="https://assets.mixkit.co/videos/preview/mixkit-forest-stream-in-the-sunlight-529-large.mp4" type="video/mp4" />
            </video>
            <img src="https://images.unsplash.com/photo-1507525428034-b723cf961d3e?auto=format&fit=crop&w=1920&q=80" alt="The Nice Park Rumpin" class="hero-bg-img" id="heroFallbackImg" style="display:none;" />
        </div>

        <!-- Cinematic Gradient Overlay -->
        <div class="hero-overlay"></div>

        <div class="container">
            <div class="hero-content">
                <div class="hero-eyebrow-box" style="color: #b5b5be; font-family: var(--font-text); font-size: 1.05rem; font-weight: 500; text-transform: none; margin-bottom: 0.85rem; letter-spacing: normal;">
                    Portal Resmi The Nice Park Rumpin
                </div>

                <h1 class="hero-title" style="font-size: 3.6rem; font-weight: 800; line-height: 1.1; margin-bottom: 1.5rem; text-transform: none; letter-spacing: -0.03em;">
                    Wisata Alam &amp; Satwa.<br />
                    Nice Park Rumpin, Bogor.
                </h1>

                <p class="hero-desc" style="font-size: 1rem; color: #a5a5af; max-width: 600px; margin-bottom: 2rem;">
                    Pemesanan tiket masuk terverifikasi langsung dengan sistem scan QR e-ticket di pintu gerbang utama. Transaksi aman terlindungi menggunakan Midtrans Payment Gateway.
                </p>

                <div class="hero-actions" style="align-items: center; gap: 1rem;">
                    <a href="#tickets" class="btn btn-pill">Pesan Sekarang</a>
                    <a href="#school" class="btn btn-secondary" style="border-radius: 9999px; padding: 0.85rem 2rem; font-size: 0.95rem; text-transform: none;">Paket Sekolah</a>
                </div>
            </div>
        </div>
    </section>

    <!-- 4. 4-PILLAR FEATURE BAR (Wix wh-1064 Minimalist Grid) -->
    <section class="pillars-bar">
        <div class="container">
            <div class="pillars-grid-4">
                <div class="pillar-col active">
                    <div class="pillar-col-num">FITUR / 01</div>
                    <h4 class="pillar-col-title">E-Ticket QR Instan</h4>
                    <p class="pillar-col-desc">Terbit seketika di layar dan riwayat pesanan setelah pembayaran lunas.</p>
                </div>

                <div class="pillar-col">
                    <div class="pillar-col-num"> FITUR / 02 </div>
                    <h4 class="pillar-col-title">Transaksi Aman Midtrans</h4>
                    <p class="pillar-col-desc">Dukungan QRIS instan, Virtual Account bank nasional, serta kartu kredit.</p>
                </div>

                <div class="pillar-col">
                    <div class="pillar-col-num"> FITUR / 03 </div>
                    <h4 class="pillar-col-title">Bebas Antre Loket</h4>
                    <p class="pillar-col-desc">Pindai kode QR langsung pada gerbang masuk otomatis tanpa penukaran tiket fisik.</p>
                </div>

                <div class="pillar-col">
                    <div class="pillar-col-num"> FITUR / 04 </div>
                    <h4 class="pillar-col-title">Layanan Rombongan</h4>
                    <p class="pillar-col-desc">Fasilitas kuota rombongan sekolah dan pendampingan pemandu edukasi.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- 5. SHOP BY CATEGORY (Wix Category Box Layout) -->
    <section class="section" id="kategori">
        <div class="container">
            <div class="section-head">
                <div>
                    <div class="section-eyebrow">PILIHAN KUNJUNGAN</div>
                    <h2 class="section-title">Kategori Tiket &amp; Paket</h2>
                </div>
                <div class="section-counter">01 / 03</div>
            </div>

            <div class="category-grid">
                <div class="category-card">
                    <div>
                        <div class="category-card-code">KATEGORI 01</div>
                        <h3 class="category-card-title">TIKET WISATA REGULER</h3>
                        <p class="category-card-desc">
                            Untuk kunjungan perorangan, teman, dan keluarga santai. Berlaku di hari kerja maupun akhir pekan dan hari libur.
                        </p>
                    </div>
                    <a href="#tickets" class="category-card-footer">
                        <span>Pilih Tiket Mandiri</span>
                        <span class="category-card-arrow">&rarr;</span>
                    </a>
                </div>

                <div class="category-card">
                    <div>
                        <div class="category-card-code">KATEGORI 02</div>
                        <h3 class="category-card-title">PAKET EDUKASI SEKOLAH</h3>
                        <p class="category-card-desc">
                            Program field trip khusus pelajar dengan edukasi botani, pakan satwa jinak, dan pemandu berpengalaman.
                        </p>
                    </div>
                    <a href="#school" class="category-card-footer">
                        <span>Lihat Paket Sekolah</span>
                        <span class="category-card-arrow">&rarr;</span>
                    </a>
                </div>

                <div class="category-card">
                    <div>
                        <div class="category-card-code">KATEGORI 03</div>
                        <h3 class="category-card-title">GATHERING &amp; OUTBOUND</h3>
                        <p class="category-card-desc">
                            Penyediaan area khusus kegiatan korporasi, komunitas, dan rombongan keluarga besar dengan fasilitas terpadu.
                        </p>
                    </div>
                    <a href="#school" class="category-card-footer">
                        <span>Ajukan Rombongan</span>
                        <span class="category-card-arrow">&rarr;</span>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- 6. THE ONE-STOP SECTION (Wix Standard Pelayanan Grid) -->
    <section class="section" id="keunggulan" style="background-color: var(--bg-darker);">
        <div class="container">
            <div class="section-head">
                <div>
                    <div class="section-eyebrow">STANDAR PELAYANAN</div>
                    <h2 class="section-title">Kenyamanan Kunjungan Terpadu di Rumpin</h2>
                </div>
                <div class="section-counter">STANDAR RESMI</div>
            </div>

            <div class="standards-grid">
                <div class="standard-card">
                    <div class="standard-num">01</div>
                    <h4 class="standard-title">Check-in Cepat &amp; Praktis</h4>
                    <p class="standard-desc">
                        Cukup tunjukkan kode QR unik dari smartphone Anda di gerbang loket untuk langsung memulai rekreasi.
                    </p>
                </div>

                <div class="standard-card">
                    <div class="standard-num">02</div>
                    <h4 class="standard-title">Fasilitas Ramah Keluarga</h4>
                    <p class="standard-desc">
                        Jalur pedestrian yang nyaman, playground aman anak, mushola bersih, toilet terawat, dan food court.
                    </p>
                </div>

                <div class="standard-card">
                    <div class="standard-num">03</div>
                    <h4 class="standard-title">Interaksi Edukatif Satwa</h4>
                    <p class="standard-desc">
                        Pemberian makan satwa jinak terkelola di bawah pengawasan petugas dan standar kesehatan hewan yang baik.
                    </p>
                </div>

                <div class="standard-card">
                    <div class="standard-num">04</div>
                    <h4 class="standard-title">Pengawasan Kuota Harian</h4>
                    <p class="standard-desc">
                        Sistem pemesanan online membatasi kepadatan berlebih demi kenyamanan seluruh pengunjung taman.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- 7. TOP SELLERS / KATALOG TIKET UMUM -->
    <section class="section" id="tickets">
        <div class="container">
            <div class="section-head">
                <div>
                    <div class="section-eyebrow">KATALOG RESMI TIKET MASUK</div>
                    <h2 class="section-title">Pilihan Tiket Wisata Reguler</h2>
                </div>
                <a href="{{ route('tickets.index') }}" class="btn btn-secondary btn-sm">Lihat Semua Tiket &rarr;</a>
            </div>

            <div class="cards-grid">
                @forelse($tickets as $index => $ticket)
                    <div class="item-card {{ $index === 1 ? 'highlight' : '' }}">
                        <div>
                            <div class="card-top">
                                <span class="card-badge">
                                    {{ $index === 0 ? 'BEST SELLER' : ($index === 1 ? 'FAVORIT KELUARGA' : 'TARIF KHUSUS') }}
                                </span>
                                <span class="card-code">TK-0{{ $index + 1 }}</span>
                            </div>

                            <h3 class="card-name">{{ $ticket->name }}</h3>
                            <p class="card-summary">{{ $ticket->description }}</p>

                            <div class="card-price-box">
                                <div class="price-label">Harga Tiket</div>
                                <div>
                                    <span class="price-currency">IDR</span>
                                    <span class="price-number">{{ number_format($ticket->price, 0, ',', '.') }}</span>
                                    <span class="price-unit">/ orang</span>
                                </div>
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
                        </div>

                        <div>
                            <a href="{{ route('tickets.show', $ticket->id) }}" class="btn {{ $index === 1 ? 'btn-primary' : 'btn-secondary' }} btn-block">
                                Pesan Tiket Ini
                            </a>
                        </div>
                    </div>
                @empty
                    <p style="color: var(--text-muted); grid-column: 1 / -1;">Belum ada tiket aktif saat ini.</p>
                @endforelse
            </div>
        </div>
    </section>

    <!-- 8. PAKET ROMBONGAN SEKOLAH -->
    <section class="section" id="school" style="background-color: var(--bg-darker);">
        <div class="container">
            <div class="section-head">
                <div>
                    <div class="section-eyebrow">PROGRAM KHUSUS INSTITUSI PENDIDIKAN</div>
                    <h2 class="section-title">Paket Kunjungan Rombongan Sekolah</h2>
                </div>
                <a href="{{ route('school.index') }}" class="btn btn-secondary btn-sm">Katalog Rombongan &rarr;</a>
            </div>

            <!-- Alur 4 Tahap Pengajuan Sekolah (Wix Minimal Steps) -->
            <div class="steps-row">
                <div class="step-card">
                    <div class="step-num">TAHAP 01</div>
                    <div class="step-title">Pengajuan Data</div>
                    <p class="step-text">Pilih paket dan isi data sekolah, tanggal kunjungan, serta perkiraan jumlah siswa.</p>
                </div>
                <div class="step-card">
                    <div class="step-num">TAHAP 02</div>
                    <div class="step-title">Verifikasi Admin</div>
                    <p class="step-text">Pengelola memeriksa kuota jadwal dan kesiapan fasilitator pendamping rombongan.</p>
                </div>
                <div class="step-card">
                    <div class="step-num">TAHAP 03</div>
                    <div class="step-title">Pelunasan Midtrans</div>
                    <p class="step-text">Setelah disetujui, tombol pelunasan online aktif pada riwayat pesanan sekolah.</p>
                </div>
                <div class="step-card">
                    <div class="step-num">TAHAP 04</div>
                    <div class="step-title">E-Ticket Rombongan</div>
                    <p class="step-text">E-ticket digital terbit resmi dengan barcode rombongan untuk akses masuk satu pintu.</p>
                </div>
            </div>

            <!-- Paket Grid -->
            <div class="cards-grid">
                @forelse($packages as $index => $package)
                    <div class="item-card {{ $index === 1 ? 'highlight' : '' }}">
                        <div>
                            <div class="card-top">
                                <span class="card-badge">EDUKASI RESMI</span>
                                <span class="card-code">PK-0{{ $index + 1 }}</span>
                            </div>

                            <h3 class="card-name">{{ $package->name }}</h3>
                            <p class="card-summary">{{ $package->description }}</p>

                            <div class="card-price-box">
                                <div class="price-label">Tarif Siswa (Min. {{ $package->min_students }} Peserta &bull; Durasi: {{ $package->duration }})</div>
                                <div>
                                    <span class="price-currency">IDR</span>
                                    <span class="price-number">{{ number_format($package->price_per_student, 0, ',', '.') }}</span>
                                    <span class="price-unit">/ siswa</span>
                                </div>
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
                        </div>

                        <div>
                            <a href="{{ route('school.apply', ['package' => $package->id]) }}" class="btn {{ $index === 1 ? 'btn-primary' : 'btn-secondary' }} btn-block">
                                Ajukan Paket Rombongan
                            </a>
                        </div>
                    </div>
                @empty
                    <p style="color: var(--text-muted); grid-column: 1 / -1;">Belum ada paket sekolah aktif saat ini.</p>
                @endforelse
            </div>
        </div>
    </section>

    <!-- 9. PANDUAN KUNJUNGAN & OPERASIONAL -->
    <section class="section" id="lokasi">
        <div class="container">
            <div class="section-head">
                <div>
                    <div class="section-eyebrow">INFORMASI KAWASAN</div>
                    <h2 class="section-title">Panduan Operasional &amp; Lokasi</h2>
                </div>
                <div class="section-counter">LOKASI &amp; AKSES</div>
            </div>

            <div class="standards-grid">
                <div class="standard-card">
                    <div class="standard-num">JAM BUKA</div>
                    <h4 class="standard-title">08.00 - 17.00 WIB</h4>
                    <p class="standard-desc">
                        Buka setiap hari, termasuk akhir pekan, hari libur nasional, dan masa libur sekolah.
                    </p>
                </div>

                <div class="standard-card">
                    <div class="standard-num">ALAMAT</div>
                    <h4 class="standard-title">Kecamatan Rumpin</h4>
                    <p class="standard-desc">
                        Jl. Raya Rumpin, Kabupaten Bogor, Jawa Barat. Akses jalan mulus dan ramah bus rombongan.
                    </p>
                </div>

                <div class="standard-card">
                    <div class="standard-num">PARKIR</div>
                    <h4 class="standard-title">Area Parkir Luas</h4>
                    <p class="standard-desc">
                        Kapasitas mencukupi untuk ratusan mobil pribadi, motor, hingga puluhan bus pariwisata.
                    </p>
                </div>

                <div class="standard-card">
                    <div class="standard-num">VALIDASI</div>
                    <h4 class="standard-title">Scan QR di Gerbang</h4>
                    <p class="standard-desc">
                        Tunjukkan E-Ticket digital langsung dari smartphone Anda kepada petugas di pintu gerbang utama.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- 10. CALL TO ACTION BANNER (Replika "Join Our Premium Club" Wix) -->
    <section class="cta-banner">
        <div class="container">
            <div class="cta-banner-content">
                <div class="section-eyebrow" style="margin-bottom: 0.75rem;">RESERVASI INSTITUSI</div>
                <h2>Siap Mengagendakan Kunjungan Edukasi?</h2>
                <p>
                    Dapatkan kemudahan proses pemesanan tiket wisata mandiri atau ajukan jadwal kunjungan rombongan sekolah Anda hari ini dengan verifikasi instan.
                </p>
                <div class="cta-buttons">
                    <a href="#tickets" class="btn btn-primary btn-lg">Pesan Tiket Wisata &rarr;</a>
                    <a href="{{ route('school.index') }}" class="btn btn-secondary btn-lg">Katalog Paket Sekolah</a>
                </div>
            </div>
        </div>
    </section>

    <!-- 11. MULTI-COLUMN FOOTER (Wix wh-1064 Exact Structure) -->
    <footer class="footer">
        <div class="container">
            <div class="footer-grid">
                <div class="footer-brand">
                    <h4>THE NICE PARK RUMPIN</h4>
                    <p>
                        Kawasan wisata rekreasi alam terbuka, zona edukasi flora-fauna ramah anak, dan destinasi gathering rombongan sekolah di Rumpin, Bogor.
                    </p>
                    <div style="margin-top: 1.5rem; font-size: 0.75rem; color: var(--text-sub);">
                        &copy; 2026 The Nice Park Rumpin. Seluruh hak cipta dilindungi.
                    </div>
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
                    <h5>Lokasi &amp; Kontak</h5>
                    <p style="color: var(--text-muted); margin-bottom: 0.5rem;">Jl. Raya Rumpin, Kec. Rumpin, Kab. Bogor, Jawa Barat</p>
                    <p style="color: var(--color-primary); font-weight: 600;">Tel: 0812-3456-7890</p>
                    <p style="color: var(--text-sub); margin-top: 0.5rem;">08.00 - 17.00 WIB</p>
                </div>

                <div class="footer-col">
                    <h5>Metode Pembayaran</h5>
                    <p style="color: var(--text-muted); font-size: 0.78rem; line-height: 1.5;">
                        Transaksi terenkripsi dan terverifikasi otomatis via Midtrans Payment Gateway:
                    </p>
                    <div class="footer-pay-badges">
                        <span class="pay-badge">QRIS</span>
                        <span class="pay-badge">BCA VA</span>
                        <span class="pay-badge">MANDIRI</span>
                        <span class="pay-badge">BNI</span>
                        <span class="pay-badge">BRI</span>
                    </div>
                </div>
            </div>

            <div class="footer-bottom">
                <div>The Nice Park Rumpin Ticketing Portal &bull; Terintegrasi Midtrans Sandbox/Production</div>
                <div>Format Desain Mengadaptasi Wix wh-1064 Dark Theme</div>
            </div>
        </div>
    </footer>

    <!-- Video Controller Script -->
    <script>
        function toggleHeroVideo() {
            const video = document.getElementById('heroVideo');
            const icon = document.getElementById('videoStatusIcon');
            const text = document.getElementById('videoStatusText');

            if (!video) return;

            if (video.paused) {
                video.play();
                icon.textContent = '⏸';
                text.textContent = 'Jeda Video Background';
            } else {
                video.pause();
                icon.textContent = '▶';
                text.textContent = 'Putar Video Background';
            }
        }

        // Fallback jika video gagal load di browser tertentu
        const heroVideo = document.getElementById('heroVideo');
        if (heroVideo) {
            heroVideo.addEventListener('error', function() {
                heroVideo.style.display = 'none';
                const fallbackImg = document.getElementById('heroFallbackImg');
                if (fallbackImg) fallbackImg.style.display = 'block';
            });
        }
    </script>

</body>
</html>
