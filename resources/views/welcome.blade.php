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
        .hero-gradient {
            background: linear-gradient(135deg,
                rgba(79, 70, 229, 0.95) 0%,
                rgba(99, 102, 241, 0.9) 50%,
                rgba(129, 140, 248, 0.85) 100%);
        }

        .floating {
            animation: float 6s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }

        .card-hover {
            transition: all 0.3s ease;
        }

        .card-hover:hover {
            transform: translateY(-4px);
        }

        .gradient-text {
            background: linear-gradient(135deg, #1E3A8A 0%, #4F46E5 50%, #6366F1 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .feature-icon {
            background: linear-gradient(135deg, #4F46E5 0%, #6366F1 100%);
        }

        .pricing-card.featured {
            border: 2px solid #4F46E5;
            position: relative;
        }

        .pricing-card.featured::before {
            content: 'Populaire';
            position: absolute;
            top: -12px;
            left: 50%;
            transform: translateX(-50%);
            background: #4F46E5;
            color: white;
            padding: 4px 16px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .testimonial-card {
            background: linear-gradient(135deg, #FFFFFF 0%, #F8FAFC 100%);
        }

        .nav-blur {
            backdrop-filter: blur(20px);
            background: rgba(255, 255, 255, 0.8);
        }

        .section-pattern {
            background-image:
                radial-gradient(circle at 25% 25%, rgba(99, 102, 241, 0.05) 0%, transparent 50%),
                radial-gradient(circle at 75% 75%, rgba(79, 70, 229, 0.05) 0%, transparent 50%);
        }
    </style>
</head>

<body class="min-h-full bg-white overflow-x-hidden">
    <!-- Navigation -->
    <nav class="fixed top-0 w-full nav-blur z-50 border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="{{ url('/') }}" class="flex items-center space-x-3">
                        <div class="flex items-center justify-center h-8 w-8 rounded-lg bg-indigo-600 text-white font-bold">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <span class="text-xl font-bold text-gray-900">EventManager</span>
                    </a>
                </div>
                <div class="hidden md:flex items-center space-x-8">
                    <a href="#features" class="text-sm font-medium text-gray-600 hover:text-gray-900 transition-colors">Fonctionnalités</a>
                    <a href="#pricing" class="text-sm font-medium text-gray-600 hover:text-gray-900 transition-colors">Tarifs</a>
                    <a href="#testimonials" class="text-sm font-medium text-gray-600 hover:text-gray-900 transition-colors">Avis</a>
                    @auth
                        <a href="{{ route('dashboard') }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-700">Tableau de bord</a>
                    @else
                        <a href="{{ route('login') }}" class="text-sm font-medium text-gray-600 hover:text-gray-900">Connexion</a>
                        <a href="{{ route('register') }}" class="text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 px-4 py-2 rounded-lg transition-colors">
                            S'inscrire
                        </a>
                    @endauth
                </div>
                <!-- Mobile menu button -->
                <div class="md:hidden flex items-center">
                    <button type="button" id="mobile-menu-button" class="p-2 rounded-lg text-gray-600 hover:text-gray-900 hover:bg-gray-100">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="relative min-h-screen flex items-center justify-center overflow-hidden hero-gradient text-white pt-16">
        <!-- Background Elements -->
        <div class="absolute top-20 left-10 w-72 h-72 bg-white/10 rounded-full blur-3xl floating"></div>
        <div class="absolute bottom-20 right-10 w-96 h-96 bg-indigo-300/10 rounded-full blur-3xl floating" style="animation-delay: 2s;"></div>

        <div class="relative max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <!-- Badge -->
            <div class="inline-flex items-center space-x-2 bg-white/20 px-4 py-2 rounded-full text-sm font-medium text-white mb-8 backdrop-blur-sm">
                <span>🎯 Plateforme événementielle tout-en-un</span>
            </div>

            <!-- Main Heading -->
            <h1 class="text-4xl sm:text-5xl lg:text-6xl font-bold mb-6 leading-tight">
                Organisez des événements
                <span class="block bg-gradient-to-r from-white to-indigo-100 bg-clip-text text-transparent">mémorables</span>
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
                       class="inline-flex items-center justify-center px-6 py-3 text-base font-medium text-indigo-600 bg-white hover:bg-gray-50 rounded-lg transition-colors shadow-lg">
                        <svg class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        Créer un événement
                    </a>
                @else
                    <a href="{{ route('register') }}"
                       class="inline-flex items-center justify-center px-6 py-3 text-base font-medium text-indigo-600 bg-white hover:bg-gray-50 rounded-lg transition-colors shadow-lg">
                        Commencer gratuitement
                        <svg class="w-5 h-5 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                        </svg>
                    </a>
                @endauth
                <a href="#features"
                   class="inline-flex items-center justify-center px-6 py-3 text-base font-medium text-white border-2 border-white/30 hover:border-white/50 rounded-lg transition-colors">
                    Voir les fonctionnalités
                </a>
            </div>

            <!-- Stats -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6 max-w-2xl mx-auto">
                <div class="text-center">
                    <div class="text-2xl font-bold text-white">50K+</div>
                    <div class="text-indigo-200 text-sm">Événements</div>
                </div>
                <div class="text-center">
                    <div class="text-2xl font-bold text-white">2M+</div>
                    <div class="text-indigo-200 text-sm">Participants</div>
                </div>
                <div class="text-center">
                    <div class="text-2xl font-bold text-white">98%</div>
                    <div class="text-indigo-200 text-sm">Satisfaction</div>
                </div>
                <div class="text-center">
                    <div class="text-2xl font-bold text-white">24/7</div>
                    <div class="text-indigo-200 text-sm">Support</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="py-20 bg-white section-pattern">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl sm:text-4xl font-bold text-gray-900">
                    Des outils <span class="gradient-text">puissants</span> pour vos événements
                </h2>
                <p class="mt-4 text-lg text-gray-600 max-w-2xl mx-auto">
                    Tout ce dont vous avez besoin pour créer, promouvoir et gérer des événements exceptionnels
                </p>
            </div>

            <!-- Main Feature -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center mb-16">
                <div>
                    <div class="flex items-center space-x-2 text-indigo-600 font-medium text-sm mb-4">
                        <div class="w-2 h-2 bg-indigo-600 rounded-full"></div>
                        <span>CRÉATION SIMPLIFIÉE</span>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">Créez des événements en quelques clics</h3>
                    <p class="text-gray-600 mb-6 leading-relaxed">
                        Notre interface intuitive vous guide pas à pas dans la création de votre événement.
                        Personnalisez tous les détails et lancez-vous en toute confiance.
                    </p>
                    <ul class="space-y-3">
                        <li class="flex items-center text-gray-600">
                            <svg class="h-5 w-5 text-indigo-500 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            Éditeur visuel drag & drop
                        </li>
                        <li class="flex items-center text-gray-600">
                            <svg class="h-5 w-5 text-indigo-500 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            Modèles personnalisables
                        </li>
                        <li class="flex items-center text-gray-600">
                            <svg class="h-5 w-5 text-indigo-500 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            Intégration de paiement
                        </li>
                    </ul>
                </div>
                <div class="relative">
                    <div class="bg-gradient-to-br from-indigo-500 to-indigo-600 rounded-2xl p-6 text-white card-hover shadow-xl">
                        <div class="grid grid-cols-2 gap-4">
                            <div class="bg-white/10 rounded-xl p-4 backdrop-blur-sm">
                                <div class="text-xl font-bold">📅</div>
                                <div class="text-sm mt-1">Planification</div>
                            </div>
                            <div class="bg-white/10 rounded-xl p-4 backdrop-blur-sm">
                                <div class="text-xl font-bold">🎫</div>
                                <div class="text-sm mt-1">Billeterie</div>
                            </div>
                            <div class="bg-white/10 rounded-xl p-4 backdrop-blur-sm">
                                <div class="text-xl font-bold">📊</div>
                                <div class="text-sm mt-1">Analytics</div>
                            </div>
                            <div class="bg-white/10 rounded-xl p-4 backdrop-blur-sm">
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
                <div class="bg-gray-50 rounded-xl p-6 border border-gray-200 card-hover">
                    <div class="flex items-center justify-center h-12 w-12 rounded-lg feature-icon text-white mb-4">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Sécurité maximale</h3>
                    <p class="text-gray-600 text-sm leading-relaxed">
                        Vos données et transactions sont protégées par les meilleures standards de sécurité.
                    </p>
                </div>

                <!-- Feature 2 -->
                <div class="bg-gray-50 rounded-xl p-6 border border-gray-200 card-hover">
                    <div class="flex items-center justify-center h-12 w-12 rounded-lg feature-icon text-white mb-4">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Performance optimale</h3>
                    <p class="text-gray-600 text-sm leading-relaxed">
                        Temps de chargement ultra-rapide pour une expérience utilisateur fluide.
                    </p>
                </div>

                <!-- Feature 3 -->
                <div class="bg-gray-50 rounded-xl p-6 border border-gray-200 card-hover">
                    <div class="flex items-center justify-center h-12 w-12 rounded-lg feature-icon text-white mb-4">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Gestion d'équipe</h3>
                    <p class="text-gray-600 text-sm leading-relaxed">
                        Collaborez avec votre équipe et assignez des rôles spécifiques à chaque membre.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Pricing Section -->
    <section id="pricing" class="py-20 bg-gray-50">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl sm:text-4xl font-bold text-gray-900">
                    Des tarifs <span class="gradient-text">adaptés</span> à vos besoins
                </h2>
                <p class="mt-4 text-lg text-gray-600 max-w-2xl mx-auto">
                    Choisissez la formule qui correspond à votre ambition
                </p>

                <!-- Billing Toggle -->
                <div class="mt-8 flex justify-center">
                    <div class="relative bg-white rounded-lg p-1 shadow-sm border border-gray-200">
                        <div class="flex">
                            <button type="button" class="relative py-2 px-6 text-sm font-medium text-gray-700 rounded-md billing-toggle active" data-billing="monthly">
                                Mensuel
                            </button>
                            <button type="button" class="relative py-2 px-6 text-sm font-medium text-gray-700 rounded-md billing-toggle" data-billing="yearly">
                                Annuel <span class="ml-1 px-2 py-1 text-xs bg-green-100 text-green-800 rounded-full">-20%</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 max-w-4xl mx-auto">
                <!-- Basic Plan -->
                <div class="bg-white rounded-xl border border-gray-200 p-6 card-hover">
                    <div class="text-center mb-6">
                        <h3 class="text-xl font-bold text-gray-900">Basique</h3>
                        <p class="mt-2 text-gray-500 text-sm">Idéal pour débuter</p>

                        <div class="mt-4">
                            <div class="monthly-price">
                                <span class="text-3xl font-bold text-gray-900">30 000</span>
                                <span class="text-gray-500 text-sm">FCFA/mois</span>
                            </div>
                            <div class="yearly-price hidden">
                                <span class="text-3xl font-bold text-gray-900">288 000</span>
                                <span class="text-gray-500 text-sm">FCFA/an</span>
                                <div class="text-xs text-green-600 font-medium mt-1">Économisez 72 000 FCFA</div>
                            </div>
                        </div>
                    </div>

                    <ul class="mt-6 space-y-3 text-sm text-gray-600">
                        <li class="flex items-center">
                            <svg class="h-4 w-4 text-green-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            50 places max par événement
                        </li>
                        <li class="flex items-center">
                            <svg class="h-4 w-4 text-green-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            10 événements par mois
                        </li>
                        <li class="flex items-center">
                            <svg class="h-4 w-4 text-green-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            Billets QR Code
                        </li>
                        <li class="flex items-center">
                            <svg class="h-4 w-4 text-green-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            Support par email
                        </li>
                    </ul>

                    <div class="mt-6 pt-6 border-t border-gray-200">
                        <button type="button" class="w-full bg-gray-100 text-gray-700 py-2 px-4 rounded-lg font-medium hover:bg-gray-200 transition-colors">
                            Choisir ce plan
                        </button>
                    </div>
                </div>

                <!-- Premium Plan -->
                <div class="bg-white rounded-xl border-2 border-indigo-500 p-6 card-hover pricing-card featured">
                    <div class="text-center mb-6">
                        <h3 class="text-xl font-bold text-gray-900">Premium</h3>
                        <p class="mt-2 text-gray-500 text-sm">Pour monter en puissance</p>

                        <div class="mt-4">
                            <div class="monthly-price">
                                <span class="text-3xl font-bold text-gray-900">60 000</span>
                                <span class="text-gray-500 text-sm">FCFA/mois</span>
                            </div>
                            <div class="yearly-price hidden">
                                <span class="text-3xl font-bold text-gray-900">576 000</span>
                                <span class="text-gray-500 text-sm">FCFA/an</span>
                                <div class="text-xs text-green-600 font-medium mt-1">Économisez 144 000 FCFA</div>
                            </div>
                        </div>
                    </div>

                    <ul class="mt-6 space-y-3 text-sm text-gray-600">
                        <li class="flex items-center">
                            <svg class="h-4 w-4 text-green-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            150 places max par événement
                        </li>
                        <li class="flex items-center">
                            <svg class="h-4 w-4 text-green-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            30 événements par mois
                        </li>
                        <li class="flex items-center">
                            <svg class="h-4 w-4 text-green-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            Billets QR Code premium
                        </li>
                        <li class="flex items-center">
                            <svg class="h-4 w-4 text-green-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            Support prioritaire
                        </li>
                        <li class="flex items-center">
                            <svg class="h-4 w-4 text-green-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            Statistiques avancées
                        </li>
                    </ul>

                    <div class="mt-6 pt-6 border-t border-gray-200">
                        <button type="button" class="w-full bg-indigo-600 text-white py-2 px-4 rounded-lg font-medium hover:bg-indigo-700 transition-colors">
                            Choisir ce plan
                        </button>
                    </div>
                </div>

                <!-- Pro Plan -->
                <div class="bg-white rounded-xl border border-gray-200 p-6 card-hover">
                    <div class="text-center mb-6">
                        <h3 class="text-xl font-bold text-gray-900">Professionnel</h3>
                        <p class="mt-2 text-gray-500 text-sm">Pour les pros exigeants</p>

                        <div class="mt-4">
                            <div class="monthly-price">
                                <span class="text-3xl font-bold text-gray-900">90 000</span>
                                <span class="text-gray-500 text-sm">FCFA/mois</span>
                            </div>
                            <div class="yearly-price hidden">
                                <span class="text-3xl font-bold text-gray-900">864 000</span>
                                <span class="text-gray-500 text-sm">FCFA/an</span>
                                <div class="text-xs text-green-600 font-medium mt-1">Économisez 216 000 FCFA</div>
                            </div>
                        </div>
                    </div>

                    <ul class="mt-6 space-y-3 text-sm text-gray-600">
                        <li class="flex items-center">
                            <svg class="h-4 w-4 text-green-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            Places illimitées
                        </li>
                        <li class="flex items-center">
                            <svg class="h-4 w-4 text-green-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            100 événements par mois
                        </li>
                        <li class="flex items-center">
                            <svg class="h-4 w-4 text-green-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            Billets QR Code VIP
                        </li>
                        <li class="flex items-center">
                            <svg class="h-4 w-4 text-green-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            Support dédié 24/7
                        </li>
                    </ul>

                    <div class="mt-6 pt-6 border-t border-gray-200">
                        <button type="button" class="w-full bg-gray-100 text-gray-700 py-2 px-4 rounded-lg font-medium hover:bg-gray-200 transition-colors">
                            Choisir ce plan
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section id="testimonials" class="py-20 bg-white">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl sm:text-4xl font-bold text-gray-900">
                    Ils nous <span class="gradient-text">font confiance</span>
                </h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Testimonial 1 -->
                <div class="testimonial-card rounded-xl p-6 border border-gray-200 card-hover">
                    <div class="flex items-center mb-4">
                        <div class="text-lg">⭐️⭐️⭐️⭐️⭐️</div>
                    </div>
                    <p class="text-gray-600 text-sm mb-4 italic">
                        "EventManager a révolutionné notre façon d'organiser des conférences. Simple, efficace et professionnel."
                    </p>
                    <div class="flex items-center">
                        <div class="h-10 w-10 bg-indigo-100 rounded-full flex items-center justify-center text-indigo-600 font-medium mr-3">
                            MS
                        </div>
                        <div>
                            <div class="font-medium text-gray-900">Marie Simon</div>
                            <div class="text-xs text-gray-500">Organisatrice d'événements</div>
                        </div>
                    </div>
                </div>

                <!-- Testimonial 2 -->
                <div class="testimonial-card rounded-xl p-6 border border-gray-200 card-hover">
                    <div class="flex items-center mb-4">
                        <div class="text-lg">⭐️⭐️⭐️⭐️⭐️</div>
                    </div>
                    <p class="text-gray-600 text-sm mb-4 italic">
                        "La gestion des billets et des participants est incroyablement fluide. Un gain de temps considérable !"
                    </p>
                    <div class="flex items-center">
                        <div class="h-10 w-10 bg-indigo-100 rounded-full flex items-center justify-center text-indigo-600 font-medium mr-3">
                            TP
                        </div>
                        <div>
                            <div class="font-medium text-gray-900">Thomas Petit</div>
                            <div class="text-xs text-gray-500">Responsable événements</div>
                        </div>
                    </div>
                </div>

                <!-- Testimonial 3 -->
                <div class="testimonial-card rounded-xl p-6 border border-gray-200 card-hover">
                    <div class="flex items-center mb-4">
                        <div class="text-lg">⭐️⭐️⭐️⭐️⭐️</div>
                    </div>
                    <p class="text-gray-600 text-sm mb-4 italic">
                        "Le support client est exceptionnel. Ils nous accompagnent à chaque étape de nos événements."
                    </p>
                    <div class="flex items-center">
                        <div class="h-10 w-10 bg-indigo-100 rounded-full flex items-center justify-center text-indigo-600 font-medium mr-3">
                            LC
                        </div>
                        <div>
                            <div class="font-medium text-gray-900">Laura Chen</div>
                            <div class="text-xs text-gray-500">CEO, Startup Week</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-16 bg-indigo-600">
        <div class="max-w-4xl mx-auto text-center px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl font-bold text-white mb-4">
                Prêt à révolutionner vos événements ?
            </h2>
            <p class="text-lg text-indigo-100 mb-8 max-w-2xl mx-auto">
                Rejoignez des milliers d'organisateurs qui font confiance à EventManager
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('register') }}"
                   class="inline-flex items-center justify-center px-6 py-3 text-base font-medium text-indigo-600 bg-white hover:bg-gray-50 rounded-lg transition-colors">
                    Commencer gratuitement
                </a>
                <a href="#features"
                   class="inline-flex items-center justify-center px-6 py-3 text-base font-medium text-white border-2 border-white/30 hover:border-white/50 rounded-lg transition-colors">
                    Voir une démo
                </a>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white">
        <div class="max-w-6xl mx-auto py-12 px-4 sm:px-6 lg:py-16 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div>
                    <div class="flex items-center space-x-3 mb-4">
                        <div class="flex items-center justify-center h-8 w-8 rounded-lg bg-white text-indigo-600 font-bold">
                            EM
                        </div>
                        <span class="text-lg font-bold text-white">EventManager</span>
                    </div>
                    <p class="text-gray-400 text-sm">
                        La plateforme événementielle nouvelle génération.
                    </p>
                </div>
                <div>
                    <h3 class="text-sm font-semibold uppercase tracking-wider mb-4">Produit</h3>
                    <ul class="space-y-2">
                        <li><a href="#features" class="text-gray-400 hover:text-white text-sm transition-colors">Fonctionnalités</a></li>
                        <li><a href="#pricing" class="text-gray-400 hover:text-white text-sm transition-colors">Tarifs</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-sm font-semibold uppercase tracking-wider mb-4">Support</h3>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-400 hover:text-white text-sm transition-colors">Centre d'aide</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white text-sm transition-colors">Contact</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-sm font-semibold uppercase tracking-wider mb-4">Légal</h3>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-400 hover:text-white text-sm transition-colors">Confidentialité</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white text-sm transition-colors">Conditions</a></li>
                    </ul>
                </div>
            </div>
            <div class="mt-12 pt-8 border-t border-gray-800 text-center">
                <p class="text-gray-400 text-sm">
                    &copy; {{ date('Y') }} EventManager. Tous droits réservés.
                </p>
            </div>
        </div>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Billing Toggle
            const billingToggles = document.querySelectorAll('.billing-toggle');
            const monthlyPrices = document.querySelectorAll('.monthly-price');
            const yearlyPrices = document.querySelectorAll('.yearly-price');

            billingToggles.forEach(toggle => {
                toggle.addEventListener('click', function() {
                    const billingType = this.getAttribute('data-billing');

                    // Update active state
                    billingToggles.forEach(t => t.classList.remove('active', 'bg-indigo-600', 'text-white'));
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

            // Smooth scrolling
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function(e) {
                    e.preventDefault();
                    const target = document.querySelector(this.getAttribute('href'));
                    if (target) {
                        target.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                    }
                });
            });
        });
    </script>
</body>
</html>
