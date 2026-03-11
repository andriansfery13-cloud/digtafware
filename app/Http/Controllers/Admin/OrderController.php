<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Services\OrderService;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    protected $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    public function index(Request $request)
    {
        $query = Order::with('user', 'payment')->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $orders = $query->paginate(15);

        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $order->load(['user', 'items.product', 'payment']);
        return view('admin.orders.show', compact('order'));
    }

    public function verifyPayment(Request $request, Order $order)
    {
        $validated = $request->validate([
            'status' => 'required|in:success,failed',
        ]);

        if ($order->payment && $order->payment->method === 'manual') {
            $order->payment->update([
                'status' => $validated['status'],
                'verified_at' => now(),
                'verified_by' => auth()->id(),
            ]);

            if ($validated['status'] === 'success') {
                $this->orderService->processPaymentSuccess($order);
            } else {
                $order->update(['status' => 'cancelled']);
            }

            return back()->with('success', 'Payment verification processed.');
        }

        return back()->with('error', 'Invalid payment verification attempt.');
    }
}
