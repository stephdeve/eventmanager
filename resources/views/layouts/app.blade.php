<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@yield('title', config('app.name', 'EventManager'))</title>

        <!-- Favicon -->
        <link rel="icon" href="{{ asset('favicon.ico') }}">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <!-- Additional CSS -->
        @stack('styles')
    </head>
    <body class="font-sans antialiased bg-gray-50 min-h-screen flex flex-col">
        <!-- Navigation -->
        @include('layouts.navigation')

        <!-- Page Content -->
        <div class="flex-grow">
            <!-- Page Heading -->
            @if (isset($header) && !request()->routeIs('home'))
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        <div class="flex justify-between items-center">
                            <h2 class="text-2xl font-semibold text-gray-800">
                                {{ $header }}
                            </h2>
                            @yield('header-actions')
                        </div>
                    </div>
                </header>
            @endif

            <!-- Flash Messages -->
            @if (session('success') || session('error') || $errors->any())
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
                    @if(session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                    @endif
                    
                    @if(session('error'))
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <span class="block sm:inline">{{ session('error') }}</span>
                        </div>
                    @endif
                    
                    @if($errors->any())
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <ul class="list-disc list-inside">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>
            @endif

            <!-- Main Content -->
            <main class="py-6">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    @yield('content')
                </div>
            </main>
        </div>

        <!-- Footer -->
        <footer class="bg-white border-t border-gray-200 mt-12">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                <div class="flex flex-col md:flex-row justify-between items-center">
                    <div class="text-sm text-gray-500">
                        &copy; {{ date('Y') }} {{ config('app.name', 'EventManager') }}. Tous droits réservés.
                    </div>
                    <div class="mt-4 md:mt-0">
                        {{-- <a href="#" class="text-sm text-gray-500 hover:text-gray-700">Mentions légales</a>
                        <span class="mx-2 text-gray-300">|</span>
                        <a href="#" class="text-sm text-gray-500 hover:text-gray-700">Confidentialité</a>
                        <span class="mx-2 text-gray-300">|</span>
                        <a href="#" class="text-sm text-gray-500 hover:text-gray-700">Contact</a> --}}
                    </div>
                </div>
            </div>
        </footer>

        <!-- Scripts -->
        @stack('scripts')
        
        <!-- Livewire Scripts -->
        {{-- @livewireScripts --}}
    </body>
</html>
