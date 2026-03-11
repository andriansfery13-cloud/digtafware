<?php

namespace App\Http\Controllers;

use App\Services\MidtransService;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function midtransWebhook(Request $request, MidtransService $midtransService)
    {
        $payload = $request->all();

        // Very basic structural check against midtrans signature logic
        // Ideally should hash and verify the signature key 
        $success = $midtransService->handleWebhook($payload);

        if ($success) {
            return response()->json(['message' => 'Processed Successfully']);
        }

        return response()->json(['message' => 'Order not found or Invalid request'], 400);
    }
}
