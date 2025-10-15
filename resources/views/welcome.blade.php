<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description"
        content="Gérez et participez à des événements facilement avec notre plateforme de gestion d'événements.">

    <title>EventManager - Gestion d'événements</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />

    <!-- Favicon -->
    <link rel="icon" href="{{ asset('favicon.ico') }}">

    <!-- Styles / Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        .gradient-bg {
            background: linear-gradient(135deg, #4F46E5 0%, #3730A3 50%, #1E3A8A 100%);
        }

        .hero-gradient {
            background: radial-gradient(circle at 50% 50%, rgba(79, 70, 229, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 80% 20%, rgba(30, 58, 138, 0.15) 0%, transparent 50%),
                radial-gradient(circle at 20% 80%, rgba(99, 102, 241, 0.1) 0%, transparent 50%);
        }

        .floating-element {
            animation: float 6s ease-in-out infinite;
        }

        .floating-element-2 {
            animation: float 8s ease-in-out infinite;
        }

        .floating-element-3 {
            animation: float 7s ease-in-out infinite;
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0px) rotate(0deg);
            }

            50% {
                transform: translateY(-20px) rotate(5deg);
            }
        }

        .card-hover {
            transition: all 0.3s ease;
        }

        .card-hover:hover {
            transform: translateY(-8px);
            box-shadow: 0 25px 50px -12px rgba(79, 70, 229, 0.25);
        }

        .feature-icon {
            background: linear-gradient(135deg, #4F46E5 0%, #6366F1 100%);
            box-shadow: 0 10px 25px -5px rgba(79, 70, 229, 0.3);
        }

        .gradient-text {
            background: linear-gradient(135deg, #1E3A8A 0%, #4F46E5 50%, #6366F1 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .stats-gradient {
            background: linear-gradient(135deg, rgba(79, 70, 229, 0.05) 0%, rgba(224, 231, 255, 0.1) 100%);
        }

        .testimonial-bg {
            background: linear-gradient(135deg, #FFFFFF 0%, #F9FAFB 100%);
        }

        .pricing-card {
            transition: all 0.3s ease;
            background: linear-gradient(135deg, #FFFFFF 0%, #F9FAFB 100%);
        }

        .pricing-card:hover {
            transform: scale(1.05);
            box-shadow: 0 30px 60px -12px rgba(79, 70, 229, 0.25);
        }

        .pricing-card.featured {
            background: linear-gradient(135deg, #4F46E5 0%, #6366F1 100%);
            color: white;
        }

        .grid-pattern {
            background-image:
                linear-gradient(rgba(79, 70, 229, 0.03) 1px, transparent 1px),
                linear-gradient(90deg, rgba(79, 70, 229, 0.03) 1px, transparent 1px);
            background-size: 50px 50px;
        }

        .pulse-ring {
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% {
                transform: scale(1);
                opacity: 1;
            }

            50% {
                transform: scale(1.05);
                opacity: 0.8;
            }

            100% {
                transform: scale(1);
                opacity: 1;
            }
        }
    </style>
</head>

<body class="min-h-full bg-[#F9FAFB] overflow-x-hidden">
    <!-- Navigation -->
    <nav class="fixed top-0 w-full bg-white/80 backdrop-blur-md z-50 border-b border-[#E0E7FF]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex-shrink-0 flex items-center">
                    <a href="{{ url('/') }}" class="flex items-center space-x-3">
                        <div
                            class="flex items-center justify-center h-10 w-10 rounded-xl bg-gradient-to-r from-[#4F46E5] to-[#6366F1] text-white font-bold shadow-lg pulse-ring">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <span
                            class="text-2xl font-bold bg-gradient-to-r from-[#1E3A8A] to-[#4F46E5] bg-clip-text text-transparent">EventManager</span>
                    </a>
                </div>
                <div class="hidden sm:ml-6 sm:flex sm:items-center space-x-8">
                    <a href="#features"
                        class="px-3 py-2 text-sm font-medium text-[#6B7280] hover:text-[#1E3A8A] transition-colors duration-200">Fonctionnalités</a>
                    <a href="#events"
                        class="px-3 py-2 text-sm font-medium text-[#6B7280] hover:text-[#1E3A8A] transition-colors duration-200">Événements</a>
                    <a href="#pricing"
                        class="px-3 py-2 text-sm font-medium text-[#6B7280] hover:text-[#1E3A8A] transition-colors duration-200">Tarifs</a>
                    <a href="#testimonials"
                        class="px-3 py-2 text-sm font-medium text-[#6B7280] hover:text-[#1E3A8A] transition-colors duration-200">Avis</a>
                    @auth
                        <a href="{{ route('dashboard') }}"
                            class="px-4 py-2 text-sm  text-[#4F46E5] hover:text-[#3730A3] transition-colors duration-200 font-semibold">Tableau
                            de bord</a>
                    @else
                        <a href="{{ route('login') }}"
                            class="px-4 py-2 text-sm  text-[#4F46E5] hover:text-[#3730A3] transition-colors duration-200 font-semibold">Connexion</a>
                        <a href="{{ route('register') }}"
                            class="px-4 py-2 text-sm font-medium text-white bg-gradient-to-r from-[#4F46E5] to-[#6366F1] rounded-lg hover:from-[#3730A3] hover:to-[#4F46E5] transition-all duration-200 shadow-lg hover:shadow-xl">
                            S'inscrire
                        </a>
                    @endauth
                </div>
                <!-- Mobile menu button -->
                <div class="sm:hidden flex items-center">
                    <button type="button" id="mobile-menu-button"
                        class="inline-flex items-center justify-center p-2 rounded-lg text-[#6B7280] hover:text-[#1E3A8A] hover:bg-[#E0E7FF] focus:outline-none focus:ring-2 focus:ring-[#4F46E5] focus:ring-inset transition-colors duration-200"
                        aria-expanded="false">
                        <span class="sr-only">Ouvrir le menu principal</span>
                        <svg class="block h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section
        class="relative min-h-screen flex items-center justify-center overflow-hidden gradient-bg text-white pt-16">
        <div class="absolute inset-0 hero-gradient"></div>

        <!-- Animated background elements -->
        <div class="absolute top-1/4 left-1/4 w-64 h-64 bg-[#E0E7FF] rounded-full opacity-10 blur-3xl floating-element">
        </div>
        <div
            class="absolute bottom-1/4 right-1/4 w-96 h-96 bg-[#4F46E5] rounded-full opacity-5 blur-3xl floating-element-2">
        </div>
        <div
            class="absolute top-1/2 left-1/2 w-80 h-80 bg-[#1E3A8A] rounded-full opacity-5 blur-3xl floating-element-3">
        </div>

        <div class="relative max-w-7xl max-sm:py-12  mx-auto px-4 sm:px-6 lg:px-8 text-center z-10">
            <div
                class="inline-flex items-center space-x-2 bg-white/10 px-4 py-2 rounded-full text-sm font-semibold text-white mb-8 backdrop-blur-sm border border-white/20">
                <span
                    class="inline-flex h-6 w-6 items-center justify-center rounded-full bg-white text-[#4F46E5] font-bold">🎯</span>
                <span>Plateforme événementielle EventManager</span>
            </div>

            <h1 class="text-5xl sm:text-6xl lg:text-7xl font-extrabold tracking-tight mb-6 leading-tight">
                <span class="block">Organisez des</span>
                <span class="block bg-gradient-to-r from-white to-[#E0E7FF] bg-clip-text text-transparent">événements
                    mémorables</span>
            </h1>

            <p class="text-xl sm:text-2xl text-[#E0E7FF] max-w-4xl mx-auto mb-12 leading-relaxed">
                Créez, gérez et promouvez vos événements avec notre plateforme tout-en-un.
                <span class="font-semibold text-white">Simplifiez l'organisation, maximisez l'impact.</span>
            </p>

            <div class="flex flex-col sm:flex-row gap-4 justify-center items-center mb-16">
                @auth
                    <a href="{{ route('events.create') }}"
                        class="group inline-flex items-center justify-center px-8 py-4 text-lg font-semibold rounded-2xl text-[#4F46E5] bg-white hover:bg-[#E0E7FF] transition-all duration-300 shadow-2xl hover:shadow-3xl transform hover:scale-105">
                        <svg class="h-6 w-6 mr-3 group-hover:rotate-90 transition-transform duration-300" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        Créer un événement
                    </a>
                @else
                    <a href="{{ route('register') }}"
                        class="group inline-flex items-center justify-center px-8 py-4 text-lg font-semibold rounded-2xl text-[#4F46E5] bg-white hover:bg-[#E0E7FF] transition-all duration-300 shadow-2xl hover:shadow-3xl transform hover:scale-105">
                        Commencer gratuitement
                        <svg class="h-5 w-5 ml-2 group-hover:translate-x-1 transition-transform duration-300" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 7l5 5m0 0l-5 5m5-5H6" />
                        </svg>
                    </a>
                @endauth
                <a href="#features"
                    class="group inline-flex items-center justify-center px-8 py-4 text-lg font-semibold rounded-2xl text-white border-2 border-white/30 hover:border-white/50 hover:bg-white/10 transition-all duration-300 backdrop-blur-sm">
                    <svg class="h-5 w-5 mr-2 group-hover:animate-bounce" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                    Découvrir les features
                </a>
            </div>

            <!-- Stats -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8 max-w-4xl mx-auto">
                <div class="text-center">
                    <div class="text-3xl font-bold text-white">50K+</div>
                    <div class="text-[#E0E7FF] text-sm">Événements créés</div>
                </div>
                <div class="text-center">
                    <div class="text-3xl font-bold text-white">2M+</div>
                    <div class="text-[#E0E7FF] text-sm">Participants</div>
                </div>
                <div class="text-center">
                    <div class="text-3xl font-bold text-white">98%</div>
                    <div class="text-[#E0E7FF] text-sm">Satisfaction</div>
                </div>
                <div class="text-center">
                    <div class="text-3xl font-bold text-white">24/7</div>
                    <div class="text-[#E0E7FF] text-sm">Support</div>
                </div>
            </div>
        </div>

        <!-- Scroll indicator -->
        <div class="absolute bottom-8 left-1/2 transform -translate-x-1/2 animate-bounce">
            <div class="w-6 h-10 border-2 border-white/50 rounded-full flex justify-center">
                <div class="w-1 h-3 bg-white/50 rounded-full mt-2"></div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="py-20 bg-white relative">
        <div class="absolute inset-0 grid-pattern"></div>
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-extrabold text-[#1E3A8A] sm:text-5xl">
                    Des outils <span class="gradient-text">puissants</span> pour vos événements
                </h2>
                <p class="mt-6 text-xl text-[#6B7280] max-w-3xl mx-auto leading-relaxed">
                    Tout ce dont vous avez besoin pour créer, promouvoir et gérer des événements exceptionnels
                </p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center mb-20">
                <div>
                    <div class="flex items-center space-x-2 text-[#4F46E5] font-semibold mb-4">
                        <div class="w-2 h-2 bg-[#4F46E5] rounded-full"></div>
                        <span>CRÉATION SIMPLIFIÉE</span>
                    </div>
                    <h3 class="text-3xl font-bold text-[#1E3A8A] mb-6">Créez des événements en quelques clics</h3>
                    <p class="text-lg text-[#6B7280] mb-8 leading-relaxed">
                        Notre interface intuitive vous guide pas à pas dans la création de votre événement.
                        Personnalisez tous les détails et lancez-vous en toute confiance.
                    </p>
                    <ul class="space-y-4">
                        <li class="flex items-center text-[#6B7280]">
                            <svg class="h-6 w-6 text-[#4F46E5] mr-3" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                            Éditeur visuel drag & drop
                        </li>
                        <li class="flex items-center text-[#6B7280]">
                            <svg class="h-6 w-6 text-[#4F46E5] mr-3" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                            Modèles personnalisables
                        </li>
                        <li class="flex items-center text-[#6B7280]">
                            <svg class="h-6 w-6 text-[#4F46E5] mr-3" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                            Intégration de paiement
                        </li>
                    </ul>
                </div>
                <div class="relative">
                    <div class="bg-gradient-to-br from-[#4F46E5] to-[#6366F1] rounded-3xl p-8 text-white card-hover">
                        <div class="grid grid-cols-2 gap-4">
                            <div class="bg-white/10 rounded-2xl p-4 backdrop-blur-sm">
                                <div class="text-2xl font-bold">📅</div>
                                <div class="text-sm mt-2">Planification</div>
                            </div>
                            <div class="bg-white/10 rounded-2xl p-4 backdrop-blur-sm">
                                <div class="text-2xl font-bold">🎫</div>
                                <div class="text-sm mt-2">Billeterie</div>
                            </div>
                            <div class="bg-white/10 rounded-2xl p-4 backdrop-blur-sm">
                                <div class="text-2xl font-bold">📊</div>
                                <div class="text-sm mt-2">Analytics</div>
                            </div>
                            <div class="bg-white/10 rounded-2xl p-4 backdrop-blur-sm">
                                <div class="text-2xl font-bold">👥</div>
                                <div class="text-sm mt-2">Participants</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Features Grid -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Feature 1 -->
                <div class="bg-[#F9FAFB] rounded-2xl p-8 border border-[#E0E7FF] card-hover">
                    <div class="flex items-center justify-center h-16 w-16 rounded-xl feature-icon text-white mb-6">
                        <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-[#1E3A8A] mb-4">Sécurité maximale</h3>
                    <p class="text-[#6B7280] leading-relaxed">
                        Vos données et transactions sont protégées par les meilleures standards de sécurité.
                    </p>
                </div>

                <!-- Feature 2 -->
                <div class="bg-[#F9FAFB] rounded-2xl p-8 border border-[#E0E7FF] card-hover">
                    <div class="flex items-center justify-center h-16 w-16 rounded-xl feature-icon text-white mb-6">
                        <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-[#1E3A8A] mb-4">Performance optimale</h3>
                    <p class="text-[#6B7280] leading-relaxed">
                        Temps de chargement ultra-rapide pour une expérience utilisateur fluide.
                    </p>
                </div>

                <!-- Feature 3 -->
                <div class="bg-[#F9FAFB] rounded-2xl p-8 border border-[#E0E7FF] card-hover">
                    <div class="flex items-center justify-center h-16 w-16 rounded-xl feature-icon text-white mb-6">
                        <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-[#1E3A8A] mb-4">Gestion d'équipe</h3>
                    <p class="text-[#6B7280] leading-relaxed">
                        Collaborez avec votre équipe et assignez des rôles spécifiques à chaque membre.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Events Section -->
    <section id="events" class="py-20 bg-[#F9FAFB]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-extrabold text-[#1E3A8A] sm:text-5xl">
                    Événements <span class="gradient-text">populaires</span>
                </h2>
                <p class="mt-6 text-xl text-[#6B7280] max-w-3xl mx-auto">
                    Découvrez les prochains événements créés par notre communauté
                </p>
            </div>

            <!-- Events grid would go here -->
            <div class="text-center">
                <a href="{{ route('events.index') }}"
                    class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-xl text-white bg-gradient-to-r from-[#4F46E5] to-[#6366F1] hover:from-[#3730A3] hover:to-[#4F46E5] transition-all duration-200 shadow-lg hover:shadow-xl">
                    Voir tous les événements
                </a>
            </div>
        </div>
    </section>

    <!-- Pricing Section -->
    <section id="pricing" class="py-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-extrabold text-gray-900 sm:text-5xl">
                    Des tarifs <span class="text-indigo-600">adaptés</span> à vos besoins
                </h2>
                <p class="mt-4 text-xl text-gray-600 max-w-2xl mx-auto">
                    Choisissez la formule qui correspond à votre ambition. Tous nos plans incluent les fonctionnalités
                    essentielles.
                </p>

                <!-- Billing Toggle -->
                <div class="mt-8 flex justify-center">
                    <div class="relative bg-white rounded-lg p-1 shadow-sm border border-gray-200">
                        <div class="flex">
                            <button type="button"
                                class="relative py-2 px-6 text-sm font-medium text-gray-700 rounded-md billing-toggle active"
                                data-billing="monthly">
                                Mensuel
                            </button>
                            <button type="button"
                                class="relative py-2 px-6 text-sm font-medium text-gray-700 rounded-md billing-toggle"
                                data-billing="yearly">
                                Annuel <span
                                    class="ml-1 px-2 py-1 text-xs bg-green-100 text-green-800 rounded-full">-20%</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 max-w-5xl mx-auto">
                <!-- Basic Plan -->
                <div
                    class="relative rounded-2xl border border-gray-200 bg-white p-8 flex flex-col transition-all duration-300 hover:scale-105 hover:shadow-xl">
                    <div class="text-center mb-6">
                        <h3 class="text-2xl font-bold text-gray-900">Basique</h3>
                        <p class="mt-2 text-gray-500">Idéal pour débuter</p>

                        <div class="mt-6">
                            <div class="monthly-price">
                                <span class="text-4xl font-bold text-gray-900">30 000</span>
                                <span class="text-gray-500">FCFA / mois</span>
                            </div>
                            <div class="yearly-price hidden">
                                <span class="text-4xl font-bold text-gray-900">288 000</span>
                                <span class="text-gray-500">FCFA / an</span>
                                <div class="text-sm text-green-600 font-semibold mt-1">Économisez 72 000 FCFA</div>
                            </div>
                        </div>
                    </div>

                    <ul class="mt-6 space-y-4 flex-1">
                        <li class="flex items-center text-sm text-gray-600">
                            <svg class="h-5 w-5 text-green-500 mr-3" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                            50 places max par événement
                        </li>
                        <li class="flex items-center text-sm text-gray-600">
                            <svg class="h-5 w-5 text-green-500 mr-3" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                            10 événements par mois
                        </li>
                        <li class="flex items-center text-sm text-gray-600">
                            <svg class="h-5 w-5 text-green-500 mr-3" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                            Billets QR Code personnalisés
                        </li>
                        <li class="flex items-center text-sm text-gray-600">
                            <svg class="h-5 w-5 text-green-500 mr-3" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                            Support par email
                        </li>
                        <li class="flex items-center text-sm text-gray-600">
                            <svg class="h-5 w-5 text-green-500 mr-3" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                            Statistiques de base
                        </li>
                        <li class="flex items-center text-sm text-gray-400">
                            <svg class="h-5 w-5 text-gray-400 mr-3" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                            Support prioritaire
                        </li>
                    </ul>

                    <div class="mt-8 pt-6 border-t border-gray-200">
                        <button type="button"
                            class="kkiapay-subscribe w-full bg-indigo-600 text-white py-3 px-4 rounded-xl font-semibold hover:bg-indigo-700 transition-colors duration-200 shadow-md"
                            data-plan="basic" data-amount="30000">
                            Choisir ce plan
                        </button>
                    </div>
                </div>

                <!-- Premium Plan -->
                <div
                    class="relative rounded-2xl border-2 border-indigo-500 bg-white p-8 flex flex-col shadow-lg transition-all duration-300 hover:scale-105 hover:shadow-xl">
                    <div class="absolute top-0 left-1/2 transform -translate-x-1/2 -translate-y-1/2">
                        <span
                            class="inline-flex items-center px-4 py-1 rounded-full text-xs font-semibold bg-indigo-100 text-indigo-800">
                            Populaire
                        </span>
                    </div>

                    <div class="text-center mb-6">
                        <h3 class="text-2xl font-bold text-gray-900">Premium</h3>
                        <p class="mt-2 text-gray-500">Pour monter en puissance</p>

                        <div class="mt-6">
                            <div class="monthly-price">
                                <span class="text-4xl font-bold text-gray-900">60 000</span>
                                <span class="text-gray-500">FCFA / mois</span>
                            </div>
                            <div class="yearly-price hidden">
                                <span class="text-4xl font-bold text-gray-900">576 000</span>
                                <span class="text-gray-500">FCFA / an</span>
                                <div class="text-sm text-green-600 font-semibold mt-1">Économisez 144 000 FCFA</div>
                            </div>
                        </div>
                    </div>

                    <ul class="mt-6 space-y-4 flex-1">
                        <li class="flex items-center text-sm text-gray-600">
                            <svg class="h-5 w-5 text-green-500 mr-3" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                            150 places max par événement
                        </li>
                        <li class="flex items-center text-sm text-gray-600">
                            <svg class="h-5 w-5 text-green-500 mr-3" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                            30 événements par mois
                        </li>
                        <li class="flex items-center text-sm text-gray-600">
                            <svg class="h-5 w-5 text-green-500 mr-3" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                            Billets QR Code premium
                        </li>
                        <li class="flex items-center text-sm text-gray-600">
                            <svg class="h-5 w-5 text-green-500 mr-3" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                            Support prioritaire
                        </li>
                        <li class="flex items-center text-sm text-gray-600">
                            <svg class="h-5 w-5 text-green-500 mr-3" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                            Statistiques avancées
                        </li>
                        <li class="flex items-center text-sm text-gray-600">
                            <svg class="h-5 w-5 text-green-500 mr-3" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                            Personnalisation de base
                        </li>
                    </ul>

                    <div class="mt-8 pt-6 border-t border-gray-200">
                        <button type="button"
                            class="kkiapay-subscribe w-full bg-indigo-600 text-white py-3 px-4 rounded-xl font-semibold hover:bg-indigo-700 transition-colors duration-200 shadow-md"
                            data-plan="premium" data-amount="60000">
                            Choisir ce plan
                        </button>
                    </div>
                </div>

                <!-- Pro Plan -->
                <div
                    class="relative rounded-2xl border border-gray-200 bg-gradient-to-br from-indigo-50 to-white p-8 flex flex-col transition-all duration-300 hover:scale-105 hover:shadow-xl">
                    <div class="text-center mb-6">
                        <h3 class="text-2xl font-bold text-gray-900">Professionnel</h3>
                        <p class="mt-2 text-gray-500">Pour les pros exigeants</p>

                        <div class="mt-6">
                            <div class="monthly-price">
                                <span class="text-4xl font-bold text-gray-900">90 000</span>
                                <span class="text-gray-500">FCFA / mois</span>
                            </div>
                            <div class="yearly-price hidden">
                                <span class="text-4xl font-bold text-gray-900">864 000</span>
                                <span class="text-gray-500">FCFA / an</span>
                                <div class="text-sm text-green-600 font-semibold mt-1">Économisez 216 000 FCFA</div>
                            </div>
                        </div>
                    </div>

                    <ul class="mt-6 space-y-4 flex-1">
                        <li class="flex items-center text-sm text-gray-600">
                            <svg class="h-5 w-5 text-green-500 mr-3" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                            Places illimitées par événement
                        </li>
                        <li class="flex items-center text-sm text-gray-600">
                            <svg class="h-5 w-5 text-green-500 mr-3" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                            100 événements par mois
                        </li>
                        <li class="flex items-center text-sm text-gray-600">
                            <svg class="h-5 w-5 text-green-500 mr-3" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                            Billets QR Code VIP
                        </li>
                        <li class="flex items-center text-sm text-gray-600">
                            <svg class="h-5 w-5 text-green-500 mr-3" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                            Support dédié 24/7
                        </li>
                        <li class="flex items-center text-sm text-gray-600">
                            <svg class="h-5 w-5 text-green-500 mr-3" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                            Analytics complets
                        </li>
                        <li class="flex items-center text-sm text-gray-600">
                            <svg class="h-5 w-5 text-green-500 mr-3" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                            Personnalisation totale
                        </li>
                    </ul>

                    <div class="mt-8 pt-6 border-t border-gray-200">
                        <button type="button"
                            class="kkiapay-subscribe w-full bg-indigo-600 text-white py-3 px-4 rounded-xl font-semibold hover:bg-indigo-700 transition-colors duration-200 shadow-md"
                            data-plan="pro" data-amount="90000">
                            Choisir ce plan
                        </button>
                    </div>
                </div>
            </div>

            <!-- Features Comparison Table -->
            <div class="mt-20 max-w-4xl mx-auto">
                <div class="text-center mb-12">
                    <h3 class="text-2xl font-bold text-gray-900">Comparaison des fonctionnalités</h3>
                    <p class="mt-2 text-gray-600">Découvrez ce qui est inclus dans chaque plan</p>
                </div>

                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b border-gray-200">
                                <th class="py-4 px-6 text-left text-sm font-semibold text-gray-900">Fonctionnalités
                                </th>
                                <th class="py-4 px-6 text-center text-sm font-semibold text-gray-900">Basique</th>
                                <th class="py-4 px-6 text-center text-sm font-semibold text-indigo-600">Premium</th>
                                <th class="py-4 px-6 text-center text-sm font-semibold text-gray-900">Pro</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="border-b border-gray-100">
                                <td class="py-4 px-6 text-sm text-gray-600">Places par événement</td>
                                <td class="py-4 px-6 text-center text-sm text-gray-600">50</td>
                                <td class="py-4 px-6 text-center text-sm text-indigo-600 font-semibold">150</td>
                                <td class="py-4 px-6 text-center text-sm text-gray-600 font-semibold">Illimité</td>
                            </tr>
                            <tr class="border-b border-gray-100">
                                <td class="py-4 px-6 text-sm text-gray-600">Événements par mois</td>
                                <td class="py-4 px-6 text-center text-sm text-gray-600">10</td>
                                <td class="py-4 px-6 text-center text-sm text-indigo-600 font-semibold">30</td>
                                <td class="py-4 px-6 text-center text-sm text-gray-600 font-semibold">100</td>
                            </tr>
                            <tr class="border-b border-gray-100">
                                <td class="py-4 px-6 text-sm text-gray-600">Type de billets</td>
                                <td class="py-4 px-6 text-center text-sm text-gray-600">Standard</td>
                                <td class="py-4 px-6 text-center text-sm text-indigo-600 font-semibold">Premium</td>
                                <td class="py-4 px-6 text-center text-sm text-gray-600 font-semibold">VIP</td>
                            </tr>
                            <tr class="border-b border-gray-100">
                                <td class="py-4 px-6 text-sm text-gray-600">Support</td>
                                <td class="py-4 px-6 text-center text-sm text-gray-600">Email</td>
                                <td class="py-4 px-6 text-center text-sm text-indigo-600 font-semibold">Prioritaire
                                </td>
                                <td class="py-4 px-6 text-center text-sm text-gray-600 font-semibold">Dédié 24/7</td>
                            </tr>
                            <tr>
                                <td class="py-4 px-6 text-sm text-gray-600">Analytics</td>
                                <td class="py-4 px-6 text-center text-sm text-gray-600">Basique</td>
                                <td class="py-4 px-6 text-center text-sm text-indigo-600 font-semibold">Avancé</td>
                                <td class="py-4 px-6 text-center text-sm text-gray-600 font-semibold">Complet</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- FAQ Section -->
            <div class="mt-20 max-w-4xl mx-auto">
                <div class="text-center mb-12">
                    <h3 class="text-2xl font-bold text-gray-900">Questions fréquentes</h3>
                    <p class="mt-2 text-gray-600">Tout ce que vous devez savoir sur nos tarifs</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-200">
                        <h4 class="font-semibold text-gray-900 mb-2">Puis-je changer de plan à tout moment ?</h4>
                        <p class="text-gray-600 text-sm">Oui, vous pouvez passer à un plan supérieur à tout moment. Le
                            changement vers un plan inférieur se fait à la fin de la période de facturation.</p>
                    </div>

                    <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-200">
                        <h4 class="font-semibold text-gray-900 mb-2">Y a-t-il des frais de résiliation ?</h4>
                        <p class="text-gray-600 text-sm">Non, aucun frais de résiliation. Vous pouvez annuler votre
                            abonnement à tout moment sans engagement.</p>
                    </div>

                    <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-200">
                        <h4 class="font-semibold text-gray-900 mb-2">Quels moyens de paiement acceptez-vous ?</h4>
                        <p class="text-gray-600 text-sm">Nous acceptons les cartes bancaires, Mobile Money (Orange
                            Money, MTN Money) et virements bancaires via KkiaPay.</p>
                    </div>

                    <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-200">
                        <h4 class="font-semibold text-gray-900 mb-2">Puis-je essayer avant d'acheter ?</h4>
                        <p class="text-gray-600 text-sm">Contactez-nous pour une démonstration personnalisée de la
                            plateforme avant de prendre votre décision.</p>
                    </div>
                </div>
            </div>

            <!-- CTA Section -->
            <div class="mt-16 text-center">
                <p class="text-gray-600 mb-6">Vous avez des besoins spécifiques ? Contactez-nous pour une solution sur
                    mesure.</p>
                <button
                    class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-xl text-white bg-indigo-600 hover:bg-indigo-700 transition-colors duration-200 shadow-md">
                    <svg class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                    </svg>
                    Contactez notre équipe
                </button>
            </div>
        </div>
    </section>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Billing Toggle Functionality
            const billingToggles = document.querySelectorAll('.billing-toggle');
            const monthlyPrices = document.querySelectorAll('.monthly-price');
            const yearlyPrices = document.querySelectorAll('.yearly-price');

            billingToggles.forEach(toggle => {
                toggle.addEventListener('click', function() {
                    const billingType = this.getAttribute('data-billing');

                    // Update active state
                    billingToggles.forEach(t => t.classList.remove('active', 'bg-indigo-600',
                        'text-white'));
                    this.classList.add('active', 'bg-indigo-600', 'text-white');

                    // Show/hide prices
                    if (billingType === 'monthly') {
                        monthlyPrices.forEach(p => p.classList.remove('hidden'));
                        yearlyPrices.forEach(p => p.classList.add('hidden'));
                    } else {
                        monthlyPrices.forEach(p => p.classList.add('hidden'));
                        yearlyPrices.forEach(p => p.classList.remove('hidden'));
                    }
                });
            });

            // KkiaPay Integration
            const subscribeButtons = document.querySelectorAll('.kkiapay-subscribe');

            subscribeButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const plan = this.getAttribute('data-plan');
                    const amount = this.getAttribute('data-amount');

                    // Integration with KkiaPay
                    console.log(`Abonnement au plan ${plan} pour ${amount} FCFA`);

                    // Exemple d'intégration KkiaPay (à adapter)
                    /*
                    window.kkiapay.open({
                        amount: amount,
                        plan: plan,
                        // autres paramètres KkiaPay
                    })
                    */
                });
            });
        });
    </script>

    <style>
        .billing-toggle.active {
            background-color: #4F46E5;
            color: white;
        }

        .billing-toggle {
            transition: all 0.3s ease;
        }

        .kkiapay-subscribe:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(79, 70, 229, 0.3);
        }

        /* Animation pour les cartes de pricing */
        .pricing-card {
            transition: all 0.3s ease;
        }

        .pricing-card:hover {
            transform: translateY(-5px);
        }
    </style>



    <style>
        .billing-toggle.active {
            background-color: #4F46E5;
            color: white;
        }

        .billing-toggle {
            transition: all 0.3s ease;
        }

        .kkiapay-subscribe:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(79, 70, 229, 0.3);
        }

        /* Animation pour les cartes de pricing */
        .pricing-card {
            transition: all 0.3s ease;
        }

        .pricing-card:hover {
            transform: translateY(-5px);
        }
    </style>

    <!-- Testimonials Section -->
    <section id="testimonials" class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-extrabold text-[#1E3A8A] sm:text-5xl">
                    Ils nous <span class="gradient-text">font confiance</span>
                </h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Testimonial 1 -->
                <div class="testimonial-bg rounded-2xl p-8 border border-[#E0E7FF] card-hover">
                    <div class="flex items-center mb-4">
                        <div class="text-2xl">⭐️⭐️⭐️⭐️⭐️</div>
                    </div>
                    <p class="text-[#6B7280] mb-6 italic">
                        "EventManager a révolutionné notre façon d'organiser des conférences. Simple, efficace et
                        professionnel."
                    </p>
                    <div class="flex items-center">
                        <div
                            class="h-12 w-12 bg-gradient-to-r from-[#4F46E5] to-[#6366F1] rounded-full flex items-center justify-center text-white font-bold mr-4">
                            MS
                        </div>
                        <div>
                            <div class="font-semibold text-[#1E3A8A]">Marie Simon</div>
                            <div class="text-sm text-[#6B7280]">Organisatrice d'événements</div>
                        </div>
                    </div>
                </div>

                <!-- Testimonial 2 -->
                <div class="testimonial-bg rounded-2xl p-8 border border-[#E0E7FF] card-hover">
                    <div class="flex items-center mb-4">
                        <div class="text-2xl">⭐️⭐️⭐️⭐️⭐️</div>
                    </div>
                    <p class="text-[#6B7280] mb-6 italic">
                        "La gestion des billets et des participants est incroyablement fluide. Un gain de temps
                        considérable !"
                    </p>
                    <div class="flex items-center">
                        <div
                            class="h-12 w-12 bg-gradient-to-r from-[#4F46E5] to-[#6366F1] rounded-full flex items-center justify-center text-white font-bold mr-4">
                            TP
                        </div>
                        <div>
                            <div class="font-semibold text-[#1E3A8A]">Thomas Petit</div>
                            <div class="text-sm text-[#6B7280]">Responsable événements</div>
                        </div>
                    </div>
                </div>

                <!-- Testimonial 3 -->
                <div class="testimonial-bg rounded-2xl p-8 border border-[#E0E7FF] card-hover">
                    <div class="flex items-center mb-4">
                        <div class="text-2xl">⭐️⭐️⭐️⭐️⭐️</div>
                    </div>
                    <p class="text-[#6B7280] mb-6 italic">
                        "Le support client est exceptionnel. Ils nous accompagnent à chaque étape de nos événements."
                    </p>
                    <div class="flex items-center">
                        <div
                            class="h-12 w-12 bg-gradient-to-r from-[#4F46E5] to-[#6366F1] rounded-full flex items-center justify-center text-white font-bold mr-4">
                            LC
                        </div>
                        <div>
                            <div class="font-semibold text-[#1E3A8A]">Laura Chen</div>
                            <div class="text-sm text-[#6B7280]">CEO, Startup Week</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-20 gradient-bg relative overflow-hidden">
        <div class="absolute inset-0 hero-gradient"></div>
        <div class="relative max-w-4xl mx-auto text-center px-4 sm:px-6 lg:px-8">
            <h2 class="text-4xl font-extrabold text-white sm:text-5xl">
                Prêt à révolutionner vos événements ?
            </h2>
            <p class="mt-6 text-xl text-[#E0E7FF] max-w-2xl mx-auto">
                Rejoignez des milliers d'organisateurs qui font confiance à EventManager
            </p>
            <div class="mt-10 flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('register') }}"
                    class="inline-flex items-center justify-center px-8 py-4 text-lg font-semibold rounded-2xl text-[#4F46E5] bg-white hover:bg-[#E0E7FF] transition-all duration-300 shadow-2xl hover:shadow-3xl transform hover:scale-105">
                    Commencer gratuitement
                </a>
                <a href="#features"
                    class="inline-flex items-center justify-center px-8 py-4 text-lg font-semibold rounded-2xl text-white border-2 border-white/30 hover:border-white/50 hover:bg-white/10 transition-all duration-300 backdrop-blur-sm">
                    Voir une démo
                </a>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-[#1E3A8A] text-white">
        <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:py-16 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div>
                    <div class="flex items-center space-x-3 mb-4">
                        <div
                            class="flex items-center justify-center h-10 w-10 rounded-xl bg-white text-[#4F46E5] font-bold">
                            EM
                        </div>
                        <span class="text-xl font-bold text-white">EventManager</span>
                    </div>
                    <p class="text-[#E0E7FF] text-sm">
                        La plateforme événementielle nouvelle génération pour des événements mémorables.
                    </p>
                </div>
                <div>
                    <h3 class="text-sm font-semibold uppercase tracking-wider mb-4">Produit</h3>
                    <ul class="space-y-2">
                        <li><a href="#features"
                                class="text-[#E0E7FF] hover:text-white transition-colors">Fonctionnalités</a></li>
                        <li><a href="#pricing" class="text-[#E0E7FF] hover:text-white transition-colors">Tarifs</a>
                        </li>
                        <li><a href="#" class="text-[#E0E7FF] hover:text-white transition-colors">API</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-sm font-semibold uppercase tracking-wider mb-4">Support</h3>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-[#E0E7FF] hover:text-white transition-colors">Centre
                                d'aide</a></li>
                        <li><a href="#" class="text-[#E0E7FF] hover:text-white transition-colors">Contact</a>
                        </li>
                        <li><a href="#" class="text-[#E0E7FF] hover:text-white transition-colors">Status</a>
                        </li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-sm font-semibold uppercase tracking-wider mb-4">Légal</h3>
                    <ul class="space-y-2">
                        <li><a href="#"
                                class="text-[#E0E7FF] hover:text-white transition-colors">Confidentialité</a></li>
                        <li><a href="#" class="text-[#E0E7FF] hover:text-white transition-colors">Conditions</a>
                        </li>
                        <li><a href="#" class="text-[#E0E7FF] hover:text-white transition-colors">Mentions
                                légales</a></li>
                    </ul>
                </div>
            </div>
            <div class="mt-12 pt-8 border-t border-[#3730A3] text-center">
                <p class="text-[#E0E7FF] text-sm">
                    &copy; {{ date('Y') }} EventManager. Tous droits réservés.
                </p>
            </div>
        </div>
    </footer>

    <!-- Mobile menu -->
    <div class="sm:hidden hidden" id="mobile-menu">
        <div class="pt-2 pb-3 space-y-1 bg-white border-t border-[#E0E7FF] fixed top-16 left-0 right-0 z-40">
            <a href="#features"
                class="block px-4 py-3 text-base font-medium text-[#6B7280] hover:text-[#1E3A8A] hover:bg-[#E0E7FF] transition-colors duration-200">Fonctionnalités</a>
            <a href="#events"
                class="block px-4 py-3 text-base font-medium text-[#6B7280] hover:text-[#1E3A8A] hover:bg-[#E0E7FF] transition-colors duration-200">Événements</a>
            <a href="#pricing"
                class="block px-4 py-3 text-base font-medium text-[#6B7280] hover:text-[#1E3A8A] hover:bg-[#E0E7FF] transition-colors duration-200">Tarifs</a>
            <a href="#testimonials"
                class="block px-4 py-3 text-base font-medium text-[#6B7280] hover:text-[#1E3A8A] hover:bg-[#E0E7FF] transition-colors duration-200">Avis</a>
            @auth
                <a href="{{ route('dashboard') }}"
                    class="block px-4 py-3 text-base font-medium text-[#6B7280] hover:text-[#1E3A8A] hover:bg-[#E0E7FF] transition-colors duration-200">Tableau
                    de bord</a>
            @else
                <a href="{{ route('login') }}"
                    class="block px-4 py-3 text-base font-medium text-[#6B7280] hover:text-[#1E3A8A] hover:bg-[#E0E7FF] transition-colors duration-200">Connexion</a>
                <a href="{{ route('register') }}"
                    class="block px-4 py-3 text-base  text-[#4F46E5] hover:bg-[#E0E7FF] transition-colors duration-200 font-semibold">
                    S'inscrire
                </a>
            @endauth
        </div>
    </div>

    <script>
        // Toggle mobile menu
        document.addEventListener('DOMContentLoaded', function() {
            const mobileMenuButton = document.getElementById('mobile-menu-button');
            const mobileMenu = document.getElementById('mobile-menu');

            if (mobileMenuButton && mobileMenu) {
                mobileMenuButton.addEventListener('click', function() {
                    const isExpanded = mobileMenuButton.getAttribute('aria-expanded') === 'true';
                    mobileMenuButton.setAttribute('aria-expanded', !isExpanded);
                    mobileMenu.classList.toggle('hidden');
                });
            }

            // Smooth scrolling for anchor links
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

                        // Close mobile menu if open
                        if (mobileMenu && !mobileMenu.classList.contains('hidden')) {
                            mobileMenu.classList.add('hidden');
                            mobileMenuButton.setAttribute('aria-expanded', 'false');
                        }
                    }
                });
            });
        });
    </script>
    <script src="https://cdn.kkiapay.me/k.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Billing Toggle Functionality
            const billingToggles = document.querySelectorAll('.billing-toggle');
            const monthlyPrices = document.querySelectorAll('.monthly-price');
            const yearlyPrices = document.querySelectorAll('.yearly-price');

            billingToggles.forEach(toggle => {
                toggle.addEventListener('click', function() {
                    const billingType = this.getAttribute('data-billing');

                    // Update active state
                    billingToggles.forEach(t => t.classList.remove('active', 'bg-indigo-600',
                        'text-white'));
                    this.classList.add('active', 'bg-indigo-600', 'text-white');

                    // Show/hide prices
                    if (billingType === 'monthly') {
                        monthlyPrices.forEach(p => p.classList.remove('hidden'));
                        yearlyPrices.forEach(p => p.classList.add('hidden'));
                    } else {
                        monthlyPrices.forEach(p => p.classList.add('hidden'));
                        yearlyPrices.forEach(p => p.classList.remove('hidden'));
                    }
                });
            });

            // KkiaPay Integration
            const subscribeButtons = document.querySelectorAll('.kkiapay-subscribe');

            subscribeButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const plan = this.getAttribute('data-plan');
                    const amount = this.getAttribute('data-amount');

                    // Integration with KkiaPay
                    // Vous devrez adapter cette partie selon la documentation officielle de KkiaPay
                    console.log(`Abonnement au plan ${plan} pour ${amount} FCFA`);

                    // Exemple d'intégration KkiaPay (à adapter)
                    /*
                    window.kkiapay.open({
                    amount: amount,
                    plan: plan,
                    // autres paramètres KkiaPay
                    })
                    */
                    (function() {
                        const buttons = document.querySelectorAll('.kkiapay-subscribe');
                        const currency = 'XOF';
                        const sandbox =
                            {{ json_encode((bool) config('services.kkiapay.sandbox')) }};
                        const apiKey = @json(config('services.kkiapay.public_key'));
                        const name = @json(Auth::user()->name ?? '');
                        const email = @json(Auth::user()->email ?? '');
                        let selectedPlan = null;

                        function openWidget(amount) {
                            if (typeof window.openKkiapayWidget !== 'function') {
                                if (window.kkiapay && typeof window.kkiapay.open ===
                                    'function') {
                                    window.kkiapay.open({
                                        amount,
                                        currency,
                                        sandbox,
                                        api_key: apiKey,
                                        name,
                                        email
                                    });
                                    return;
                                }
                                alert(
                                    "Le widget de paiement n'est pas disponible. Veuillez réessayer.");
                                return;
                            }
                            window.openKkiapayWidget({
                                amount,
                                currency,
                                sandbox,
                                api_key: apiKey,
                                name,
                                email
                            });
                        }

                        function onSuccess(resp) {
                            try {
                                const tx = resp && (resp.transactionId || resp.transaction_id ||
                                    resp.reference || resp.id);
                                if (tx && selectedPlan) {
                                    const url = @json(route('subscriptions.confirm')) + '?plan=' +
                                        encodeURIComponent(selectedPlan) + '&transaction_id=' +
                                        encodeURIComponent(tx);
                                    window.location.href = url;
                                    return;
                                }
                            } catch (e) {}
                            alert(
                                'Paiement réussi mais impossible de confirmer. Contactez le support.');
                        }

                        function onFailed(err) {
                            console.error('Kkiapay failed', err);
                            alert('Le paiement a échoué. Veuillez réessayer.');
                        }

                        if (typeof window.addSuccessListener === 'function') {
                            window.addSuccessListener(onSuccess);
                        }
                        if (typeof window.addFailedListener === 'function') {
                            window.addFailedListener(onFailed);
                        }

                        buttons.forEach(btn => {
                            btn.addEventListener('click', () => {
                                selectedPlan = btn.getAttribute('data-plan');
                                const amount = parseInt(btn.getAttribute(
                                    'data-amount'), 10) || 0;
                                openWidget(amount);
                            });
                        });
                    })();
                });
            });
        });
    </script>






</body>

</html>
