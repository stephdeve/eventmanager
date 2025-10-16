@extends('layouts.app')

@section('title', 'Tableau de bord - Étudiant')

@section('content')
<div class="min-h-screen py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- En-tête -->
        <div class="mb-8">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6">
                <div class="text-center md:text-left">
                    <div class="flex items-center justify-center md:justify-start gap-3">
                        <h1 class="text-3xl font-bold text-gray-900">Bonjour, {{ Auth::user()->name }} 👋</h1>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-gradient-to-r from-blue-500 to-purple-600 text-white shadow-sm">
                            Participant
                        </span>
                    </div>
                    <p class="mt-2 text-lg text-gray-600">Bienvenue sur votre espace personnel de gestion d'événements</p>
                </div>
                <div class="flex justify-center md:justify-end">
                    <a href="{{ route('events.index') }}"
                       class="group inline-flex items-center gap-3 px-6 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200">
                        <svg class="w-5 h-5 group-hover:scale-110 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        Découvrir les événements
                    </a>
                </div>
            </div>
        </div>

        <!-- Cartes de statistiques -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <!-- Prochains événements -->
            <div class="group bg-white/80 backdrop-blur-sm rounded-2xl p-6 border shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                <div class="flex items-center">
                    <div class="p-3 bg-blue-100 rounded-xl mr-4 group-hover:scale-110 transition-transform duration-200">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-600">Événements à venir</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $upcomingRegistrations->count() }}</p>
                    </div>
                </div>
            </div>

            <!-- Événements passés -->
            <div class="group bg-white/80 backdrop-blur-sm rounded-2xl p-6 border shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                <div class="flex items-center">
                    <div class="p-3 bg-green-100 rounded-xl mr-4 group-hover:scale-110 transition-transform duration-200">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-600">Événements passés</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $pastRegistrations->count() }}</p>
                    </div>
                </div>
            </div>

            <!-- Billets -->
            <div class="group bg-white/80 backdrop-blur-sm rounded-2xl p-6 border  shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                <div class="flex items-center">
                    <div class="p-3 bg-purple-100 rounded-xl mr-4 group-hover:scale-110 transition-transform duration-200">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2m-8-10v2m0 4v2m0 4v2m8-14a2 2 0 012 2v14a2 2 0 01-2 2H7a2 2 0 01-2-2V5a2 2 0 012-2h10z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-600">Billets</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $upcomingRegistrations->count() + $pastRegistrations->count() }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Vos prochains événements -->
        <div class="mb-12">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-2xl font-bold text-gray-900">Vos prochains événements</h2>
                <a href="{{ route('events.index') }}"
                   class="group flex items-center gap-2 text-blue-600 font-semibold hover:text-blue-700 transition-colors duration-200">
                    Voir tout
                    <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </a>
            </div>

            @if($upcomingRegistrations->isNotEmpty())
            <div class="bg-white/80 backdrop-blur-sm rounded-2xl hover:shadow-xl  border  shadow-lg overflow-hidden">
                <div class="divide-y divide-gray-100">
                    @foreach($upcomingRegistrations as $registration)
                    @php
                        $eventDate = $registration->event->event_date ?? $registration->event->start_date;
                    @endphp
                    <div class="group p-6 hover:bg-gray-100/50 transition-colors duration-200">
                        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                            <div class="flex items-start gap-4">
                                <div class="flex-shrink-0">
                                    <div class="w-12 h-12 bg-gradient-to-r from-blue-500 to-blue-800 rounded-xl flex items-center justify-center text-white font-semibold shadow-lg">
                                        {{ $eventDate ? $eventDate->format('d') : '--' }}
                                    </div>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <h3 class="text-lg font-semibold text-gray-900 group-hover:text-blue-600 transition-colors duration-200">
                                        <a href="{{ route('events.show', $registration->event) }}" class="hover:underline">
                                            {{ $registration->event->title }}
                                        </a>
                                    </h3>
                                    <div class="mt-2 flex flex-wrap gap-4 text-sm text-gray-600">
                                        <div class="flex items-center gap-1">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            </svg>
                                            {{ $registration->event->location }}
                                        </div>
                                        <div class="flex items-center gap-1">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                            {{ $eventDate ? $eventDate->format('H:i') : '--:--' }}
                                        </div>
                                    </div>
                                    @if($eventDate)
                                    <p class="mt-1 text-sm text-gray-500">
                                        {{ $eventDate->isoFormat('dddd D MMMM YYYY') }}
                                    </p>
                                    @endif
                                </div>
                            </div>
                            <div class="flex items-center gap-3">
                                <a href="{{ route('registrations.show', $registration->qr_code_data) }}"
                                   class="inline-flex items-center gap-2 px-4 py-2 bg-green-100 text-green-700 font-semibold rounded-lg hover:bg-green-200 transition-colors duration-200">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2m-8-10v2m0 4v2m0 4v2m8-14a2 2 0 012 2v14a2 2 0 01-2 2H7a2 2 0 01-2-2V5a2 2 0 012-2h10z"/>
                                    </svg>
                                    Voir le billet
                                </a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @else
            <div class="bg-white/80 backdrop-blur-sm rounded-2xl border border-white shadow-lg p-12 text-center">
                <div class="max-w-md mx-auto">
                    <div class="w-20 h-20 mx-auto mb-6 bg-gradient-to-br from-blue-100 to-purple-100 rounded-2xl flex items-center justify-center">
                        <svg class="w-10 h-10 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-3">Aucun événement à venir</h3>
                    <p class="text-gray-600 mb-8">Parcourez les événements disponibles et inscrivez-vous pour commencer votre expérience.</p>
                    <a href="{{ route('events.index') }}"
                       class="inline-flex items-center gap-3 px-8 py-4 bg-gradient-to-r from-blue-600 to-purple-600 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"/>
                        </svg>
                        Découvrir les événements
                    </a>
                </div>
            </div>
            @endif
        </div>

        <!-- Événements recommandés -->
        @if($recommendedEvents->isNotEmpty())
        <div class="mb-12">
            <div class="flex items-center justify-between mb-8">
                <div>
                    <h2 class="text-2xl font-bold text-gray-900 mb-2">Événements recommandés</h2>
                    <p class="text-gray-600">Découvrez des événements qui pourraient vous intéresser</p>
                </div>
                <a href="{{ route('events.index') }}"
                   class="group flex items-center gap-2 text-blue-600 font-semibold hover:text-blue-700 transition-colors duration-200">
                    Voir tout
                    <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
                @foreach($recommendedEvents as $event)
                <div class="group bg-white rounded-2xl shadow-lg border border-gray-200 overflow-hidden hover:shadow-xl transition-all duration-500 transform hover:-translate-y-2">
                    <!-- Image -->
                    <div class="relative h-48 bg-gray-200 overflow-hidden">
                        @if($event->cover_image)
                            <img src="{{ asset('storage/' . $event->cover_image) }}"
                                 alt="{{ $event->title }}"
                                 class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                        @else
                            <div class="w-full h-full bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center">
                                <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                            </div>
                        @endif
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent"></div>

                        <!-- Badge places -->
                        <div class="absolute top-4 right-4">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold {{ $event->available_seats_calculated > 3 ? 'bg-green-500 text-white shadow-lg' : ($event->available_seats_calculated > 0 ? 'bg-yellow-500 text-white shadow-lg' : 'bg-red-500 text-white shadow-lg') }}">
                                @if(isset($event->available_seats_calculated))
                                    {{ $event->available_seats_calculated }} place{{ $event->available_seats_calculated > 1 ? 's' : '' }}
                                @else
                                    {{ $event->available_seats ?? 0 }} place{{ $event->available_seats > 1 ? 's' : '' }}
                                @endif
                            </span>
                        </div>
                    </div>

                    <!-- Contenu -->
                    <div class="p-6">
                        <h3 class="font-bold text-xl text-gray-900 mb-3 line-clamp-2 group-hover:text-blue-600 transition-colors duration-200">
                            {{ $event->title }}
                        </h3>

                        <!-- Métadonnées -->
                        <div class="space-y-3 mb-4">
                            <div class="flex items-center text-gray-600">
                                <svg class="w-5 h-5 mr-3 text-blue-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                                <span class="truncate">{{ $event->location }}</span>
                            </div>

                            <div class="flex items-center text-gray-600">
                                <svg class="w-5 h-5 mr-3 text-purple-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                <span>
                                    @if($event->event_date)
                                        {{ $event->event_date->format('d/m/Y H:i') }}
                                    @else
                                        Date à confirmer
                                    @endif
                                </span>
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="space-y-3">
                            <a href="{{ route('events.show', $event) }}"
                               class="w-full inline-flex items-center justify-center px-4 py-3 bg-gradient-to-r from-blue-600 to-purple-600 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200">
                                En savoir plus
                                <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </a>

                            @if(auth()->check() && auth()->user()->isStudent())
                                <form action="{{ route('events.register', $event) }}" method="POST" class="space-y-3">
                                    @csrf

                                    @if($event->is_restricted_18)
                                        <div class="bg-amber-50 border border-amber-200 rounded-xl p-4">
                                            <label class="flex items-start gap-3 cursor-pointer">
                                                <input type="checkbox"
                                                       id="confirm_age_{{ $event->id }}"
                                                       name="confirm_age"
                                                       value="1"
                                                       class="mt-1 w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500"
                                                       required>
                                                <div>
                                                    <span class="block text-sm font-semibold text-amber-900">+18 ans</span>
                                                    <span class="block text-xs text-amber-700 mt-1">Vérification sur place possible</span>
                                                </div>
                                            </label>
                                        </div>
                                    @endif

                                    @if(($event->price ?? 0) > 0)
                                        <fieldset class="border border-gray-200 rounded-xl p-4">
                                            <legend class="text-sm font-semibold text-gray-900 px-2">Mode de paiement</legend>
                                            <div class="mt-3 space-y-3">
                                                <label class="flex items-center gap-3 p-3 rounded-lg border-2 border-transparent hover:border-blue-200 cursor-pointer transition-colors duration-200">
                                                    <input type="radio"
                                                           name="payment_method"
                                                           value="kkiapay"
                                                           class="w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500"
                                                           checked
                                                           required>
                                                    <div>
                                                        <span class="block text-sm font-medium text-gray-900">Payer maintenant</span>
                                                        <span class="block text-xs text-gray-600">Paiement sécurisé</span>
                                                    </div>
                                                </label>
                                                <label class="flex items-center gap-3 p-3 rounded-lg border-2 border-transparent hover:border-blue-200 cursor-pointer transition-colors duration-200">
                                                    <input type="radio"
                                                           name="payment_method"
                                                           value="physical"
                                                           class="w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500"
                                                           required>
                                                    <div>
                                                        <span class="block text-sm font-medium text-gray-900">Payer sur place</span>
                                                        <span class="block text-xs text-gray-600">Le jour de l'événement</span>
                                                    </div>
                                                </label>
                                            </div>
                                        </fieldset>
                                    @endif

                                    <button type="submit"
                                            class="w-full inline-flex items-center justify-center gap-2 px-4 py-3 bg-gradient-to-r from-green-600 to-emerald-600 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                        </svg>
                                        S'inscrire maintenant
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script>
// Animation d'entrée des éléments
document.addEventListener('DOMContentLoaded', function() {
    // Animation des cartes de statistiques
    const statCards = document.querySelectorAll('.bg-white\\/80');
    statCards.forEach((card, index) => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(20px)';

        setTimeout(() => {
            card.style.transition = 'all 0.6s ease-out';
            card.style.opacity = '1';
            card.style.transform = 'translateY(0)';
        }, index * 100);
    });

    // Animation des cartes d'événements
    const eventCards = document.querySelectorAll('.group.bg-white');
    eventCards.forEach((card, index) => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(30px)';

        setTimeout(() => {
            card.style.transition = 'all 0.8s ease-out';
            card.style.opacity = '1';
            card.style.transform = 'translateY(0)';
        }, 300 + index * 100);
    });

    // Effet de parallaxe sur les images
    function handleScrollAnimations() {
        const scrolled = window.pageYOffset;
        const events = document.querySelectorAll('.group.bg-white');

        events.forEach((event, index) => {
            const rate = scrolled * -0.5;
            const img = event.querySelector('img');
            if (img) {
                img.style.transform = `translateY(${rate}px) scale(1.1)`;
            }
        });
    }

    // Intersection Observer pour l'animation au scroll
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }
        });
    }, observerOptions);

    // Observer tous les éléments animables
    const animatedElements = document.querySelectorAll('.bg-white\\/80, .group.bg-white');
    animatedElements.forEach(el => {
        observer.observe(el);
    });

    // Gestion des interactions au survol
    eventCards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-8px) scale(1.02)';
        });

        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(-2px) scale(1)';
        });
    });

    // Animation CSS pour les apparitions
    const style = document.createElement('style');
    style.textContent = `
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fade-in-up {
            animation: fadeInUp 0.8s ease-out;
        }

        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
    `;
    document.head.appendChild(style);
});

// Gestion des formulaires d'inscription
document.addEventListener('DOMContentLoaded', function() {
    const forms = document.querySelectorAll('form[action*="register"]');

    forms.forEach(form => {
        form.addEventListener('submit', function(e) {
            const submitButton = this.querySelector('button[type="submit"]');
            const originalText = submitButton.innerHTML;

            // Animation de chargement
            submitButton.innerHTML = `
                <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Inscription en cours...
            `;
            submitButton.disabled = true;
        });
    });
});
</script>
@endpush
