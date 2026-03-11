<?php

namespace App\Services;

use App\Models\CartItem;
use App\Models\Coupon;
use Illuminate\Support\Facades\Session;

class CartService
{
    public function getItems()
    {
        if (auth()->check()) {
            return CartItem::with('product')->where('user_id', auth()->id())->get();
        }

        return collect(Session::get('cart', []));
    }

    public function addItem($productId)
    {
        if (auth()->check()) {
            CartItem::firstOrCreate([
                'user_id' => auth()->id(),
                'product_id' => $productId,
            ]);
            return;
        }

        $cart = Session::get('cart', []);
        if (!in_array($productId, $cart)) {
            $cart[] = $productId;
            Session::put('cart', $cart);
        }
    }

    public function removeItem($productId)
    {
        if (auth()->check()) {
            CartItem::where('user_id', auth()->id())->where('product_id', $productId)->delete();
            return;
        }

        $cart = Session::get('cart', []);
        $cart = array_diff($cart, [$productId]);
        Session::put('cart', $cart);
    }

    public function clear()
    {
        if (auth()->check()) {
            CartItem::where('user_id', auth()->id())->delete();
            return;
        }

        Session::forget('cart');
        Session::forget('coupon');
    }

    public function applyCoupon($code)
    {
        $coupon = Coupon::where('code', $code)->first();

        if (!$coupon || !$coupon->isValid()) {
            return false;
        }

        Session::put('coupon', $coupon);
        return true;
    }

    public function removeCoupon()
    {
        Session::forget('coupon');
    }

    public function calculateTotal()
    {
        $items = $this->getItems();
        $subtotal = 0;

        foreach ($items as $item) {
            // For session cart, item is product_id
            $product = is_numeric($item) ? \App\Models\Product::find($item) : $item->product;
            if ($product && !$product->is_enterprise) {
                $subtotal += $product->price;
            }
        }

        $coupon = Session::get('coupon');
        $discount = 0;

        if ($coupon && $coupon->isValid()) {
            if ($coupon->type === 'fixed') {
                $discount = min($coupon->value, $subtotal);
            } else { // percent
                $discount = $subtotal * ($coupon->value / 100);
            }
        }

        return [
            'subtotal' => $subtotal,
            'discount' => $discount,
            'total' => max(0, $subtotal - $discount),
            'coupon' => $coupon
        ];
    }
}
