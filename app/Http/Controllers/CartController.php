<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Services\CartService;
use Illuminate\Http\Request;

class CartController extends Controller
{
    protected $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    public function index()
    {
        $items = $this->cartService->getItems();
        $totals = $this->cartService->calculateTotal();

        $cartItems = [];
        foreach ($items as $item) {
            $product = is_numeric($item) ? Product::find($item) : $item->product;
            if ($product) {
                $cartItems[] = [
                    'id' => is_numeric($item) ? $product->id : $item->product_id,
                    'product' => $product,
                    'price' => $product->price,
                ];
            }
        }

        $subtotal = $totals['subtotal'];
        $discountValue = $totals['discount'];
        $total = $totals['total'];
        $couponCode = $totals['coupon'] ? $totals['coupon']->code : null;

        return view('cart.index', compact('cartItems', 'subtotal', 'discountValue', 'total', 'couponCode'));
    }

    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
        ]);

        $this->cartService->addItem($request->product_id);

        if ($request->has('buy_now')) {
            return redirect()->route('checkout.index');
        }

        return back()->with('success', 'Product added to cart.');
    }

    public function remove(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
        ]);

        $this->cartService->removeItem($request->product_id);

        return back()->with('success', 'Product removed from cart.');
    }

    public function applyCoupon(Request $request)
    {
        $request->validate([
            'code' => 'required|string',
        ]);

        if ($this->cartService->applyCoupon($request->code)) {
            return back()->with('success', 'Coupon applied successfully.');
        }

        return back()->with('error', 'Invalid or expired coupon code.');
    }

    public function removeCoupon()
    {
        $this->cartService->removeCoupon();
        return back()->with('success', 'Coupon removed.');
    }
}
