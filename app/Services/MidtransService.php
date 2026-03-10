<?php

namespace App\Services;

use App\Models\Order;
use Midtrans\Config;
use Midtrans\Snap;
use Midtrans\Notification;

class MidtransService
{
    public function __construct()
    {
        Config::$serverKey = config('services.midtrans.server_key');
        Config::$isProduction = config('services.midtrans.is_production');
        Config::$isSanitized = true;
        Config::$is3ds = true;
    }

    public function generateSnapToken(Order $order)
    {
        // Build items array
        $itemDetails = [];
        foreach ($order->items as $item) {
            $itemDetails[] = [
                'id' => $item->product_id,
                'price' => (int) $item->price,
                'quantity' => 1,
                'name' => $item->product->title,
            ];
        }

        $params = [
            'transaction_details' => [
                'order_id' => $order->order_number,
                'gross_amount' => (int) $order->total,
            ],
            'customer_details' => [
                'first_name' => $order->user->name,
                'email' => $order->user->email,
                'phone' => $order->user->phone ?? '081234567890',
            ],
            'item_details' => $itemDetails,
        ];

        try {
            return Snap::getSnapToken($params);
        } catch (\Exception $e) {
            \Log::error('Midtrans Snap Error: ' . $e->getMessage());
            return null;
        }
    }

    public function handleWebhook($payload)
    {
        $notif = new Notification();

        $transaction = $notif->transaction_status;
        $type = $notif->payment_type;
        $orderId = $notif->order_id;
        $fraud = $notif->fraud_status;

        $order = Order::where('order_number', $orderId)->first();

        if (!$order) {
            return false;
        }

        if ($transaction == 'capture') {
            if ($type == 'credit_card') {
                if ($fraud == 'challenge') {
                    // TODO set payment status in merchant's database to 'Challenge by FDS'
                    // $order->update(['status' => 'pending']);
                } else {
                    // TODO set payment status in merchant's database to 'Success'
                    app(OrderService::class)->processPaymentSuccess($order, $notif->transaction_id);
                }
            }
        } elseif ($transaction == 'settlement') {
            app(OrderService::class)->processPaymentSuccess($order, $notif->transaction_id);
        } elseif ($transaction == 'pending') {
            // TODO set payment status in merchant's database to 'Pending'
        } elseif ($transaction == 'deny') {
            // TODO set payment status in merchant's database to 'Denied'
            $order->update(['status' => 'cancelled']);
        } elseif ($transaction == 'expire') {
            // TODO set payment status in merchant's database to 'expire'
            $order->update(['status' => 'cancelled']);
        } elseif ($transaction == 'cancel') {
            // TODO set payment status in merchant's database to 'Denied'
            $order->update(['status' => 'cancelled']);
        }

        return true;
    }
}
