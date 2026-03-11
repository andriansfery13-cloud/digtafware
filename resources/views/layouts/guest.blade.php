<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'DigtafWare') }}</title>

    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        .glass {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        .dark .glass {
            background: rgba(15, 23, 42, 0.7);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        @keyframes blob {
            0% {
                transform: translate(0px, 0px) scale(1);
            }

            33% {
                transform: translate(30px, -50px) scale(1.1);
            }

            66% {
                transform: translate(-20px, 20px) scale(0.9);
            }

            100% {
                transform: translate(0px, 0px) scale(1);
            }
        }

        .animate-blob {
            animation: blob 7s infinite;
        }

        .animation-delay-2000 {
            animation-delay: 2s;
        }

        .animation-delay-4000 {
            animation-delay: 4s;
        }
    </style>
</head>

<body class="font-sans text-gray-900 antialiased h-full overflow-hidden">
    <div
        class="min-h-screen relative flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8 bg-gray-50 dark:bg-slate-950">
        <!-- Animated Background Blobs -->
        <div
            class="absolute top-0 -left-4 w-72 h-72 bg-emerald-300 dark:bg-emerald-900 rounded-full mix-blend-multiply dark:mix-blend-overlay filter blur-xl opacity-70 dark:opacity-30 animate-blob">
        </div>
        <div
            class="absolute top-0 -right-4 w-72 h-72 bg-teal-300 dark:bg-teal-900 rounded-full mix-blend-multiply dark:mix-blend-overlay filter blur-xl opacity-70 dark:opacity-30 animate-blob animation-delay-2000">
        </div>
        <div
            class="absolute -bottom-8 left-20 w-72 h-72 bg-emerald-200 dark:bg-emerald-800 rounded-full mix-blend-multiply dark:mix-blend-overlay filter blur-xl opacity-70 dark:opacity-30 animate-blob animation-delay-4000">
        </div>

        <div class="relative w-full max-w-md">
            <div class="flex flex-col items-center mb-10">
                <a href="/" class="flex flex-col items-center">
                    <img src="{{ asset('assets/img/logo.png') }}" alt="DigtafWare Logo"
                        class="h-24 w-auto dark:invert mb-6 hover:scale-110 transition-transform duration-300">
                </a>
            </div>

            <div class="glass relative px-8 py-10 shadow-2xl rounded-3xl overflow-hidden">
                <div
                    class="absolute inset-0 bg-gradient-to-br from-white/40 to-white/10 dark:from-white/5 dark:to-transparent pointer-events-none">
                </div>
                <div class="relative">
                    {{ $slot }}
                </div>
            </div>

            <p class="mt-8 text-center text-sm text-gray-500 dark:text-gray-400">
                &copy; {{ date('Y') }} {{ config('app.name') }}. Built for developers.
            </p>
        </div>
    </div>
</body>

</html>