# Web App Ticketing - The Nice Park Rumpin

Aplikasi web pemesanan tiket wisata mandiri dan reservasi paket kunjungan edukasi rombongan sekolah berbasis **Laravel** dengan integrasi pembayaran **Midtrans Payment Gateway (Sandbox)**.

---

## 1. Dokumen Pra-Development

### A. Product Backlog
1. **Autentikasi & Otorisasi**: Registrasi, Login, Logout, dan pemisahan hak akses peran `admin` dan `customer`.
2. **Katalog Tiket & Paket**: Menampilkan pilihan tiket umum (Anak, Dewasa, Lansia) dan paket sekolah (Edukasi Satwa, Field Trip, Outbound).
3. **Pemesanan Tiket Umum**: Form pemilihan tanggal, jumlah tiket, dan perhitungan total biaya di server.
4. **Pengajuan Rombongan Sekolah**: Form permohonan tanggal, data institusi, PIC, dan kuota rombongan dengan alur persetujuan admin terlebih dahulu sebelum pembayaran.
5. **Manajemen Admin**:
   - CRUD Tiket Umum
   - CRUD Paket Sekolah
   - Review persetujuan/penolakan permohonan rombongan sekolah
   - Pemantauan seluruh pesanan dan verifikasi transaksi
6. **Integrasi Midtrans (Single Payment Gateway)**: Pembayaran online via Midtrans Snap (QRIS, VA, Kartu).
7. **Penerbitan E-Ticket**: Penerbitan kode unik tiket digital setelah status pembayaran terverifikasi lunas di server.
8. **Optimasi Kueri**: Penerapan *Eager Loading* untuk mengeliminasi masalah *N+1 Query*.

---

### B. User Flow
#### 1. Alur Pemesanan Tiket Umum (Customer):
`Katalog Tiket` ➔ `Pilih Tiket & Isi Tanggal/Jumlah` ➔ `Hitung Total di Server` ➔ `Checkout Midtrans` ➔ `Bayar Online` ➔ `Verifikasi Server` ➔ `Terbit E-Ticket`

#### 2. Alur Pengajuan Paket Sekolah (Sekolah & Admin):
`Katalog Paket Sekolah` ➔ `Isi Formulir Pengajuan (Data Sekolah & PIC)` ➔ `Status: Menunggu Persetujuan` ➔ `Admin Meninjau (Setujui / Tolak)` ➔ `Jika Disetujui: Tombol Bayar Midtrans Aktif` ➔ `Pelunasan via Midtrans` ➔ `Verifikasi Server` ➔ `Terbit E-Ticket Rombongan`

---

### C. Rancangan Database (ERP Schema)
- **`users`**: `id`, `name`, `email`, `phone`, `password`, `role ('admin', 'customer')`, `timestamps`
- **`tickets`**: `id`, `name`, `price`, `min_age`, `max_age`, `description`, `features`, `is_active`, `timestamps`
- **`packages`**: `id`, `name`, `price_per_student`, `min_students`, `duration`, `description`, `features`, `is_active`, `timestamps`
- **`orders`**: `id`, `order_number`, `user_id`, `type ('general', 'school')`, `ticket_id`, `package_id`, `visit_date`, `quantity`, `unit_price`, `total_price`, `status ('pending_approval', 'approved', 'rejected', 'unpaid', 'paid')`, data kontak/PIC/sekolah, `timestamps`
- **`payments`**: `id`, `order_id`, `midtrans_order_id`, `transaction_id`, `payment_type`, `gross_amount`, `transaction_status`, `snap_token`, `paid_at`, `timestamps`
- **`e_tickets`**: `id`, `order_id`, `ticket_code`, `qr_data`, `is_used`, `used_at`, `timestamps`

---

### D. Bukti Optimasi Kueri (Eager Loading vs N+1 Query)
Pada halaman riwayat pesanan (`OrderController@history`) dan manajemen admin (`OrderAdminController@index`):

- **Sebelum Optimasi (Lazy Loading / N+1 Problem)**:
  ```php
  // Menghasilkan 1 query orders + N query ticket + N query package + N query eTicket (N*3 + 1 query)
  $orders = Order::latest()->get();
  ```
- **Sesudah Optimasi (Eager Loading)**:
  ```php
  // Hanya menghasilkan 4 query terpola konstan berapa pun jumlah data pesanan
  $orders = Order::with(['ticket', 'package', 'eTicket', 'latestPayment'])->latest()->get();
  ```

---

## 2. Panduan Instalasi & Menjalankan Aplikasi

### Kebutuhan Sistem:
- PHP >= 8.2
- Composer
- SQLite (bawaan Laravel, tanpa perlu instal MySQL)

### Langkah Menjalankan:
1. Masuk ke direktori proyek:
   ```bash
   cd c:\Users\alwih\sertikom-3
   ```
2. Salin environment file:
   ```bash
   copy .env.example .env
   ```
3. Generate Application Key:
   ```bash
   php artisan key:generate
   ```
4. Jalankan Migration & Database Seeder:
   ```bash
   php artisan migrate:fresh --seed
   ```
5. Jalankan server lokal:
   ```bash
   php artisan serve
   ```
6. Buka di browser: **`http://localhost:8000`**

---

## 3. Akun Uji Coba (Demo Credentials)

| Peran | Email | Kata Sandi | Akses |
|---|---|---|---|
| **Administrator** | `admin@nicepark.id` | `password123` | Portal Admin (`/admin/dashboard`), CRUD tiket/paket, review pengajuan sekolah, verifikasi pesanan |
| **Pelanggan** | `alwi@example.com` | `password123` | Pesan tiket umum, ajukan paket sekolah, bayar Midtrans, lihat e-ticket |

---

## 4. Konfigurasi Midtrans Sandbox
File konfigurasi terletak di `config/midtrans.php` dan dibaca dari `.env`:
```env
MIDTRANS_SERVER_KEY=SB-Mid-server-test-key
MIDTRANS_CLIENT_KEY=SB-Mid-client-test-key
MIDTRANS_IS_PRODUCTION=false
```
*Catatan: Tombol "Simulasi Pembayaran Midtrans Berhasil" juga telah disematkan pada halaman checkout untuk memudahkan pengujian atau presentasi di depan asesor tanpa kendala jaringan.*
