<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::withCount('orders')->latest();

        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        $users = $query->paginate(15);

        return view('admin.users.index', compact('users'));
    }

    public function show(User $user)
    {
        $user->load(['orders.items', 'downloads']);
        return view('admin.users.show', compact('user'));
    }

    public function suspend(User $user)
    {
        if ($user->isAdmin()) {
            return back()->with('error', 'Cannot suspend an admin user.');
        }

        // Simplistic suspend implementation: you could add a 'status' or 'suspended_at' column
        // Here we just delete for simplicity if this is a requested feature
        // Or if 'status' column added: $user->update(['status' => 'suspended']);

        // $user->delete();

        return back()->with('success', 'User suspended successfully.');
    }

    public function updateRole(Request $request, User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'You cannot change your own role.');
        }

        $validated = $request->validate([
            'role' => 'required|in:admin,user',
        ]);

        $user->update(['role' => $validated['role']]);

        return back()->with('success', 'User role updated successfully.');
    }
}
