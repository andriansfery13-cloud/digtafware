<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Payment;
use App\Models\Download;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderSuccess;

class OrderService
{
    protected $cartService;
    protected $licenseService;

    public function __construct(CartService $cartService, LicenseService $licenseService)
    {
        $this->cartService = $cartService;
        $this->licenseService = $licenseService;
    }

    public function createOrder($userId, $paymentMethod)
    {
        $totals = $this->cartService->calculateTotal();
        $items = $this->cartService->getItems();

        if ($totals['total'] <= 0 || $items->isEmpty()) {
            throw new \Exception('Cart is empty or total is invalid.');
        }

        $order = Order::create([
            'user_id' => $userId,
            'order_number' => 'ORD-' . strtoupper(Str::random(8)),
            'total' => $totals['total'],
            'status' => 'pending',
            'payment_method' => $paymentMethod,
        ]);

        foreach ($items as $item) {
            $product = is_numeric($item) ? \App\Models\Product::find($item) : $item->product;

            $order->items()->create([
                'product_id' => $product->id,
                'price' => $product->price,
            ]);
        }

        // Apply coupon usage
        if ($totals['coupon']) {
            $totals['coupon']->increment('used_count');
        }

        $this->cartService->clear();

        return $order;
    }

    public function processPaymentSuccess(Order $order, $transactionId = null)
    {
        if ($order->status === 'paid') {
            return $order; // Already processed
        }

        $order->update(['status' => 'paid']);

        // Generate payments record if it doesn't exist (e.g. from Midtrans webhook)
        Payment::updateOrCreate(
            ['order_id' => $order->id],
            [
                'method' => $order->payment_method,
                'transaction_id' => $transactionId,
                'amount' => $order->total,
                'status' => 'success',
            ]
        );

        // Generate Licenses & Downloads for each item
        foreach ($order->items as $item) {
            // Generate License Key
            $license = $this->licenseService->generateKey($item->product_id, $order->id, $order->user_id);
            $item->update(['license_key' => $license->key]);

            // Create Download Access Token
            Download::create([
                'user_id' => $order->user_id,
                'product_id' => $item->product_id,
                'order_id' => $order->id,
                'token' => Str::random(40),
                'max_downloads' => null, // unlimited by default
            ]);
        }

        // Send Success Email
        $order->load(['user', 'items.product']);
        Mail::to($order->user->email)->send(new OrderSuccess($order));

        return $order;
    }
}
