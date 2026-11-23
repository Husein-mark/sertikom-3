<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Package;
use App\Models\Ticket;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Statistik
        $totalOrders = Order::count();
        $totalRevenue = Order::where('status', 'paid')->sum('total_price');
        $pendingSchoolCount = Order::where('type', 'school')->where('status', 'pending_approval')->count();
        $paidOrdersCount = Order::where('status', 'paid')->count();

        // Eager Loading untuk pesanan terbaru (mengatasi N+1 query)
        $recentOrders = Order::with(['ticket', 'package', 'latestPayment'])
            ->latest()
            ->take(6)
            ->get();

        // Antrean pengajuan sekolah pending
        $pendingSchools = Order::with(['package'])
            ->where('type', 'school')
            ->where('status', 'pending_approval')
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalOrders',
            'totalRevenue',
            'pendingSchoolCount',
            'paidOrdersCount',
            'recentOrders',
            'pendingSchools'
        ));
    }
}
