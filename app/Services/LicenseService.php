<?php

namespace App\Services;

use Illuminate\Support\Str;
use App\Models\License;

class LicenseService
{
    /**
     * Generate a unique license key for a software product
     */
    public function generateKey($productId, $orderId, $userId)
    {
        // Format: DGTF-XXXX-XXXX-XXXX
        $key = 'DGTF-' . strtoupper(Str::random(4)) . '-' . strtoupper(Str::random(4)) . '-' . strtoupper(Str::random(4));

        // Ensure completely unique
        while (License::where('key', $key)->exists()) {
            $key = 'DGTF-' . strtoupper(Str::random(4)) . '-' . strtoupper(Str::random(4)) . '-' . strtoupper(Str::random(4));
        }

        return License::create([
            'user_id' => $userId,
            'product_id' => $productId,
            'order_id' => $orderId,
            'key' => $key,
            'device_limit' => 1, // Default limit
            'status' => 'active'
        ]);
    }

    /**
     * Activate a device against a license
     */
    public function activateDevice($key)
    {
        $license = License::where('key', $key)->first();

        if (!$license || $license->status !== 'active') {
            return false;
        }

        if ($license->activated_devices >= $license->device_limit) {
            return false; // Limit reached
        }

        $license->increment('activated_devices');
        return true;
    }
}
