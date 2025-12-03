<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description"
        content="Là où les idées, les talents et les passions s'affrontent pour inspirer le monde. Rejoignez la plateforme événementielle immersive.">

    <title>EventManager - Là où les passions s'affrontent</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=poppins:400,500,600,700&family=inter:400,500,600,700&display=swap"
        rel="stylesheet" />

    <!-- Favicon -->
    <link rel="icon" href="{{ asset('favicon.ico') }}">

    <!-- Styles / Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])


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

    <style>
        /* Visual Identity */
        :root {
            --primary-gradient: linear-gradient(135deg, #6C63FF 0%, #00BFFF 100%);
            --accent-color: #FFD700;
            --bg-dark: #0A0A0F;
            --text-primary: #FFFFFF;
            --text-secondary: rgba(255, 255, 255, 0.8);
        }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--bg-dark);
            color: var(--text-primary);
            overflow-x: hidden;
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            font-family: 'Poppins', sans-serif;
        }

        /* Hero Section */
        .hero-section {
            position: relative;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        /* Floating Animation */
        @keyframes float {

            0%,
            100% {
                transform: translateY(0px) translateX(0px) scale(1);
                opacity: 0.3;
            }

            25% {
                transform: translateY(-20px) translateX(10px) scale(1.1);
                opacity: 0.6;
            }

            50% {
                transform: translateY(-10px) translateX(-5px) scale(0.9);
                opacity: 0.8;
            }

            75% {
                transform: translateY(-30px) translateX(15px) scale(1.05);
                opacity: 0.4;
            }
        }

        /* Particle Float Animation */
        @keyframes particleFloat {

            0%,
            100% {
                transform: translateY(0px) translateX(0px);
                opacity: 0;
            }

            10% {
                opacity: 0.6;
            }

            90% {
                opacity: 0.6;
            }

            100% {
                transform: translateY(-100vh) translateX(50px);
                opacity: 0;
            }
        }

        .particle {
            animation: particleFloat linear infinite;
        }

        .hero-background {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -2;
        }

        .hero-background video {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .hero-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg,
                    rgba(10, 10, 15, 0.7) 0%,
                    rgba(10, 10, 15, 0.8) 50%,
                    rgba(10, 10, 15, 0.9) 100%);
            backdrop-filter: blur(8px);
            z-index: -1;
        }

        .hero-content {
            position: relative;
            z-index: 1;
            text-align: center;
            max-width: 6xl;
            margin: 0 auto;
            padding: 0 2rem;
        }

        .hero-title {
            font-size: clamp(2.5rem, 5vw, 4rem);
            font-weight: 600;
            line-height: 1.2;
            margin-bottom: 1.5rem;
            background: linear-gradient(135deg, #FFFFFF 0%, #E0E7FF 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .hero-subtitle {
            font-size: clamp(1.1rem, 2vw, 1.3rem);
            color: var(--text-secondary);
            margin-bottom: 2rem;
            line-height: 1.6;
        }

        .cta-button {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 1rem 2rem;
            font-size: 1.1rem;
            font-weight: 500;
            border-radius: 0.75rem;
            text-decoration: none;
            transition: all 0.3s ease;
            margin: 0.5rem;
            position: relative;
            overflow: hidden;
        }

        .cta-button-primary {
            background: var(--primary-gradient);
            color: white;
            box-shadow: 0 8px 32px rgba(108, 99, 255, 0.3);
        }

        .cta-button-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 40px rgba(108, 99, 255, 0.4);
        }

        .cta-button-secondary {
            background: rgba(255, 255, 255, 0.1);
            color: white;
            border: 2px solid rgba(255, 255, 255, 0.3);
            backdrop-filter: blur(10px);
        }

        .cta-button-secondary:hover {
            background: rgba(255, 255, 255, 0.2);
            border-color: rgba(255, 255, 255, 0.5);
            transform: translateY(-2px);
        }

        /* Navigation */
        .nav-blur {
            backdrop-filter: blur(20px);
            background: rgba(10, 10, 15, 0.8);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .nav-link {
            color: var(--text-secondary);
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .nav-link:hover {
            color: var(--text-primary);
        }

        /* Floating animations */
        .floating {
            animation: float 6s ease-in-out infinite;
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-20px);
            }
        }

        /* Glow effects */
        .glow-violet {
            box-shadow: 0 0 30px rgba(108, 99, 255, 0.5);
        }

        .glow-violet:hover {
            box-shadow: 0 0 50px rgba(108, 99, 255, 0.8);
        }

        /* Glassmorphism */
        .glass-card {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 1rem;
        }

        .glass-card-gold {
            background: linear-gradient(135deg,
                    rgba(255, 215, 0, 0.15) 0%,
                    rgba(255, 215, 0, 0.05) 100%);
            backdrop-filter: blur(15px);
            border: 1px solid rgba(255, 215, 0, 0.3);
            border-radius: 1rem;
        }

        /* 3D Transform effect */
        .card-3d {
            transition: all 0.3s ease;
            transform-style: preserve-3d;
        }

        .card-3d:hover {
            transform: rotateY(5deg) translateY(-10px);
        }

        /* Counter animation */
        .counter {
            transition: all 0.5s ease;
        }

        /* Audio toggle */
        .audio-toggle {
            position: fixed;
            bottom: 2rem;
            right: 2rem;
            z-index: 100;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            width: 3rem;
            height: 3rem;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .audio-toggle:hover {
            background: rgba(255, 255, 255, 0.2);
            transform: scale(1.1);
        }

        /* Responsive */
        @media (max-width: 768px) {
            .hero-title {
                font-size: clamp(2rem, 4vw, 3rem);
            }

            .cta-button {
                padding: 0.875rem 1.5rem;
                font-size: 1rem;
                margin: 0.25rem;
            }
        }

        /* Dynamic enhancements */
        .reveal {
            opacity: 0;
            transform: translateY(20px) scale(0.98);
            filter: blur(2px);
            transition: opacity .8s cubic-bezier(0.4, 0, 0.2, 1), transform .8s cubic-bezier(0.4, 0, 0.2, 1), filter .8s;
        }

        .reveal.visible {
            opacity: 1;
            transform: translateY(0) scale(1);
            filter: blur(0);
        }

        .tilt-zone {
            will-change: transform;
            transform-style: preserve-3d;
        }

        .tilt-zone:hover {
            transition: transform .2s ease;
        }

        .pointer-none {
            pointer-events: none;
        }

        .nav-hide {
            transform: translateY(-110%);
        }

        #scroll-progress {
            position: fixed;
            top: 0;
            left: 0;
            height: 3px;
            width: 0;
            background: linear-gradient(90deg, #8B5CF6, #22D3EE);
            box-shadow: 0 0 12px rgba(139, 92, 246, 0.6);
            z-index: 60;
            transition: width .1s linear;
        }

        #hero-keyword {
            transition: opacity .25s ease;
        }

        @media (prefers-reduced-motion: reduce) {
            * {
                animation: none !important;
                transition: none !important;
            }
        }
    </style>
</head>

<body class="min-h-full bg-black overflow-x-hidden">
    <div id="scroll-progress"></div>
    <!-- Navigation Cohérente -->
    <nav class="fixed top-0 w-full z-50 transition-all duration-300" x-data="{
        scrolled: false,
        mobileMenuOpen: false,
        init() {
            window.addEventListener('scroll', () => {
                this.scrolled = window.scrollY > 20;
            });
        }
    }"
        :class="scrolled ? 'bg-black/90 backdrop-blur-lg border-b border-white/10 shadow-xl' : 'bg-transparent'">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Logo -->
                <div class="flex items-center">
                    <a href="{{ url('/') }}" class="group flex items-center space-x-3">
                        <div class="relative">
                            <div
                                class="absolute inset-0 bg-gradient-to-r from-violet-600 to-blue-500 rounded-lg blur-md group-hover:blur-lg transition-all duration-300 opacity-75 group-hover:opacity-100">
                            </div>
                            <div
                                class="relative flex items-center justify-center h-8 w-8 rounded-lg bg-gradient-to-r from-violet-600 to-blue-500 text-white font-bold shadow-md group-hover:shadow-lg transition-all duration-300">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 10V3L4 14h7v7l9-11h-7z" />
                                </svg>
                            </div>
                        </div>
                        <div>
                            <span
                                class="text-lg font-bold text-white group-hover:text-violet-200 transition-colors duration-300">EventManager</span>
                        </div>
                    </a>
                </div>

                <!-- Desktop Navigation -->
                <div class="hidden md:flex items-center space-x-2">
                    <a href="#features"
                        class="nav-item group relative px-4 py-2 text-sm font-medium text-gray-300 hover:text-white transition-all duration-300">
                        <span class="relative z-10">Fonctionnalités</span>
                        <div
                            class="absolute inset-0 bg-violet-600/20 rounded-lg scale-0 group-hover:scale-100 transition-transform duration-300">
                        </div>
                    </a>
                    <a href="#pricing"
                        class="nav-item group relative px-4 py-2 text-sm font-medium text-gray-300 hover:text-white transition-all duration-300">
                        <span class="relative z-10">Tarifs</span>
                        <div
                            class="absolute inset-0 bg-violet-600/20 rounded-lg scale-0 group-hover:scale-100 transition-transform duration-300">
                        </div>
                    </a>
                    <a href="#testimonials"
                        class="nav-item group relative px-4 py-2 text-sm font-medium text-gray-300 hover:text-white transition-all duration-300">
                        <span class="relative z-10">Avis</span>
                        <div
                            class="absolute inset-0 bg-violet-600/20 rounded-lg scale-0 group-hover:scale-100 transition-transform duration-300">
                        </div>
                    </a>

                    @auth
                        <a href="{{ route('dashboard') }}"
                            class="group relative px-4 py-2 text-sm font-medium text-violet-400 hover:text-violet-300 transition-all duration-300">
                            <span class="relative z-10 flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                                </svg>
                                Tableau de bord
                            </span>
                            <div
                                class="absolute inset-0 bg-violet-600/20 rounded-lg scale-0 group-hover:scale-100 transition-transform duration-300">
                            </div>
                        </a>
                    @else
                        <a href="{{ route('login') }}"
                            class="group relative px-4 py-2 text-sm font-medium text-gray-300 hover:text-white transition-all duration-300">
                            <span class="relative z-10">Connexion</span>
                            <div
                                class="absolute inset-0 bg-white/10 rounded-lg scale-0 group-hover:scale-100 transition-transform duration-300">
                            </div>
                        </a>
                        <a href="{{ route('register') }}"
                            class="group relative px-4 py-2 text-sm font-medium text-white bg-gradient-to-r from-violet-600 to-blue-500 hover:from-violet-700 hover:to-blue-700 rounded-lg shadow-md hover:shadow-lg transition-all duration-300">
                            <span class="relative z-10">S'inscrire</span>
                        </a>
                    @endauth

                    <x-theme-toggle />
                </div>

                <!-- Mobile menu button -->
                <div class="md:hidden flex items-center">
                    <button @click="mobileMenuOpen = !mobileMenuOpen"
                        class="relative p-2 rounded-lg text-gray-300 hover:text-white hover:bg-white/10 transition-all duration-300">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                :class="mobileMenuOpen ? 'hidden' : 'block'" d="M4 6h16M4 12h16M4 18h16" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                :class="mobileMenuOpen ? 'block' : 'hidden'" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Mobile menu -->
            <div x-show="mobileMenuOpen" x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0"
                x-transition:leave="transition ease-in duration-150"
                x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 -translate-y-2"
                class="md:hidden bg-black/90 backdrop-blur-lg rounded-xl mt-2 p-4 border border-white/10">
                <div class="flex flex-col space-y-2">
                    <div class="flex items-center justify-end mb-2">
                        <x-theme-toggle />
                    </div>
                    <a href="#features" @click="mobileMenuOpen = false"
                        class="block px-4 py-3 text-base font-medium text-gray-300 hover:text-white hover:bg-white/10 rounded-lg transition-all duration-300">
                        Fonctionnalités
                    </a>
                    <a href="#pricing" @click="mobileMenuOpen = false"
                        class="block px-4 py-3 text-base font-medium text-gray-300 hover:text-white hover:bg-white/10 rounded-lg transition-all duration-300">
                        Tarifs
                    </a>
                    <a href="#testimonials" @click="mobileMenuOpen = false"
                        class="block px-4 py-3 text-base font-medium text-gray-300 hover:text-white hover:bg-white/10 rounded-lg transition-all duration-300">
                        Avis
                    </a>
                    @auth
                        <a href="{{ route('dashboard') }}" @click="mobileMenuOpen = false"
                            class="block px-4 py-3 text-base font-medium text-violet-400 hover:text-violet-300 hover:bg-violet-600/20 rounded-lg transition-all duration-300">
                            Tableau de bord
                        </a>
                    @else
                        <a href="{{ route('login') }}" @click="mobileMenuOpen = false"
                            class="block px-4 py-3 text-base font-medium text-gray-300 hover:text-white hover:bg-white/10 rounded-lg transition-all duration-300">
                            Connexion
                        </a>
                        <a href="{{ route('register') }}" @click="mobileMenuOpen = false"
                            class="block px-4 py-3 text-base font-medium text-white bg-gradient-to-r from-violet-600 to-blue-500 hover:from-violet-700 hover:to-blue-700 rounded-lg transition-all duration-300">
                            S'inscrire
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section
        class="relative min-h-screen flex items-center justify-center overflow-hidden hero-section text-white pt-16">
        <!-- Background Image with Overlay -->
        <div class="absolute inset-0 bg-gradient-to-br from-black via-purple-900/20 to-black">
            <div class="absolute inset-0 bg-gradient-to-r from-violet-900/20 via-blue-900/20 to-indigo-900/20"></div>
            <img src="https://images.unsplash.com/photo-1472653431158-636457a7753f?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80"
                alt="" loading="lazy" decoding="async" fetchpriority="low"
                class="absolute inset-0 w-full h-full object-cover opacity-25" onerror="this.style.display='none'">
            <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/40 to-transparent"></div>

            <!-- Animated gradient overlay -->
            <div class="absolute inset-0 opacity-50">
                <div
                    class="absolute inset-0 bg-gradient-to-br from-violet-600/10 via-transparent to-blue-600/10 animate-pulse">
                </div>
            </div>
        </div>

        <!-- Animated Background Elements -->
        <div class="absolute top-20 left-10 w-72 h-72 bg-violet-600/20 rounded-full blur-3xl floating"></div>
        <div class="absolute bottom-20 right-10 w-96 h-96 bg-indigo-600/20 rounded-full blur-3xl floating"
            style="animation-delay: 2s;"></div>
        <div class="absolute top-1/2 left-1/4 w-64 h-64 bg-blue-600/10 rounded-full blur-2xl floating"
            style="animation-delay: 4s;"></div>

        <!-- Particle Animation -->
        <div class="absolute inset-0 overflow-hidden">
            <div class="particles absolute inset-0">
                <div class="particle absolute w-1 h-1 bg-white rounded-full opacity-50"
                    style="top: 20%; left: 10%; animation: float 8s infinite;"></div>
                <div class="particle absolute w-2 h-2 bg-violet-300 rounded-full opacity-40"
                    style="top: 30%; left: 80%; animation: float 12s infinite;"></div>
                <div class="particle absolute w-1 h-1 bg-blue-300 rounded-full opacity-60"
                    style="top: 60%; left: 20%; animation: float 10s infinite;"></div>
                <div class="particle absolute w-1 h-1 bg-white rounded-full opacity-30"
                    style="top: 80%; left: 70%; animation: float 15s infinite;"></div>
                <div class="particle absolute w-2 h-2 bg-indigo-300 rounded-full opacity-40"
                    style="top: 15%; left: 50%; animation: float 9s infinite;"></div>
                <div class="particle absolute w-1 h-1 bg-violet-200 rounded-full opacity-50"
                    style="top: 70%; left: 85%; animation: float 11s infinite;"></div>
                <div class="particle absolute w-1 h-1 bg-blue-200 rounded-full opacity-40"
                    style="top: 40%; left: 30%; animation: float 13s infinite;"></div>
                <div class="particle absolute w-2 h-2 bg-white rounded-full opacity-30"
                    style="top: 90%; left: 40%; animation: float 14s infinite;"></div>
            </div>
        </div>

        <div class="relative max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <!-- Badge -->
            <div
                class="inline-flex items-center space-x-2 bg-violet-600/30 backdrop-blur-md border border-violet-400/30 px-4 py-2 rounded-full text-sm font-medium text-white mb-8 shadow-lg shadow-violet-600/20">
                <span class="w-2 h-2 bg-violet-400 rounded-full animate-pulse"></span>
                <span>🎯 Plateforme événementielle tout-en-un</span>
            </div>

            <!-- Main Heading -->
            <h1 class="text-4xl sm:text-5xl lg:text-6xl font-bold mb-6 leading-tight">
                Organisez des événements
                <span id="hero-keyword"
                    class="block bg-gradient-to-r from-white to-indigo-100 bg-clip-text text-transparent">mémorables</span>
            </h1>

            <!-- Subtitle -->
            <p class="text-lg sm:text-xl text-indigo-100 max-w-2xl mx-auto mb-8 leading-relaxed">
                Créez, gérez et promouvez vos événements avec notre plateforme intuitive.
                <span class="font-semibold text-white">Simplifiez l'organisation, maximisez l'impact.</span>
            </p>

            <!-- CTA Buttons -->
            <div class="flex flex-col sm:flex-row gap-4 justify-center items-center mb-12">
                @auth
                    <a href="{{ route('events.create') }}"
                        class="group inline-flex items-center justify-center px-8 py-4 text-base font-medium text-white bg-gradient-to-r from-violet-600 to-indigo-600 hover:from-violet-700 hover:to-indigo-700 rounded-xl transition-all duration-300 shadow-xl shadow-violet-600/30 hover:shadow-2xl hover:shadow-violet-600/40 transform hover:-translate-y-1">
                        <svg class="w-5 h-5 mr-2 group-hover:rotate-90 transition-transform duration-300" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        Créer un événement
                    </a>
                @else
                    <a href="{{ route('register') }}"
                        class="group inline-flex items-center justify-center px-8 py-4 text-base font-medium text-white bg-gradient-to-r from-violet-600 to-indigo-600 hover:from-violet-700 hover:to-indigo-700 rounded-xl transition-all duration-300 shadow-xl shadow-violet-600/30 hover:shadow-2xl hover:shadow-violet-600/40 transform hover:-translate-y-1">
                        Commencer gratuitement
                        <svg class="w-5 h-5 ml-2 group-hover:translate-x-1 transition-transform duration-300"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 7l5 5m0 0l-5 5m5-5H6" />
                        </svg>
                    </a>
                @endauth
                <a href="#features"
                    class="group inline-flex items-center justify-center px-8 py-4 text-base font-medium text-white border-2 border-white/40 hover:border-white/60 bg-white/10 backdrop-blur-sm hover:bg-white/20 rounded-xl transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                    Voir les fonctionnalités
                    <svg class="w-5 h-5 ml-2 group-hover:translate-y-1 transition-transform duration-300"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 14l-7 7m0 0l-7-7m7 7V3" />
                    </svg>
                </a>
            </div>

            <!-- Stats (dynamic) -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6 max-w-2xl mx-auto">
                <div
                    class="group text-center bg-white/10 backdrop-blur-md rounded-xl p-6 border border-white/20 hover:bg-white/15 transition-all duration-300">
                    <div class="text-3xl font-bold text-white group-hover:scale-110 transition-transform duration-300">
                        {{ number_format($stats['events'] ?? 0, 0, ',', ' ') }}</div>
                    <div class="text-indigo-200 text-sm mt-1">Événements</div>
                </div>
                <div
                    class="group text-center bg-white/10 backdrop-blur-md rounded-xl p-6 border border-white/20 hover:bg-white/15 transition-all duration-300">
                    <div class="text-3xl font-bold text-white group-hover:scale-110 transition-transform duration-300">
                        {{ number_format($stats['upcoming'] ?? 0, 0, ',', ' ') }}</div>
                    <div class="text-indigo-200 text-sm mt-1">À venir</div>
                </div>
                <div
                    class="group text-center bg-white/10 backdrop-blur-md rounded-xl p-6 border border-white/20 hover:bg-white/15 transition-all duration-300">
                    <div class="text-3xl font-bold text-white group-hover:scale-110 transition-transform duration-300">
                        {{ number_format($stats['participants'] ?? 0, 0, ',', ' ') }}</div>
                    <div class="text-indigo-200 text-sm mt-1">Participants</div>
                </div>
                <div
                    class="group text-center bg-white/10 backdrop-blur-md rounded-xl p-6 border border-white/20 hover:bg-white/15 transition-all duration-300">
                    <div class="text-3xl font-bold text-white group-hover:scale-110 transition-transform duration-300">
                        {{ number_format($stats['tickets_sold'] ?? 0, 0, ',', ' ') }}</div>
                    <div class="text-indigo-200 text-sm mt-1">Billets vendus</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="py-20 bg-black section-pattern">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl sm:text-4xl font-bold text-white">
                    Des outils <span class="gradient-text">puissants</span> pour vos événements
                </h2>
                <p class="mt-4 text-lg text-gray-300 max-w-2xl mx-auto">
                    Tout ce dont vous avez besoin pour créer, promouvoir et gérer des événements exceptionnels
                </p>
            </div>

            <!-- Main Feature -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center mb-16">
                <div>
                    <div class="flex items-center space-x-2 text-violet-400 font-medium text-sm mb-4">
                        <div class="w-2 h-2 bg-gradient-to-r from-violet-600 to-blue-500 rounded-full"></div>
                        <span>CRÉATION SIMPLIFIÉE</span>
                    </div>
                    <h3 class="text-2xl font-bold text-white mb-4">Créez des événements en quelques clics</h3>
                    <p class="text-gray-300 mb-6 leading-relaxed">
                        Notre interface intuitive vous guide pas à pas dans la création de votre événement.
                        Personnalisez tous les détails et lancez-vous en toute confiance.
                    </p>
                    <ul class="space-y-3">
                        <li class="flex items-center text-gray-300">
                            <svg class="h-4 w-4 text-indigo-500 mr-2" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                            Éditeur visuel drag & drop
                        </li>
                        <li class="flex items-center text-gray-300">
                            <svg class="h-4 w-4 text-indigo-500 mr-2" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                            Modèles personnalisables
                        </li>
                        <li class="flex items-center text-gray-300">
                            <svg class="h-4 w-4 text-indigo-500 mr-2" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                            Intégration de paiement
                        </li>
                    </ul>
                </div>
                <div class="relative">
                    <div
                        class="bg-gradient-to-br from-indigo-500 to-indigo-600 rounded-2xl p-6 text-white card-hover shadow-xl">
                        <div class="grid grid-cols-2 gap-4">
                            <div class="bg-black/10 rounded-xl p-4 backdrop-blur-sm">
                                <div class="text-xl font-bold">📅</div>
                                <div class="text-sm mt-1">Planification</div>
                            </div>
                            <div class="bg-black/10 rounded-xl p-4 backdrop-blur-sm">
                                <div class="text-xl font-bold">🎫</div>
                                <div class="text-sm mt-1">Billeterie</div>
                            </div>
                            <div class="bg-black/10 rounded-xl p-4 backdrop-blur-sm">
                                <div class="text-xl font-bold">📊</div>
                                <div class="text-sm mt-1">Analytics</div>
                            </div>
                            <div class="bg-black/10 rounded-xl p-4 backdrop-blur-sm">
                                <div class="text-xl font-bold">👥</div>
                                <div class="text-sm mt-1">Participants</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Features Grid -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Feature 1 -->
                <div class="bg-gray-800 rounded-xl p-6 border border-gray-700 card-hover">
                    <div class="flex items-center justify-center h-12 w-12 rounded-lg feature-icon text-white mb-4">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-white mb-2">Sécurité maximale</h3>
                    <p class="text-gray-300 text-sm leading-relaxed">
                        Vos données et transactions sont protégées par les meilleures standards de sécurité.
                    </p>
                </div>

                <!-- Feature 2 -->
                <div class="bg-gray-800 rounded-xl p-6 border border-gray-700 card-hover">
                    <div class="flex items-center justify-center h-12 w-12 rounded-lg feature-icon text-white mb-4">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-white mb-2">Performance optimale</h3>
                    <p class="text-gray-300 text-sm leading-relaxed">
                        Temps de chargement ultra-rapide pour une expérience utilisateur fluide.
                    </p>
                </div>

                <!-- Feature 3 -->
                <div class="bg-gray-800 rounded-xl p-6 border border-gray-700 card-hover">
                    <div class="flex items-center justify-center h-12 w-12 rounded-lg feature-icon text-white mb-4">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-white mb-2">Gestion d'équipe</h3>
                    <p class="text-gray-300 text-sm leading-relaxed">
                        Collaborez avec votre équipe et assignez des rôles spécifiques à chaque membre.
                    </p>
                </div>
            </div>
        </div>
    </section>

    @if ($highlightedEvents->isNotEmpty())
        <section id="highlights" class="py-20 bg-black">
            <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-end justify-between mb-8">
                    <div>
                        <h2 class="text-3xl sm:text-4xl font-bold text-white">Événements à venir</h2>
                        <p class="mt-2 text-gray-300">Découvrez les prochains rendez-vous</p>
                    </div>
                    <a href="{{ route('events.index') }}"
                        class="hidden md:inline-flex cta-button cta-button-secondary">Tous les événements</a>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($highlightedEvents as $ev)
                        <a href="{{ route('events.show', $ev) }}"
                            class="group block bg-white/10 backdrop-blur-md rounded-2xl overflow-hidden border border-white/10 hover:border-white/20 transition-all card-hover">
                            <div class="aspect-video relative overflow-hidden">
                                <img src="{{ $ev->cover_image_url }}" alt="{{ $ev->title }}" loading="lazy"
                                    decoding="async"
                                    class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                                <div
                                    class="absolute bottom-3 left-3 right-3 text-white text-xs sm:text-sm flex flex-wrap items-center gap-2">
                                    <span
                                        class="px-2 py-1 rounded bg-white/10 backdrop-blur-sm">{{ $ev->category ?? 'Événement' }}</span>
                                    <span
                                        class="px-2 py-1 rounded bg-white/10 backdrop-blur-sm">{{ optional($ev->start_date)->format('d/m/Y H:i') }}</span>
                                </div>
                            </div>
                            <div class="p-4">
                                <h3 class="text-white font-semibold mb-1 truncate">{{ $ev->title }}</h3>
                                <div class="text-gray-300 text-sm mb-3">
                                    {{ \Illuminate\Support\Str::limit(strip_tags($ev->description ?? ''), 90) }}</div>
                                <div class="flex items-center justify-between text-sm text-indigo-100">
                                    <span class="font-medium">{{ $ev->price_for_display ?? 'Gratuit' }}</span>
                                    <span class="opacity-80 truncate max-w-[50%]">{{ $ev->location ?? '' }}</span>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
                <div class="mt-8 text-center md:hidden">
                    <a href="{{ route('events.index') }}" class="cta-button cta-button-secondary">Tous les
                        événements</a>
                </div>
            </div>
        </section>
    @endif

    <!-- Pricing Section -->
    <section id="pricing" class="py-20 bg-gray-900">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl sm:text-4xl font-bold text-white">
                    Des tarifs <span class="gradient-text">adaptés</span> à vos besoins
                </h2>
                <p class="mt-4 text-lg text-gray-300 max-w-2xl mx-auto">
                    Choisissez la formule qui correspond à votre ambition
                </p>

                <!-- Billing Toggle -->
                <div class="mt-8 flex justify-center">
                    <div class="relative bg-gray-800 rounded-lg p-1 shadow-sm border border-gray-700">
                        <div class="flex">
                            <button type="button"
                                class="relative py-2 px-6 text-sm font-medium text-white rounded-md billing-toggle active"
                                data-billing="monthly">
                                Mensuel
                            </button>
                            <button type="button"
                                class="relative py-2 px-6 text-sm font-medium text-gray-300 rounded-md billing-toggle"
                                data-billing="yearly">
                                Annuel <span
                                    class="ml-1 px-2 py-1 text-xs bg-green-600 text-green-100 rounded-full">-20%</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 max-w-4xl mx-auto">
                <!-- Basic Plan -->
                <div class="bg-gray-800 rounded-xl border border-gray-700 p-6 card-hover">
                    <div class="text-center mb-6">
                        <h3 class="text-xl font-bold text-white">Basique</h3>
                        <p class="mt-2 text-gray-400 text-sm">Idéal pour débuter</p>

                        <div class="mt-4">
                            <div class="monthly-price">
                                <span class="text-3xl font-bold text-white">30 000</span>
                                <span class="text-gray-400 text-sm">FCFA/mois</span>
                            </div>
                            <div class="yearly-price hidden">
                                <span class="text-3xl font-bold text-white">288 000</span>
                                <span class="text-gray-400 text-sm">FCFA/an</span>
                                <div class="text-xs text-green-400 font-medium mt-1">Économisez 72 000 FCFA</div>
                            </div>
                        </div>
                    </div>

                    <ul class="mt-6 space-y-3 text-sm text-gray-300">
                        <li class="flex items-center">
                            <svg class="h-4 w-4 text-green-400 mr-2" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                            50 places max par événement
                        </li>
                        <li class="flex items-center">
                            <svg class="h-4 w-4 text-green-400 mr-2" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                            10 événements par mois
                        </li>
                        <li class="flex items-center">
                            <svg class="h-4 w-4 text-green-400 mr-2" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                            Billets QR Code
                        </li>
                        <li class="flex items-center">
                            <svg class="h-4 w-4 text-green-400 mr-2" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                            Support par email
                        </li>
                    </ul>

                    <div class="mt-6 pt-6 border-t border-gray-700">
                        <a href="{{ route('subscriptions.plans', ['plan' => 'basic']) }}"
                            class="w-full inline-flex items-center justify-center bg-gray-700 text-white py-2 px-4 rounded-lg font-medium hover:bg-gray-600 transition-colors">
                            Choisir ce plan
                        </a>
                    </div>
                </div>

                <!-- Premium Plan -->
                <div class="bg-gray-800 rounded-xl border-2 border-violet-600 p-6 card-hover pricing-card featured">
                    <div class="text-center mb-6">
                        <h3 class="text-xl font-bold text-white">Premium</h3>
                        <p class="mt-2 text-gray-400 text-sm">Pour monter en puissance</p>

                        <div class="mt-4">
                            <div class="monthly-price">
                                <span class="text-3xl font-bold text-white">60 000</span>
                                <span class="text-gray-400 text-sm">FCFA/mois</span>
                            </div>
                            <div class="yearly-price hidden">
                                <span class="text-3xl font-bold text-white">576 000</span>
                                <span class="text-gray-400 text-sm">FCFA/an</span>
                                <div class="text-xs text-green-400 font-medium mt-1">Économisez 144 000 FCFA</div>
                            </div>
                        </div>
                    </div>

                    <ul class="mt-6 space-y-3 text-sm text-gray-300">
                        <li class="flex items-center">
                            <svg class="h-4 w-4 text-green-400 mr-2" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                            200 places max par événement
                        </li>
                        <li class="flex items-center">
                            <svg class="h-4 w-4 text-green-400 mr-2" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                            Événements illimités
                        </li>
                        <li class="flex items-center">
                            <svg class="h-4 w-4 text-green-400 mr-2" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                            Billets QR Code + VIP
                        </li>
                        <li class="flex items-center">
                            <svg class="h-4 w-4 text-green-400 mr-2" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                            Support prioritaire 24/7
                        </li>
                        <li class="flex items-center">
                            <svg class="h-4 w-4 text-green-400 mr-2" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                            Analytics avancés
                        </li>
                    </ul>

                    <div class="mt-6 pt-6 border-t border-gray-700">
                        <a href="{{ route('subscriptions.plans', ['plan' => 'premium']) }}"
                            class="w-full inline-flex items-center justify-center bg-violet-600 text-white py-2 px-4 rounded-lg font-medium hover:bg-violet-700 transition-colors">
                            Choisir ce plan
                        </a>
                    </div>
                </div>

                <!-- Enterprise Plan -->
                <div class="bg-gray-800 rounded-xl border border-gray-700 p-6 card-hover">
                    <div class="text-center mb-6">
                        <h3 class="text-xl font-bold text-white">Enterprise</h3>
                        <p class="mt-2 text-gray-400 text-sm">Pour les organisations</p>

                        <div class="mt-4">
                            <div class="monthly-price">
                                <span class="text-3xl font-bold text-white">120 000</span>
                                <span class="text-gray-400 text-sm">FCFA/mois</span>
                            </div>
                            <div class="yearly-price hidden">
                                <span class="text-3xl font-bold text-white">1 152 000</span>
                                <span class="text-gray-400 text-sm">FCFA/an</span>
                                <div class="text-xs text-green-400 font-medium mt-1">Économisez 288 000 FCFA</div>
                            </div>
                        </div>
                    </div>

                    <ul class="mt-6 space-y-3 text-sm text-gray-300">
                        <li class="flex items-center">
                            <svg class="h-4 w-4 text-green-400 mr-2" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                            Places illimitées
                        </li>
                        <li class="flex items-center">
                            <svg class="h-4 w-4 text-green-400 mr-2" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                            Événements illimités
                        </li>
                        <li class="flex items-center">
                            <svg class="h-4 w-4 text-green-400 mr-2" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                            Billets personnalisés
                        </li>
                        <li class="flex items-center">
                            <svg class="h-4 w-4 text-green-400 mr-2" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                            Support dédié
                        </li>
                        <li class="flex items-center">
                            <svg class="h-4 w-4 text-green-400 mr-2" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                            API & intégrations
                        </li>
                        <li class="flex items-center">
                            <svg class="h-4 w-4 text-green-400 mr-2" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                            SLA garanti
                        </li>
                    </ul>

                    <div class="mt-6 pt-6 border-t border-gray-700">
                        <a href="{{ route('subscriptions.plans', ['plan' => 'pro']) }}"
                            class="w-full inline-flex items-center justify-center bg-gray-700 text-white py-2 px-4 rounded-lg font-medium hover:bg-gray-600 transition-colors">
                            Contactez-nous
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section id="testimonials" class="py-20 bg-black">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl sm:text-4xl font-bold text-white">
                    Ils nous <span class="gradient-text">font confiance</span>
                </h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @if (isset($testimonials) && $testimonials->isNotEmpty())
                    @foreach ($testimonials->take(3) as $review)
                        <div class="testimonial-card rounded-xl p-6 border border-gray-200 card-hover">
                            <div class="flex items-center mb-4">
                                <div class="text-lg">
                                    @php $stars = max(1, min(5, (int) ($review->rating ?? 5))); @endphp
                                    {!! str_repeat('⭐️', $stars) !!}
                                </div>
                            </div>
                            <p class="text-gray-300 text-sm mb-4 italic">
                                "{{ \Illuminate\Support\Str::limit(strip_tags($review->comment ?? ''), 160) }}"
                            </p>
                            <div class="flex items-center">
                                @if ($review->user && $review->user->avatar_url)
                                    <img src="{{ $review->user->avatar_url }}" alt="{{ $review->user->name }}"
                                        class="h-10 w-10 rounded-full mr-3 object-cover">
                                @else
                                    <div
                                        class="h-10 w-10 bg-indigo-100 rounded-full flex items-center justify-center text-violet-400 font-medium mr-3">
                                        {{ \Illuminate\Support\Str::upper(\Illuminate\Support\Str::substr($review->user->name ?? '??', 0, 2)) }}
                                    </div>
                                @endif
                                <div>
                                    <div class="font-medium text-white">{{ $review->user->name ?? 'Utilisateur' }}
                                    </div>
                                    <div class="text-xs text-gray-500">{{ $review->event->title ?? 'Événement' }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="testimonial-card rounded-xl p-6 border border-gray-200 card-hover">
                        <div class="flex items-center mb-4">
                            <div class="text-lg">⭐️⭐️⭐️⭐️⭐️</div>
                        </div>
                        <p class="text-gray-300 text-sm mb-4 italic">"EventManager a révolutionné notre façon
                            d'organiser des conférences. Simple, efficace et professionnel."</p>
                        <div class="flex items-center">
                            <div
                                class="h-10 w-10 bg-indigo-100 rounded-full flex items-center justify-center text-violet-400 font-medium mr-3">
                                MS</div>
                            <div>
                                <div class="font-medium text-white">Marie Simon</div>
                                <div class="text-xs text-gray-500">Organisatrice d'événements</div>
                            </div>
                        </div>
                    </div>
                    <div class="testimonial-card rounded-xl p-6 border border-gray-200 card-hover">
                        <div class="flex items-center mb-4">
                            <div class="text-lg">⭐️⭐️⭐️⭐️⭐️</div>
                        </div>
                        <p class="text-gray-300 text-sm mb-4 italic">"La gestion des billets et des participants est
                            incroyablement fluide. Un gain de temps considérable !"</p>
                        <div class="flex items-center">
                            <div
                                class="h-10 w-10 bg-indigo-100 rounded-full flex items-center justify-center text-violet-400 font-medium mr-3">
                                TP</div>
                            <div>
                                <div class="font-medium text-white">Thomas Petit</div>
                                <div class="text-xs text-gray-500">Responsable événements</div>
                            </div>
                        </div>
                    </div>
                    <div class="testimonial-card rounded-xl p-6 border border-gray-200 card-hover">
                        <div class="flex items-center mb-4">
                            <div class="text-lg">⭐️⭐️⭐️⭐️⭐️</div>
                        </div>
                        <p class="text-gray-300 text-sm mb-4 italic">"Le support client est exceptionnel. Ils nous
                            accompagnent à chaque étape de nos événements."</p>
                        <div class="flex items-center">
                            <div
                                class="h-10 w-10 bg-indigo-100 rounded-full flex items-center justify-center text-violet-400 font-medium mr-3">
                                LC</div>
                            <div>
                                <div class="font-medium text-white">Laura Chen</div>
                                <div class="text-xs text-gray-500">CEO, Startup Week</div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </section>

    <!-- Why Join Us Section -->
    <section id="why-join" class="py-24 bg-black">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-4xl sm:text-5xl font-bold text-white mb-6">
                    Pourquoi nous <span
                        class="bg-gradient-to-r from-amber-400 to-yellow-400 bg-clip-text text-transparent">rejoindre</span>
                </h2>
                <p class="text-xl text-gray-300 max-w-3xl mx-auto">
                    Trois raisons qui font toute la différence
                </p>
            </div>

            <!-- Golden Cards Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Community Card -->
                <div class="glass-card-gold p-8 text-center card-3d group">
                    <div
                        class="w-20 h-20 mx-auto mb-6 rounded-2xl bg-gradient-to-br from-amber-400 to-yellow-500 flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-10 h-10 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-white mb-4">🌍 Une communauté vibrante et inclusive</h3>
                    <p class="text-gray-300 mb-6 leading-relaxed">
                        Connecte-toi avec des passionnés à travers l'Afrique et le monde.
                        Des talents divers, des cultures riches, des opportunités infinies.
                    </p>
                    <div class="flex items-center justify-center space-x-4 text-sm text-gray-400">
                        <div class="flex items-center">
                            <span class="w-2 h-2 bg-green-400 rounded-full mr-2"></span>
                            50+ pays
                        </div>
                        <div class="flex items-center">
                            <span class="w-2 h-2 bg-blue-400 rounded-full mr-2"></span>
                            1000+ villes
                        </div>
                    </div>
                </div>

                <!-- Opportunities Card -->
                <div class="glass-card-gold p-8 text-center card-3d group">
                    <div
                        class="w-20 h-20 mx-auto mb-6 rounded-2xl bg-gradient-to-br from-amber-400 to-yellow-500 flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-10 h-10 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-white mb-4">💪 Des opportunités et des récompenses réelles</h3>
                    <p class="text-gray-300 mb-6 leading-relaxed">
                        Gagne plus que du prestige : expériences, partenariats, visibilité.
                        Transforme ton talent en carrière, ta passion en projet.
                    </p>
                    <div class="flex items-center justify-center space-x-4 text-sm text-gray-400">
                        <div class="flex items-center">
                            <span class="w-2 h-2 bg-amber-400 rounded-full mr-2"></span>
                            Prix en espèces
                        </div>
                        <div class="flex items-center">
                            <span class="w-2 h-2 bg-emerald-400 rounded-full mr-2"></span>
                            Contrats pro
                        </div>
                    </div>
                </div>

                <!-- Experience Card -->
                <div class="glass-card-gold p-8 text-center card-3d group">
                    <div
                        class="w-20 h-20 mx-auto mb-6 rounded-2xl bg-gradient-to-br from-amber-400 to-yellow-500 flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-10 h-10 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-white mb-4">🚀 Une expérience immersive et innovante</h3>
                    <p class="text-gray-300 mb-6 leading-relaxed">
                        Vote, assiste à des lives, interagis en temps réel.
                        Une plateforme technologique de pointe pour des moments inoubliables.
                    </p>
                    <div class="flex items-center justify-center space-x-4 text-sm text-gray-400">
                        <div class="flex items-center">
                            <span class="w-2 h-2 bg-violet-400 rounded-full mr-2"></span>
                            Temps réel
                        </div>
                        <div class="flex items-center">
                            <span class="w-2 h-2 bg-rose-400 rounded-full mr-2"></span>
                            Interactions
                        </div>
                    </div>
                </div>
            </div>

            <!-- Join CTA -->
            <div class="mt-16 text-center">
                <p class="text-gray-400 mb-6">Prêt à faire partie de l'aventure ?</p>
                <a href="#featured-event" class="cta-button cta-button-primary">
                    Rejoindre maintenant →
                </a>
            </div>
        </div>
    </section>

    <!-- Featured Event Section -->
    <section id="featured-event" class="py-24 bg-gradient-to-b from-gray-900 to-black relative overflow-hidden">
        <!-- Background Effects -->
        <div class="absolute inset-0 opacity-20">
            <div class="absolute top-0 left-1/4 w-96 h-96 bg-orange-500 rounded-full blur-3xl"></div>
            <div class="absolute bottom-0 right-1/4 w-96 h-96 bg-red-500 rounded-full blur-3xl"></div>
        </div>

        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <!-- Event Header -->
            <div class="text-center mb-12">
                <div class="inline-flex items-center space-x-2 glass-card px-6 py-3 rounded-full mb-6">
                    <span class="w-3 h-3 bg-red-500 rounded-full animate-pulse"></span>
                    <span class="text-white font-medium">🔥 Événement spécial</span>
                </div>
                <h2 class="text-5xl sm:text-6xl font-bold text-white mb-6">
                    {{ $featuredEvent->title ?? 'Bientôt un grand événement' }}
                </h2>
                @if ($featuredEvent)
                    <p class="text-2xl text-gray-300 font-medium mb-4">
                        {{ optional($featuredEvent->start_date)->format('d/m/Y H:i') }} @if ($featuredEvent->location)
                            • {{ $featuredEvent->location }}
                        @endif
                    </p>
                    <p class="text-lg text-gray-400 max-w-3xl mx-auto">
                        {{ \Illuminate\Support\Str::limit(strip_tags($featuredEvent->description ?? ''), 200) }}
                    </p>
                @else
                    <p class="text-lg text-gray-400 max-w-3xl mx-auto">Aucun événement n'est encore programmé.
                        Consultez la liste pour découvrir les prochaines dates.</p>
                @endif
            </div>

            <!-- Countdown Timer -->
            @if ($featuredEvent)
                <div class="glass-card p-8 mb-12" x-data="{
                    days: 0,
                    hours: 0,
                    minutes: 0,
                    seconds: 0,
                    eventTime: new Date('{{ optional($featuredEvent->start_date)->format('c') }}'),
                    init() {
                        const update = () => {
                            const now = new Date();
                            let diff = Math.max(0, Math.floor((this.eventTime - now) / 1000));
                            this.days = Math.floor(diff / 86400);
                            diff %= 86400;
                            this.hours = Math.floor(diff / 3600);
                            diff %= 3600;
                            this.minutes = Math.floor(diff / 60);
                            this.seconds = diff % 60;
                        };
                        update();
                        setInterval(update, 1000);
                    }
                }">
                    <div class="text-center mb-6">
                        <h3 class="text-2xl font-bold text-white mb-2">L'événement commence dans</h3>
                        <div class="flex items-center justify-center space-x-2">
                            <div class="text-4xl md:text-5xl font-bold text-white mb-2" x-text="days"></div>
                            <div class="text-sm text-gray-400 uppercase tracking-wider">Jours</div>
                        </div>
                        <div class="flex items-center justify-center space-x-2">
                            <div class="text-4xl md:text-5xl font-bold text-white mb-2"
                                x-text="String(hours).padStart(2, '0')"></div>
                            <div class="text-sm text-gray-400 uppercase tracking-wider">Heures</div>
                        </div>
                        <div class="flex items-center justify-center space-x-2">
                            <div class="text-4xl md:text-5xl font-bold text-white mb-2"
                                x-text="String(minutes).padStart(2, '0')"></div>
                            <div class="text-sm text-gray-400 uppercase tracking-wider">Minutes</div>
                        </div>
                        <div class="flex items-center justify-center space-x-2">
                            <div class="text-4xl md:text-5xl font-bold text-white mb-2"
                                x-text="String(seconds).padStart(2, '0')"></div>
                            <div class="text-sm text-gray-400 uppercase tracking-wider">Secondes</div>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Event Visual -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center mb-12">
                <div class="relative">
                    <div class="aspect-video rounded-2xl overflow-hidden bg-gradient-to-br from-red-600 to-orange-600">
                        <img src="{{ $featuredEvent->cover_image_url ?? null ?: asset('images/event-default.jpg') }}"
                            alt="{{ $featuredEvent->title ?? 'Événement' }}" class="w-full h-full object-cover">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent"></div>
                        <div class="absolute bottom-6 left-6 right-6">
                            <div class="flex items-center space-x-4">
                                <div class="flex -space-x-2">
                                    <div class="w-8 h-8 rounded-full bg-violet-500 border-2 border-white"></div>
                                    <div class="w-8 h-8 rounded-full bg-blue-500 border-2 border-white"></div>
                                    <div class="w-8 h-8 rounded-full bg-emerald-500 border-2 border-white"></div>
                                    <div class="w-8 h-8 rounded-full bg-amber-500 border-2 border-white"></div>
                                </div>
                                @if ($featuredEvent)
                                    <span
                                        class="text-white text-sm font-medium">{{ number_format($featuredEvent->registrations()->sum('quantity') ?? 0, 0, ',', ' ') }}
                                        participants déjà inscrits</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <div>
                    <h3 class="text-3xl font-bold text-white mb-6">
                        @if ($featuredEvent)
                            Rejoins {{ \Illuminate\Support\Str::limit($featuredEvent->title, 60) }}
                        @else
                            Rejoins la compétition de l'année
                        @endif
                    </h3>
                    <ul class="space-y-4 mb-8">
                        <li class="flex items-start text-gray-300">
                            <svg class="w-6 h-6 text-orange-400 mr-3 mt-1 flex-shrink-0" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span>
                                @if ($featuredEvent && $featuredEvent->price)
                                    <strong>Prix :</strong> {{ $featuredEvent->price_for_display }}
                                @else
                                    <strong>Prix :</strong> Gratuit ou à préciser
                                @endif
                            </span>
                        </li>
                        <li class="flex items-start text-gray-300">
                            <svg class="w-6 h-6 text-orange-400 mr-3 mt-1 flex-shrink-0" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span><strong>Catégorie :</strong> {{ $featuredEvent->category ?? 'À définir' }}</span>
                        </li>
                        <li class="flex items-start text-gray-300">
                            <svg class="w-6 h-6 text-orange-400 mr-3 mt-1 flex-shrink-0" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span><strong>Lieu :</strong> {{ $featuredEvent->location ?? 'À préciser' }}</span>
                            @if ($featuredEvent && ($featuredEvent->google_maps_url || $featuredEvent->location))
                                @php
                                    $mapsUrl =
                                        $featuredEvent->google_maps_url ?:
                                        'https://www.google.com/maps/search/?api=1&query=' .
                                            urlencode($featuredEvent->location);
                                @endphp
                                <a href="{{ $mapsUrl }}" target="_blank" rel="noopener"
                                    class="ml-3 inline-flex items-center text-violet-300 hover:text-white text-sm">
                                    <svg class="w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 11a3 3 0 100-6 3 3 0 000 6zm0 0c-4.418 0-8 2.239-8 5v2h16v-2c0-2.761-3.582-5-8-5z" />
                                    </svg>
                                    Ouvrir dans Google Maps
                                </a>
                            @endif
                        </li>
                        <li class="flex items-start text-gray-300">
                            <svg class="w-6 h-6 text-orange-400 mr-3 mt-1 flex-shrink-0" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span><strong>Date :</strong>
                                {{ optional($featuredEvent?->start_date)->format('d/m/Y H:i') }}</span>
                        </li>
                    </ul>

                    <div class="flex flex-col sm:flex-row gap-4">
                        @auth
                            <a href="{{ $featuredEvent ? route('events.show', $featuredEvent) : route('events.create') }}"
                                class="cta-button cta-button-primary">
                                🔥 Participer maintenant
                            </a>
                        @else
                            <a href="{{ $featuredEvent ? route('events.show', $featuredEvent) : route('register') }}"
                                class="cta-button cta-button-primary">
                                🔥 Participer maintenant
                            </a>
                        @endauth
                        <a href="#" class="cta-button cta-button-secondary">
                            En savoir plus
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials & Stories Section -->
    <section class="py-24 bg-black">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-4xl sm:text-5xl font-bold text-white mb-6">
                    Témoignages & <span
                        class="bg-gradient-to-r from-violet-400 to-blue-400 bg-clip-text text-transparent">stories</span>
                </h2>
                <p class="text-xl text-gray-300 max-w-3xl mx-auto">
                    Les visages et les voix qui font notre communauté
                </p>
            </div>

            <!-- Stories Carousel -->
            @if (!empty($stories) && count($stories) > 0)
                <div class="relative mb-16" x-data="{ currentStory: 0, stories: @json($stories ?? []) }">

                    <!-- Story Display -->
                    <div class="glass-card p-8 mb-8">
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                            <!-- Story Visual -->
                            <div class="relative">
                                <div
                                    class="aspect-square rounded-2xl overflow-hidden bg-gradient-to-br from-violet-600 to-blue-600">
                                    <img loading="lazy" decoding="async" :src="stories[currentStory].image_url"
                                        :alt="stories[currentStory].name" class="w-full h-full object-cover">
                                    <div
                                        class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent">
                                    </div>
                                    <div class="absolute bottom-6 left-6 right-6">
                                        <div class="flex items-center space-x-3">
                                            <div
                                                class="w-12 h-12 rounded-full bg-black/20 backdrop-blur-sm flex items-center justify-center">
                                                <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24"
                                                    stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                                </svg>
                                            </div>
                                            <div>
                                                <h4 class="text-white font-bold text-lg"
                                                    x-text="stories[currentStory].name"></h4>
                                                <p class="text-gray-300 text-sm" x-text="stories[currentStory].role">
                                                </p>
                                                <p class="text-gray-400 text-xs"
                                                    x-text="stories[currentStory].location"></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Story Content -->
                            <div>
                                <div class="mb-6">
                                    <span
                                        class="inline-block px-4 py-2 bg-gradient-to-r from-violet-500 to-blue-500 text-white rounded-full text-sm font-medium mb-4"
                                        x-text="stories[currentStory].achievement"></span>
                                    <blockquote class="text-xl text-gray-300 leading-relaxed italic"
                                        x-text="stories[currentStory].quote"></blockquote>
                                </div>

                                <div class="flex items-center space-x-4">
                                    <button
                                        @click="currentStory = (currentStory - 1 + stories.length) % stories.length"
                                        class="w-10 h-10 rounded-full bg-black/10 backdrop-blur-sm flex items-center justify-center hover:bg-white/20 transition-colors">
                                        <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 19l-7-7 7-7" />
                                        </svg>
                                    </button>

                                    <div class="flex space-x-2">
                                        <template x-for="(story, index) in stories">
                                            <button @click="currentStory = index"
                                                :class="currentStory === index ? 'w-8 bg-black' : 'w-2 bg-white/40'"
                                                class="h-2 rounded-full transition-all duration-300"></button>
                                        </template>
                                    </div>

                                    <button @click="currentStory = (currentStory + 1) % stories.length"
                                        class="w-10 h-10 rounded-full bg-black/10 backdrop-blur-sm flex items-center justify-center hover:bg-white/20 transition-colors">
                                        <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 5l7 7-7 7" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="glass-card p-8 mb-16 text-center text-gray-300">
                    Aucune story pour le moment.
                </div>
            @endif

            <!-- Additional Testimonials Grid -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @if (isset($testimonials) && $testimonials->count() > 3)
                    @foreach ($testimonials->skip(3)->take(3) as $review)
                        <div class="glass-card p-6 text-center">
                            <div
                                class="w-16 h-16 mx-auto mb-4 rounded-full bg-gradient-to-br from-emerald-500 to-teal-500 flex items-center justify-center overflow-hidden">
                                @if ($review->user && $review->user->avatar_url)
                                    <img src="{{ $review->user->avatar_url }}" alt="{{ $review->user->name }}"
                                        class="w-16 h-16 rounded-full object-cover">
                                @else
                                    <span
                                        class="text-white font-bold text-xl">{{ \Illuminate\Support\Str::upper(\Illuminate\Support\Str::substr($review->user->name ?? '??', 0, 2)) }}</span>
                                @endif
                            </div>
                            <p class="text-gray-300 mb-4 italic">
                                "{{ \Illuminate\Support\Str::limit(strip_tags($review->comment ?? ''), 140) }}"</p>
                            <div class="text-sm">
                                <div class="font-medium text-white">{{ $review->user->name ?? 'Utilisateur' }}</div>
                                <div class="text-gray-400">{{ $review->event->title ?? '' }}</div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="glass-card p-6 text-center">
                        <div
                            class="w-16 h-16 mx-auto mb-4 rounded-full bg-gradient-to-br from-emerald-500 to-teal-500 flex items-center justify-center">
                            <span class="text-white font-bold text-xl">KD</span>
                        </div>
                        <p class="text-gray-300 mb-4 italic">"Une plateforme qui change vraiment la vie des jeunes
                            talents africains."</p>
                        <div class="text-sm">
                            <div class="font-medium text-white">Koffi Dosso</div>
                            <div class="text-gray-400">Entrepreneur, Abidjan</div>
                        </div>
                    </div>
                    <div class="glass-card p-6 text-center">
                        <div
                            class="w-16 h-16 mx-auto mb-4 rounded-full bg-gradient-to-br from-rose-500 to-pink-500 flex items-center justify-center">
                            <span class="text-white font-bold text-xl">SM</span>
                        </div>
                        <p class="text-gray-300 mb-4 italic">"J'ai trouvé des collaborateurs incroyables et lancé mon
                            projet rêvé."</p>
                        <div class="text-sm">
                            <div class="font-medium text-white">Sophie Martin</div>
                            <div class="text-gray-400">Designer, Lyon</div>
                        </div>
                    </div>
                    <div class="glass-card p-6 text-center">
                        <div
                            class="w-16 h-16 mx-auto mb-4 rounded-full bg-gradient-to-br from-amber-500 to-orange-500 flex items-center justify-center">
                            <span class="text-white font-bold text-xl">YN</span>
                        </div>
                        <p class="text-gray-300 mb-4 italic">"L'innovation et la créativité se rencontrent ici.
                            Magique!"</p>
                        <div class="text-sm">
                            <div class="font-medium text-white">Youssef Ndiaye</div>
                            <div class="text-gray-400">Développeur, Tunis</div>
                        </div>
                    </div>
                @endif
            </div>
            <footer class="bg-gray-900 border-t border-gray-800">
                <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
                    <!-- Main Content -->
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-8">
                        <!-- Brand -->
                        <div class="col-span-1 md:col-span-2">
                            <div class="flex items-center mb-4">
                                <div
                                    class="flex items-center justify-center h-8 w-8 rounded-lg bg-violet-600 text-white font-bold mr-3">
                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M13 10V3L4 14h7v7l9-11h-7z" />
                                    </svg>
                                </div>
                                <span class="text-xl font-bold text-white">EventManager</span>
                            </div>
                            <p class="text-gray-400 mb-6 max-w-sm">
                                La plateforme événementielle où les créateurs et innovateurs se rencontrent pour
                                inspirer le monde.
                            </p>

                            <!-- Social Links -->
                            <div class="flex space-x-4">
                                <a href="#"
                                    class="w-10 h-10 bg-gray-800 rounded-lg flex items-center justify-center text-gray-400 hover:bg-violet-600 hover:text-white transition-colors">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                        <path
                                            d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z" />
                                    </svg>
                                </a>
                                <a href="#"
                                    class="w-10 h-10 bg-gray-800 rounded-lg flex items-center justify-center text-gray-400 hover:bg-violet-600 hover:text-white transition-colors">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                        <path
                                            d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z" />
                                    </svg>
                                </a>
                                <a href="#"
                                    class="w-10 h-10 bg-gray-800 rounded-lg flex items-center justify-center text-gray-400 hover:bg-violet-600 hover:text-white transition-colors">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                        <path
                                            d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z" />
                                    </svg>
                                </a>
                                <a href="#"
                                    class="w-10 h-10 bg-gray-800 rounded-lg flex items-center justify-center text-gray-400 hover:bg-violet-600 hover:text-white transition-colors">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                    </svg>
                                </a>
                                <a href="#"
                                    class="w-10 h-10 bg-gray-800 rounded-lg flex items-center justify-center text-gray-400 hover:bg-violet-600 hover:text-white transition-colors">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </a>
                            </div>
                        </div>

                        <!-- Quick Links -->
                        <div>
                            <h3 class="text-white font-semibold mb-4">Explorer</h3>
                            <ul class="space-y-3">
                                <li><a href="#ecosystem"
                                        class="text-gray-400 hover:text-white transition-colors">Écosystème</a></li>
                                <li><a href="#highlights"
                                        class="text-gray-400 hover:text-white transition-colors">Moments forts</a></li>
                                <li><a href="#why-join"
                                        class="text-gray-400 hover:text-white transition-colors">Pourquoi nous</a></li>
                                <li><a href="#featured-event"
                                        class="text-gray-400 hover:text-white transition-colors">Événement spécial</a>
                                </li>
                                <li><a href="{{ route('events.index') }}"
                                        class="text-gray-400 hover:text-white transition-colors">Tous les
                                        événements</a></li>
                            </ul>
                        </div>

                        <!-- Support -->
                        <div>
                            <h3 class="text-white font-semibold mb-4">Support</h3>
                            <ul class="space-y-3">
                                <li><a href="#" class="text-gray-400 hover:text-white transition-colors">Centre
                                        d'aide</a></li>
                                <li><a href="#"
                                        class="text-gray-400 hover:text-white transition-colors">Contact</a></li>
                                <li><a href="#" class="text-gray-400 hover:text-white transition-colors">FAQ</a>
                                </li>
                                <li><a href="#"
                                        class="text-gray-400 hover:text-white transition-colors">Conditions
                                        d'utilisation</a></li>
                                <li><a href="#"
                                        class="text-gray-400 hover:text-white transition-colors">Confidentialité</a>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <!-- Partners -->
                    <div class="border-t border-gray-800 pt-8 mb-8">
                        <div class="text-center mb-6">
                            <h3 class="text-white font-semibold mb-2">Ils nous font confiance</h3>
                            <p class="text-gray-400 text-sm">Partenaires premium</p>
                        </div>
                        <div class="grid grid-cols-3 md:grid-cols-6 gap-6 items-center">
                            <div class="flex justify-center">
                                <div
                                    class="w-16 h-10 bg-gray-800 rounded flex items-center justify-center text-xs font-medium text-gray-400">
                                    TechCorp</div>
                            </div>
                            <div class="flex justify-center">
                                <div
                                    class="w-16 h-10 bg-gray-800 rounded flex items-center justify-center text-xs font-medium text-gray-400">
                                    ArtHub</div>
                            </div>
                            <div class="flex justify-center">
                                <div
                                    class="w-16 h-10 bg-gray-800 rounded flex items-center justify-center text-xs font-medium text-gray-400">
                                    MusicFlow</div>
                            </div>
                            <div class="flex justify-center">
                                <div
                                    class="w-16 h-10 bg-gray-800 rounded flex items-center justify-center text-xs font-medium text-gray-400">
                                    DesignPro</div>
                            </div>
                            <div class="flex justify-center">
                                <div
                                    class="w-16 h-10 bg-gray-800 rounded flex items-center justify-center text-xs font-medium text-gray-400">
                                    Innovate</div>
                            </div>
                            <div class="flex justify-center">
                                <div
                                    class="w-16 h-10 bg-gray-800 rounded flex items-center justify-center text-xs font-medium text-gray-400">
                                    CreateLab</div>
                            </div>
                        </div>
                    </div>

                    <!-- CTA -->
                    <div class="border-t border-gray-800 pt-8 mb-8">
                        <div class="text-center">
                            <h3 class="text-white font-semibold mb-3">Prêt à rejoindre l'aventure ?</h3>
                            <p class="text-gray-400 mb-6">Des milliers de créateurs t'attendent</p>
                            @auth
                                <a href="{{ route('dashboard') }}"
                                    class="inline-block bg-violet-600 text-white px-6 py-2 rounded-lg hover:bg-violet-700 transition-colors">
                                    Accéder à mon espace
                                </a>
                            @else
                                <a href="{{ route('register') }}"
                                    class="inline-block bg-violet-600 text-white px-6 py-2 rounded-lg hover:bg-violet-700 transition-colors">
                                    Commencer maintenant
                                </a>
                            @endauth
                        </div>
                    </div>

                    <!-- Bottom -->
                    <div class="border-t border-gray-800 pt-8">
                        <div class="flex flex-col md:flex-row justify-between items-center text-sm text-gray-400">
                            <p>&copy; {{ date('Y') }} EventManager. Tous droits réservés.</p>
                            <p>Fait avec ❤️ en Afrique • Powered by innovation</p>
                        </div>
                    </div>
                </div>
            </footer>
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    // Reveal on scroll for key sections/cards/buttons
                    const revealTargets = document.querySelectorAll(
                        '.card-hover, .glass-card, .glass-card-gold, .pricing-card, .testimonial-card, section[id], .feature-icon, .cta-button'
                    );
                    const io = new IntersectionObserver((entries) => {
                        entries.forEach((e) => {
                            if (e.isIntersecting) {
                                e.target.classList.add('visible');
                                io.unobserve(e.target);
                            }
                        });
                    }, {
                        threshold: 0.2
                    });
                    revealTargets.forEach((el) => {
                        el.classList.add('reveal');
                        io.observe(el);
                    });

                    // Animated numbers for hero stats (only values with + or % to avoid prices)
                    const statEls = Array.from(document.querySelectorAll('.text-3xl.font-bold'))
                        .filter(el => /[+%]/.test(el.textContent));

                    function animateNumber(el, target, duration = 1500, suffix = '') {
                        const start = 0;
                        const startTime = performance.now();

                        function tick(now) {
                            const p = Math.min((now - startTime) / duration, 1);
                            const val = Math.floor(start + p * (target - start));
                            el.textContent = val.toLocaleString('fr-FR') + suffix;
                            if (p < 1) requestAnimationFrame(tick);
                        }
                        requestAnimationFrame(tick);
                    }
                    statEls.forEach((el) => {
                        const txt = el.textContent.trim();
                        let suffix = txt.includes('%') ? '%' : (txt.endsWith('+') ? '+' : '');
                        let mult = txt.includes('M') ? 1_000_000 : (txt.includes('K') ? 1_000 : 1);
                        const num = parseFloat(txt.replace(/[^\d.]/g, ''));
                        const target = isNaN(num) ? 0 : Math.round(num * mult);
                        const obs = new IntersectionObserver((ents, o) => {
                            ents.forEach(ent => {
                                if (ent.isIntersecting) {
                                    animateNumber(el, target, 1600, suffix);
                                    o.unobserve(el);
                                }
                            });
                        }, {
                            threshold: 0.7
                        });
                        obs.observe(el);
                    });

                    // Pricing toggle: monthly/yearly switch
                    const toggles = document.querySelectorAll('.billing-toggle');
                    toggles.forEach(btn => {
                        btn.addEventListener('click', () => {
                            toggles.forEach(b => {
                                b.classList.toggle('text-white', b === btn);
                                b.classList.toggle('text-gray-300', b !== btn);
                                b.classList.toggle('active', b === btn);
                            });
                            const yearly = btn.dataset.billing === 'yearly';
                            document.querySelectorAll('.monthly-price').forEach(el => el.classList.toggle(
                                'hidden', yearly));
                            document.querySelectorAll('.yearly-price').forEach(el => el.classList.toggle(
                                'hidden', !yearly));
                        });
                    });

                    // Card tilt effect for interactive feel
                    const tiltEls = document.querySelectorAll(
                        '.card-hover, .glass-card, .glass-card-gold, .pricing-card, .testimonial-card');
                    tiltEls.forEach((card) => {
                        card.classList.add('tilt-zone');
                        card.addEventListener('mousemove', (e) => {
                            const r = card.getBoundingClientRect();
                            const x = (e.clientX - r.left) / r.width - 0.5;
                            const y = (e.clientY - r.top) / r.height - 0.5;
                            card.style.transform = `rotateY(${x * 6}deg) rotateX(${ -y * 6}deg)`;
                        });
                        card.addEventListener('mouseleave', () => {
                            card.style.transform = 'rotateY(0deg) rotateX(0deg)';
                        });
                    });

                    // CTA ripple effect
                    document.querySelectorAll('.cta-button').forEach((btn) => {
                        btn.style.position = 'relative';
                        btn.style.overflow = 'hidden';
                        btn.addEventListener('click', function(e) {
                            const ripple = document.createElement('span');
                            const size = Math.max(this.clientWidth, this.clientHeight);
                            Object.assign(ripple.style, {
                                position: 'absolute',
                                width: size + 'px',
                                height: size + 'px',
                                left: e.offsetX - size / 2 + 'px',
                                top: e.offsetY - size / 2 + 'px',
                                background: 'radial-gradient(circle, rgba(255,255,255,.35) 0%, transparent 60%)',
                                borderRadius: '50%',
                                transform: 'scale(0)',
                                transition: 'transform .6s ease, opacity .8s ease',
                                pointerEvents: 'none'
                            });
                            this.appendChild(ripple);
                            requestAnimationFrame(() => {
                                ripple.style.transform = 'scale(1)';
                                ripple.style.opacity = '0';
                            });
                            setTimeout(() => ripple.remove(), 800);
                        });
                    });

                    // Smooth scroll for internal anchors
                    document.querySelectorAll('a[href^="#"]').forEach((a) => {
                        a.addEventListener('click', (e) => {
                            const id = a.getAttribute('href').slice(1);
                            const target = document.getElementById(id);
                            if (target) {
                                e.preventDefault();
                                target.scrollIntoView({
                                    behavior: 'smooth',
                                    block: 'start'
                                });
                            }
                        });
                    });

                    // Stories autoplay (Alpine carousel): click the next arrow every 6s
                    const storyRoot = document.querySelector('[x-data*="currentStory"]');
                    const nextArrow = storyRoot?.querySelector('button.w-10.h-10:last-of-type');
                    if (storyRoot && nextArrow) {
                        setInterval(() => nextArrow.click(), 6000);
                    }
                    const progress = document.getElementById('scroll-progress');
                    const updateProgress = () => {
                        const h = document.documentElement;
                        const max = h.scrollHeight - h.clientHeight;
                        const v = (window.scrollY / (max || 1)) * 100;
                        if (progress) progress.style.width = v + '%';
                    };
                    updateProgress();
                    window.addEventListener('scroll', updateProgress, {
                        passive: true
                    });
                    window.addEventListener('resize', updateProgress);
                    const nav = document.querySelector('nav.fixed.top-0');
                    let lastY = window.scrollY;
                    window.addEventListener('scroll', () => {
                        const y = window.scrollY;
                        const down = y > lastY + 2;
                        if (nav) {
                            if (y > 80 && down) nav.classList.add('nav-hide');
                            else nav.classList.remove('nav-hide');
                        }
                        lastY = y;
                    }, {
                        passive: true
                    });
                    const heroKeyword = document.getElementById('hero-keyword');
                    const words = ['mémorables', 'immersifs', 'interactifs', 'vibrants', 'inoubliables'];
                    let wordIndex = 0;
                    if (heroKeyword) {
                        setInterval(() => {
                            heroKeyword.style.opacity = '0';
                            setTimeout(() => {
                                wordIndex = (wordIndex + 1) % words.length;
                                heroKeyword.textContent = words[wordIndex];
                                heroKeyword.style.opacity = '1';
                            }, 250);
                        }, 3000);
                    }
                });
            </script>
</body>

</html>
