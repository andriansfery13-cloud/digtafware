<?php

namespace App\Http\Controllers;

use App\Models\Download;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DownloadController extends Controller
{
    public function process($token)
    {
        // Token is already validated by DownloadMiddleware before hitting this

        $download = Download::with('product')->where('token', $token)->firstOrFail();

        $product = $download->product;

        if (!$product->file_path || !Storage::disk('local')->exists($product->file_path)) {
            abort(404, 'File not found on server.');
        }

        // Increment download counts
        $download->increment('download_count');
        $product->increment('download_count');

        $fileName = $product->slug . '-v' . ($product->version ?? 'latest') . '.' . pathinfo($product->file_path, PATHINFO_EXTENSION);

        return response()->download(storage_path('app/private/' . $product->file_path), $fileName);
    }
}
