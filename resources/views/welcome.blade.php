<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description"
        content="EventManager - La plateforme événementielle immersive qui révolutionne l'organisation et la participation aux événements. Créez, gérez et participez à des expériences uniques.">
    <title>EventManager - Là où les passions s'affrontent</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.bunny.net/css?family=sora:400,500,600,700&family=inter:400,500,600,700&display=swap"
        rel="stylesheet" />

    <link rel="icon" href="{{ asset('favicon.ico') }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* Variables et identité visuelle (Optimisé) */
        :root {
            --primary-color: #6C63FF;
            --secondary-color: #00BFFF;
            --primary-gradient: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            --accent-color: #FFD700;
            --accent-gradient: linear-gradient(135deg, var(--accent-color) 0%, #FF8C00 100%);
            --bg-dark: #0A0A0F;
            --bg-darker: #050508;
            --bg-light: rgba(255, 255, 255, 0.05);
            --text-primary: #FFFFFF;
            --text-secondary: rgba(255, 255, 255, 0.8);
            --border-light: rgba(255, 255, 255, 0.1);
            --glow-primary: 0 0 40px rgba(108, 99, 255, 0.4);
            --radius-md: 16px;
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        body {
            font-family: 'Sora', sans-serif;
            background: var(--bg-dark);
            color: var(--text-primary);
            overflow-x: hidden;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        h1,
        h2,
        h3,
        h4 {
            font-family: 'Sora', sans-serif;
            font-weight: 700;
            line-height: 1.2;
        }

        /* Animations personnalisées (simplifiées) */
        @keyframes float {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-15px);
            }
        }

        @keyframes pulse-glow {

            0%,
            100% {
                opacity: 0.6;
                transform: scale(1);
            }

            50% {
                opacity: 0.9;
                transform: scale(1.05);
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

        .animate-float {
            animation: float 8s ease-in-out infinite;
        }

        .animate-pulse-glow {
            animation: pulse-glow 3s ease-in-out infinite;
        }

        .animate-slide-in-up {
            animation: slide-in-up 0.8s ease-out forwards;
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
            border-color: rgba(255, 255, 255, 0.2);
            transform: translateY(-4px);
        }

        /* Navigation */
        .nav-container {
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 100;

            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-bottom: 1px solid var(--border-light);
            transition: var(--transition);
        }

        .nav-container.scrolled {
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.3);
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

        /* Hero Section */
        .hero-section {
            min-height: 100vh;
            position: relative;
            overflow: hidden;
            padding-top: 80px;
        }

        .hero-title-gradient {
            background: linear-gradient(135deg, #FFFFFF 0%, #E0E7FF 50%, #A5B4FC 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            position: relative;
        }

        /* Boutons premium */
        .btn-gradient-primary {
            background: var(--primary-gradient);
            color: white;
            padding: 12px 24px;
            border-radius: var(--radius-md);
            font-weight: 600;
            position: relative;
            overflow: hidden;
            transition: var(--transition);
            box-shadow: var(--glow-primary);
        }

        .btn-gradient-secondary {
            background: var(--primary-gradient);
            color: white;
            font-weight: 600;
            position: relative;
            overflow: hidden;
            transition: var(--transition);
            box-shadow: var(--glow-primary);
        }



        .btn-gradient-primary:hover,
        .btn-gradient-secondary:hover {
            transform: translateY(-2px);
            box-shadow: 0 0 60px rgba(108, 99, 255, 0.6);
        }

        .btn-glass {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: white;
            padding: 12px 24px;
            border-radius: var(--radius-md);
            font-weight: 600;
            text-align: center;
            transition: var(--transition);
        }

        .btn-glass:hover {
            background: rgba(255, 255, 255, 0.2);
            transform: translateY(-2px);
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
            padding-top: 100px;
            padding-bottom: 100px;
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

        /* Style spécifique pour la section événement récent */
        .event-card-recent {
            position: relative;
            background-size: cover;
            background-position: center;
            overflow: hidden;
            border-radius: 20px;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.5);
            /* Assurez-vous d'avoir une image de couverture par défaut ou gérée par l'URL */
            background-image: url('{{ $nextEvent->cover_image_url ?? asset('images/event-default.jpg') }}');
        }

        .event-card-overlay {
            background: linear-gradient(to top, rgba(10, 10, 15, 0.975) 0%, rgba(10, 10, 15, 0.5) 100%, rgba(10, 10, 15, 0.0) 100%);
            padding: 40px;
        }

        .countdown-item {
            background: var(--bg-darker);
            border: 1px solid var(--primary-color);
            border-radius: var(--radius-md);
            padding: 10px 15px;
            text-align: center;
        }

        .testimonial-card {
            background: rgba(108, 99, 255, 0.1);
            border: 1px solid rgba(108, 99, 255, 0.3);
            border-radius: var(--radius-md);
            padding: 24px;
            box-shadow: 0 5px 20px rgba(108, 99, 255, 0.1);
            transition: var(--transition);
        }

        .testimonial-card:hover {
            background: rgba(108, 99, 255, 0.15);
            transform: translateY(-5px);
        }

        /* Progress bar */
        .scroll-progress {
            position: fixed;
            top: 0;
            left: 0;
            width: 0%;
            height: 1px;
            background: var(--primary-gradient);
            z-index: 1000;
            transition: width 0.1s ease;
        }

        .glass-card-gold {
            background: linear-gradient(135deg, rgba(235, 201, 4, 0.1), rgba(251, 142, 9, 0.05));
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 215, 0, 0.2);
        }
    </style>
</head>

<body class="min-h-full bg-black overflow-x-hidden">
    <div class="scroll-progress" id="scrollProgress"></div>

    <nav class="nav-container backdrop-blur-md bg-slate-800/50 fixed top-0 left-0 right-0 z-50" id="mainNav">
        <div class="container-narrow max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20">
                <a href="{{ url('/') }}" class="flex items-center space-x-3 z-20">
                    <div
                        class="w-10 h-10 bg-gradient-to-br from-indigo-600 to-indigo-600 rounded-xl flex items-center justify-center text-white font-bold shadow-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="lucide lucide-calendar-days-icon lucide-calendar-days">
                            <path d="M8 2v4" />
                            <path d="M16 2v4" />
                            <rect width="18" height="18" x="3" y="4" rx="2" />
                            <path d="M3 10h18" />
                            <path d="M8 14h.01" />
                            <path d="M12 14h.01" />
                            <path d="M16 14h.01" />
                            <path d="M8 18h.01" />
                            <path d="M12 18h.01" />
                            <path d="M16 18h.01" />
                        </svg>
                    </div>
                    <span class="text-xl font-bold text-white">EventManager</span>
                </a>

                <div class="hidden lg:flex items-center space-x-8">
                    <a href="#features"
                        class="nav-link-animated text-gray-300 hover:text-white transition-colors duration-300">
                        Fonctionnalités
                    </a>
                    <a href="#event-recent"
                        class="nav-link-animated text-gray-300 hover:text-white transition-colors duration-300">
                        Prochain Event
                    </a>
                    <a href="#events"
                        class="nav-link-animated text-gray-300 hover:text-white transition-colors duration-300">
                        Événements
                    </a>
                    <a href="#subscription-plans"
                        class="nav-link-animated text-gray-300 hover:text-white transition-colors duration-300">
                        Plans
                    </a>

                    @auth
                        <a href="{{ route('dashboard') }}" class="btn-glass">
                            Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}"
                            class="text-gray-300 btn-glass -mr-8! hover:text-white transition-colors duration-300">
                            Connexion
                        </a>
                        <a href="{{ route('register') }}" class="btn-gradient-primary">
                            S'inscrire
                        </a>
                    @endauth
                </div>

                <button class="lg:hidden text-gray-300 hover:text-white z-20" id="mobileMenuBtn"
                    aria-label="Toggle Menu">
                    <svg class="w-7 h-7 hidden" id="menuIconOpen" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                    <svg class="w-7 h-7" id="menuIconClose" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <div class="lg:hidden absolute top-20 py-4 left-0 w-full bg-slate-800 rounded-b-3xl backdrop-blur-sm shadow-xl transition-all duration-300 ease-in-out transform -translate-y-full opacity-0"
                id="mobileMenuContent">
                <div class="flex flex-col space-y-4 p-6 pt-0">
                    <a href="#features"
                        class="text-xl text-gray-300 hover:text-white transition-colors duration-300 py-2 border-b border-gray-700"
                        onclick="closeMobileMenu()">
                        Fonctionnalités
                    </a>
                    <a href="#event-recent"
                        class="text-xl text-gray-300 hover:text-white transition-colors duration-300 py-2 border-b border-gray-700"
                        onclick="closeMobileMenu()">
                        Prochain Event
                    </a>
                    <a href="#events"
                        class="text-xl text-gray-300 hover:text-white transition-colors duration-300 py-2 border-b border-gray-700"
                        onclick="closeMobileMenu()">
                        Événements
                    </a>
                    <a href="#subscription-plans"
                        class="text-xl text-gray-300 hover:text-white transition-colors duration-300 py-2 border-b border-gray-700"
                        onclick="closeMobileMenu()">
                        Plans
                    </a>

                    <div class="pt-4 flex flex-col space-y-4">
                        @auth
                            <a href="{{ route('dashboard') }}" class="btn-glass w-full text-center">
                                Dashboard
                            </a>
                        @else
                            <a href="{{ route('login') }}"
                                class="btn-glass w-full text-center border-gray-600/50 text-gray-300 hover:bg-gray-600/30">
                                Connexion
                            </a>
                            <a href="{{ route('register') }}" class="btn-gradient-primary w-full text-center">
                                S'inscrire
                            </a>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <section class="hero-section bg-gradient-to-b from-slate-900 to-slate-900/40 pb-16">
        <div class="absolute inset-0 overflow-hidden z-0">
            <div
                class="absolute w-500 h-500 rounded-full filter blur-xl opacity-30 z-0 top-[-200px] left-[-200px] bg-gradient-to-r from-violet-600 to-transparent animate-float">
            </div>
            <div class="absolute w-500 h-500 rounded-full filter blur-xl opacity-30 z-0 bottom-[-200px] right-[-200px] bg-gradient-to-l from-blue-500 to-transparent animate-float"
                style="animation-delay: 2s;"></div>
        </div>

        <div class="container-narrow flex items-center justify-center min-h-[90vh] pt-20 relative z-10">
            <div class="text-center max-w-4xl mx-auto">
                <div
                    class="inline-flex items-center space-x-2 glass-card px-6 py-2 rounded-full mb-8 animate-slide-in-up max-md:mt-10">
                    <span
                        class="w-2 h-2 bg-gradient-to-r from-violet-600 to-blue-500 rounded-full animate-pulse-glow"></span>
                    <span class="text-sm font-medium text-gray-300">🚀 Plateforme événementielle nouvelle
                        génération</span>
                </div>

                <h1 class="text-5xl md:text-6xl lg:text-7xl font-bold mb-6 hero-title-gradient animate-slide-in-up"
                    style="animation-delay: 0.1s">
                    Donnez vie à vos<br>
                    <span class="text-gradient-accent">événements</span>
                </h1>

                <p class="text-xl md:text-2xl text-gray-300 mb-10 max-w-2xl mx-auto leading-relaxed animate-slide-in-up"
                    style="animation-delay: 0.2s">
                    Créez des expériences interactives uniques. Engagez votre audience avec des votes en direct,
                    des réactions animées et un chat immersif. L'avenir des événements commence ici.
                </p>

                <div class="flex flex-col sm:flex-row gap-4 justify-center items-center mb-16 animate-slide-in-up"
                    style="animation-delay: 0.3s">
                    @auth
                        <a href="{{ route('events.create') }}" class="btn-gradient-primary group">
                            <span class="flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 4v16m8-8H4" />
                                </svg>
                                Créer un événement
                            </span>
                        </a>
                    @else
                        <a href="{{ route('register') }}" class="btn-gradient-primary group">
                            <span class="flex items-center">
                                Commencer gratuitement
                                <svg class="w-5 h-5 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 7l5 5m0 0l-5 5m5-5H6" />
                                </svg>
                            </span>
                        </a>
                    @endauth
                    <a href="#features" class="btn-glass group">
                        <span class="flex items-center">
                            Découvrir les fonctionnalités
                            <svg class="w-5 h-5 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 14l-7 7m0 0l-7-7m7 7V3" />
                            </svg>
                        </span>
                    </a>
                </div>

                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 max-w-4xl mx-auto animate-slide-in-up"
                    style="animation-delay: 0.4s">
                    <div class="glass-card p-6 text-center group">
                        <div class="stat-counter mb-1 text-4xl lg:text-5xl font-extrabold text-gradient"
                            data-count="{{ $stats['events'] }}">0</div>
                        <div class="text-gray-400 text-sm">Événements créés</div>
                    </div>
                    <div class="glass-card p-6 text-center group">
                        <div class="stat-counter mb-1 text-4xl lg:text-5xl font-extrabold text-gradient"
                            data-count="{{ $stats['participants'] }}">0</div>
                        <div class="text-gray-400 text-sm">Participants</div>
                    </div>
                    <div class="glass-card p-6 text-center group">
                        <div class="stat-counter mb-1 text-4xl lg:text-5xl font-extrabold text-gradient"
                            data-count="{{ $stats['tickets_sold'] }}">0</div>
                        <div class="text-gray-400 text-sm">Billets vendus</div>
                    </div>
                    <div class="glass-card p-6 text-center group">
                        <div class="stat-counter mb-1 text-4xl lg:text-5xl font-extrabold text-gradient"
                            data-count="{{ $stats['live_events'] }}">0</div>
                        <div class="text-gray-400 text-sm">Événements en direct</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <hr class="border-t border-gray-800 my-16 container-narrow" />

    <section id="event-recent" class="section-spacing pt-0">
        <div class="container-narrow">
            <div class="text-center mb-16 reveal">
                <p class="text-gradient font-bold uppercase tracking-widest text-sm mb-2">⭐ LE MOMENT CLÉ</p>
                <h2 class="text-4xl md:text-5xl font-bold">Prochain <span
                        class="text-gradient-accent">événement</span> en vedette</h2>
            </div>

            @if ($nextEvent)
                <div class="event-card-recent  border border-neutral-800 reveal group relative p-10 lg:p-12 overflow-hidden"
                    style="background-image: url('{{ $nextEvent->cover_image_url ?? asset('images/event-default.jpg') }}');">

                    <div class="event-card-overlay overflow-hidden absolute inset-0 transition-opacity duration-500 opacity-95 group-hover:opacity-100"
                        style="background: linear-gradient(to top, var(--bg-dark) 0%, rgba(10, 10, 15, 0.9) 50%, rgba(10, 10, 15, 0.4) 100%);">
                    </div>

                    <div class="flex flex-col lg:flex-row relative z-20 min-h-[450px]">

                        <div class="lg:w-1/2 mb-10 lg:mb-0 lg:pr-16">
                            <span
                                class="text-sm font-semibold text-white/50 mb-2 block">{{ optional($nextEvent->start_date)->isoFormat('dddd') }}</span>

                            <h3
                                class="text-4xl lg:text-5xl font-extrabold mb-4 leading-tight text-white group-hover:text-violet-200 transition-colors duration-300">
                                {{ $nextEvent->title }}
                            </h3>

                            <p class="text-gray-300 mb-8 text-lg line-clamp-3">{{ $nextEvent->description }}</p>

                            <div class="grid grid-cols-2 gap-4 mb-10">

                                <div
                                    class="flex items-start space-x-3 glass-card p-4 border-l-4 border-violet-500/80 hover:bg-white/10 transition-colors">
                                    <svg class="w-6 h-6 text-violet-400 flex-shrink-0 mt-1" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    <div>
                                        <p class="text-sm text-gray-400">Date & Heure</p>
                                        <p class="font-extrabold uppercase text-white">
                                            {{ optional($nextEvent->start_date)->format('d F Y') }} à
                                            {{ optional($nextEvent->start_date)->format('H:i') }}</p>
                                    </div>
                                </div>

                                <div
                                    class="flex items-start space-x-3 glass-card p-4 border-l-4 border-violet-500/80 hover:bg-white/10 transition-colors">
                                    <svg class="w-6 h-6 text-blue-400 flex-shrink-0 mt-1" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.828 0l-4.243-4.243a8 8 0 1111.314 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    <div>
                                        <p class="text-sm text-gray-400 ">Lieu de l'événement</p>
                                        <p class="font-bold uppercase text-white">
                                            {{ $nextEvent->location }}</p>
                                    </div>
                                </div>

                                <div
                                    class="flex items-start space-x-3 glass-card p-4 border-l-4 border-emerald-500/80 hover:bg-white/10 transition-colors">
                                    <svg class="w-6 h-6 text-emerald-400 flex-shrink-0 mt-1" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 22a10 10 0 100-20 10 10 0 000 20z" />
                                    </svg>
                                    <div>
                                        <p class="text-sm text-gray-400">Catégorie de l'événement</p>
                                        <p class="font-bold uppercase text-white">
                                            {{ $nextEvent->category ?? 'Non spécifiée' }}</p>
                                    </div>
                                </div>

                                <div
                                    class="flex items-start space-x-3 glass-card p-4 border-l-4 border-yellow-500/80 hover:bg-white/10 transition-colors">
                                    <svg class="w-6 h-6 text-yellow-400 flex-shrink-0 mt-1" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 14h.01M12 11h.01M15 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                    </svg>
                                    <div>
                                        <p class="text-sm text-gray-400">Prix de l'événement</p>
                                        <p class="font-extrabold text-gradient-accent">
                                            {{ $nextEvent->price_for_display ?? 'Gratuit' }}</p>
                                    </div>
                                </div>
                            </div>

                            @php
                                $nextEventStories = $nextEvent->stories()->active()->count();
                            @endphp

                            <div class="flex flex-col sm:flex-row gap-4">
                                @if($nextEventStories > 0)
                                   <button onclick="openStoryViewer('{{ $nextEvent->id }}')"
                                        class="btn-glass inline-flex items-center justify-center h-fit text-lg w-full  border-2 border-purple-500/50 hover:border-purple-400 bg-purple-500/10 hover:bg-purple-500/20">
                                        <svg class="w-6 h-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                        </svg>
                                        Voir la présentation vidéo ({{ $nextEventStories }})
                                    </button>
                                @endif

                                <a href="{{ route('events.show', $nextEvent) }}"
                                    class="btn-gradient-primary inline-flex items-center justify-center text-lg h-fit w-full">
                                    <svg class="w-6 h-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                    Réserver votre place maintenant
                                </a>
                            </div>
                        </div>

                        <div class="lg:w-1/2 lg:pl-10 lg:pt-0 pt-8 flex flex-col justify-center">
                            <div class="glass-card py-8 border-2 border-violet-500/50">
                                <div id="nextEventCountdownDisplay" class="flex justify-center space-x-4">
                                    <div class="countdown-item min-w-[70px] lg:min-w-[90px] border-violet-500/80">
                                        <div class="text-4xl lg:text-5xl font-mono text-gradient font-extrabold">00
                                        </div>
                                        <div class="text-xs text-gray-400 uppercase tracking-widest">Jours</div>
                                    </div>
                                    <div class="countdown-item min-w-[70px] lg:min-w-[90px] border-violet-500/80">
                                        <div class="text-4xl lg:text-5xl font-mono text-gradient font-extrabold">00
                                        </div>
                                        <div class="text-xs text-gray-400 uppercase tracking-widest">Heures</div>
                                    </div>
                                    <div class="countdown-item min-w-[70px] lg:min-w-[90px] border-violet-500/80">
                                        <div class="text-4xl lg:text-5xl font-mono text-gradient font-extrabold">00
                                        </div>
                                        <div class="text-xs text-gray-400 uppercase tracking-widest">Min</div>
                                    </div>
                                    <div class="countdown-item min-w-[70px] lg:min-w-[90px] border-violet-500/80">
                                        <div class="text-4xl lg:text-5xl font-mono text-gradient font-extrabold">00
                                        </div>
                                        <div class="text-xs text-gray-400 uppercase tracking-widest">Sec</div>
                                    </div>
                                </div>
                                <p class="text-sm text-gray-400 mt-4 text-center">Ne manquez pas le lancement officiel
                                    de cet événement unique.</p>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="glass-card p-12 text-center reveal">
                    <h3 class="text-2xl font-bold mb-3 text-gradient">Aucun événement à venir</h3>
                    <p class="text-gray-300">Revenez bientôt pour découvrir le prochain grand événement !</p>
                </div>
            @endif
        </div>
    </section>

    <hr class="border-t border-gray-800 my-16 container-narrow" />

    {{-- Stories integrated into event cards with video buttons --}}

    <section id="events" class="section-spacing bg-gradient-to-b from-slate-900 to-slate-800/40 pt-0">
        <div class="container-narrow">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-end mb-16 reveal">
                <div>
                    <p class="text-gradient-accent font-bold uppercase tracking-widest text-sm mb-2">Classement</p>
                    <h2 class="text-4xl md:text-5xl font-bold mb-4">Les plus <span
                            class="text-gradient">populaires</span></h2>
                    <p class="text-xl text-gray-300">Découvrez les événements qui font le buzz </p>
                </div>
                <a href="{{ route('events.index') }}"
                    class="btn-glass mt-4 md:mt-0 text-violet-400 border-violet-600/50 hover:bg-violet-600/20 transition-colors">
                    Voir tous les événements
                </a>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse($topPopularEvents as $index => $event)
                    <a href="{{ route('events.show', $event) }}" class="group reveal"
                        style="animation-delay: {{ $index * 0.1 }}s;">
                        <div
                            class="glass-card-border bg-neutral-800/50 rounded-xl overflow-hidden h-full transform hover:scale-[1.03] transition-transform duration-500 relative p-0 border border-neutral-600/50 ">

                            <div class="aspect-video relative overflow-hidden">
                                <img src="{{ $event->cover_image_url ?? asset('images/event-default.jpg') }}"
                                    alt="{{ $event->title }}"
                                    class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">

                                <div
                                    class="absolute inset-0 bg-gradient-to-t from-black/80 via-transparent to-transparent opacity-100 group-hover:opacity-90 transition-opacity duration-300">
                                </div>

                                <div class="absolute top-4 left-4 z-10">
                                    <span
                                        class="px-4 py-1.5 rounded-full text-xs font-bold bg-violet-600/90 text-white shadow-md backdrop-blur-sm tracking-wider">{{ $event->category ?? 'GÉNÉRAL' }}</span>
                                </div>

                                <div
                                    class="absolute bottom-4 right-4 z-10 flex items-center bg-emerald-600/90 rounded-full px-3 py-1 shadow-lg">
                                    <svg class="w-4 h-4 mr-1 text-white" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                    <span class="text-sm font-semibold text-white">{{ $event->registrations_count }}
                                        inscrits</span>
                                </div>
                                {{-- Badge statut événement --}}
                                <div class="absolute bottom-4 left-4 z-10">

                                    @if ($event->isOngoing())
                                        <span
                                            class="px-3 py-1.5 rounded-full text-xs font-bold bg-red-600/90 text-white shadow-lg backdrop-blur-sm animate-pulse flex items-center gap-1">

                                            {{-- Dot live --}}
                                            <svg class="w-3 h-3 text-white" fill="currentColor" viewBox="0 0 8 8">
                                                <circle cx="4" cy="4" r="4" />
                                            </svg>

                                            En cours
                                        </span>
                                    @elseif ($event->isFinished())
                                        <span
                                            class="px-3 py-1.5 rounded-full text-xs font-bold bg-gray-600/90 text-white backdrop-blur-sm flex items-center gap-1">

                                            {{-- Checked icon --}}
                                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor"
                                                stroke-width="2" viewBox="0 0 24 24" stroke-linecap="round"
                                                stroke-linejoin="round">
                                                <path d="M20 6L9 17l-5-5" />
                                            </svg>

                                            Terminé
                                        </span>
                                    @else
                                        <span
                                            class="px-3 py-1 rounded-full text-xs font-bold bg-emerald-600/90 text-white backdrop-blur-sm flex items-center gap-1">

                                            {{-- Clock icon --}}
                                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor"
                                                stroke-width="2" viewBox="0 0 24 24" stroke-linecap="round"
                                                stroke-linejoin="round">
                                                <circle cx="12" cy="12" r="10" />
                                                <path d="M12 6v6l4 2" />
                                            </svg>

                                            À venir
                                        </span>
                                    @endif

                                </div>


                            </div>

                            <div class="p-6">
                                <h3
                                    class="text-2xl font-extrabold mb-3 text-white group-hover:text-emerald-400 transition-colors leading-snug">
                                    {{ $event->title }}
                                </h3>

                                <div class="flex items-center justify-between text-sm pt-2 border-t border-white/10">

                                    <div class="flex items-center text-gray-400 font-medium">
                                        <svg class="w-5 h-5 mr-2 text-violet-400" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        {{ optional($event->start_date)->format('d F Y') }}
                                    </div>

                                    <div class="text-xl font-extrabold text-gradient-accent">
                                        {{ $event->price_for_display ?? 'Gratuit' }}
                                    </div>
                                </div>

                                @php
                                    $eventStoriesCount = $event->stories()->active()->count();
                                @endphp

                                @if($eventStoriesCount > 0)
                                    <button onclick="event.stopPropagation(); event.preventDefault(); openStoryViewer('{{ $event->id }}');" type="button"
                                        class="w-full mt-3 btn-glass flex items-center justify-center gap-2 py-2.5 px-4 border border-purple-500/30 hover:border-purple-400 bg-purple-500/5 hover:bg-purple-500/15 transition-all rounded-lg">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                        </svg>
                                        <span class="text-sm font-semibold">Voir vidéo ({{ $eventStoriesCount }})</span>
                                    </button>
                                @endif
                            </div>
                        </div>
                    </a>
                @empty
                    <div class="col-span-3 text-center py-16 reveal">
                        <div class="glass-card p-10 inline-block border-2 border-gray-700">
                            <h3 class="text-2xl font-bold mb-3 text-gradient-accent">Pas encore d'événements populaires
                            </h3>
                            <p class="text-gray-300">Créez ou inscrivez-vous à un événement pour lancer la dynamique !
                            </p>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <hr class="border-t border-gray-800 my-20 container-narrow" />

    <section id="features" class="section-spacing pt-0">
        <div class="container-narrow">
            <div class="text-center mb-16 reveal">
                <h2 class="text-4xl md:text-5xl font-bold mb-6">
                    Le Cœur du Système : <span class="text-gradient">Outils Révolutionnaires</span>
                </h2>
                <p class="text-xl text-gray-300 max-w-3xl mx-auto">
                    Chaque fonctionnalité est pensée pour transformer la logistique complexe en une expérience fluide et
                    captivante.
                </p>
            </div>

            <div class="space-y-24">

                <div class="flex flex-col lg:flex-row items-center gap-12 reveal">
                    <div class="lg:w-1/2 space-y-4 lg:pr-12">
                        <span class="text-gradient font-bold uppercase tracking-widest text-sm">Organisez &
                            Publiez</span>
                        <h3 class="text-3xl md:text-4xl font-extrabold mb-4">
                            Création et gestion d’événements
                        </h3>
                        <p class="text-gray-300 text-lg">
                            Prenez le contrôle total de vos événements. Notre éditeur visuel et nos outils de gestion
                            centralisés vous permettent de lancer des événements complexes en un temps record. Du
                            planning à la publication, tout est simple.
                        </p>
                        <ul class="mt-6 space-y-2 text-gray-400">
                            <li class="flex items-center"><svg class="w-5 h-5 mr-2 text-violet-400" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>Calendriers intégrés et rappels automatiques.</li>
                            <li class="flex items-center"><svg class="w-5 h-5 mr-2 text-violet-400" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>Personnalisation avancée de la page de l'événement.</li>
                        </ul>
                    </div>
                    <div
                        class="lg:w-1/2 relative glass-card overflow-hidden rounded-lg transform hover:scale-[1.01] transition-transform duration-500 shadow-2xl">

                        <img src="{{ asset('storage/screenshots/Gestion WeLovEya Festival.png') }}" alt="Dashboard" class="w-full h-full object-contain object-center">
                        <div
                            class="absolute -top-6 -right-6 w-20 h-20 bg-violet-600/50 rounded-full filter blur-xl animate-pulse-slow">
                        </div>
                    </div>
                </div>

                <div class="flex flex-col lg:flex-row-reverse items-center gap-12 reveal">
                    <div class="lg:w-1/2 space-y-4 lg:pl-12">
                        <span class="text-gradient-accent font-bold uppercase tracking-widest text-sm">Monétisez &
                            Sécurisez</span>
                        <h3 class="text-3xl md:text-4xl font-extrabold mb-4">
                            Paiement sécurisé et accès sans friction
                        </h3>
                        <p class="text-gray-300 text-lg">
                            Gérez toutes les transactions et l'accès physique à l'événement en toute sécurité. Des
                            paiements
                            instantanés aux transferts de billets, simplifiez l'expérience pour les organisateurs et les
                            participants.
                        </p>
                        <ul class="mt-6 space-y-3 text-gray-400">
                            <li class="flex items-center text-white"><svg class="w-5 h-5 mr-2 text-yellow-400"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8V6m0 4v2m0 4v2" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9" />
                                </svg><span class="font-medium">Paiement de tickets en ligne sécurisé
                                    .</span>
                            </li>
                            <li class="flex items-center text-white"><svg class="w-5 h-5 mr-2 text-yellow-400"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 7h12m0 0l-4-4m4 4l-4 4M4 18h12m0 0l-4-4m4 4l-4 4" />
                                </svg><span class="font-medium">Partage et Transfert de tickets entre
                                    utilisateurs.</span>
                            </li>
                            <li class="flex items-center text-white"><svg class="w-5 h-5 mr-2 text-yellow-400"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 4v16m8-8H4" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 10l5-5 5 5m-5 14v-7" />
                                </svg><span class="font-medium">Accès direct à l'événement via Lien
                                    d'Invitation.</span>
                            </li>
                            <li class="flex items-center text-white"><svg class="w-5 h-5 mr-2 text-yellow-400"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                                </svg><span class="font-medium">Scan QR Code pour validation rapide à l'entrée.</span>
                            </li>
                        </ul>
                    </div>
                    <div
                        class="lg:w-1/2 relative overflow-hidden glass-card transform hover:scale-[1.01] transition-transform duration-500 shadow-2xl">
                        <img src="{{ asset('storage/screenshots/Ticket.png') }}" alt="Dashboard" class="w-full h-full object-contain object-center">
                        <div class="absolute -bottom-6 -left-6 w-20 h-20 bg-yellow-600/50 rounded-full filter blur-xl animate-pulse-slow"
                            style="animation-delay: 1s;"></div>
                    </div>
                </div>

                <div class="flex flex-col lg:flex-row items-center gap-12 reveal">
                    <div class="lg:w-1/2 space-y-4 lg:pr-12">
                        <span class="text-gradient font-bold uppercase tracking-widest text-sm">Interagissez &
                            Captivez</span>
                        <h3 class="text-3xl md:text-4xl font-extrabold mb-4">
                            Engagement interactif : votes, chat, Q&A, challenges
                        </h3>
                        <p class="text-gray-300 text-lg">
                            Fini les événements passifs. Intégrez le public au cœur de l'action grâce à nos outils
                            d'interactivité en temps réel. Animez, questionnez et récompensez l'engagement pour un
                            souvenir mémorable.
                        </p>
                        <div class="mt-6 grid grid-cols-2 gap-4">
                            <span class="flex items-center glass-card p-3 rounded-md text-sm text-blue-300"><svg
                                    class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 10V3L4 14h7v7l9-11h-7z" />
                                </svg>Votes & Sondages Live</span>
                            <span class="flex items-center glass-card p-3 rounded-md text-sm text-blue-300"><svg
                                    class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                                </svg>Chat & Q&A Modéré</span>
                            <span class="flex items-center glass-card p-3 rounded-md text-sm text-blue-300"><svg
                                    class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>Challenges Chronométrés</span>
                        </div>
                    </div>
                    <div
                        class="lg:w-1/2 relative glass-card transform hover:scale-[1.01] transition-transform duration-500 shadow-2xl rounded-lg overflow-hidden">
                        <img src="{{ asset('storage/screenshots/fonctionnalite interactive.png') }}" alt="Dashboard" class="w-full h-full object-contain object-center">
                        <div
                            class="absolute -top-6 -right-6 w-20 h-20 bg-blue-600/50 rounded-full filter blur-xl animate-pulse-slow">
                        </div>
                    </div>
                </div>


                <div class="flex flex-col lg:flex-row-reverse items-center gap-12 reveal">
                    <div class="lg:w-1/2 space-y-4 lg:pl-12">
                        <span class="text-gradient-accent font-bold uppercase tracking-widest text-sm">Analysez &
                            Contrôlez</span>
                        <h3 class="text-3xl md:text-4xl font-extrabold mb-4">
                            Gestion des participants et leurs paiement
                        </h3>
                        <p class="text-gray-300 text-lg">
                            Optimisez la logistique post-inscription et assurez la tranquillité d'esprit. De la gestion
                            des listes des participants, vous avez le contrôle total, validé par des
                            systèmes de scan et validation personnalise des paiement de tcikets fait pas les particiapants.
                        </p>
                        <ul class="mt-6 space-y-2 text-gray-400">
                            <li class="flex items-center"><svg class="w-5 h-5 mr-2 text-emerald-400" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7" />
                                </svg>Espace de gestion de validation des tickets.</li>
                            <li class="flex items-center"><svg class="w-5 h-5 mr-2 text-emerald-400" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7" />
                                </svg>Vue globale sur l'etats des billets commandes par les participants.</li>
                        </ul>
                    </div>
                    <div
                        class="lg:w-1/2 relative overflow-hidden rounded-lg glass-card transform hover:scale-[1.01] transition-transform duration-500 shadow-2xl">
                    <img src="{{ asset('storage/screenshots/Liste des participants - Retro Rave.png') }}" alt="Dashboard" class="w-full h-fit object-contain object-center">
                        <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-40 h-40 bg-emerald-600/30 rounded-full filter blur-3xl animate-pulse-slow"
                            style="animation-duration: 4s;"></div>
                    </div>
                </div>

               <div class="flex flex-col lg:flex-row items-center gap-12 reveal">
                    <div class="lg:w-1/2 space-y-4 lg:pr-12">
                        <span class="text-gradient font-bold uppercase tracking-widest text-sm">Historique & Contrôle</span>
                        <h3 class="text-3xl md:text-4xl font-extrabold mb-4">
                            Historique Complet de vos activites
                        </h3>
                        <p class="text-gray-300 text-lg">
                            Récupérez un historique complet de vos activités,events, billets, tickets, revenus et vos dépenses.
                        </p>
                        <div class="mt-6 w-fit ">
                            <span class="flex items-center glass-card p-3 rounded-md text-sm text-blue-300"><svg
                                    class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 10V3L4 14h7v7l9-11h-7z" />
                                </svg>Historique Complet de vos activites </span>
                        </div>
                    </div>
                    <div
                        class="lg:w-1/2 relative glass-card transform hover:scale-[1.01] transition-transform duration-500 shadow-2xl rounded-lg overflow-hidden">
                        <img src="{{ asset('storage/screenshots/Historique des événements.png') }}" alt="Dashboard" class="w-full h-full object-contain object-center">
                        <div
                            class="absolute -top-6 -right-6 w-20 h-20 bg-blue-600/50 rounded-full filter blur-xl animate-pulse-slow">
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <hr class="border-t border-gray-800 my-20 container-narrow" />

    <section id="user-roles" class="section-spacing pt-0">
        <div class="container-narrow">
            <div class="text-center mb-16 reveal">
                <h2 class="text-4xl md:text-5xl font-bold mb-6">
                    Une Plateforme, <span class="text-gradient">Deux Expériences</span>
                </h2>
                <p class="text-xl text-gray-300 max-w-2xl mx-auto">
                    Chaque utilisateur bénéficie d'une interface et d'outils optimisés pour son rôle.
                </p>
            </div>

            <div class="grid lg:grid-cols-2 gap-12">

                <div class="glass-card p-8 reveal border-t-8 border-violet-600 shadow-xl flex flex-col h-full">
                    <div class="flex items-center space-x-4 mb-6">
                        <svg class="w-10 h-10 text-violet-400" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                        </svg>
                        <h3 class="text-3xl font-bold text-violet-300">Dashboard Organisateur</h3>
                    </div>

                    <p class="text-gray-300 mb-6">
                        La centrale de commande pour le créateur d'événement.
                    </p>

                    <ul class="space-y-3 text-gray-300 mb-8 flex-grow">
                        <li class="flex items-center">
                            <svg class="w-5 h-5 text-violet-400 flex-shrink-0 mr-3" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            <span class="font-medium">Gestion Complète des Événements</span>
                        </li>
                        <li class="flex items-center">
                            <svg class="w-5 h-5 text-violet-400 flex-shrink-0 mr-3" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8V6m0 4v2m0 4v2" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 12h16a2 2 0 002-2V7a2 2 0 00-2-2H4a2 2 0 00-2 2v3a2 2 0 002 2z" />
                            </svg>
                            <span class="font-medium">Tableaux de Bord Analytiques</span>
                        </li>
                        <li class="flex items-center">
                            <svg class="w-5 h-5 text-violet-400 flex-shrink-0 mr-3" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.86 9.86 0 01-4.78-1.295M12 21a9 9 0 009-9H3a9 9 0 009 9z" />
                            </svg>
                            <span class="font-medium">Modération des Interactions Live</span>
                        </li>
                        <li class="flex items-center">
                            <svg class="w-5 h-5 text-violet-400 flex-shrink-0 mr-3" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 11c0 3.866-2.686 7-6 7s-6-3.134-6-7 2.686-7 6-7 6 3.134 6 7z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 11v6m0 0l3-3m-3 3l-3-3" />
                            </svg>
                            <span class="font-medium">Gestion des Participants et Billetterie</span>
                        </li>
                    </ul>
                    <div class="mt-1 border border-violet-500/30 rounded-lg overflow-hidden shadow-lg h-fit">
                       <img src="{{ asset('storage/screenshots/Tableau de bord - Organisateur.png') }}" alt="Dashboard" class="w-full h-fit object-contain object-center">
                    </div>

                    <a href="{{ route('login') }}" class="btn-gradient-primary mt-6 text-center">Accéder au Dashboard
                        Organisateur</a>
                </div>

                <div class="glass-card p-8 reveal border-t-8 border-blue-600 shadow-xl flex flex-col h-full">
                    <div class="flex items-center space-x-4 mb-6">
                        <svg class="w-10 h-10 text-blue-400" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        <h3 class="text-3xl font-bold text-blue-300">Dashboard Participant</h3>
                    </div>

                    <p class="text-gray-300 mb-6">
                        Le portail pour l'invité et la passerelle vers l'engagement.
                    </p>

                    <ul class="space-y-3 text-gray-300 mb-8 flex-grow">
                        <li class="flex items-center">
                            <svg class="w-5 h-5 text-blue-400 flex-shrink-0 mr-3" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.828 0l-4.243-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            <span class="font-medium">Catalogue Événementiel Personnalisé</span>
                        </li>
                        <li class="flex items-center">
                            <svg class="w-5 h-5 text-blue-400 flex-shrink-0 mr-3" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 012 2v3a2 2 0 01-2 2v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 01-2-2v-3a2 2 0 012-2V7a2 2 0 00-2-2H5z" />
                            </svg>
                            <span class="font-medium">Accès Mobile à la Billetterie (QR Codes)</span>
                        </li>
                        <li class="flex items-center">
                            <svg class="w-5 h-5 text-blue-400 flex-shrink-0 mr-3" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span class="font-medium">Participation Interactive (Votes, Chat)</span>
                        </li>
                        <li class="flex items-center">
                            <svg class="w-5 h-5 text-blue-400 flex-shrink-0 mr-3" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span class="font-medium">Historique et Calendrier des Événements</span>
                        </li>
                    </ul>
                    <div
                        class="mt-4 border border-blue-500/30 rounded-lg overflow-hidden h-fit shadow-blue-900/50 shadow-lg">
                    <img src="{{ asset('storage/screenshots/Tableau de bord - Étudiant.png') }}" alt="Dashboard" class="w-full h-fit  object-contain object-center">
                    </div>

                    <a href="{{ route('events.index') }}"
                        class="btn-glass mt-6 text-center border-blue-600/50 text-blue-300 hover:bg-blue-600/20">Explorer
                        les Événements</a>
                </div>
            </div>
        </div>
    </section>


    <hr class="border-t border-gray-800 my-16 container-narrow" />




    <section id="subscription-plans" class="section-spacing py-16 md:py-24 bg-gray-900">
        <div class="container-narrow max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="text-center mb-16 reveal">
                <h2 class="text-4xl md:text-5xl font-bold mb-6">
                    Passez au niveau <span class="text-gradient">Supérieur</span>
                </h2>
                <p class="text-xl text-gray-300 max-w-2xl mx-auto">
                    Choisissez la formule Organisateur qui vous donnera le pouvoir d'échelle que vous cherchez.
                </p>
            </div>

            <div class="grid grid-cols-1 gap-10 lg:grid-cols-3 lg:gap-8">

                <div
                    class="glass-card p-8 reveal border-t-8 border-gray-600/50 shadow-2xl flex flex-col h-full hover:border-violet-600 transition duration-300">
                    <div class="mb-6">
                        <h3 class="text-3xl font-bold text-gray-300 flex items-center space-x-2">
                            <i class="fas fa-seedling text-green-400"></i>
                            <span>Starter (Basique)</span>
                        </h3>
                        <p class="mt-2 text-md text-gray-400">Idéal pour vos premiers pas</p>
                    </div>

                    <div class="flex items-baseline text-6xl font-extrabold text-white mb-6">
                        30 000
                        <span class="text-2xl font-medium text-gray-400 ml-2">FCFA/mois</span>
                    </div>

                    <ul role="list" class="space-y-4 text-gray-300 mb-8 flex-grow">
                        <li class="flex items-center">
                            <i class="fas fa-user-friends w-5 h-5 text-violet-400 flex-shrink-0 mr-3"></i>
                            <span class="font-medium">Jusqu'à 50 places par événement</span>
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-calendar-week w-5 h-5 text-yellow-400 flex-shrink-0 mr-3"></i>
                            <span class="font-medium">Jusqu'à 10 événements par mois</span>
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-chart-line w-5 h-5 text-green-400 flex-shrink-0 mr-3"></i>
                            <span class="font-semibold">Lien de promotion</span>
                        </li>
                    </ul>

                    <a href="{{ route('register', ['plan' => 'basic']) }}"
                        class="btn-glass mt-auto text-center border-gray-600/50 text-gray-300 hover:bg-violet-600/20 transition duration-300">
                        Démarrer Basique
                    </a>
                </div>

                <div
                    class="glass-card p-8 reveal border-t-8 border-violet-600 shadow-violet-900/50 shadow-2xl scale-105 transform transition duration-500 flex flex-col h-full relative">
                    <span
                        class="absolute top-0 right-0 -mt-3 mr-4 px-4 py-1 text-xs font-bold tracking-wider text-white bg-violet-600 rounded-full uppercase shadow-lg transform rotate-2">
                        Le Plus Populaire
                    </span>

                    <div class="mb-6">
                        <h3 class="text-3xl font-bold text-violet-300 flex items-center space-x-2">
                            <i class="fas fa-medal text-yellow-400"></i>
                            <span>Ascension (Premium)</span>
                        </h3>
                        <p class="mt-2 text-md text-violet-300">Montez en puissance et optimisez vos ventes</p>
                    </div>

                    <div class="flex items-baseline text-6xl font-extrabold text-white mb-6">
                        60 000
                        <span class="text-2xl font-medium text-gray-400 ml-2">FCFA/mois</span>
                    </div>

                    <ul role="list" class="space-y-4 text-gray-300 mb-8 flex-grow">
                        <li class="flex items-center">
                            <i class="fas fa-user-check w-5 h-5 text-violet-400 flex-shrink-0 mr-3"></i>
                            <span class="font-semibold">Jusqu'à 150 places par événement</span>
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-calendar-check w-5 h-5 text-yellow-400 flex-shrink-0 mr-3"></i>
                            <span class="font-semibold">Jusqu'à 30 événements par mois</span>
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-chart-line w-5 h-5 text-green-400 flex-shrink-0 mr-3"></i>
                            <span class="font-semibold">Lien de promotion + Suivi des clics</span>
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-video w-5 h-5 text-red-400 flex-shrink-0 mr-3"></i>
                            <span class="font-semibold">Post de stories pour l'événement</span>
                        </li>
                    </ul>

                    <a href="{{ route('register', ['plan' => 'premium']) }}"
                        class="btn-gradient-primary mt-auto text-center shadow-lg shadow-violet-700/50">
                        <i class="fas fa-arrow-right mr-2"></i>
                        Choisir Ascension
                    </a>
                </div>

                <div
                    class="glass-card p-8 reveal border-t-8 border-violet-800 shadow-2xl flex flex-col h-full hover:border-violet-600 transition duration-300">
                    <div class="mb-6">
                        <h3 class="text-3xl font-bold text-violet-300 flex items-center space-x-2">
                            <i class="fas fa-crown text-yellow-500"></i>
                            <span>Élite (Pro)</span>
                        </h3>
                        <p class="mt-2 text-md text-gray-400">Pour les professionnels du secteur exigeants</p>
                    </div>

                    <div class="flex items-baseline text-6xl font-extrabold text-white mb-6">
                        90 000
                        <span class="text-2xl font-medium text-gray-400 ml-2">FCFA/mois</span>
                    </div>

                    <ul role="list" class="space-y-4 text-gray-300 mb-8 flex-grow">
                        <li class="flex items-center">
                            <i class="fas fa-infinity w-5 h-5 text-violet-400 flex-shrink-0 mr-3"></i>
                            <span class="font-semibold">Places ILLIMITÉES par événement</span>
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-grip-lines-vertical w-5 h-5 text-yellow-400 flex-shrink-0 mr-3"></i>
                            <span class="font-semibold">Jusqu'à 100 événements par mois</span>
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-chart-line w-5 h-5 text-green-400 flex-shrink-0 mr-3"></i>
                            <span class="font-semibold">Lien de promotion + Suivi des clics</span>
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-video w-5 h-5 text-red-400 flex-shrink-0 mr-3"></i>
                            <span class="font-semibold">Post de stories pour l'événement</span>
                        </li>
                    </ul>

                    <a href="{{ route('register', ['plan' => 'pro']) }}"
                        class="btn-glass mt-auto text-center border-violet-600/50 text-violet-300 hover:bg-violet-600/30 transition duration-300">
                        Passer à Élite
                    </a>
                </div>

            </div>
        </div>
    </section>







    <hr class="border-t border-gray-800 my-16 container-narrow" />


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
                @forelse($testimonials as $review)
                    <div class="glass-card p-8 reveal">
                        <div class="flex items-center mb-6">
                            @php
                                $user = $review->user;
                                $avatarUrl = $user->avatar_url ?? null;
                                $name = $user->name ?? 'Utilisateur';
                                $initials = strtoupper(substr($name, 0, 2));
                            @endphp
                            @if ($avatarUrl)
                                <img src="{{ $avatarUrl }}" alt="{{ $name }}"
                                    class="w-12 h-12 rounded-full object-cover mr-4">
                            @else
                                <div
                                    class="w-12 h-12 rounded-full bg-gradient-to-r from-violet-600 to-blue-500 flex items-center justify-center text-white font-bold mr-4">
                                    {{ $initials }}
                                </div>
                            @endif
                            <div>
                                <div class="font-bold">{{ $name }}</div>
                                <div class="text-sm text-gray-400">{{ optional($review->event)->title ?? '' }}</div>
                            </div>
                        </div>
                        <div class="text-yellow-400 mb-4">★★★★★</div>
                        <p class="text-gray-300 italic">
                            "{{ $review->comment ?? 'Excellent événement !' }}"
                        </p>
                    </div>
                @empty
                    <!-- Témoignages par défaut si vide -->
                    <div class="glass-card p-8 reveal">
                        <div class="flex items-center mb-6">
                            <div
                                class="w-12 h-12 rounded-full bg-gradient-to-r from-violet-600 to-blue-500 flex items-center justify-center text-white font-bold mr-4">
                                ML
                            </div>
                            <div>
                                <div class="font-bold">Marie Laurent</div>
                                <div class="text-sm text-gray-400">Organisatrice de conférences</div>
                            </div>
                        </div>
                        <div class="text-yellow-400 mb-4">★★★★★</div>
                        <p class="text-gray-300 italic">
                            "EventManager a révolutionné nos conférences. Les participants sont bien plus engagés grâce
                            aux votes en direct et au chat interactif. Une plateforme indispensable !"
                        </p>
                    </div>

                    <div class="glass-card p-8 reveal" style="animation-delay: 0.1s">
                        <div class="flex items-center mb-6">
                            <div
                                class="w-12 h-12 rounded-full bg-gradient-to-r from-blue-600 to-cyan-500 flex items-center justify-center text-white font-bold mr-4">
                                TP
                            </div>
                            <div>
                                <div class="font-bold">Thomas Petit</div>
                                <div class="text-sm text-gray-400">Manager événements sportifs</div>
                            </div>
                        </div>
                        <div class="text-yellow-400 mb-4">★★★★★</div>
                        <p class="text-gray-300 italic">
                            "La gestion des événements e-sports est devenue un jeu d'enfant. Le tableau de score en
                            temps réel et les réactions animées créent une ambiance incroyable !"
                        </p>
                    </div>

                    <div class="glass-card p-8 reveal" style="animation-delay: 0.2s">
                        <div class="flex items-center mb-6">
                            <div
                                class="w-12 h-12 rounded-full bg-gradient-to-r from-emerald-600 to-green-500 flex items-center justify-center text-white font-bold mr-4">
                                SC
                            </div>
                            <div>
                                <div class="font-bold">Sarah Cohen</div>
                                <div class="text-sm text-gray-400">Professeure d'université</div>
                            </div>
                        </div>
                        <div class="text-yellow-400 mb-4">★★★★★</div>
                        <p class="text-gray-300 italic">
                            "Mes cours en ligne n'ont jamais été aussi interactifs. Les quiz en direct et le chat modéré
                            permettent de maintenir l'attention des étudiants tout au long de la session."
                        </p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>




    <section id="faq" class="section-spacing py-16 md:py-24 bg-gradient-to-t from-gray-900 to-gray-800">
        <div class="container-narrow max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="text-center mb-16 reveal">
                <h2 class="text-4xl md:text-5xl font-bold mb-4 text-white">
                    Expertise <span class="text-gradient">et Transparence</span>
                </h2>
                <p class="text-xl text-gray-400 max-w-3xl mx-auto">
                    Toutes les questions que vous vous posez sur les fonctionnalités, la tarification et l'utilisation
                    de la plateforme.
                </p>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">

                <div class="glass-card p-6 reveal border-t-8 border-violet-600 shadow-xl flex flex-col h-full cursor-pointer  transition duration-300"
                    onclick="openModal('q1')">
                    <i class="fas fa-calendar-alt text-violet-400 text-3xl mb-4"></i>
                    <h3 class="text-xl font-bold text-white mb-2">Comment créer un événement rapidement ?</h3>
                    <p class="text-gray-400 text-sm flex-grow">
                        Découvrez les étapes simples pour mettre en ligne et configurer votre premier événement en moins
                        de 5 minutes.
                    </p>
                </div>

                <div class="glass-card p-6 reveal border-t-8 border-violet-600 shadow-xl flex flex-col h-full cursor-pointer transition duration-300"
                    onclick="openModal('q2')">
                    <i class="fas fa-ticket-alt text-violet-400 text-3xl mb-4"></i>
                    <h3 class="text-xl font-bold text-white mb-2">Puis-je créer différents types de billets ?</h3>
                    <p class="text-gray-400 text-sm flex-grow">
                        Oui, la plateforme supporte la gestion de multiples catégories (VIP, Early Bird, Standard) et
                        les coupons de réduction.
                    </p>
                </div>

                <div class="glass-card p-6 reveal border-t-8 border-violet-600 shadow-xl flex flex-col h-full cursor-pointer transition duration-300"
                    onclick="openModal('q3')">
                    <i class="fas fa-chart-line text-violet-400 text-3xl mb-4"></i>
                    <h3 class="text-xl font-bold text-white mb-2">Comment fonctionne le suivi de promotion ?</h3>
                    <p class="text-gray-400 text-sm flex-grow">
                        Le plan Premium vous donne accès à des liens uniques pour suivre l'efficacité de vos campagnes
                        marketing (clics, inscriptions).
                    </p>
                </div>

                <div class="glass-card p-6 reveal border-t-8 border-violet-600 shadow-xl flex flex-col h-full cursor-pointer  transition duration-300"
                    onclick="openModal('q4')">
                    <i class="fas fa-users text-violet-400 text-3xl mb-4"></i>
                    <h3 class="text-xl font-bold text-white mb-2">Comment gérer l'accès le jour J ?</h3>
                    <p class="text-gray-400 text-sm flex-grow">
                        La billetterie est compatible avec le scan de QR codes via l'application mobile pour un contrôle
                        d'accès rapide et fiable.
                    </p>
                </div>

                <div class="glass-card p-6 reveal border-t-8 border-violet-600 shadow-xl flex flex-col h-full cursor-pointer transition duration-300"
                    onclick="openModal('q5')">
                    <i class="fas fa-comment-dots text-violet-400 text-3xl mb-4"></i>
                    <h3 class="text-xl font-bold text-white mb-2">Les participants peuvent-ils interagir ?</h3>
                    <p class="text-gray-400 text-sm flex-grow">
                        Oui, les participants ont accès à un dashboard pour le chat en direct, les votes et les
                        questions/réponses pendant l'événement.
                    </p>
                </div>

                <div class="glass-card p-6 reveal border-t-8 border-violet-600 shadow-xl flex flex-col h-full cursor-pointer transition duration-300"
                    onclick="openModal('q6')">
                    <i class="fas fa-hand-holding-usd text-violet-400 text-3xl mb-4"></i>
                    <h3 class="text-xl font-bold text-white mb-2">Y a-t-il des frais supplémentaires cachés ?</h3>
                    <p class="text-gray-400 text-sm flex-grow">
                        Nous garantissons une totale transparence : seuls les frais de service clairement indiqués lors
                        de la vente sont appliqués.
                    </p>
                </div>

            </div>
        </div>
    </section>
    <div id="faqModal"
        class="fixed inset-0 bg-gray-900  bg-opacity-75 z-[9999] hidden items-center justify-center p-4 transition-opacity duration-300">
        <div class="bg-gray-800 justify-center absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 rounded-xl max-w-2xl w-full p-6 md:p-8 shadow-2xl scale-95 transition-transform duration-300 border border-slate-700"
            id="modalContentWrapper">

            <div class="flex justify-between items-start mb-4">
                <h3 id="modalTitle" class="text-2xl font-bold text-gradient-accent">Titre de la Question</h3>
                <button class="text-gray-400 hover:text-white transition" onclick="closeModal()">
                    <i class="fas fa-times text-2xl"></i>
                </button>
            </div>

            <div id="modalBody" class="text-gray-300 space-y-4 max-h-96 overflow-y-auto pr-2">
            </div>

            <div class="mt-6 pt-4 border-t border-gray-700/50">
                <a href="{{ route('home') }}" class="text-sm font-semibold text-violet-400 hover:text-violet-300">
                    Vous avez encore des doutes ? Contactez-nous directement. <i class="fas fa-arrow-right ml-1"></i>
                </a>
            </div>
        </div>
    </div>


    <!-- CTA Final -->
    <section class="section-spacing py-16 md:py-32 ">
        <div class="container-narrow max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="p-8 md:p-12 reveal glass-card-gold rounded-3xl text-center shadow-2xl transition">

                <i class="fas fa-magic text-yellow-400 text-5xl mb-6"></i>

                <h2 class="text-4xl md:text-6xl font-extrabold mb-6 text-white leading-tight">
                    Prêt à créer des
                    <span class="text-transparent"
                        style="background-image: linear-gradient(to right, #FDE68A, #F59E0B); -webkit-background-clip: text; background-clip: text;">
                        expériences d'exception
                    </span> ?
                </h2>

                <p class="text-xl text-gray-300 mb-10 max-w-3xl mx-auto">
                    Rejoignez les milliers d'organisateurs qui transforment leurs événements avec la puissance
                    d'EventManager.
                </p>

                <div class="flex flex-col sm:flex-row gap-4 justify-center">

                    @auth
                        <a href="{{ route('events.create') }}"
                            class="text-xl px-10 py-4 shadow-xl transition duration-300 transform hover:scale-[1.03] font-bold rounded-lg"
                            style="background: linear-gradient(135deg, #FDE68A 0%, #FBBF24 100%); color: #1F2937; box-shadow: 0 5px 15px rgba(252, 211, 77, 0.4);">
                            <i class="fas fa-plus-circle mr-2"></i> Créer votre premier événement
                        </a>
                    @else
                        <a href="{{ route('register') }}"
                            class="text-xl px-10 py-4 shadow-xl transition duration-300 transform hover:scale-[1.03] font-bold rounded-lg"
                            style="background: linear-gradient(135deg, #FDE68A 0%, #FBBF24 100%); color: #1F2937; box-shadow: 0 5px 15px rgba(252, 211, 77, 0.4);">
                            <i class="fas fa-rocket mr-2"></i> Commencer gratuitement
                        </a>
                    @endauth


                </div>

                <p class="text-gray-400 text-sm mt-8">
                    <i class="fas fa-credit-card text-gray-500 mr-1"></i> Aucune carte bancaire requise • Formule
                    Starter disponible pour toujours
                </p>
            </div>

        </div>
    </section>


    <!-- Footer -->
    <footer class="py-12 border-t bg-neutral-800/50 border-white/10">
        <div class="container-narrow">
            <div class="grid md:grid-cols-4 gap-8 mb-8">
                <!-- Brand -->
                <div>
                    <a href="{{ url('/') }}" class="flex items-center mb-3 space-x-3 z-20">
                        <div
                            class="w-10 h-10 bg-gradient-to-br from-indigo-600 to-indigo-600 rounded-xl flex items-center justify-center text-white font-bold shadow-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round"
                                class="lucide lucide-calendar-days-icon lucide-calendar-days">
                                <path d="M8 2v4" />
                                <path d="M16 2v4" />
                                <rect width="18" height="18" x="3" y="4" rx="2" />
                                <path d="M3 10h18" />
                                <path d="M8 14h.01" />
                                <path d="M12 14h.01" />
                                <path d="M16 14h.01" />
                                <path d="M8 18h.01" />
                                <path d="M12 18h.01" />
                                <path d="M16 18h.01" />
                            </svg>
                        </div>
                        <span class="text-xl font-bold text-white">EventManager</span>
                    </a>
                    <p class="text-gray-400 text-sm">
                        La plateforme événementielle immersive qui révolutionne l'organisation et la participation aux
                        événements.
                    </p>
                </div>

                <!-- Liens rapides -->
                <div>
                    <h3 class="font-bold mb-4">Navigation</h3>
                    <ul class="space-y-2">
                        <li><a href="#features"
                                class="text-gray-400 hover:text-white transition-colors">Fonctionnalités</a></li>
                        <li><a href="#how-it-works" class="text-gray-400 hover:text-white transition-colors">Comment
                                ça marche</a></li>
                        <li><a href="#events" class="text-gray-400 hover:text-white transition-colors">Événements</a>
                        </li>
                        <li><a href="#testimonials"
                                class="text-gray-400 hover:text-white transition-colors">Témoignages</a></li>
                    </ul>
                </div>

                <!-- Ressources -->
                <div>
                    <h3 class="font-bold mb-4">Ressources</h3>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-400 hover:text-white transition-colors">Centre
                                d'aide</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition-colors">Blog</a></li>
                        <li><a href="#"
                                class="text-gray-400 hover:text-white transition-colors">Documentation</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition-colors">API</a></li>
                    </ul>
                </div>

                <!-- Légale -->
                <div>
                    <h3 class="font-bold mb-4">Légal</h3>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-400 hover:text-white transition-colors">Conditions
                                d'utilisation</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition-colors">Politique de
                                confidentialité</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition-colors">Mentions
                                légales</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition-colors">Cookies</a>
                        </li>
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

    @if ($nextEventStartIso)
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const eventDate = new Date("{{ $nextEventStartIso }}").getTime();
                const countdownDisplay = document.getElementById('nextEventCountdownDisplay');

                const updateCountdown = () => {
                    const now = new Date().getTime();
                    const distance = eventDate - now;

                    if (distance < 0) {
                        countdownDisplay.innerHTML =
                            '<span class="text-red-400 font-bold text-xl">ÉVÉNEMENT EN COURS !</span>';
                        clearInterval(interval);
                        return;
                    }

                    const days = Math.floor(distance / (1000 * 60 * 60 * 24));
                    const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                    const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                    const seconds = Math.floor((distance % (1000 * 60)) / 1000);

                    const countdownData = [{
                            value: days,
                            label: 'Jours'
                        },
                        {
                            value: hours,
                            label: 'Heures'
                        },
                        {
                            value: minutes,
                            label: 'Min'
                        },
                        {
                            value: seconds,
                            label: 'Sec'
                        }
                    ];

                    countdownDisplay.innerHTML = countdownData.map(item => `
                        <div class="btn-gradient-secondary text-center items-center p-4 rounded-xl justify-center">
                            <div class="text-3xl font-bold text-white">${item.value.toString().padStart(2, '0')}</div>
                            <div class="text-xs text-gray-100 text-center uppercase tracking-wider">${item.label}</div>
                        </div>
                    `).join('');
                };

                const interval = setInterval(updateCountdown, 1000);
                updateCountdown(); // Appel initial
            });
        </script>
    @endif

    <script>
        // Fonction pour animer les compteurs
        function animateCounters() {
            document.querySelectorAll('.stat-counter').forEach(counter => {
                const target = parseInt(counter.dataset.count);
                let current = 0;
                const duration = 2000;
                const start = performance.now();

                function update(timestamp) {
                    const elapsed = timestamp - start;
                    const progress = Math.min(elapsed / duration, 1);
                    current = Math.floor(progress * target);
                    counter.textContent = current.toLocaleString();

                    if (progress < 1) {
                        requestAnimationFrame(update);
                    }
                }
                requestAnimationFrame(update);
            });
        }

        // Intersection Observer pour révéler les éléments
        const observerOptions = {
            root: null,
            rootMargin: '0px',
            threshold: 0.1
        };

        const observer = new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');

                    // Si l'élément est dans la section des stats, animer les compteurs
                    if (entry.target.closest('.hero-section') && entry.target.classList.contains(
                            'animate-slide-in-up')) {
                        animateCounters();
                    }

                    // Une fois visible, on peut arrêter d'observer
                    observer.unobserve(entry.target);
                }
            });
        }, observerOptions);

        document.querySelectorAll('.reveal, .animate-slide-in-up').forEach(element => {
            observer.observe(element);
        });

        // Gestion de la navigation (scrolled state)
        document.addEventListener('scroll', () => {
            const nav = document.getElementById('mainNav');
            if (window.scrollY > 50) {
                nav.classList.add('scrolled');
            } else {
                nav.classList.remove('scrolled');
            }

            // Scroll Progress
            const winScroll = document.body.scrollTop || document.documentElement.scrollTop;
            const height = document.documentElement.scrollHeight - document.documentElement.clientHeight;
            const scrolled = (winScroll / height) * 100;
            document.getElementById("scrollProgress").style.width = scrolled + "%";
        });

        // Mobile Menu Toggle
        document.addEventListener('DOMContentLoaded', function() {
            const menuBtn = document.getElementById('mobileMenuBtn');
            const menuContent = document.getElementById('mobileMenuContent');
            const menuIconOpen = document.getElementById('menuIconOpen'); // Hamburger
            const menuIconClose = document.getElementById('menuIconClose'); // Croix

            // Fonction pour basculer les icônes
            function toggleIcons(isOpen) {
                if (isOpen) {
                    menuIconOpen.classList.add('hidden');
                    menuIconClose.classList.remove('hidden');
                } else {
                    menuIconOpen.classList.remove('hidden');
                    menuIconClose.classList.add('hidden');
                }
            }
            menuIconOpen.classList.remove('hidden');
            menuIconClose.classList.add('hidden');

            // Fonction de basculement principale
            function toggleMobileMenu() {
                const isOpen = menuContent.classList.contains('opacity-100');

                if (isOpen) {
                    // Fermeture
                    menuContent.classList.add('-translate-y-full', 'opacity-0');
                    menuContent.classList.remove('translate-y-0', 'opacity-100');
                    document.body.style.overflow = ''; // Réactiver le scroll
                    toggleIcons(false);
                } else {
                    // Ouverture
                    menuContent.classList.remove('-translate-y-full', 'opacity-0');
                    menuContent.classList.add('translate-y-0', 'opacity-100');
                    document.body.style.overflow = 'hidden'; // Désactiver le scroll du corps
                    toggleIcons(true);
                }
            }

            // Événement au clic sur le bouton
            menuBtn.addEventListener('click', toggleMobileMenu);

            // Fonction pour fermer le menu lors du clic sur un lien ancre
            window.closeMobileMenu = function() {
                if (menuContent.classList.contains('opacity-100')) {
                    toggleMobileMenu();
                }
            }
        });


        // Base de données des questions/réponses faqs
        const faqData = {
            'q1': {
                title: "Comment créer un événement rapidement ?",
                body: `
                <p>La création se fait en 4 étapes simples via votre Dashboard Organisateur :</p>
                <ol class="list-decimal list-inside ml-4 space-y-2 mt-2">
                    <li>**Détails de base :** Nom, date, heure et lieu (physique ou virtuel).</li>
                    <li>**Configuration Billetterie :** Définissez vos catégories de billets, leur prix et les quotas par catégorie.</li>
                    <li>**Personnalisation :** Ajoutez des images, une description attrayante, et définissez les options de chat/Q&A.</li>
                    <li>**Publication :** Après vérification, votre événement est immédiatement visible sur le catalogue de l'application et vous recevez votre lien de promotion unique (plans Premium/Élite).</li>
                </ol>
                <p class="mt-4 text-violet-300">Temps estimé pour la publication : 5 minutes.</p>
            `
            },
            'q2': {
                title: "Puis-je créer différents types de billets ?",
                body: `
                <p>Oui, notre système de billetterie est extrêmement flexible. Vous pouvez configurer :</p>
                <ul class="list-disc list-inside ml-4 space-y-2 mt-2">
                    <li>**Billets à prix multiples :** Standard, VIP, Accès Presse, etc.</li>
                    <li>**Tarification dynamique :** Définissez des dates de début et de fin pour les tarifs spéciaux (Ex: Early Bird).</li>
                    <li>**Billets gratuits :** Utile pour les invités ou les événements gratuits nécessitant une inscription.</li>
                    <li>**Coupons et Codes de Réduction :** Créez des codes promotionnels pour offrir des pourcentages ou des montants fixes de réduction.</li>
                </ul>
            `
            },
            'q3': {
                title: "Comment fonctionne le suivi de promotion ?",
                body: `
                <p>Disponible pour les plans Premium et Élite, cette fonctionnalité est cruciale pour optimiser vos dépenses marketing :</p>
                <p class="text-violet-300 font-semibold">Méthode :</p>
                <p>Vous générez des liens de promotion uniques (UTM) pour chaque canal (Facebook, Instagram, Email, Partenaire A). Notre système enregistre :</p>
                <ul class="list-disc list-inside ml-4 space-y-2 mt-2">
                    <li>Le nombre de clics reçus par ce lien.</li>
                    <li>Le nombre d'inscriptions ou de ventes générées directement par ce lien.</li>
                    <li>Le taux de conversion.</li>
                </ul>
                <p class="mt-4">Cela vous permet de savoir exactement quel canal vous apporte le meilleur retour sur investissement (ROI).</p>
            `
            },
            'q4': {
                title: "Comment gérer l'accès le jour J ?",
                body: `
                <p>Nous facilitons l'entrée de vos participants grâce à deux méthodes principales :</p>
                <ol class="list-decimal list-inside ml-4 space-y-2 mt-2">
                    <li>**QR Code mobile :** Chaque participant reçoit un billet unique avec un QR code scannable via n'importe quel smartphone avec notre application d'organisateur. Le scan vérifie instantanément la validité du billet et marque le participant comme présent.</li>
                    <li>**Liste d'invités numérique :** Vous pouvez également rechercher manuellement le nom du participant sur votre liste numérique en cas de problème de QR code.</li>
                </ol>
                <p class="mt-4 text-violet-300">Le processus est rapide (moins de 2 secondes par participant) et réduit les files d'attente.</p>
            `
            },
            'q5': {
                title: "Les participants peuvent-ils interagir pendant l'événement ?",
                body: `
                <p>Oui, nous offrons des outils pour maximiser l'engagement des participants, transformant les spectateurs en acteurs :</p>
                <ul class="list-disc list-inside ml-4 space-y-2 mt-2">
                    <li>**Chat en Direct :** Permet des échanges instantanés et des modérations par l'organisateur (selon le plan).</li>
                    <li>**Sondages et Votes :** Lancez des sondages en direct pour recueillir des opinions ou influencer le déroulement de l'événement.</li>
                    <li>**Session Q&A :** Les participants peuvent poser des questions qui peuvent être affichées et votées par les autres pour les prioriser.</li>
                </ul>
                <p class="mt-4">Ces outils sont accessibles via le Dashboard Participant.</p>
            `
            },
            'q6': {
                title: "Y a-t-il des frais supplémentaires cachés ?",
                body: `
                <p>Absolument pas. La transparence est notre engagement principal :</p>
                <ul class="list-disc list-inside ml-4 space-y-2 mt-2">
                    <li>**Abonnement mensuel :** Le prix fixe (30 000, 60 000 ou 90 000 FCFA) couvre l'accès aux fonctionnalités du plan choisi.</li>
                    <li>**Frais de service (Commission) :** C'est le seul frais additionnel, appliqué par transaction (vente de billet). Ce pourcentage est clairement affiché dans votre contrat et ne change pas.</li>
                    <li>**Pas de frais de retrait :** Nous ne facturons pas de frais pour le transfert des fonds de billetterie vers votre compte bancaire/mobile money.</li>
                </ul>
            `
            }
        };

        const modal = document.getElementById('faqModal');
        const modalTitle = document.getElementById('modalTitle');
        const modalBody = document.getElementById('modalBody');
        const modalContentWrapper = document.getElementById('modalContentWrapper');

        function openModal(questionId) {
            const data = faqData[questionId];

            if (!data) return;

            // Remplir le contenu du modal
            modalTitle.innerHTML = data.title;
            modalBody.innerHTML = data.body;

            // Afficher le modal
            modal.classList.remove('hidden');

            // Appliquer la transformation pour l'animation (légèrement retardée)
            setTimeout(() => {
                modalContentWrapper.classList.remove('scale-95');
                modalContentWrapper.classList.add('scale-100');
            }, 10);
        }

        function closeModal() {
            // Appliquer la transformation inverse
            modalContentWrapper.classList.remove('scale-100');
            modalContentWrapper.classList.add('scale-95');

            // Cacher le modal après la transition
            setTimeout(() => {
                modal.classList.add('hidden');
            }, 300);
        }

        // Fermeture du modal en cliquant à l'extérieur
        modal.addEventListener('click', function(event) {
            if (event.target === modal) {
                closeModal();
            }
        });

        // Fermeture du modal avec la touche Échap
        document.addEventListener('keydown', function(event) {
            if (event.key === "Escape" && !modal.classList.contains('hidden')) {
                closeModal();
            }
        });
    </script>

    {{-- Stories Modal & Scripts --}}
    @php
        $allStoriesData = \App\Models\EventStory::with('event')
            ->active()
            ->ordered()
            ->get()
            ->groupBy('event_id');
    @endphp

    @if($allStoriesData->isNotEmpty())
        <x-stories-viewer :stories="$allStoriesData" />
    @endif
</body>

</html>
