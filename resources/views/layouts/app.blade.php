<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', config('app.name', 'EventManager'))</title>

    @stack('meta')

    <!-- Favicon -->
    <link rel="icon" href="{{ asset('favicon.ico') }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.bunny.net/css?family=sora:400,500,600,700&display=swap" rel="stylesheet" />

    <script>
        (function() {
            try {
                var ls = localStorage.getItem('theme');
                var prefersDark = window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;
                var theme = ls ? ls : (prefersDark ? 'dark' : 'light');
                if (!ls) localStorage.setItem('theme', theme);
                if (theme === 'dark') document.documentElement.classList.add('dark');
                else document.documentElement.classList.remove('dark');
                window.toggleTheme = function(next) {
                    var current = document.documentElement.classList.contains('dark') ? 'dark' : 'light';
                    var target = next || (current === 'dark' ? 'light' : 'dark');
                    document.documentElement.classList.toggle('dark', target === 'dark');
                    localStorage.setItem('theme', target);
                    document.dispatchEvent(new CustomEvent('themechange', {
                        detail: target
                    }));
                };
                var mq = window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)');
                if (mq && mq.addEventListener) {
                    mq.addEventListener('change', function(e) {
                        if (!localStorage.getItem('theme')) {
                            var t = e.matches ? 'dark' : 'light';
                            document.documentElement.classList.toggle('dark', t === 'dark');
                        }
                    });
                }
            } catch (e) {}
        })();
    </script>


    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @livewireStyles
    @stack('styles')
</head>

<body class="font-sans antialiased min-h-screen bg-white text-neutral-800 dark:bg-neutral-950 dark:text-neutral-200"
    x-data="{ sidebarOpen: false, sidebarCollapsed: window.innerWidth < 1024 }">
    <div x-data="{
        sidebarOpen: false,
        sidebarCollapsed: localStorage.getItem('sidebarCollapsed') === 'true',

        init() {
            // Synchroniser l'état initial
            this.$watch('sidebarCollapsed', (value) => {
                localStorage.setItem('sidebarCollapsed', value);
            });

            // Réinitialiser l'état collapse quand on navigue (optionnel)
            // Si vous voulez que le sidebar reste toujours étendu après navigation,
            // décommentez la ligne suivante :
            // this.sidebarCollapsed = false;
        },

        closeSidebar() {
            this.sidebarOpen = false;
        }
    }" @keydown.escape="sidebarOpen = false">
        <div class="flex h-screen">
            @include('layouts.sidebar')

            <div class="flex-1 flex flex-col overflow-hidden lg:ml-0 transition-all duration-300"
                :class="sidebarCollapsed ? 'lg:ml-16' : 'lg:ml-64'">
                @include('layouts.header')

                @if (session('success') || session('error') || $errors->any())
                    <div class="mx-4 mt-4">
                        @if (session('success'))
                            <div class="bg-green-100 border border-green-400 text-green-700 dark:bg-emerald-900/30 dark:border-emerald-700 dark:text-emerald-300 px-4 py-3 rounded-lg relative mb-4"
                                role="alert">
                                <span class="block sm:inline">{{ session('success') }}</span>
                            </div>
                        @endif

                        @if (session('error'))
                            <div class="bg-red-100 border border-red-400 text-red-700 dark:bg-red-900/30 dark:border-red-700 dark:text-red-300 px-4 py-3 rounded-lg relative mb-4"
                                role="alert">
                                <span class="block sm:inline">{{ session('error') }}</span>
                            </div>
                        @endif

                        @if ($errors->any())
                            <div class="bg-red-100 border border-red-400 text-red-700 dark:bg-red-900/30 dark:border-red-700 dark:text-red-300 px-4 py-3 rounded-lg relative mb-4"
                                role="alert">
                                <ul class="list-disc list-inside">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </div>
                @endif

                <main class="flex-1 overflow-y-auto p-4 lg:p-6">
                    {{ $slot ?? '' }}
                    @yield('content')
                </main>

                <footer
                    class="bg-white dark:bg-neutral-900 border-t border-neutral-200 dark:border-neutral-800 py-4 px-6">
                    <div class="flex flex-col sm:flex-row justify-between items-center space-y-2 sm:space-y-0">
                        <div class="text-sm text-neutral-500 dark:text-neutral-400">
                            &copy; {{ date('Y') }} {{ config('app.name', 'EventManager') }}. Tous droits réservés.
                        </div>
                        <div class="flex space-x-4 text-sm text-neutral-500 dark:text-neutral-400">

                        </div>
                    </div>
                </footer>
            </div>
        </div>

        @stack('scripts')

        @livewireScripts
        @auth
            <script>
                window.CURRENT_USER_ID = {{ (int) auth()->id() }};
                window.CURRENT_USER_NAME = @json(optional(auth()->user())->name ?? 'Utilisateur');
            </script>
        @endauth
        <div id="toast-container" class="fixed top-4 right-4 z-60"></div>
        <script>
            window.addEventListener('toast', function(e) {
                try {
                    const detail = e.detail || {};
                    const type = (detail.type || 'info').toString();
                    const message = (detail.message || '').toString();
                    const container = document.getElementById('toast-container') || document.body;
                    const toast = document.createElement('div');
                    const base = 'mb-2 max-w-sm z-60 px-4 py-3 rounded shadow text-white';
                    let bg = 'bg-gray-800';
                    if (type === 'success') bg = 'bg-emerald-600';
                    else if (type === 'error') bg = 'bg-red-600';
                    else if (type === 'warning') bg = 'bg-amber-600';
                    else if (type === 'info') bg = 'bg-indigo-600';
                    toast.className = `${base} ${bg}`;
                    toast.textContent = message;
                    container.appendChild(toast);
                    setTimeout(() => { toast.remove(); }, 4000);
                } catch (_) {}
            });
        </script>
        @if (session('toast'))
            <script>
                (function() {
                    const container = document.getElementById('toast-container') || document.body;
                    const toast = document.createElement('div');
                    toast.className = 'mb-2 max-w-sm z-60 bg-emerald-600 text-white px-4 py-3 rounded shadow';
                    toast.textContent = @json(session('toast'));
                    container.appendChild(toast);
                    setTimeout(() => {
                        toast.remove();
                    }, 4000);
                })();
            </script>
        @endif
</body>

</html>
