<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $totalProducts = Product::count();
        $totalOrders = Order::count();
        $totalCustomers = User::where('role', '!=', 'admin')->count();
        $totalRevenue = Order::where('status', 'paid')->sum('total_amount');

        // Ambil pesanan terbaru (5 terakhir)
        $recentOrders = Order::with('user')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // Prepare data for the view
        $stats = [
            'total_products' => $totalProducts,
            'total_orders' => $totalOrders,
            'total_customers' => $totalCustomers,
            'total_revenue' => $totalRevenue,
            'recent_orders' => $recentOrders,
        ];

        return view('movr.admin.dashboard', $stats);
    }

    

public function report()
{
    // Ambil data pendapatan 6 bulan terakhir untuk grafik
    $revenueData = Order::where('status', 'paid')
        ->select(
            DB::raw('SUM(total_amount) as total'),
            DB::raw("DATE_FORMAT(created_at, '%M') as month"),
            DB::raw('MAX(created_at) as sort_date')
        )
        ->groupBy('month')
        ->orderBy('sort_date', 'asc')
        ->get();

    // Ambil detail transaksi terbaru
    $incomeRecords = Order::with('user')
        ->where('status', 'paid')
        ->orderBy('created_at', 'desc')
        ->paginate(10);

    $totalRevenue = Order::where('status', 'paid')->sum('total_amount');

    return view('movr.admin.report', [
        'revenueData' => $revenueData,
        'incomeRecords' => $incomeRecords,
        'totalRevenue' => $totalRevenue
    ]);
}
}