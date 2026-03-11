<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Wishlist;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    public function index()
    {
        $wishlists = Wishlist::with([
            'product' => function ($q) {
                $q->with('category', 'reviews');
            }
        ])
            ->where('user_id', auth()->id())
            ->latest()
            ->paginate(12);

        return view('dashboard.wishlist.index', compact('wishlists'));
    }

    public function toggle(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id'
        ]);

        $wishlist = Wishlist::where('user_id', auth()->id())
            ->where('product_id', $request->product_id)
            ->first();

        if ($wishlist) {
            $wishlist->delete();
            $status = 'removed';
            $message = 'Product removed from wishlist.';
        } else {
            Wishlist::create([
                'user_id' => auth()->id(),
                'product_id' => $request->product_id
            ]);
            $status = 'added';
            $message = 'Product added to wishlist.';
        }

        if ($request->wantsJson()) {
            return response()->json(['status' => $status, 'message' => $message]);
        }

        return back()->with('success', $message);
    }
}
