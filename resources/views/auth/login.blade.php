<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <div class="mb-8">
        <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Welcome back</h2>
        <p class="text-gray-500 dark:text-gray-400 mt-1">Please enter your details to sign in.</p>
    </div>

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" class="dark:text-gray-300" />
            <x-text-input id="email" class="block mt-1 w-full dark:bg-slate-900/50" type="email" name="email"
                :value="old('email')" required autofocus autocomplete="username" placeholder="name@company.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div>
            <div class="flex items-center justify-between">
                <x-input-label for="password" :value="__('Password')" class="dark:text-gray-300" />
                @if (Route::has('password.request'))
                    <a class="text-xs font-semibold text-emerald-600 dark:text-emerald-400 hover:text-emerald-500"
                        href="{{ route('password.request') }}">
                        {{ __('Forgot password?') }}
                    </a>
                @endif
            </div>

            <x-text-input id="password" class="block mt-1 w-full dark:bg-slate-900/50" type="password" name="password"
                required autocomplete="current-password" placeholder="••••••••" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="flex items-center justify-between">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox"
                    class="rounded border-gray-300 dark:border-gray-700 bg-white dark:bg-slate-900 text-emerald-600 shadow-sm focus:ring-emerald-500"
                    name="remember">
                <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">{{ __('Remember me') }}</span>
            </label>
        </div>

        <div class="pt-2">
            <x-primary-button
                class="w-full justify-center py-3 text-sm font-bold uppercase tracking-widest bg-emerald-600 hover:bg-emerald-700 active:bg-emerald-800 shadow-lg shadow-emerald-500/20">
                {{ __('Sign In') }}
            </x-primary-button>
        </div>

        @if (Route::has('register'))
            <p class="text-center text-sm text-gray-600 dark:text-gray-400 mt-6">
                Don't have an account?
                <a href="{{ route('register') }}"
                    class="font-bold text-emerald-600 dark:text-emerald-400 hover:text-emerald-500">Sign up</a>
            </p>
        @endif
    </form>
</x-guest-layout>