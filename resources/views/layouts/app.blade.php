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
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Additional CSS -->
    @stack('styles')
</head>

<body class="font-sans antialiased bg-gray-50 min-h-screen" x-data="{ sidebarOpen: false, sidebarCollapsed: window.innerWidth < 1024 }">
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
            <!-- Sidebar Navigation -->
            @include('layouts.sidebar')

            <!-- Main Content -->
            <div class="flex-1 flex flex-col overflow-hidden lg:ml-0 transition-all duration-300"
                :class="sidebarCollapsed ? 'lg:ml-16' : 'lg:ml-64'">
                <!-- Top Header -->
                @include('layouts.header')

                <!-- Flash Messages -->
                @if (session('success') || session('error') || $errors->any())
                    <div class="mx-4 mt-4">
                        @if (session('success'))
                            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg relative mb-4"
                                role="alert">
                                <span class="block sm:inline">{{ session('success') }}</span>
                            </div>
                        @endif

                        @if (session('error'))
                            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg relative mb-4"
                                role="alert">
                                <span class="block sm:inline">{{ session('error') }}</span>
                            </div>
                        @endif

                        @if ($errors->any())
                            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg relative mb-4"
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

                <!-- Page Content -->
                <main class="flex-1 overflow-y-auto p-4 lg:p-6">
                    @yield('content')
                </main>

                <!-- Footer -->
                <footer class="bg-white border-t border-gray-200 py-4 px-6">
                    <div class="flex flex-col sm:flex-row justify-between items-center space-y-2 sm:space-y-0">
                        <div class="text-sm text-gray-500">
                            &copy; {{ date('Y') }} {{ config('app.name', 'EventManager') }}. Tous droits réservés.
                        </div>
                        <div class="flex space-x-4 text-sm text-gray-500">
                            {{-- <a href="#" class="hover:text-gray-700 transition-colors">Mentions légales</a>
                            <a href="#" class="hover:text-gray-700 transition-colors">Confidentialité</a>
                            <a href="#" class="hover:text-gray-700 transition-colors">Contact</a> --}}
                        </div>
                    </div>
                </footer>
            </div>
        </div>

        <!-- Scripts -->
        @stack('scripts')

        <!-- Livewire Scripts -->
        {{-- @livewireScripts --}}
</body>

</html>
