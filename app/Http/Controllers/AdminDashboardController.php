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
        // Count total products
        $totalProducts = Product::count();

        // Count total orders
        $totalOrders = Order::count();

        // Count total customers
        $totalCustomers = User::where('role', '!=', 'admin')->count();

        // Calculate total revenue from paid orders
        $totalRevenue = Order::where('status', 'paid')->sum('total_amount');

        // Get recent orders (last 5 orders)
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
}