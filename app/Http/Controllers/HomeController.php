<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Top 4 most popular products
        $popularProducts = Product::with('category', 'reviews')
            ->where('status', 'published')
            ->orderByDesc('download_count')
            ->take(4)
            ->get();

        // 6 newest products
        $newProducts = Product::with('category', 'reviews')
            ->where('status', 'published')
            ->latest()
            ->take(6)
            ->get();

        return view('home', compact('popularProducts', 'newProducts'));
    }
}
