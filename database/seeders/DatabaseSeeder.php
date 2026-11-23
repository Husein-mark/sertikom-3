<?php

namespace Database\Seeders;

use App\Models\ETicket;
use App\Models\Order;
use App\Models\Package;
use App\Models\Payment;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Akun Admin & Pelanggan
        $admin = User::create([
            'name' => 'Administrator The Nice Park',
            'email' => 'admin@nicepark.id',
            'phone' => '081200000001',
            'role' => 'admin',
            'password' => Hash::make('password123'),
        ]);

        $customer = User::create([
            'name' => 'Ahmad Alwi',
            'email' => 'alwi@example.com',
            'phone' => '081234567890',
            'role' => 'customer',
            'password' => Hash::make('password123'),
        ]);

        // 2. Data Tiket Umum
        $ticketAnak = Ticket::create([
            'name' => 'Tiket Anak',
            'price' => 35000,
            'min_age' => 3,
            'max_age' => 12,
            'description' => 'Akses wahana bermain anak, taman satwa, dan arena bermain pasir.',
            'features' => "Akses Area Taman Utama\nAkses Arena Bermain Anak\nArea Mini Zoo & Satwa",
            'is_active' => true,
        ]);

        $ticketDewasa = Ticket::create([
            'name' => 'Tiket Dewasa',
            'price' => 55000,
            'min_age' => 13,
            'max_age' => 59,
            'description' => 'Akses penuh ke seluruh area rekreasi, wahana utama, dan spot pemandangan alam.',
            'features' => "Akses Seluruh Area Wisata\nWahana Utama & Spot Panorama\nFasilitas Rest Area & Kuliner\nAkses Mini Zoo",
            'is_active' => true,
        ]);

        $ticketLansia = Ticket::create([
            'name' => 'Tiket Lansia',
            'price' => 25000,
            'min_age' => 60,
            'max_age' => null,
            'description' => 'Tarif khusus untuk lansia dengan akses jalur ramah difabel dan area istirahat.',
            'features' => "Akses Area Jalur Khusus Lansia\nArea Santai & Pemandangan\nBantuan Pendamping Khusus",
            'is_active' => true,
        ]);

        // 3. Data Paket Sekolah
        $packageA = Package::create([
            'name' => 'Paket Edukasi Satwa',
            'price_per_student' => 40000,
            'min_students' => 20,
            'duration' => '4 Jam',
            'description' => 'Program pengenalan satwa dan botani taman dengan pendamping edukator.',
            'features' => "Tiket Masuk Siswa & Guru Pendamping\nFasilitator Edukasi Satwa\nPakan Satwa Interaktif\nDurasi 4 Jam Kunjungan",
            'is_active' => true,
        ]);

        $packageB = Package::create([
            'name' => 'Paket Field Trip Lengkap',
            'price_per_student' => 75000,
            'min_students' => 30,
            'duration' => 'Full Day',
            'description' => 'Program lengkap satu hari termasuk pemandu dan konsumsi makan siang siswa.',
            'features' => "Pemandu Tur Bersertifikat\nMakan Siang & Air Mineral\nAkses Semua Wahana & Taman\nSertifikat Kunjungan Sekolah",
            'is_active' => true,
        ]);

        $packageC = Package::create([
            'name' => 'Paket Outbound Edukasi',
            'price_per_student' => 12000,
            'min_students' => 50,
            'duration' => 'Full Day',
            'description' => 'Kombinasi kegiatan edukasi lingkungan dan dinamika kelompok outbound alam terbuka.',
            'features' => "Master Games & Instruktur Outbound\n2x Konsumsi (Snack & Lunch Box)\nBanner & Dokumentasi Foto\nSound System & Area Eksklusif",
            'is_active' => true,
        ]);

        // 4. Sample Pesanan Tiket Umum yang LUNAS
        $orderPaid = Order::create([
            'order_number' => 'TRX-20261120-0019',
            'user_id' => $customer->id,
            'type' => 'general',
            'ticket_id' => $ticketDewasa->id,
            'visit_date' => now()->addDays(2)->format('Y-m-d'),
            'quantity' => 3,
            'unit_price' => 55000,
            'total_price' => 165000,
            'status' => 'paid',
            'customer_name' => 'Ahmad Alwi',
            'customer_email' => 'alwi@example.com',
            'customer_phone' => '081234567890',
        ]);

        Payment::create([
            'order_id' => $orderPaid->id,
            'midtrans_order_id' => $orderPaid->order_number,
            'transaction_id' => 'mid-trx-' . uniqid(),
            'payment_type' => 'qris',
            'gross_amount' => 165000,
            'transaction_status' => 'settlement',
            'fraud_status' => 'accept',
            'paid_at' => now()->subHours(2),
        ]);

        ETicket::create([
            'order_id' => $orderPaid->id,
            'ticket_code' => 'ETK-992384',
            'qr_data' => 'NP-992384-' . $orderPaid->order_number,
            'is_used' => false,
        ]);

        // 5. Sample Pesanan Tiket Umum Menunggu Pembayaran
        Order::create([
            'order_number' => 'TRX-20261123-0042',
            'user_id' => $customer->id,
            'type' => 'general',
            'ticket_id' => $ticketDewasa->id,
            'visit_date' => now()->addDays(5)->format('Y-m-d'),
            'quantity' => 2,
            'unit_price' => 55000,
            'total_price' => 110000,
            'status' => 'unpaid',
            'customer_name' => 'Ahmad Alwi',
            'customer_email' => 'alwi@example.com',
            'customer_phone' => '081234567890',
        ]);

        // 6. Sample Pengajuan Sekolah yang Disetujui Admin (Siap Bayar)
        Order::create([
            'order_number' => 'SCH-20261118-0005',
            'user_id' => $customer->id,
            'type' => 'school',
            'package_id' => $packageB->id,
            'visit_date' => now()->addDays(12)->format('Y-m-d'),
            'quantity' => 45,
            'unit_price' => 75000,
            'total_price' => 3375000,
            'status' => 'approved',
            'customer_name' => 'Hendra, S.Pd',
            'customer_email' => 'alwi@example.com',
            'customer_phone' => '081234567890',
            'school_name' => 'SMA Negeri 1 Bogor',
            'school_address' => 'Jl. Ir. H. Juanda No. 16, Kota Bogor',
            'pic_name' => 'Hendra, S.Pd',
            'pic_position' => 'Wakasek Kesiswaan',
            'pic_phone' => '081298765432',
            'pic_email' => 'sman1bogor@sch.id',
            'admin_notes' => 'Permohonan disetujui. Kuota fasilitator edukasi telah dialokasikan.',
        ]);

        // 7. Sample Pengajuan Sekolah Menunggu Review Admin
        Order::create([
            'order_number' => 'SCH-20261122-0009',
            'user_id' => $customer->id,
            'type' => 'school',
            'package_id' => $packageC->id,
            'visit_date' => now()->addDays(19)->format('Y-m-d'),
            'quantity' => 60,
            'unit_price' => 120000,
            'total_price' => 7200000,
            'status' => 'pending_approval',
            'customer_name' => 'Dra. Ratna Kusuma',
            'customer_email' => 'ratna@alazhar.sch.id',
            'customer_phone' => '081299887711',
            'school_name' => 'SMP Al-Azhar 1 Bogor',
            'school_address' => 'Jl. Pajajaran No. 20, Kota Bogor',
            'pic_name' => 'Dra. Ratna Kusuma',
            'pic_position' => 'Wakasek Kesiswaan',
            'pic_phone' => '081299887711',
            'pic_email' => 'smpalazhar1@bogor.sch.id',
            'notes' => 'Mohon disiapkan fasilitator pendamping outbound untuk 4 kelompok.',
        ]);
    }
}
