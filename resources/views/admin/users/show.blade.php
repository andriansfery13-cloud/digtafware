@extends('layouts.admin')

@section('header')
User Profile: {{ $user->name }}
@endsection

@section('content')
<div class="mb-6 flex items-center justify-between">
    <a href="{{ route('admin.users.index') }}" class="text-sm font-medium text-indigo-600 dark:text-indigo-400 hover:text-indigo-500">&larr; Back to Users</a>
    
    <div class="flex gap-2">
        @if(!$user->isAdmin())
            <form action="{{ route('admin.users.role', $user->id) }}" method="POST" onsubmit="return confirm('Promote this user to Admin? They will have full access.');">
                @csrf
                @method('PATCH')
                <input type="hidden" name="role" value="admin">
                <button type="submit" class="px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700">Make Admin</button>
            </form>
        @elseif($user->id !== auth()->id())
            <form action="{{ route('admin.users.role', $user->id) }}" method="POST" onsubmit="return confirm('Remove Admin privileges from this user?');">
                @csrf
                @method('PATCH')
                <input type="hidden" name="role" value="user">
                <button type="submit" class="px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm text-sm font-medium text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-gray-700">Revoke Admin</button>
            </form>
        @endif
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    
    <!-- Profile Sidebar -->
    <div class="lg:col-span-1 space-y-8">
        <div class="bg-white dark:bg-gray-800 shadow-sm rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden text-center p-6">
            <div class="mx-auto h-24 w-24 rounded-full bg-indigo-100 dark:bg-indigo-900/50 flex items-center justify-center font-bold text-3xl text-indigo-700 dark:text-indigo-400 border border-indigo-200 dark:border-indigo-800 mb-4">
                {{ substr($user->name, 0, 1) }}
            </div>
            <h3 class="text-xl font-bold text-gray-900 dark:text-white">{{ $user->name }}</h3>
            <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">{{ $user->email }}</p>
            
            <div class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium {{ $user->isAdmin() ? 'bg-purple-100 text-purple-800 flex dark:bg-purple-900/40 dark:text-purple-400' : 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300' }}">
                {{ $user->isAdmin() ? 'Administrator' : 'Customer' }}
            </div>
            
            <div class="mt-6 border-t border-gray-200 dark:border-gray-700 pt-6 text-left text-sm text-gray-500 dark:text-gray-400 space-y-3">
                <div class="flex justify-between">
                    <strong class="text-gray-700 dark:text-gray-300">Joined:</strong> 
                    <span>{{ $user->created_at->format('M d, Y') }}</span>
                </div>
                <div class="flex justify-between">
                    <strong class="text-gray-700 dark:text-gray-300">Total Spent:</strong> 
                    <span class="text-gray-900 dark:text-white font-medium">Rp {{ number_format($user->orders()->where('status', 'paid')->sum('total'), 0, ',', '.') }}</span>
                </div>
            </div>
        </div>
    </div>
    
    <!-- User Activity -->
    <div class="lg:col-span-2 space-y-8">
        <div class="bg-white dark:bg-gray-800 shadow-sm rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
            <div class="px-6 py-5 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800">
                <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white">Recent Orders</h3>
            </div>
            
            @php
                $userOrders = $user->orders()->orderBy('created_at', 'desc')->take(5)->get();
            @endphp
            
            @if($userOrders->count() > 0)
                <ul role="list" class="divide-y divide-gray-200 dark:divide-gray-700">
                    @foreach($userOrders as $order)
                        <li class="p-6 flex items-center justify-between hover:bg-gray-50 dark:hover:bg-gray-750 transition-colors">
                            <div>
                                <p class="text-sm font-bold text-gray-900 dark:text-white"><a href="{{ route('admin.orders.show', $order->id) }}" class="hover:underline text-indigo-600 dark:text-indigo-400">#{{ $order->order_number }}</a></p>
                                <p class="text-xs text-gray-500 dark:text-gray-400">{{ $order->created_at->format('M d, Y H:i') }}</p>
                            </div>
                            <div class="flex items-center gap-4">
                                <span class="font-medium text-gray-900 dark:text-white">Rp {{ number_format($order->total, 0, ',', '.') }}</span>
                                @if($order->status == 'paid')
                                    <span class="px-2.5 py-0.5 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800 dark:bg-green-900/40 dark:text-green-400">Paid</span>
                                @else
                                    <span class="px-2.5 py-0.5 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300">{{ ucfirst(str_replace('_', ' ', $order->status)) }}</span>
                                @endif
                            </div>
                        </li>
                    @endforeach
                </ul>
                <div class="p-4 border-t border-gray-200 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-900/30 text-center">
                    <a href="{{ route('admin.orders.index', ['search' => $user->name]) }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-500 dark:text-indigo-400">View all orders by {{ $user->name }}</a>
                </div>
            @else
                <div class="p-8 text-center text-sm text-gray-500 dark:text-gray-400">
                    This user hasn't placed any orders yet.
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
