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

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased bg-gray-100">
        <div class="min-h-screen flex flex-col sm:justify-center items-center px-4 py-12">
            <div class="w-full sm:max-w-md bg-white shadow-md overflow-hidden sm:rounded-lg">
                <div class="px-6 py-8">
                    <div class="text-center mb-8">
                        <h1 class="text-2xl font-bold text-gray-900">EventManager</h1>
                        <p class="mt-2 text-sm text-gray-600">Gestion d'événements simplifiée</p>
                    </div>
                    {{ $slot }}
                </div>
            </div>
        </div>
    </body>
</html>
