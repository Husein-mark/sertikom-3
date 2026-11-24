<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\OrderAdminController;
use App\Http\Controllers\Admin\PackageCrudController;
use App\Http\Controllers\Admin\SchoolAdminController;
use App\Http\Controllers\Admin\TicketCrudController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\SchoolPackageController;
use App\Http\Controllers\TicketController;
use App\Models\Package;
use App\Models\Ticket;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes - The Nice Park Rumpin
|--------------------------------------------------------------------------
*/

// 1. Landing Page
Route::get('/', function () {
    $tickets = Ticket::where('is_active', true)->get();
    $packages = Package::where('is_active', true)->get();
    return view('landing', compact('tickets', 'packages'));
})->name('home');

// 2. Auth Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// 3. Tiket Wisata Umum
Route::get('/tickets', [TicketController::class, 'index'])->name('tickets.index');
Route::get('/tickets/{id}', [TicketController::class, 'show'])->name('tickets.show');
Route::post('/tickets/{id}/order', [TicketController::class, 'storeOrder'])->name('tickets.order');

// 4. Paket Rombongan Sekolah
Route::get('/school', [SchoolPackageController::class, 'index'])->name('school.index');
Route::get('/school/apply', [SchoolPackageController::class, 'apply'])->name('school.apply');
Route::post('/school/apply', [SchoolPackageController::class, 'storeApply'])->name('school.storeApply');

// 5. Transaksi, Pembayaran Midtrans, & E-Ticket
Route::get('/orders/checkout/{id}', [OrderController::class, 'checkout'])->name('orders.checkout');
Route::get('/orders/history', [OrderController::class, 'history'])->name('orders.history');
Route::get('/orders/eticket/{id}', [OrderController::class, 'eticket'])->name('orders.eticket');
Route::get('/orders/simulate-success/{id}', [OrderController::class, 'simulateSuccess'])->name('orders.simulateSuccess');
Route::get('/orders/check-status/{id}', [OrderController::class, 'checkStatus'])->name('orders.checkStatus');

// Webhook, Callback, & Finish URL Resmi Midtrans (Mendukung GET & POST di semua variasi URL)
Route::match(['get', 'post'], '/midtrans/webhook', [OrderController::class, 'handleMidtransNotification'])->name('midtrans.webhook');
Route::match(['get', 'post'], '/midtrans/callback', [OrderController::class, 'handleMidtransNotification'])->name('midtrans.callback');
Route::match(['get', 'post'], '/midtrans/notification', [OrderController::class, 'handleMidtransNotification'])->name('midtrans.notification');
Route::match(['get', 'post'], '/api/midtrans/webhook', [OrderController::class, 'handleMidtransNotification']);
Route::match(['get', 'post'], '/api/midtrans/callback', [OrderController::class, 'handleMidtransNotification']);
Route::match(['get', 'post'], '/api/midtrans/notification', [OrderController::class, 'handleMidtransNotification']);
Route::match(['get', 'post'], '/midtrans/finish', [OrderController::class, 'handleMidtransFinish'])->name('midtrans.finish');
Route::match(['get', 'post'], '/orders/finish', [OrderController::class, 'handleMidtransFinish']);
Route::match(['get', 'post'], '/payment/finish', [OrderController::class, 'handleMidtransFinish']);

// 6. Admin Portal (Protected with 'admin' middleware)
Route::prefix('admin')->middleware(['admin'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

    // Kelola Tiket Umum (CRUD)
    Route::resource('tickets', TicketCrudController::class, [
        'as' => 'admin'
    ]);

    // Kelola Paket Rombongan Sekolah (CRUD)
    Route::resource('packages', PackageCrudController::class, [
        'as' => 'admin'
    ]);

    // Semua Pesanan & Transaksi Midtrans
    Route::get('/orders', [OrderAdminController::class, 'index'])->name('admin.orders.index');
    Route::get('/orders/{id}', [OrderAdminController::class, 'show'])->name('admin.orders.show');
    Route::post('/orders/{id}/verify', [OrderAdminController::class, 'verifyPayment'])->name('admin.orders.verify');

    // Pengajuan Rombongan Sekolah & Review Persetujuan
    Route::get('/school', [SchoolAdminController::class, 'index'])->name('admin.school.index');
    Route::get('/school/{id}', [SchoolAdminController::class, 'show'])->name('admin.school.show');
    Route::post('/school/{id}/status', [SchoolAdminController::class, 'updateStatus'])->name('admin.school.status');
});
