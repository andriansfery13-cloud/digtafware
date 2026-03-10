<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\License;
use Illuminate\Http\Request;

class LicenseApiController extends Controller
{
    /**
     * POST /api/license/verify
     *
     * Verify a license key and optionally activate it on a device.
     *
     * Request body:
     *   - license_key (required): The license key string
     *   - device_id (optional): A unique device identifier for activation tracking
     *
     * Responses:
     *   200: License is valid
     *   403: License suspended/expired or device limit reached
     *   404: License not found
     *   422: Validation error
     */
    public function verify(Request $request)
    {
        $request->validate([
            'license_key' => 'required|string',
            'device_id' => 'nullable|string|max:255',
        ]);

        $license = License::with('product:id,title,slug,version')
            ->where('key', $request->license_key)
            ->first();

        if (!$license) {
            return response()->json([
                'valid' => false,
                'error' => 'license_not_found',
                'message' => 'The provided license key was not found.',
            ], 404);
        }

        if ($license->status !== 'active') {
            return response()->json([
                'valid' => false,
                'error' => 'license_' . $license->status,
                'message' => 'This license is ' . $license->status . '.',
                'license' => [
                    'key' => $license->key,
                    'status' => $license->status,
                ],
            ], 403);
        }

        // If a device_id is provided, handle device activation tracking
        if ($request->filled('device_id')) {
            if ($license->device_limit > 0 && $license->activated_devices >= $license->device_limit) {
                return response()->json([
                    'valid' => false,
                    'error' => 'device_limit_reached',
                    'message' => 'Maximum number of device activations (' . $license->device_limit . ') has been reached.',
                    'license' => [
                        'key' => $license->key,
                        'status' => $license->status,
                        'device_limit' => $license->device_limit,
                        'activated_devices' => $license->activated_devices,
                    ],
                ], 403);
            }

            // Increment activated devices count
            $license->increment('activated_devices');
        }

        return response()->json([
            'valid' => true,
            'message' => 'License is valid and active.',
            'license' => [
                'key' => $license->key,
                'status' => $license->status,
                'device_limit' => $license->device_limit,
                'activated_devices' => $license->activated_devices,
            ],
            'product' => [
                'id' => $license->product->id,
                'title' => $license->product->title,
                'slug' => $license->product->slug,
                'version' => $license->product->version,
            ],
        ], 200);
    }

    /**
     * POST /api/license/deactivate
     *
     * Deactivate a device from a license (decrements activated_devices).
     */
    public function deactivate(Request $request)
    {
        $request->validate([
            'license_key' => 'required|string',
        ]);

        $license = License::where('key', $request->license_key)->first();

        if (!$license) {
            return response()->json([
                'success' => false,
                'error' => 'license_not_found',
                'message' => 'The provided license key was not found.',
            ], 404);
        }

        if ($license->activated_devices > 0) {
            $license->decrement('activated_devices');
        }

        return response()->json([
            'success' => true,
            'message' => 'Device deactivated successfully.',
            'license' => [
                'key' => $license->key,
                'status' => $license->status,
                'device_limit' => $license->device_limit,
                'activated_devices' => $license->activated_devices,
            ],
        ], 200);
    }
}
