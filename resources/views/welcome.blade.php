<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-gray-50">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Gérez et participez à des événements facilement avec notre plateforme de gestion d'événements.">

    <title>EventManager - Gestion d'événements</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />

    <!-- Favicon -->
    <link rel="icon" href="{{ asset('favicon.ico') }}">

    <!-- Styles / Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen">
    <!-- Navigation -->
    <nav class="bg-white shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex-shrink-0 flex items-center">
                    <a href="{{ url('/') }}" class="flex items-center space-x-2">
                        <span class="inline-flex h-9 w-9 items-center justify-center rounded-lg bg-indigo-600 text-white font-semibold">
                            EM
                        </span>
                        <span class="text-xl font-bold text-gray-900">EventManager</span>
                    </a>
                </div>
                <div class="hidden sm:ml-6 sm:flex sm:items-center space-x-4">
                    <a href="#features" class="px-3 py-2 text-sm font-medium text-gray-700 hover:text-gray-900">Fonctionnalités</a>
                    <a href="#how-it-works" class="px-3 py-2 text-sm font-medium text-gray-700 hover:text-gray-900">Comment ça marche</a>
                    @auth
                        <a href="{{ route('dashboard') }}" class="px-4 py-2 text-sm font-medium text-indigo-600 hover:text-indigo-800">Tableau de bord</a>
                    @else
                        <a href="{{ route('login') }}" class="px-4 py-2 text-sm font-medium text-indigo-600 hover:text-indigo-800">Connexion</a>
                        <a href="{{ route('register') }}" class="px-4 py-2 text-sm font-medium text-white bg-indigo-600 rounded-md hover:bg-indigo-700">
                            S'inscrire
                        </a>
                    @endauth
                </div>
                <!-- Mobile menu button -->
                <div class="sm:hidden flex items-center">
                    <button type="button" id="mobile-menu-button" class="inline-flex items-center justify-center p-2 rounded-md text-gray-700 hover:text-gray-900 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500" aria-expanded="false">
                        <span class="sr-only">Ouvrir le menu principal</span>
                        <svg class="block h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <div class="bg-indigo-700 text-white py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="lg:grid lg:grid-cols-2 lg:gap-8 items-center">
                <div class="mb-8 lg:mb-0">
                    <div class="inline-flex items-center space-x-2 bg-indigo-600 bg-opacity-20 px-3 py-1 rounded-full text-sm font-semibold text-indigo-100 mb-4">
                        <span class="inline-flex h-6 w-6 items-center justify-center rounded-full bg-white text-indigo-600 font-semibold">EM</span>
                        <span>EventManager</span>
                    </div>
                    <h1 class="text-4xl font-extrabold tracking-tight sm:text-5xl lg:text-6xl mb-6">
                        Gérez vos événements en toute simplicité
                    </h1>
                    <p class="text-xl text-indigo-100 max-w-3xl">
                        Créez, gérez et suivez vos événements en temps réel. Notre plateforme intuitive rend la gestion d'événements accessible à tous.
                    </p>
                    <div class="mt-8 flex flex-col sm:flex-row gap-3">
                        @auth
                            <a href="{{ route('events.create') }}" class="inline-flex items-center justify-center px-5 py-3 border border-transparent text-base font-medium rounded-md text-indigo-600 bg-white hover:bg-indigo-50">
                                Créer un événement
                            </a>
                        @else
                            <a href="{{ route('register') }}" class="inline-flex items-center justify-center px-5 py-3 border border-transparent text-base font-medium rounded-md text-indigo-600 bg-white hover:bg-indigo-50">
                                Commencer maintenant
                            </a>
                        @endauth
                        <a href="#features" class="inline-flex items-center justify-center px-5 py-3 border border-transparent text-base font-medium rounded-md text-white bg-indigo-800 bg-opacity-60 hover:bg-opacity-70">
                            En savoir plus
                        </a>
                    </div>
                </div>
                <div class="relative">
                    <div class="relative mx-auto w-full rounded-lg shadow-lg overflow-hidden">
                        <img class="w-full h-auto" src="https://images.unsplash.com/photo-1540575467063-178a50c2df87?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1470&q=80" alt="Événement en cours">
                        <div class="absolute inset-0 bg-indigo-800 bg-opacity-30"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Features Section -->
    <div id="features" class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            @if(isset($highlightedEvents) && $highlightedEvents->isNotEmpty())
                <div class="mb-16">
                    <div class="flex items-center justify-between mb-6">
                        <div>
                            <h2 class="text-3xl font-extrabold text-gray-900 sm:text-4xl">Événements à venir</h2>
                            <p class="mt-2 text-gray-500">Parcourez les prochains rendez-vous à ne pas manquer.</p>
                        </div>
                        <div class="flex space-x-2">
                            <button type="button" class="event-carousel-prev inline-flex items-center justify-center h-10 w-10 rounded-full border border-gray-300 text-gray-600 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-indigo-500" aria-label="Précédent">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                            </button>
                            <button type="button" class="event-carousel-next inline-flex items-center justify-center h-10 w-10 rounded-full border border-gray-300 text-gray-600 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-indigo-500" aria-label="Suivant">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                            </button>
                        </div>
                    </div>

                    <div class="relative">
                        <div class="overflow-x-auto scroll-smooth" id="event-carousel" data-carousel-container>
                            <div class="flex flex-nowrap space-x-4 snap-x snap-mandatory" data-carousel-track>
                                @foreach($highlightedEvents as $event)
                                    <article class="min-w-[280px] max-w-xs flex-shrink-0 bg-white border border-gray-200 rounded-xl shadow-sm hover:shadow-md transition-shadow duration-300 snap-start">
                                        @if($event->cover_image)
                                            <div class="h-40 overflow-hidden rounded-t-xl">
                                                <img src="{{ asset('storage/' . $event->cover_image) }}" alt="{{ $event->title }}" class="w-full h-full object-cover">
                                            </div>
                                        @else
                                            <div class="h-40 rounded-t-xl bg-gradient-to-r from-indigo-500 to-purple-600 flex items-center justify-center text-white text-2xl font-semibold">
                                                EM
                                            </div>
                                        @endif
                                        <div class="p-5 space-y-3">
                                            <div class="flex items-center text-sm text-gray-500 space-x-2">
                                                <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                                <span>{{ optional($event->start_date)->format('d/m/Y H:i') }}</span>
                                            </div>
                                            <h3 class="text-lg font-semibold text-gray-900 line-clamp-2">{{ $event->title }}</h3>
                                            <p class="text-sm text-gray-600 line-clamp-3">{{ $event->description }}</p>
                                            <div class="flex items-center justify-between text-sm">
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full bg-indigo-100 text-indigo-700 font-medium">
                                                    {{ max(0, $event->available_seats) }} places
                                                </span>
                                                <a href="{{ route('events.show', $event) }}" class="text-indigo-600 hover:text-indigo-800 font-medium">Voir</a>
                                            </div>
                                        </div>
                                    </article>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <div class="text-center">
                <h2 class="text-3xl font-extrabold text-gray-900 sm:text-4xl">
                    Tout ce dont vous avez besoin pour vos événements
                </h2>
                <p class="mt-4 max-w-2xl text-xl text-gray-500 mx-auto">
                    Une plateforme complète pour gérer tous les aspects de vos événements
                </p>
            </div>

            <div class="mt-16">
                <div class="grid grid-cols-1 gap-8 md:grid-cols-2 lg:grid-cols-3">
                    <!-- Feature 1 -->
                    <div class="pt-6">
                        <div class="flow-root bg-gray-50 rounded-lg px-6 pb-8">
                            <div class="-mt-6">
                                <div class="flex items-center justify-center h-12 w-12 rounded-md bg-indigo-500 text-white">
                                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                <h3 class="mt-4 text-lg font-medium text-gray-900 text-center">Création d'événements</h3>
                                <p class="mt-2 text-base text-gray-500">
                                    Créez facilement des événements avec des détails complets, des billets personnalisables et des options de paiement intégrées.
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Feature 2 -->
                    <div class="pt-6">
                        <div class="flow-root bg-gray-50 rounded-lg px-6 pb-8">
                            <div class="-mt-6">
                                <div class="flex items-center justify-center h-12 w-12 rounded-md bg-indigo-500 text-white">
                                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                    </svg>
                                </div>
                                <h3 class="mt-4 text-lg font-medium text-gray-900 text-center">Gestion des inscriptions</h3>
                                <p class="mt-2 text-base text-gray-500">
                                    Gérez les inscriptions, envoyez des confirmations et suivez les participants en temps réel avec notre tableau de bord intuitif.
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Feature 3 -->
                    <div class="pt-6">
                        <div class="flow-root bg-gray-50 rounded-lg px-6 pb-8">
                            <div class="-mt-6">
                                <div class="flex items-center justify-center h-12 w-12 rounded-md bg-indigo-500 text-white">
                                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                    </svg>
                                </div>
                                <h3 class="mt-4 text-lg font-medium text-gray-900 text-center">Expérience utilisateur</h3>
                                <p class="mt-2 text-base text-gray-500">
                                    Offrez une expérience fluide à vos participants avec des billets numériques, des rappels automatiques et des notifications en temps réel.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- How It Works Section -->
    <div id="how-it-works" class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h2 class="text-3xl font-extrabold text-gray-900 sm:text-4xl">
                    Comment ça marche
                </h2>
                <p class="mt-4 max-w-2xl text-xl text-gray-500 mx-auto">
                    En quelques étapes simples, organisez votre prochain événement
                </p>
            </div>

            <div class="mt-16">
                <div class="lg:grid lg:grid-cols-3 lg:gap-8">
                    <!-- Step 1 -->
                    <div class="relative">
                        <div class="flex items-center justify-center h-12 w-12 rounded-md bg-indigo-500 text-white text-lg font-bold">
                            1
                        </div>
                        <h3 class="mt-4 text-lg font-medium text-gray-900">Créez un compte</h3>
                        <p class="mt-2 text-base text-gray-500">
                            Inscrivez-vous gratuitement en quelques secondes et accédez à votre tableau de bord personnel.
                        </p>
                    </div>

                    <!-- Step 2 -->
                    <div class="mt-10 lg:mt-0 relative">
                        <div class="flex items-center justify-center h-12 w-12 rounded-md bg-indigo-500 text-white text-lg font-bold">
                            2
                        </div>
                        <h3 class="mt-4 text-lg font-medium text-gray-900">Planifiez votre événement</h3>
                        <p class="mt-2 text-base text-gray-500">
                            Ajoutez les détails de votre événement, configurez les billets et personnalisez la page d'inscription.
                        </p>
                    </div>

                    <!-- Step 3 -->
                    <div class="mt-10 lg:mt-0 relative">
                        <div class="flex items-center justify-center h-12 w-12 rounded-md bg-indigo-500 text-white text-lg font-bold">
                            3
                        </div>
                        <h3 class="mt-4 text-lg font-medium text-gray-900">Partagez et gérez</h3>
                        <p class="mt-2 text-base text-gray-500">
                            Partagez le lien de votre événement et gérez les inscriptions en temps réel depuis votre tableau de bord.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- CTA Section -->
    <div class="bg-indigo-700">
        <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:py-16 lg:px-8 lg:flex lg:items-center lg:justify-between">
            <h2 class="text-3xl font-extrabold tracking-tight text-white sm:text-4xl">
                <span class="block">Prêt à organiser votre prochain événement ?</span>
                <span class="block text-indigo-200">Commencez gratuitement dès aujourd'hui.</span>
            </h2>
            <div class="mt-8 flex lg:mt-0 lg:flex-shrink-0">
                <div class="inline-flex rounded-md shadow">
                    <a href="{{ route('register') }}" class="inline-flex items-center justify-center px-5 py-3 border border-transparent text-base font-medium rounded-md text-indigo-600 bg-white hover:bg-indigo-50">
                        S'inscrire maintenant
                    </a>
                </div>
                <div class="ml-3 inline-flex rounded-md shadow">
                    <a href="#features" class="inline-flex items-center justify-center px-5 py-3 border border-transparent text-base font-medium rounded-md text-white bg-indigo-600 bg-opacity-60 hover:bg-opacity-70">
                        En savoir plus
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-white">
        <div class="max-w-7xl mx-auto py-12 px-4 overflow-hidden sm:px-6 lg:px-8">
            {{--
            <nav class="-mx-5 -my-2 flex flex-wrap justify-center" aria-label="Footer">
                <div class="px-5 py-2">
                    <a href="#" class="text-base text-gray-500 hover:text-gray-900">
                        À propos
                    </a>
                </div>
                <div class="px-5 py-2">
                    <a href="#" class="text-base text-gray-500 hover:text-gray-900">
                        Blog
                    </a>
                </div>
                <div class="px-5 py-2">
                    <a href="#" class="text-base text-gray-500 hover:text-gray-900">
                        Carrières
                    </a>
                </div>
                <div class="px-5 py-2">
                    <a href="#" class="text-base text-gray-500 hover:text-gray-900">
                        Confidentialité
                    </a>
                </div>
                <div class="px-5 py-2">
                    <a href="#" class="text-base text-gray-500 hover:text-gray-900">
                        Conditions
                    </a>
                </div>
            </nav>
            --}}
            <p class="mt-8 text-center text-base text-gray-400">
                &copy; {{ date('Y') }} EventManager. Tous droits réservés.
            </p>
        </div>
    </footer>

    <!-- Mobile menu, show/hide based on menu state. -->
    <div class="sm:hidden hidden" id="mobile-menu">
        <div class="pt-2 pb-3 space-y-1">
            <a href="#features" class="block px-3 py-2 text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50">Fonctionnalités</a>
            <a href="#how-it-works" class="block px-3 py-2 text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50">Comment ça marche</a>
            @auth
                <a href="{{ route('dashboard') }}" class="block px-3 py-2 text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50">Tableau de bord</a>
            @else
                <a href="{{ route('login') }}" class="block px-3 py-2 text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50">Connexion</a>
                <a href="{{ route('register') }}" class="block px-3 py-2 text-base font-medium text-indigo-600 hover:bg-indigo-50">
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
                anchor.addEventListener('click', function (e) {
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
</body>
</html>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const container = document.querySelector('[data-carousel-container]');
        const track = document.querySelector('[data-carousel-track]');
        const prevBtn = document.querySelector('.event-carousel-prev');
        const nextBtn = document.querySelector('.event-carousel-next');

        if (!container || !track || !prevBtn || !nextBtn) {
            return;
        }

        const getScrollAmount = () => {
            const firstCard = track.querySelector('article');
            if (!firstCard) {
                return 300;
            }
            const style = window.getComputedStyle(firstCard);
            const marginRight = parseFloat(style.marginRight || '0');
            return firstCard.offsetWidth + marginRight;
        };

        prevBtn.addEventListener('click', () => {
            container.scrollBy({ left: -getScrollAmount(), behavior: 'smooth' });
        });

        nextBtn.addEventListener('click', () => {
            container.scrollBy({ left: getScrollAmount(), behavior: 'smooth' });
        });
    });
</script>
</html>
