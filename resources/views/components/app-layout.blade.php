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

        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @stack('styles')
    </head>
    <body class="font-sans antialiased bg-gray-50 min-h-screen flex flex-col">
        @include('layouts.navigation')

        <div class="flex-grow">
            @if ($header)
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8 flex justify-between items-center">
                        <h2 class="text-2xl font-semibold text-gray-800">
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

        <footer class="bg-white border-t border-gray-200 mt-12">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                <div class="flex flex-col md:flex-row justify-between items-center">
                    <div class="text-sm text-gray-500">
                        &copy; {{ date('Y') }} {{ config('app.name', 'EventManager') }}. Tous droits réservés.
                    </div>
                    <div class="mt-4 md:mt-0 space-x-3 text-sm text-gray-500">
                        <a href="#" class="hover:text-gray-700">Mentions légales</a>
                        <a href="#" class="hover:text-gray-700">Confidentialité</a>
                        <a href="#" class="hover:text-gray-700">Contact</a>
                    </div>
                </div>
            </div>
        </footer>

        @stack('scripts')
        @livewireScripts
    </body>
</html>
