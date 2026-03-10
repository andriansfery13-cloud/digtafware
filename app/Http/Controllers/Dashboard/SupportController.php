<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\SupportTicket;
use Illuminate\Http\Request;

class SupportController extends Controller
{
    public function index()
    {
        $tickets = SupportTicket::where('user_id', auth()->id())
            ->latest()
            ->paginate(15);

        return view('dashboard.support.index', compact('tickets'));
    }

    public function create()
    {
        $orders = auth()->user()->orders()->where('status', 'paid')->get();
        return view('dashboard.support.create', compact('orders'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'order_id' => 'nullable|exists:orders,id',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        if ($request->filled('order_id')) {
            // Verify order belongs to user
            $order = auth()->user()->orders()->find($request->order_id);
            if (!$order) {
                return back()->withErrors(['order_id' => 'Invalid order selected.']);
            }
        }

        $validated['user_id'] = auth()->id();
        $validated['status'] = 'open';

        SupportTicket::create($validated);

        return redirect()->route('dashboard.support.index')
            ->with('success', 'Support ticket created successfully. We will reply shortly.');
    }

    public function show(SupportTicket $ticket)
    {
        if ($ticket->user_id !== auth()->id()) {
            abort(403);
        }

        return view('dashboard.support.show', compact('ticket'));
    }
}
