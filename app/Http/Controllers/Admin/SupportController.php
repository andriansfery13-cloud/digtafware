<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SupportTicket;
use Illuminate\Http\Request;

class SupportController extends Controller
{
    public function index()
    {
        $tickets = SupportTicket::with('user', 'order')
            ->latest()
            ->paginate(15);

        return view('admin.support.index', compact('tickets'));
    }

    public function show(SupportTicket $support)
    {
        $support->load('user', 'order');
        return view('admin.support.show', [
            'ticket' => $support
        ]);
    }

    public function update(Request $request, SupportTicket $support)
    {
        $validated = $request->validate([
            'admin_reply' => 'required|string',
            'status' => 'required|in:open,closed'
        ]);

        $support->update($validated);

        return redirect()->route('admin.support.show', $support)
            ->with('success', 'Ticket updated successfully.');
    }
}
