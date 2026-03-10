<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductDetailController extends Controller
{
    public function show($slug)
    {
        $product = Product::with(['category', 'screenshots', 'changelogs', 'reviews.user'])
            ->where('slug', $slug)
            ->where('status', 'published')
            ->firstOrFail();

        // Check if user has purchased this to show specific actions
        $hasPurchased = false;
        if (auth()->check()) {
            $hasPurchased = auth()->user()->orders()
                ->where('status', 'paid')
                ->whereHas('items', function ($q) use ($product) {
                    $q->where('product_id', $product->id);
                })->exists();
        }

        // Get related products (same category)
        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->where('status', 'published')
            ->take(3)
            ->get();

        return view('products.show', compact('product', 'hasPurchased', 'relatedProducts'));
    }
}
