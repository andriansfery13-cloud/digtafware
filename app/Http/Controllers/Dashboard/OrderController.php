<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = auth()->user()->orders()
            ->with(['items.product', 'payment'])
            ->latest()
            ->paginate(10);

        return view('dashboard.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        $order->load([
            'items.product',
            'payment',
            'items' => function ($q) {
                $q->with('product.category');
            }
        ]);

        $expiresAt = $order->status === 'pending' ? $order->created_at->addHours(4) : null;

        return view('dashboard.orders.show', compact('order', 'expiresAt'));
    }

    public function repay(Order $order, \App\Services\MidtransService $midtransService)
    {
        if ($order->user_id !== auth()->id() || $order->status !== 'pending') {
            abort(403);
        }

        if ($order->payment_method === 'midtrans') {
            $snapToken = $midtransService->generateSnapToken($order);
            return view('checkout.midtrans', compact('order', 'snapToken'));
        }

        return redirect()->route('checkout.manual', $order);
    }
}
