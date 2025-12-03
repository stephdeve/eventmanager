@props(['header' => null, 'headerActions' => null])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? config('app.name', 'EventManager') }}</title>

    <link rel="icon" href="{{ asset('favicon.ico') }}">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

    <!-- Theme bootstrap to avoid FOUC -->
    <script>
        (function() {
            try {
                var ls = localStorage.getItem('theme');
                var prefersDark = window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;
                var theme = ls ? ls : (prefersDark ? 'dark' : 'light');
                if (!ls) localStorage.setItem('theme', theme);
                document.documentElement.classList.toggle('dark', theme === 'dark');
                window.toggleTheme = function(next) {
                    var current = document.documentElement.classList.contains('dark') ? 'dark' : 'light';
                    var target = next || (current === 'dark' ? 'light' : 'dark');
                    document.documentElement.classList.toggle('dark', target === 'dark');
                    localStorage.setItem('theme', target);
                    document.dispatchEvent(new CustomEvent('themechange', {
                        detail: target
                    }));
                };
            } catch (e) {}
        })();
    </script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>

<body
    class="font-sans antialiased min-h-screen flex flex-col bg-white text-neutral-800 dark:bg-neutral-950 dark:text-neutral-200">
    @include('layouts.navigation')

    <div class="flex-grow">
        @if ($header)
            <header class="bg-white shadow dark:bg-neutral-900 dark:border-b dark:border-neutral-800">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8 flex justify-between items-center">
                    <h2 class="text-2xl font-semibold text-gray-800 dark:text-neutral-100">
                        {{ $header }}
                    </h2>

                    @if ($headerActions)
                        <div>
                            {{ $headerActions }}
                        </div>
                    @endif
                </div>
            </header>
        @endif

        <main class="py-6">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                {{ $slot }}
            </div>
        </main>
    </div>

    <footer class="bg-white border-t border-gray-200 mt-12 dark:bg-neutral-900 dark:border-neutral-800">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <div class="text-sm text-neutral-500 dark:text-neutral-400">
                    &copy; {{ date('Y') }} {{ config('app.name', 'EventManager') }}. Tous droits réservés.
                </div>
                <div class="mt-4 md:mt-0 space-x-3 text-sm text-neutral-500 dark:text-neutral-400">
                    <a href="#" class="hover:text-neutral-700 dark:hover:text-neutral-300">Mentions légales</a>
                    <a href="#" class="hover:text-neutral-700 dark:hover:text-neutral-300">Confidentialité</a>
                    <a href="#" class="hover:text-neutral-700 dark:hover:text-neutral-300">Contact</a>
                </div>
            </div>
        </div>
    </footer>

    @stack('scripts')
    @livewireScripts
</body>

</html>
