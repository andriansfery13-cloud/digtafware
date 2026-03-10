<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Services\CartService;
use App\Services\OrderService;
use App\Services\MidtransService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    protected $cartService;
    protected $orderService;
    protected $midtransService;

    public function __construct(CartService $cartService, OrderService $orderService, MidtransService $midtransService)
    {
        $this->cartService = $cartService;
        $this->orderService = $orderService;
        $this->midtransService = $midtransService;
    }

    public function index()
    {
        $items = $this->cartService->getItems();

        if ($items->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

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

        if (empty($cartItems)) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        $subtotal = $totals['subtotal'];
        $discountValue = $totals['discount'];
        $total = $totals['total'];
        $couponCode = $totals['coupon'] ? $totals['coupon']->code : null;

        return view('checkout.index', compact('cartItems', 'subtotal', 'discountValue', 'total', 'couponCode'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'payment_method' => 'required|in:midtrans,manual',
        ]);

        try {
            DB::beginTransaction();

            $order = $this->orderService->createOrder(auth()->id(), $request->payment_method);

            DB::commit();

            if ($request->payment_method === 'midtrans') {
                $snapToken = $this->midtransService->generateSnapToken($order);
                return view('checkout.midtrans', compact('order', 'snapToken'));
            } else {
                return redirect()->route('checkout.manual', $order);
            }

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('cart.index')->with('error', $e->getMessage());
        }
    }

    public function manualPayment(\App\Models\Order $order)
    {
        if ($order->user_id !== auth()->id() || $order->status !== 'pending' || $order->payment_method !== 'manual') {
            abort(404);
        }

        return view('checkout.manual', compact('order'));
    }

    public function storeManualPayment(Request $request, \App\Models\Order $order)
    {
        if ($order->user_id !== auth()->id() || $order->status !== 'pending') {
            abort(404);
        }

        $request->validate([
            'proof_image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $path = $request->file('proof_image')->store('payments/receipts', 'public');

        \App\Models\Payment::updateOrCreate(
            ['order_id' => $order->id],
            [
                'method' => 'manual',
                'amount' => $order->total,
                'status' => 'pending',
                'proof_image' => $path,
            ]
        );

        $order->update(['status' => 'verifying']);

        return redirect()->route('dashboard.orders')->with('success', 'Payment proof uploaded. Awaiting admin verification.');
    }

    public function success(\App\Models\Order $order)
    {
        if ($order->user_id !== auth()->id()) {
            abort(404);
        }

        return view('checkout.success', compact('order'));
    }
}
