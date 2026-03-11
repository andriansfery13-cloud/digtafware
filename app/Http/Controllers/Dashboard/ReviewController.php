<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Review;
use App\Models\Product;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function store(Request $request, Product $product)
    {
        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        // Verify user bought the product
        $hasPurchased = auth()->user()->orders()
            ->where('status', 'paid')
            ->whereHas('items', function ($q) use ($product) {
                $q->where('product_id', $product->id);
            })->exists();

        if (!$hasPurchased) {
            return back()->with('error', 'You can only review products you have purchased.');
        }

        Review::updateOrCreate(
            ['user_id' => auth()->id(), 'product_id' => $product->id],
            [
                'rating' => $validated['rating'],
                'comment' => $validated['comment']
            ]
        );

        return back()->with('success', 'Your review has been submitted.');
    }
}
