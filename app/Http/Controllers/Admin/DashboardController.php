<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_users' => User::where('role', 'user')->count(),
            'total_orders' => Order::where('status', 'paid')->count(),
            'total_revenue' => Order::where('status', 'paid')->sum('total'),
            'total_products' => Product::count(),
        ];

        $recentOrders = Order::with('user')->latest()->take(5)->get();

        $topProducts = Product::withCount([
            'orderItems as total_sales' => function ($query) {
                $query->whereHas('order', function ($q) {
                    $q->where('status', 'paid');
                });
            }
        ])->orderByDesc('total_sales')->take(5)->get();

        return view('admin.dashboard.index', compact('stats', 'recentOrders', 'topProducts'));
    }
}
