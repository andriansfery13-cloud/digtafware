<x-guest-layout>
    <div class="mb-8">
        <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Forgot password?</h2>
        <p class="text-gray-500 dark:text-gray-400 mt-1">No problem. Just let us know your email address and we will
            email you a password reset link.</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}" class="space-y-6">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" class="dark:text-gray-300" />
            <x-text-input id="email" class="block mt-1 w-full dark:bg-slate-900/50" type="email" name="email"
                :value="old('email')" required autofocus placeholder="name@company.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="pt-2">
            <x-primary-button
                class="w-full justify-center py-3 text-sm font-bold uppercase tracking-widest bg-emerald-600 hover:bg-emerald-700 active:bg-emerald-800 shadow-lg shadow-emerald-500/20">
                {{ __('Email Reset Link') }}
            </x-primary-button>
        </div>

        <div class="text-center">
            <a href="{{ route('login') }}"
                class="text-sm font-bold text-emerald-600 dark:text-emerald-400 hover:text-emerald-500">
                &larr; Back to login
            </a>
        </div>
    </form>
</x-guest-layout>