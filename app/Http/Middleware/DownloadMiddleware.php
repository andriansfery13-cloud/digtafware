<?php

namespace App\Http\Middleware;

use App\Models\Download;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class DownloadMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $token = $request->route('token');

        if (!$token) {
            abort(403, 'Invalid download link');
        }

        $download = Download::where('token', $token)->first();

        if (!$download) {
            abort(403, 'Download token not found');
        }

        // Check if user owns the download
        if (auth()->check() && $download->user_id !== auth()->id()) {
            abort(403, 'Unauthorized access to this download');
        }

        // Check if download has expired
        if ($download->expires_at && $download->expires_at->isPast()) {
            abort(403, 'Download link has expired');
        }

        // Check download limits
        if ($download->max_downloads && $download->download_count >= $download->max_downloads) {
            abort(403, 'Maximum download limit reached');
        }

        // Check order status
        if ($download->order->status !== 'paid') {
            abort(403, 'Payment has not been completed for this order');
        }

        return $next($request);
    }
}
