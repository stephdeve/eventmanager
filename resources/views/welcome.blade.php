<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="EventManager - La plateforme événementielle immersive qui révolutionne l'organisation et la participation aux événements. Créez, gérez et participez à des expériences uniques.">
    <title>EventManager - Là où les passions s'affrontent</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=sora:400,500,600,700&family=inter:400,500,600,700&display=swap" rel="stylesheet" />

    <!-- Favicon -->
    <link rel="icon" href="{{ asset('favicon.ico') }}">

    <!-- Styles / Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* Variables et identité visuelle */
        :root {
            --primary-gradient: linear-gradient(135deg, #6C63FF 0%, #00BFFF 100%);
            --primary-gradient-reverse: linear-gradient(135deg, #00BFFF 0%, #6C63FF 100%);
            --accent-gradient: linear-gradient(135deg, #FFD700 0%, #FF8C00 100%);
            --bg-dark: #0A0A0F;
            --bg-darker: #050508;
            --bg-light: rgba(255, 255, 255, 0.05);
            --text-primary: #FFFFFF;
            --text-secondary: rgba(255, 255, 255, 0.8);
            --text-tertiary: rgba(255, 255, 255, 0.6);
            --border-light: rgba(255, 255, 255, 0.1);
            --border-medium: rgba(255, 255, 255, 0.2);
            --glow-primary: 0 0 40px rgba(108, 99, 255, 0.4);
            --glow-accent: 0 0 40px rgba(255, 215, 0, 0.3);
            --radius-sm: 8px;
            --radius-md: 16px;
            --radius-lg: 24px;
            --radius-xl: 32px;
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            --transition-slow: all 0.6s cubic-bezier(0.4, 0, 0.2, 1);
        }

        body {
            font-family: 'Sora', sans-serif;
            background: var(--bg-dark);
            color: var(--text-primary);
            overflow-x: hidden;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        h1, h2, h3, h4, h5, h6 {
            font-family: 'Sora', sans-serif;
            font-weight: 600;
            line-height: 1.2;
        }

        /* Animations personnalisées */
        @keyframes float {
            0%, 100% {
                transform: translateY(0) rotate(0deg);
            }
            33% {
                transform: translateY(-20px) rotate(5deg);
            }
            66% {
                transform: translateY(-10px) rotate(-5deg);
            }
        }

        @keyframes pulse-glow {
            0%, 100% {
                opacity: 0.6;
                transform: scale(1);
            }
            50% {
                opacity: 0.9;
                transform: scale(1.05);
            }
        }

        @keyframes shimmer {
            0% {
                background-position: -200% center;
            }
            100% {
                background-position: 200% center;
            }
        }

        @keyframes slide-in-up {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fade-in {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }

        .animate-float {
            animation: float 8s ease-in-out infinite;
        }

        .animate-pulse-glow {
            animation: pulse-glow 3s ease-in-out infinite;
        }

        .animate-shimmer {
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.1), transparent);
            background-size: 200% 100%;
            animation: shimmer 3s infinite;
        }

        .animate-slide-in-up {
            animation: slide-in-up 0.8s ease-out forwards;
        }

        .animate-fade-in {
            animation: fade-in 0.8s ease-out forwards;
        }

        /* Glassmorphism */
        .glass-card {
            background: rgba(255, 255, 255, 0.08);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid var(--border-light);
            border-radius: var(--radius-md);
            transition: var(--transition);
        }

        .glass-card:hover {
            background: rgba(255, 255, 255, 0.12);
            border-color: var(--border-medium);
            transform: translateY(-4px);
        }

        .glass-card-gold {
            background: linear-gradient(135deg, rgba(255, 215, 0, 0.1), rgba(255, 140, 0, 0.05));
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 215, 0, 0.2);
            border-radius: var(--radius-md);
        }

        /* Navigation améliorée */
        .nav-container {
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 100;
            background: rgba(10, 10, 15, 0.9);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-bottom: 1px solid var(--border-light);
            transition: var(--transition);
        }

        .nav-container.scrolled {
            background: rgba(10, 10, 15, 0.95);
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.3);
        }

        .nav-logo-glow {
            position: relative;
        }

        .nav-logo-glow::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 40px;
            height: 40px;
            background: radial-gradient(circle, rgba(108, 99, 255, 0.4) 0%, transparent 70%);
            filter: blur(10px);
            z-index: -1;
            transition: var(--transition);
        }

        .nav-logo-glow:hover::after {
            width: 50px;
            height: 50px;
        }

        .nav-link-animated {
            position: relative;
            overflow: hidden;
        }

        .nav-link-animated::before {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 2px;
            background: var(--primary-gradient);
            transform: translateX(-100%);
            transition: transform 0.3s ease;
        }

        .nav-link-animated:hover::before {
            transform: translateX(0);
        }

        /* Hero Section immersive */
        .hero-section {
            min-height: 100vh;
            position: relative;
            overflow: hidden;
            padding-top: 80px;
        }

        .hero-bg-particles {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -2;
        }

        .hero-glow-orb {
            position: absolute;
            width: 500px;
            height: 500px;
            border-radius: 50%;
            filter: blur(100px);
            opacity: 0.3;
            z-index: -1;
        }

        .hero-glow-orb-1 {
            top: -200px;
            left: -200px;
            background: radial-gradient(circle, #6C63FF 0%, transparent 70%);
            animation: float 15s ease-in-out infinite;
        }

        .hero-glow-orb-2 {
            bottom: -200px;
            right: -200px;
            background: radial-gradient(circle, #00BFFF 0%, transparent 70%);
            animation: float 20s ease-in-out infinite reverse;
        }

        .hero-title-gradient {
            background: linear-gradient(135deg, #FFFFFF 0%, #E0E7FF 50%, #A5B4FC 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            position: relative;
        }

        .hero-title-gradient::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            width: 100px;
            height: 4px;
            background: var(--primary-gradient);
            border-radius: 2px;
        }

        /* Boutons premium */
        .btn-gradient-primary {
            background: var(--primary-gradient);
            color: white;
            border: none;
            padding: 16px 32px;
            border-radius: var(--radius-md);
            font-weight: 600;
            font-size: 16px;
            position: relative;
            overflow: hidden;
            transition: var(--transition);
            box-shadow: var(--glow-primary);
        }

        .btn-gradient-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 0 60px rgba(108, 99, 255, 0.6);
        }

        .btn-gradient-primary::after {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: left 0.6s ease;
        }

        .btn-gradient-primary:hover::after {
            left: 100%;
        }

        .btn-glass {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid var(--border-medium);
            color: white;
            padding: 16px 32px;
            border-radius: var(--radius-md);
            font-weight: 600;
            font-size: 16px;
            transition: var(--transition);
        }

        .btn-glass:hover {
            background: rgba(255, 255, 255, 0.2);
            transform: translateY(-2px);
        }

        /* Stats animées */
        .stat-counter {
            font-size: 48px;
            font-weight: 700;
            background: var(--primary-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            line-height: 1;
        }

        /* Icônes animées */
        .icon-wrapper {
            width: 64px;
            height: 64px;
            border-radius: var(--radius-md);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 20px;
            position: relative;
            transition: var(--transition);
        }

        .icon-wrapper::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            border-radius: var(--radius-md);
            background: var(--primary-gradient);
            opacity: 0.1;
            z-index: -1;
        }

        .icon-wrapper:hover {
            transform: translateY(-4px) scale(1.05);
        }

        .icon-wrapper:hover::after {
            opacity: 0.2;
        }

        /* Timeline stylée */
        .timeline-step {
            position: relative;
            padding-left: 40px;
            margin-bottom: 40px;
        }

        .timeline-step::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            width: 2px;
            height: 100%;
            background: var(--primary-gradient);
        }

        .timeline-step::after {
            content: '';
            position: absolute;
            left: -8px;
            top: 0;
            width: 18px;
            height: 18px;
            border-radius: 50%;
            background: var(--primary-gradient);
            border: 3px solid var(--bg-dark);
        }

        /* Chat live preview */
        .chat-preview {
            background: rgba(255, 255, 255, 0.05);
            border-radius: var(--radius-lg);
            overflow: hidden;
            position: relative;
        }

        .chat-message {
            padding: 12px 16px;
            margin: 8px;
            border-radius: var(--radius-md);
            max-width: 70%;
            animation: fade-in 0.3s ease-out;
        }

        .chat-message.incoming {
            background: rgba(108, 99, 255, 0.2);
            border: 1px solid rgba(108, 99, 255, 0.3);
            margin-right: auto;
        }

        .chat-message.outgoing {
            background: rgba(0, 191, 255, 0.2);
            border: 1px solid rgba(0, 191, 255, 0.3);
            margin-left: auto;
        }

        /* Réactions animées */
        .reaction-bubble {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid var(--border-light);
            font-size: 20px;
            cursor: pointer;
            transition: var(--transition);
            position: relative;
        }

        .reaction-bubble:hover {
            transform: scale(1.2) translateY(-4px);
            background: rgba(255, 255, 255, 0.2);
        }

        .reaction-bubble.active {
            background: rgba(255, 215, 0, 0.2);
            border-color: rgba(255, 215, 0, 0.4);
            box-shadow: var(--glow-accent);
        }

        /* Progress bar */
        .scroll-progress {
            position: fixed;
            top: 0;
            left: 0;
            width: 0%;
            height: 3px;
            background: var(--primary-gradient);
            z-index: 1000;
            transition: width 0.1s ease;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .hero-title-gradient {
                font-size: 2.5rem;
            }

            .stat-counter {
                font-size: 36px;
            }

            .icon-wrapper {
                width: 48px;
                height: 48px;
            }
        }

        @media (max-width: 640px) {
            .hero-title-gradient {
                font-size: 2rem;
            }

            .btn-gradient-primary,
            .btn-glass {
                padding: 12px 24px;
                font-size: 14px;
            }
        }

        /* Utilitaires */
        .text-gradient {
            background: var(--primary-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .text-gradient-accent {
            background: var(--accent-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .section-spacing {
            padding-top: 120px;
            padding-bottom: 120px;
        }

        .container-narrow {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 24px;
        }

        /* Animations de scroll */
        .reveal {
            opacity: 0;
            transform: translateY(30px);
            transition: opacity 0.8s ease, transform 0.8s ease;
        }

        .reveal.visible {
            opacity: 1;
            transform: translateY(0);
        }
    </style>
</head>

<body class="min-h-full bg-black overflow-x-hidden">
    <!-- Scroll Progress -->
    <div class="scroll-progress" id="scrollProgress"></div>

    <!-- Navigation -->
    <nav class="nav-container" id="mainNav">
        <div class="container-narrow">
            <div class="flex items-center justify-between h-20">
                <!-- Logo -->
                <a href="{{ url('/') }}" class="flex items-center space-x-3 nav-logo-glow">
                    <div class="relative">
                        <div class="absolute inset-0 bg-gradient-to-r from-violet-600 to-blue-500 rounded-lg blur-md opacity-75"></div>
                        <div class="relative flex items-center justify-center w-10 h-10 rounded-lg bg-gradient-to-r from-violet-600 to-blue-500">
                            <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                            </svg>
                        </div>
                    </div>
                    <span class="text-xl font-bold text-white">EventManager</span>
                </a>

                <!-- Desktop Navigation -->
                <div class="hidden md:flex items-center space-x-8">
                    <a href="#features" class="nav-link-animated text-gray-300 hover:text-white transition-colors duration-300">
                        Fonctionnalités
                    </a>
                    <a href="#how-it-works" class="nav-link-animated text-gray-300 hover:text-white transition-colors duration-300">
                        Comment ça marche
                    </a>
                    <a href="#events" class="nav-link-animated text-gray-300 hover:text-white transition-colors duration-300">
                        Événements
                    </a>
                    <a href="#testimonials" class="nav-link-animated text-gray-300 hover:text-white transition-colors duration-300">
                        Témoignages
                    </a>

                    @auth
                        <a href="{{ route('dashboard') }}" class="btn-glass">
                            Tableau de bord
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="text-gray-300 hover:text-white transition-colors duration-300 mr-4">
                            Connexion
                        </a>
                        <a href="{{ route('register') }}" class="btn-gradient-primary">
                            S'inscrire
                        </a>
                    @endauth
                </div>

                <!-- Mobile menu button -->
                <button class="md:hidden text-gray-300 hover:text-white" id="mobileMenuBtn">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section">
        <!-- Background Elements -->
        <div class="hero-bg-particles">
            <div class="hero-glow-orb hero-glow-orb-1"></div>
            <div class="hero-glow-orb hero-glow-orb-2"></div>

            <!-- Animated particles -->
            <div class="absolute inset-0 overflow-hidden">
                <div class="absolute w-1 h-1 bg-white rounded-full opacity-20 animate-float" style="top: 20%; left: 10%; animation-delay: 0s;"></div>
                <div class="absolute w-2 h-2 bg-violet-400 rounded-full opacity-30 animate-float" style="top: 30%; left: 80%; animation-delay: 1s;"></div>
                <div class="absolute w-1 h-1 bg-blue-400 rounded-full opacity-25 animate-float" style="top: 60%; left: 20%; animation-delay: 2s;"></div>
                <div class="absolute w-2 h-2 bg-white rounded-full opacity-20 animate-float" style="top: 80%; left: 70%; animation-delay: 3s;"></div>
            </div>
        </div>

        <!-- Hero Content -->
        <div class="container-narrow flex items-center justify-center min-h-[90vh] pt-20">
            <div class="text-center max-w-4xl mx-auto">
                <!-- Badge -->
                <div class="inline-flex items-center space-x-2 glass-card px-6 py-2 rounded-full mb-8 animate-slide-in-up">
                    <span class="w-2 h-2 bg-gradient-to-r from-violet-600 to-blue-500 rounded-full animate-pulse-glow"></span>
                    <span class="text-sm font-medium text-gray-300">🚀 Plateforme événementielle nouvelle génération</span>
                </div>

                <!-- Titre principal -->
                <h1 class="text-5xl md:text-6xl lg:text-7xl font-bold mb-6 hero-title-gradient animate-slide-in-up" style="animation-delay: 0.1s">
                    Donnez vie à vos<br>
                    <span class="text-gradient-accent">événements</span>
                </h1>

                <!-- Sous-titre -->
                <p class="text-xl md:text-2xl text-gray-300 mb-10 max-w-2xl mx-auto leading-relaxed animate-slide-in-up" style="animation-delay: 0.2s">
                    Créez des expériences interactives uniques. Engagez votre audience avec des votes en direct,
                    des réactions animées et un chat immersif. L'avenir des événements commence ici.
                </p>

                <!-- CTA Buttons -->
                <div class="flex flex-col sm:flex-row gap-4 justify-center items-center mb-16 animate-slide-in-up" style="animation-delay: 0.3s">
                    @auth
                        <a href="{{ route('events.create') }}" class="btn-gradient-primary group">
                            <span class="flex items-center">
                                <svg class="w-5 h-5 mr-2 group-hover:rotate-90 transition-transform duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                </svg>
                                Créer un événement
                            </span>
                        </a>
                    @else
                        <a href="{{ route('register') }}" class="btn-gradient-primary group">
                            <span class="flex items-center">
                                Commencer gratuitement
                                <svg class="w-5 h-5 ml-2 group-hover:translate-x-1 transition-transform duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                                </svg>
                            </span>
                        </a>
                    @endauth
                    <a href="#features" class="btn-glass group">
                        <span class="flex items-center">
                            Découvrir les fonctionnalités
                            <svg class="w-5 h-5 ml-2 group-hover:translate-y-1 transition-transform duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3" />
                            </svg>
                        </span>
                    </a>
                </div>

                <!-- Stats -->
                <div class="grid grid-cols-2 md:grid-cols-4 gap-6 max-w-2xl mx-auto animate-slide-in-up" style="animation-delay: 0.4s">
                    <div class="glass-card p-6 text-center group hover:bg-white/10 transition-all duration-300">
                        <div class="stat-counter mb-2" data-count="{{ $stats['events'] ?? 1250 }}">0</div>
                        <div class="text-gray-400 text-sm">Événements créés</div>
                    </div>
                    <div class="glass-card p-6 text-center group hover:bg-white/10 transition-all duration-300">
                        <div class="stat-counter mb-2" data-count="{{ $stats['participants'] ?? 50000 }}">0</div>
                        <div class="text-gray-400 text-sm">Participants</div>
                    </div>
                    <div class="glass-card p-6 text-center group hover:bg-white/10 transition-all duration-300">
                        <div class="stat-counter mb-2" data-count="{{ $stats['tickets_sold'] ?? 75000 }}">0</div>
                        <div class="text-gray-400 text-sm">Billets vendus</div>
                    </div>
                    <div class="glass-card p-6 text-center group hover:bg-white/10 transition-all duration-300">
                        <div class="stat-counter mb-2" data-count="{{ $stats['live_events'] ?? 150 }}">0</div>
                        <div class="text-gray-400 text-sm">Événements en direct</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Section: Fonctionnalités interactives -->
    <section id="features" class="section-spacing">
        <div class="container-narrow">
            <div class="text-center mb-16 reveal">
                <h2 class="text-4xl md:text-5xl font-bold mb-6">
                    Des fonctionnalités <span class="text-gradient">révolutionnaires</span>
                </h2>
                <p class="text-xl text-gray-300 max-w-2xl mx-auto">
                    Transformez vos événements en expériences interactives captivantes
                </p>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Feature 1 -->
                <div class="glass-card p-8 reveal">
                    <div class="icon-wrapper">
                        <svg class="w-8 h-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold mb-4">Votes en direct</h3>
                    <p class="text-gray-300">
                        Engagez votre audience avec des sondages interactifs en temps réel.
                        Visualisez les résultats instantanément avec des graphiques animés.
                    </p>
                </div>

                <!-- Feature 2 -->
                <div class="glass-card p-8 reveal" style="animation-delay: 0.1s">
                    <div class="icon-wrapper">
                        <svg class="w-8 h-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold mb-4">Réactions animées</h3>
                    <p class="text-gray-300">
                        Exprimez-vous avec des émojis animés qui flottent à l'écran.
                        Créez une ambiance dynamique et participative.
                    </p>
                </div>

                <!-- Feature 3 -->
                <div class="glass-card p-8 reveal" style="animation-delay: 0.2s">
                    <div class="icon-wrapper">
                        <svg class="w-8 h-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold mb-4">Chat immersif</h3>
                    <p class="text-gray-300">
                        Un chat modéré avec des messages qui apparaissent en douceur.
                        Filtrez les messages et gérez les participants facilement.
                    </p>
                </div>

                <!-- Feature 4 -->
                <div class="glass-card p-8 reveal">
                    <div class="icon-wrapper">
                        <svg class="w-8 h-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold mb-4">Quiz interactifs</h3>
                    <p class="text-gray-300">
                        Créez des quiz en direct avec chronomètre et classement.
                        Stimulez la compétition amicale entre participants.
                    </p>
                </div>

                <!-- Feature 5 -->
                <div class="glass-card p-8 reveal" style="animation-delay: 0.1s">
                    <div class="icon-wrapper">
                        <svg class="w-8 h-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold mb-4">Tableau de score</h3>
                    <p class="text-gray-300">
                        Suivez les performances en temps réel avec un tableau animé.
                        Motivez les participants avec un système de points gamifié.
                    </p>
                </div>

                <!-- Feature 6 -->
                <div class="glass-card p-8 reveal" style="animation-delay: 0.2s">
                    <div class="icon-wrapper">
                        <svg class="w-8 h-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold mb-4">Streaming intégré</h3>
                    <p class="text-gray-300">
                        Diffusez votre événement en direct avec une qualité optimale.
                        Intégration parfaite avec YouTube, Twitch et Vimeo.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Section: Comment ça marche -->
    <section id="how-it-works" class="section-spacing bg-gradient-to-b from-transparent to-black/50">
        <div class="container-narrow">
            <div class="text-center mb-16 reveal">
                <h2 class="text-4xl md:text-5xl font-bold mb-6">
                    Simple en <span class="text-gradient">3 étapes</span>
                </h2>
                <p class="text-xl text-gray-300 max-w-2xl mx-auto">
                    Lancez votre premier événement interactif en moins de 5 minutes
                </p>
            </div>

            <div class="max-w-3xl mx-auto">
                <!-- Step 1 -->
                <div class="timeline-step reveal">
                    <div class="flex items-start mb-4">
                        <div class="flex-shrink-0 w-12 h-12 rounded-full bg-gradient-to-r from-violet-600 to-blue-500 flex items-center justify-center mr-4">
                            <span class="text-white font-bold text-lg">1</span>
                        </div>
                        <div>
                            <h3 class="text-2xl font-bold mb-2">Créez votre événement</h3>
                            <p class="text-gray-300">
                                Donnez un nom à votre événement, choisissez une date, ajoutez une description captivante
                                et personnalisez les paramètres d'interaction.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Step 2 -->
                <div class="timeline-step reveal" style="animation-delay: 0.1s">
                    <div class="flex items-start mb-4">
                        <div class="flex-shrink-0 w-12 h-12 rounded-full bg-gradient-to-r from-violet-600 to-blue-500 flex items-center justify-center mr-4">
                            <span class="text-white font-bold text-lg">2</span>
                        </div>
                        <div>
                            <h3 class="text-2xl font-bold mb-2">Invitez les participants</h3>
                            <p class="text-gray-300">
                                Partagez le lien unique de votre événement. Vos participants pourront
                                s'inscrire en un clic et recevoir des rappels automatiques.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Step 3 -->
                <div class="timeline-step reveal" style="animation-delay: 0.2s">
                    <div class="flex items-start">
                        <div class="flex-shrink-0 w-12 h-12 rounded-full bg-gradient-to-r from-violet-600 to-blue-500 flex items-center justify-center mr-4">
                            <span class="text-white font-bold text-lg">3</span>
                        </div>
                        <div>
                            <h3 class="text-2xl font-bold mb-2">Animez et interagissez</h3>
                            <p class="text-gray-300">
                                Lancez des votes, répondez aux questions en direct, gérez le chat
                                et créez une expérience mémorable pour tous les participants.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- CTA -->
            <div class="text-center mt-16 reveal" style="animation-delay: 0.3s">
                <a href="{{ route('register') }}" class="btn-gradient-primary inline-flex items-center text-lg px-8 py-4">
                    <svg class="w-6 h-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Créer mon premier événement
                </a>
            </div>
        </div>
    </section>

    <!-- Section: Événements à venir -->
    <section id="events" class="section-spacing">
        <div class="container-narrow">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-end mb-12 reveal">
                <div>
                    <h2 class="text-4xl md:text-5xl font-bold mb-4">
                        Événements <span class="text-gradient">à venir</span>
                    </h2>
                    <p class="text-xl text-gray-300">
                        Découvrez les prochaines expériences interactives
                    </p>
                </div>
                <a href="{{ route('events.index') }}" class="btn-glass mt-4 md:mt-0">
                    Voir tous les événements
                </a>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($highlightedEvents as $event)
                <a href="{{ route('events.show', $event) }}" class="group reveal">
                    <div class="glass-card overflow-hidden h-full">
                        <!-- Image de l'événement -->
                        <div class="aspect-video relative overflow-hidden">
                            <img src="{{ $event->cover_image_url ?? 'https://images.unsplash.com/photo-1540575467063-178a50c2df87?w=800' }}"
                                 alt="{{ $event->title }}"
                                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-transparent to-transparent"></div>
                            <!-- Badge catégorie -->
                            <div class="absolute top-4 left-4">
                                <span class="px-3 py-1 rounded-full text-xs font-medium bg-gradient-to-r from-violet-600/80 to-blue-500/80 backdrop-blur-sm">
                                    {{ $event->category ?? 'Événement' }}
                                </span>
                            </div>
                            <!-- Badge live -->
                            @if($event->is_live)
                            <div class="absolute top-4 right-4">
                                <span class="px-3 py-1 rounded-full text-xs font-medium bg-red-500/80 backdrop-blur-sm flex items-center">
                                    <span class="w-2 h-2 bg-red-400 rounded-full mr-2 animate-pulse"></span>
                                    EN DIRECT
                                </span>
                            </div>
                            @endif
                        </div>

                        <!-- Contenu -->
                        <div class="p-6">
                            <h3 class="text-xl font-bold mb-2 group-hover:text-violet-300 transition-colors">
                                {{ $event->title }}
                            </h3>
                            <p class="text-gray-300 text-sm mb-4 line-clamp-2">
                                {{ Str::limit(strip_tags($event->description ?? ''), 100) }}
                            </p>

                            <!-- Métadonnées -->
                            <div class="flex items-center justify-between text-sm">
                                <div class="flex items-center text-gray-400">
                                    <svg class="w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    {{ optional($event->start_date)->format('d/m/Y') }}
                                </div>
                                <div class="text-violet-300 font-medium">
                                    {{ $event->price_for_display ?? 'Gratuit' }}
                                </div>
                            </div>

                            <!-- Participants -->
                            <div class="mt-4 pt-4 border-t border-white/10">
                                <div class="flex items-center justify-between">
                                    <div class="flex -space-x-2">
                                        @for($i = 0; $i < min(3, $event->participants_count ?? 0); $i++)
                                        <div class="w-8 h-8 rounded-full bg-gradient-to-r from-violet-600 to-blue-500 border-2 border-gray-900"></div>
                                        @endfor
                                        @if(($event->participants_count ?? 0) > 3)
                                        <div class="w-8 h-8 rounded-full bg-gray-800 border-2 border-gray-900 flex items-center justify-center text-xs">
                                            +{{ ($event->participants_count ?? 0) - 3 }}
                                        </div>
                                        @endif
                                    </div>
                                    <span class="text-sm text-gray-400">
                                        {{ $event->participants_count ?? 0 }} participants
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
                @empty
                <div class="col-span-3 text-center py-12 reveal">
                    <div class="glass-card p-8 inline-block">
                        <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        <h3 class="text-xl font-bold mb-2">Aucun événement à venir</h3>
                        <p class="text-gray-300">Soyez le premier à créer un événement !</p>
                    </div>
                </div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- Section: Pour qui ? -->
    <section class="section-spacing bg-gradient-to-b from-black/50 to-transparent">
        <div class="container-narrow">
            <div class="text-center mb-16 reveal">
                <h2 class="text-4xl md:text-5xl font-bold mb-6">
                    Pour <span class="text-gradient">tous</span> vos événements
                </h2>
                <p class="text-xl text-gray-300 max-w-2xl mx-auto">
                    Une plateforme adaptée à chaque type d'événement
                </p>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
                @foreach([
                    ['icon' => '⛪', 'label' => 'Églises', 'color' => 'from-purple-600/20 to-purple-600/10'],
                    ['icon' => '🎵', 'label' => 'Concerts', 'color' => 'from-pink-600/20 to-rose-600/10'],
                    ['icon' => '💼', 'label' => 'Conférences', 'color' => 'from-blue-600/20 to-cyan-600/10'],
                    ['icon' => '🎓', 'label' => 'Écoles', 'color' => 'from-emerald-600/20 to-green-600/10'],
                    ['icon' => '🎮', 'label' => 'E-sports', 'color' => 'from-orange-600/20 to-amber-600/10'],
                    ['icon' => '💍', 'label' => 'Mariages', 'color' => 'from-rose-600/20 to-pink-600/10'],
                ] as $category)
                <div class="reveal" style="animation-delay: {{ $loop->index * 0.1 }}s">
                    <div class="glass-card p-6 text-center group hover:bg-white/5 transition-all duration-300">
                        <div class="text-3xl mb-3">{{ $category['icon'] }}</div>
                        <div class="text-sm font-medium">{{ $category['label'] }}</div>
                        <div class="absolute inset-0 rounded-lg bg-gradient-to-br {{ $category['color'] }} opacity-0 group-hover:opacity-100 transition-opacity duration-300 -z-10"></div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Section: Ambiance Live Preview -->
    <section class="section-spacing">
        <div class="container-narrow">
            <div class="grid lg:grid-cols-2 gap-12 items-center">
                <!-- Preview -->
                <div class="reveal">
                    <div class="glass-card p-6 rounded-2xl">
                        <!-- Header du chat -->
                        <div class="flex items-center justify-between mb-4 pb-4 border-b border-white/10">
                            <div class="flex items-center">
                                <div class="w-3 h-3 bg-red-500 rounded-full mr-2 animate-pulse"></div>
                                <span class="font-medium">Chat en direct</span>
                            </div>
                            <span class="text-sm text-gray-400">124 participants</span>
                        </div>

                        <!-- Messages du chat -->
                        <div class="space-y-3 mb-4">
                            <div class="chat-message incoming">
                                <div class="font-medium text-violet-300">Marie L.</div>
                                <div>Super présentation ! J'adore les interactions en direct 👏</div>
                            </div>
                            <div class="chat-message outgoing">
                                <div class="font-medium text-blue-300">Vous</div>
                                <div>Merci ! N'hésitez pas à poser vos questions</div>
                            </div>
                            <div class="chat-message incoming">
                                <div class="font-medium text-violet-300">Thomas P.</div>
                                <div>Quand est-ce que le prochain vote commence ?</div>
                            </div>
                        </div>

                        <!-- Réactions -->
                        <div class="flex items-center space-x-2 mb-4">
                            <div class="reaction-bubble">👍</div>
                            <div class="reaction-bubble">🎉</div>
                            <div class="reaction-bubble active">❤️</div>
                            <div class="reaction-bubble">😂</div>
                            <div class="reaction-bubble">🔥</div>
                        </div>

                        <!-- Vote en cours -->
                        <div class="bg-gradient-to-r from-violet-600/20 to-blue-600/20 rounded-lg p-4">
                            <div class="flex items-center justify-between mb-2">
                                <span class="font-medium">Vote en cours</span>
                                <span class="text-sm text-gray-400">30s restantes</span>
                            </div>
                            <div class="space-y-2">
                                <div class="flex items-center">
                                    <div class="w-3/4 bg-violet-600/40 h-2 rounded-full overflow-hidden">
                                        <div class="bg-gradient-to-r from-violet-600 to-blue-500 h-full" style="width: 65%"></div>
                                    </div>
                                    <span class="ml-2 text-sm">Option A (65%)</span>
                                </div>
                                <div class="flex items-center">
                                    <div class="w-1/2 bg-blue-600/40 h-2 rounded-full overflow-hidden">
                                        <div class="bg-gradient-to-r from-blue-600 to-cyan-500 h-full" style="width: 35%"></div>
                                    </div>
                                    <span class="ml-2 text-sm">Option B (35%)</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Description -->
                <div class="reveal" style="animation-delay: 0.1s">
                    <h2 class="text-4xl md:text-5xl font-bold mb-6">
                        Vivez l'<span class="text-gradient">ambiance</span> live
                    </h2>
                    <p class="text-lg text-gray-300 mb-8 leading-relaxed">
                        Plongez dans l'expérience interactive d'EventManager.
                        Engagez votre audience avec des réactions en temps réel,
                        un chat dynamique et des votes instantanés qui transforment
                        vos événements en moments mémorables.
                    </p>
                    <ul class="space-y-4">
                        <li class="flex items-start">
                            <svg class="w-6 h-6 text-violet-400 mr-3 mt-1 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span><strong>Chat modéré</strong> - Gérez les conversations en temps réel</span>
                        </li>
                        <li class="flex items-start">
                            <svg class="w-6 h-6 text-violet-400 mr-3 mt-1 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span><strong>Réactions animées</strong> - Exprimez-vous avec des émojis flottants</span>
                        </li>
                        <li class="flex items-start">
                            <svg class="w-6 h-6 text-violet-400 mr-3 mt-1 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span><strong>Votes instantanés</strong> - Prenez des décisions en temps réel</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- Section: Témoignages -->
    <section id="testimonials" class="section-spacing bg-gradient-to-b from-transparent to-black/50">
        <div class="container-narrow">
            <div class="text-center mb-16 reveal">
                <h2 class="text-4xl md:text-5xl font-bold mb-6">
                    Ils nous <span class="text-gradient">font confiance</span>
                </h2>
                <p class="text-xl text-gray-300 max-w-2xl mx-auto">
                    Découvrez ce que disent nos organisateurs et participants
                </p>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Témoignage 1 -->
                <div class="glass-card p-8 reveal">
                    <div class="flex items-center mb-6">
                        <div class="w-12 h-12 rounded-full bg-gradient-to-r from-violet-600 to-blue-500 flex items-center justify-center text-white font-bold mr-4">
                            ML
                        </div>
                        <div>
                            <div class="font-bold">Marie Laurent</div>
                            <div class="text-sm text-gray-400">Organisatrice de conférences</div>
                        </div>
                    </div>
                    <div class="text-yellow-400 mb-4">★★★★★</div>
                    <p class="text-gray-300 italic">
                        "EventManager a révolutionné nos conférences. Les participants sont bien plus engagés grâce aux votes en direct et au chat interactif. Une plateforme indispensable !"
                    </p>
                </div>

                <!-- Témoignage 2 -->
                <div class="glass-card p-8 reveal" style="animation-delay: 0.1s">
                    <div class="flex items-center mb-6">
                        <div class="w-12 h-12 rounded-full bg-gradient-to-r from-blue-600 to-cyan-500 flex items-center justify-center text-white font-bold mr-4">
                            TP
                        </div>
                        <div>
                            <div class="font-bold">Thomas Petit</div>
                            <div class="text-sm text-gray-400">Manager événements sportifs</div>
                        </div>
                    </div>
                    <div class="text-yellow-400 mb-4">★★★★★</div>
                    <p class="text-gray-300 italic">
                        "La gestion des événements e-sports est devenue un jeu d'enfant. Le tableau de score en temps réel et les réactions animées créent une ambiance incroyable !"
                    </p>
                </div>

                <!-- Témoignage 3 -->
                <div class="glass-card p-8 reveal" style="animation-delay: 0.2s">
                    <div class="flex items-center mb-6">
                        <div class="w-12 h-12 rounded-full bg-gradient-to-r from-emerald-600 to-green-500 flex items-center justify-center text-white font-bold mr-4">
                            SC
                        </div>
                        <div>
                            <div class="font-bold">Sarah Cohen</div>
                            <div class="text-sm text-gray-400">Professeure d'université</div>
                        </div>
                    </div>
                    <div class="text-yellow-400 mb-4">★★★★★</div>
                    <p class="text-gray-300 italic">
                        "Mes cours en ligne n'ont jamais été aussi interactifs. Les quiz en direct et le chat modéré permettent de maintenir l'attention des étudiants tout au long de la session."
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Final -->
    <section class="section-spacing">
        <div class="container-narrow">
            <div class="glass-card-gold p-12 text-center rounded-2xl reveal">
                <h2 class="text-4xl md:text-5xl font-bold mb-6">
                    Prêt à créer des <span class="text-gradient">expériences uniques</span> ?
                </h2>
                <p class="text-xl text-gray-300 mb-10 max-w-2xl mx-auto">
                    Rejoignez des milliers d'organisateurs qui transforment leurs événements avec EventManager
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    @auth
                        <a href="{{ route('events.create') }}" class="btn-gradient-primary text-lg px-8 py-4">
                            Créer un événement
                        </a>
                    @else
                        <a href="{{ route('register') }}" class="btn-gradient-primary text-lg px-8 py-4">
                            Commencer gratuitement
                        </a>
                    @endauth
                    <a href="#features" class="btn-glass text-lg px-8 py-4">
                        Voir la démo
                    </a>
                </div>
                <p class="text-gray-400 text-sm mt-6">
                    Aucune carte bancaire requise • Essai gratuit de 14 jours
                </p>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="py-12 border-t border-white/10">
        <div class="container-narrow">
            <div class="grid md:grid-cols-4 gap-8 mb-8">
                <!-- Brand -->
                <div>
                    <a href="{{ url('/') }}" class="flex items-center space-x-3 mb-6">
                        <div class="relative">
                            <div class="absolute inset-0 bg-gradient-to-r from-violet-600 to-blue-500 rounded-lg blur-md opacity-50"></div>
                            <div class="relative flex items-center justify-center w-10 h-10 rounded-lg bg-gradient-to-r from-violet-600 to-blue-500">
                                <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                </svg>
                            </div>
                        </div>
                        <span class="text-xl font-bold text-white">EventManager</span>
                    </a>
                    <p class="text-gray-400 text-sm">
                        La plateforme événementielle immersive qui révolutionne l'organisation et la participation aux événements.
                    </p>
                </div>

                <!-- Liens rapides -->
                <div>
                    <h3 class="font-bold mb-4">Navigation</h3>
                    <ul class="space-y-2">
                        <li><a href="#features" class="text-gray-400 hover:text-white transition-colors">Fonctionnalités</a></li>
                        <li><a href="#how-it-works" class="text-gray-400 hover:text-white transition-colors">Comment ça marche</a></li>
                        <li><a href="#events" class="text-gray-400 hover:text-white transition-colors">Événements</a></li>
                        <li><a href="#testimonials" class="text-gray-400 hover:text-white transition-colors">Témoignages</a></li>
                    </ul>
                </div>

                <!-- Ressources -->
                <div>
                    <h3 class="font-bold mb-4">Ressources</h3>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-400 hover:text-white transition-colors">Centre d'aide</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition-colors">Blog</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition-colors">Documentation</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition-colors">API</a></li>
                    </ul>
                </div>

                <!-- Légale -->
                <div>
                    <h3 class="font-bold mb-4">Légal</h3>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-400 hover:text-white transition-colors">Conditions d'utilisation</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition-colors">Politique de confidentialité</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition-colors">Mentions légales</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition-colors">Cookies</a></li>
                    </ul>
                </div>
            </div>

            <!-- Copyright -->
            <div class="pt-8 border-t border-white/10 flex flex-col md:flex-row justify-between items-center">
                <p class="text-gray-400 text-sm">
                    &copy; {{ date('Y') }} EventManager. Tous droits réservés.
                </p>
                <div class="flex items-center space-x-4 mt-4 md:mt-0">
                    <a href="#" class="text-gray-400 hover:text-white transition-colors">
                        Twitter
                    </a>
                    <a href="#" class="text-gray-400 hover:text-white transition-colors">
                        LinkedIn
                    </a>
                    <a href="#" class="text-gray-400 hover:text-white transition-colors">
                        Instagram
                    </a>
                    <a href="#" class="text-gray-400 hover:text-white transition-colors">
                        YouTube
                    </a>
                </div>
            </div>
        </div>
    </footer>

    <script>
        // Scroll Progress
        window.addEventListener('scroll', function() {
            const winScroll = document.body.scrollTop || document.documentElement.scrollTop;
            const height = document.documentElement.scrollHeight - document.documentElement.clientHeight;
            const scrolled = (winScroll / height) * 100;
            document.getElementById('scrollProgress').style.width = scrolled + '%';
        });

        // Navigation scroll effect
        window.addEventListener('scroll', function() {
            const nav = document.getElementById('mainNav');
            if (window.scrollY > 50) {
                nav.classList.add('scrolled');
            } else {
                nav.classList.remove('scrolled');
            }
        });

        // Animated counters
        function animateCounter(element) {
            const target = parseInt(element.getAttribute('data-count'));
            const duration = 2000;
            const step = target / (duration / 16);
            let current = 0;

            const timer = setInterval(() => {
                current += step;
                if (current >= target) {
                    element.textContent = target.toLocaleString('fr-FR');
                    clearInterval(timer);
                } else {
                    element.textContent = Math.floor(current).toLocaleString('fr-FR');
                }
            }, 16);
        }

        // Scroll reveal animation
        function revealOnScroll() {
            const reveals = document.querySelectorAll('.reveal');

            reveals.forEach(element => {
                const windowHeight = window.innerHeight;
                const elementTop = element.getBoundingClientRect().top;
                const elementVisible = 100;

                if (elementTop < windowHeight - elementVisible) {
                    element.classList.add('visible');

                    // Animate counters when visible
                    const counters = element.querySelectorAll('.stat-counter');
                    counters.forEach(counter => {
                        if (!counter.classList.contains('animated')) {
                            counter.classList.add('animated');
                            animateCounter(counter);
                        }
                    });
                }
            });
        }

        // Mobile menu
        document.getElementById('mobileMenuBtn')?.addEventListener('click', function() {
            // Implémentez votre menu mobile ici
            alert('Menu mobile à implémenter');
        });

        // Smooth scroll for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                const targetId = this.getAttribute('href');
                if (targetId === '#') return;

                const targetElement = document.querySelector(targetId);
                if (targetElement) {
                    window.scrollTo({
                        top: targetElement.offsetTop - 80,
                        behavior: 'smooth'
                    });
                }
            });
        });

        // Initialize
        document.addEventListener('DOMContentLoaded', function() {
            // Initial reveal check
            revealOnScroll();

            // Add scroll event listener
            window.addEventListener('scroll', revealOnScroll);

            // Add resize event listener
            window.addEventListener('resize', revealOnScroll);

            // Animate hero elements
            const heroElements = document.querySelectorAll('.animate-slide-in-up');
            heroElements.forEach((el, index) => {
                el.style.animationDelay = `${index * 0.1}s`;
            });

            // Chat simulation
            const chatMessages = document.querySelectorAll('.chat-message');
            chatMessages.forEach((msg, index) => {
                msg.style.animationDelay = `${index * 0.3}s`;
            });
        });
    </script>
</body>
</html>
