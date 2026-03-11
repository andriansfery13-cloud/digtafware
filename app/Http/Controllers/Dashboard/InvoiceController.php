<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function show(Order $order)
    {
        if ($order->user_id !== auth()->id() || $order->status !== 'paid') {
            abort(403, 'Invoice not available.');
        }

        $order->load(['user', 'items.product', 'payment']);

        return view('dashboard.invoices.show', compact('order'));
    }

    public function download(Order $order)
    {
        if ($order->user_id !== auth()->id() || $order->status !== 'paid') {
            abort(403, 'Invoice not available.');
        }

        $order->load(['user', 'items.product', 'payment']);

        $pdf = Pdf::loadView('dashboard.invoices.pdf', compact('order'));

        return $pdf->download('Invoice-' . $order->order_number . '.pdf');
    }
}
