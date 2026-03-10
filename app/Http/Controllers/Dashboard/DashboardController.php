<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Download;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $stats = [
            'total_orders' => $user->orders()->count(),
            'total_downloads' => Download::where('user_id', $user->id)->count(),
            'wishlist_count' => $user->wishlists()->count(),
        ];

        $recentOrders = $user->orders()->with('items.product')->latest()->take(5)->get();

        return view('dashboard.index', compact('stats', 'recentOrders'));
    }
}
