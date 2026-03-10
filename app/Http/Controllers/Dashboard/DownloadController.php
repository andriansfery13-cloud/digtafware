<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Download;
use Illuminate\Http\Request;

class DownloadController extends Controller
{
    public function index()
    {
        $downloads = Download::with(['product', 'order'])
            ->where('user_id', auth()->id())
            ->latest()
            ->paginate(15);

        return view('dashboard.downloads.index', compact('downloads'));
    }
}
