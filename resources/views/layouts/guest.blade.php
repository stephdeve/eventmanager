<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>EventManager - Connexion</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Theme bootstrap -->
    <script>
        (function() {
            try {
                var ls = localStorage.getItem('theme');
                var prefersDark = window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;
                var theme = ls ? ls : (prefersDark ? 'dark' : 'light');
                if (!ls) localStorage.setItem('theme', theme);
                document.documentElement.classList.toggle('dark', theme === 'dark');
            } catch (e) {}
        })();
    </script>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased min-h-screen bg-white text-neutral-800 dark:bg-neutral-950 dark:text-neutral-200">
    <div class="min-h-screen flex flex-col sm:justify-center items-center px-4 py-12">
        <div
            class="w-full sm:max-w-md bg-white shadow-md overflow-hidden sm:rounded-lg dark:bg-neutral-900 dark:border dark:border-neutral-800">
            <div class="px-6 py-8">
                <div class="text-center mb-8">
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-neutral-100">EventManager</h1>
                    <p class="mt-2 text-sm text-gray-600 dark:text-neutral-400">Gestion d'événements simplifiée</p>
                </div>
                {{ $slot }}
            </div>
        </div>
    </div>
</body>

</html>
