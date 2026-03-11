@extends('layouts.app')

@section('header', 'Manual Transfer Payment')

@section('content')
    <div class="bg-gray-50 dark:bg-gray-900 min-h-[calc(100vh-theme('spacing.16'))] py-12">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="mb-8 flex items-center justify-between">
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Complete Manual Payment</h1>
                <span
                    class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400">
                    Awaiting Payment
                </span>
            </div>

            <div
                class="bg-white dark:bg-gray-800 shadow shadow-indigo-100 dark:shadow-none border border-gray-200 dark:border-gray-700 rounded-xl overflow-hidden mb-8">
                <div
                    class="p-6 sm:p-8 bg-gradient-to-br from-indigo-50 to-white dark:from-gray-800 dark:to-gray-800 border-b border-gray-200 dark:border-gray-700">
                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                        <div>
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide">Order
                                Number</p>
                            <p class="text-xl font-bold text-gray-900 dark:text-white">#{{ $order->order_number }}</p>
                        </div>
                        <div class="text-left sm:text-right">
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide">Total
                                Amount to Pay</p>
                            <p class="text-3xl font-extrabold text-indigo-600 dark:text-indigo-400">Rp
                                {{ number_format($order->total, 0, ',', '.') }}</p>
                        </div>
                    </div>
                </div>

                <div class="p-6 sm:p-8">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">1. Transfer Instructions</h3>
                    <p class="text-gray-600 dark:text-gray-300 mb-6 text-sm">Please transfer exactly the total amount to one
                        of the following bank accounts.</p>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-8">
                        <!-- Bank Accounts Hardcoded UI for demonstration -->
                        <div
                            class="border border-gray-200 dark:border-gray-700 rounded-lg p-4 bg-gray-50 dark:bg-gray-900/50">
                            <div class="font-bold text-blue-800 dark:text-blue-400 text-lg mb-1">BCA</div>
                            <p class="text-2xl font-mono text-gray-900 dark:text-white tracking-wider mb-2">1234 5678 90</p>
                            <p class="text-sm text-gray-500">A.N. PT DigtafWare Solution</p>
                        </div>
                        <div
                            class="border border-gray-200 dark:border-gray-700 rounded-lg p-4 bg-gray-50 dark:bg-gray-900/50">
                            <div class="font-bold text-sky-800 dark:text-sky-400 text-lg mb-1">Bank Mandiri</div>
                            <p class="text-2xl font-mono text-gray-900 dark:text-white tracking-wider mb-2">098 7654 321</p>
                            <p class="text-sm text-gray-500">A.N. PT DigtafWare Solution</p>
                        </div>
                    </div>

                    <hr class="border-gray-200 dark:border-gray-700 my-8">

                    <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">2. Upload Payment Proof</h3>

                    <form action="{{ route('checkout.manual.store', $order->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf

                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Transfer Receipt Image <span class="text-red-500">*</span>
                            </label>
                            <div
                                class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 dark:border-gray-600 border-dashed rounded-md bg-gray-50 dark:bg-gray-700/30 hover:bg-gray-100 dark:hover:bg-gray-700/50 transition-colors">
                                <div class="space-y-1 text-center">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none"
                                        viewBox="0 0 48 48" aria-hidden="true">
                                        <path
                                            d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02"
                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                    <div class="flex text-sm text-gray-600 dark:text-gray-300 justify-center">
                                        <label for="proof_image"
                                            class="relative cursor-pointer rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
                                            <span>Select a file</span>
                                            <input id="proof_image" name="proof_image" type="file" class="sr-only" required
                                                accept="image/*">
                                        </label>
                                        <p class="pl-1">or drag and drop</p>
                                    </div>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">PNG, JPG, JPEG up to 2MB</p>
                                </div>
                            </div>
                            @error('proof_image')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex justify-end gap-4 mt-8">
                            <a href="{{ route('dashboard.orders') }}"
                                class="px-6 py-3 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm text-base font-medium text-gray-700 dark:text-gray-200 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                                Do it later
                            </a>
                            <button type="submit"
                                class="px-8 py-3 border border-transparent rounded-md shadow-sm text-base font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors">
                                Submit Proof
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
@endsection