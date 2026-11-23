<?php

use App\Models\Order;
use App\Models\Package;
use App\Models\Ticket;
use App\Models\User;

test('halaman utama dan katalog dapat diakses', function () {
    Ticket::create([
        'name' => 'Tiket Dewasa',
        'price' => 55000,
        'description' => 'Akses seluruh area',
        'is_active' => true,
    ]);

    Package::create([
        'name' => 'Paket Edukasi Satwa',
        'price_per_student' => 40000,
        'min_students' => 20,
        'duration' => '4 Jam',
        'description' => 'Edukasi satwa',
        'is_active' => true,
    ]);

    $this->get('/')->assertStatus(200);
    $this->get('/tickets')->assertStatus(200);
    $this->get('/school')->assertStatus(200);
});

test('perhitungan total harga tiket umum diproses di server', function () {
    $ticket = Ticket::create([
        'name' => 'Tiket Dewasa',
        'price' => 55000,
        'description' => 'Akses seluruh area',
        'is_active' => true,
    ]);

    $response = $this->post(route('tickets.order', $ticket->id), [
        'visit_date' => date('Y-m-d', strtotime('+2 days')),
        'quantity' => 3,
        'customer_name' => 'Budi Santoso',
        'customer_email' => 'budi@example.com',
        'customer_phone' => '081234567890',
    ]);

    $order = Order::first();
    expect($order)->not->toBeNull();
    expect($order->quantity)->toBe(3);
    expect($order->unit_price)->toBe(55000);
    expect($order->total_price)->toBe(165000); // 3 * 55.000 = 165.000
    expect($order->status)->toBe('unpaid');

    $response->assertRedirect(route('orders.checkout', $order->id));
});

test('pengajuan sekolah berstatus pending_approval dan tidak dapat dibayar sebelum disetujui', function () {
    $package = Package::create([
        'name' => 'Paket Field Trip',
        'price_per_student' => 75000,
        'min_students' => 20,
        'duration' => 'Full Day',
        'description' => 'Field trip lengkap',
        'is_active' => true,
    ]);

    $this->post(route('school.storeApply'), [
        'school_name' => 'SMA Negeri 1 Bogor',
        'school_address' => 'Jl. Ir H Juanda',
        'pic_name' => 'Hendra',
        'pic_position' => 'Guru',
        'pic_phone' => '08123456789',
        'pic_email' => 'hendra@sman1.sch.id',
        'package_id' => $package->id,
        'visit_date' => date('Y-m-d', strtotime('+10 days')),
        'student_count' => 30,
    ]);

    $order = Order::where('type', 'school')->first();
    expect($order)->not->toBeNull();
    expect($order->status)->toBe('pending_approval');
    expect($order->total_price)->toBe(2250000); // 30 * 75.000

    // Pembayaran ditolak jika belum disetujui admin
    $checkoutResponse = $this->get(route('orders.checkout', $order->id));
    $checkoutResponse->assertRedirect(route('orders.history'));
});

test('admin dapat menyetujui pengajuan sekolah lalu pesanan dapat dibayar via midtrans', function () {
    $admin = User::create([
        'name' => 'Admin Test',
        'email' => 'admin@test.com',
        'role' => 'admin',
        'password' => bcrypt('password'),
    ]);

    $package = Package::create([
        'name' => 'Paket Field Trip',
        'price_per_student' => 75000,
        'min_students' => 20,
        'duration' => 'Full Day',
        'description' => 'Field trip lengkap',
        'is_active' => true,
    ]);

    $order = Order::create([
        'order_number' => 'SCH-TEST-001',
        'type' => 'school',
        'package_id' => $package->id,
        'visit_date' => date('Y-m-d', strtotime('+10 days')),
        'quantity' => 25,
        'unit_price' => 75000,
        'total_price' => 1875000,
        'status' => 'pending_approval',
        'customer_name' => 'Hendra',
        'customer_email' => 'hendra@test.com',
        'customer_phone' => '0812345678',
        'school_name' => 'SMA 1',
    ]);

    // Admin approve
    $this->actingAs($admin)->post(route('admin.school.status', $order->id), [
        'action' => 'approve',
        'admin_notes' => 'Disetujui',
    ]);

    $order->refresh();
    expect($order->status)->toBe('approved');

    // Sekarang halaman checkout Midtrans dapat diakses
    $this->get(route('orders.checkout', $order->id))->assertStatus(200);

    // Simulasi pelunasan Midtrans Sandbox -> e-ticket terbit
    $this->get(route('orders.simulateSuccess', $order->id));
    $order->refresh();
    expect($order->status)->toBe('paid');
    expect($order->eTicket)->not->toBeNull();
    expect($order->eTicket->ticket_code)->toStartWith('ETK-');
});

test('fitur autentikasi registrasi dan login berjalan baik', function () {
    $this->post(route('register'), [
        'name' => 'User Baru',
        'email' => 'baru@example.com',
        'phone' => '081233445566',
        'password' => 'secret123',
        'password_confirmation' => 'secret123',
    ])->assertRedirect(route('orders.history'));

    $user = User::where('email', 'baru@example.com')->first();
    expect($user)->not->toBeNull();
    expect($user->role)->toBe('customer');

    // Logout
    $this->post(route('logout'))->assertRedirect(route('login'));

    // Login
    $this->post(route('login'), [
        'email' => 'baru@example.com',
        'password' => 'secret123',
    ])->assertRedirect(route('orders.history'));
});

test('hak akses admin terlindungi dari user customer', function () {
    $customer = User::create([
        'name' => 'Biasa',
        'email' => 'biasa@test.com',
        'role' => 'customer',
        'password' => bcrypt('password'),
    ]);

    // Akses dashboard admin dicegat middleware
    $this->actingAs($customer)
        ->get(route('admin.dashboard'))
        ->assertRedirect(route('login'));
});

test('admin dapat melakukan CRUD tiket umum', function () {
    $admin = User::create([
        'name' => 'Super Admin',
        'email' => 'super@test.com',
        'role' => 'admin',
        'password' => bcrypt('password'),
    ]);

    // Create
    $this->actingAs($admin)->post(route('admin.tickets.store'), [
        'name' => 'Tiket VIP',
        'price' => 100000,
        'description' => 'Akses VIP',
        'is_active' => 1,
    ])->assertRedirect(route('admin.tickets.index'));

    $ticket = Ticket::where('name', 'Tiket VIP')->first();
    expect($ticket)->not->toBeNull();

    // Update
    $this->actingAs($admin)->put(route('admin.tickets.update', $ticket->id), [
        'name' => 'Tiket VIP Gold',
        'price' => 120000,
        'description' => 'Akses VIP Gold',
        'is_active' => 1,
    ])->assertRedirect(route('admin.tickets.index'));

    $ticket->refresh();
    expect($ticket->name)->toBe('Tiket VIP Gold');
    expect($ticket->price)->toBe(120000);

    // Delete
    $this->actingAs($admin)->delete(route('admin.tickets.destroy', $ticket->id))
        ->assertRedirect(route('admin.tickets.index'));

    expect(Ticket::find($ticket->id))->toBeNull();
});
