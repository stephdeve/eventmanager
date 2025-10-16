@extends('layouts.app')

@section('title', 'Événements à venir')

@section('content')
<div class="min-h-screen  py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header Section -->
        <div class=" mb-12">
            <h1 class="text-4xl font-bold text-gray-900 mb-4">Événements à Venir</h1>
            <p class="text-xl text-gray-600 max-w-2xl ">
                Découvrez des expériences uniques et rejoignez notre communauté dynamique
            </p>
        </div>

        <!-- Stats Cards -->
        @if(!$events->isEmpty())
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
            <div class="bg-white/80 backdrop-blur-sm rounded-2xl p-6 border  shadow-lg ">
                <div class="flex items-center">
                    <div class="p-3 bg-blue-100 rounded-xl mr-4">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <div>
                        <div class="text-2xl font-bold text-gray-900">{{ $events->count() }}</div>
                        <div class="text-gray-600">Événements</div>
                    </div>
                </div>
            </div>

            <div class="bg-white/80 backdrop-blur-sm rounded-2xl p-6 border shadow-lg">
                <div class="flex items-center">
                    <div class="p-3 bg-green-100 rounded-xl mr-4">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                    </div>
                    <div>
                        <div class="text-2xl font-bold text-gray-900">{{ $events->sum('available_seats') }}</div>
                        <div class="text-gray-600">Places disponibles</div>
                    </div>
                </div>
            </div>

            <div class="bg-white/80 backdrop-blur-sm rounded-2xl p-6 border  shadow-lg">
                <div class="flex items-center">
                    <div class="p-3 bg-purple-100 rounded-xl mr-4">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"/>
                        </svg>
                    </div>
                    <div>
                        <div class="text-2xl font-bold text-gray-900">{{ $events->where('price', 0)->count() }}</div>
                        <div class="text-gray-600">Événements gratuits</div>
                    </div>
                </div>
            </div>
        </div>
        @endif

        <!-- Action Bar -->
        <div class="flex flex-col sm:flex-row justify-between items-center mb-8 gap-4">
            <div class="flex items-center space-x-4">
                <div class="relative">
                    <input type="text"
                           placeholder="Rechercher un événement..."
                           class="pl-10 pr-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent w-64 transition-all duration-200">
                    <svg class="w-5 h-5 text-gray-400 absolute left-3 top-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>
            </div>

            @can('create', App\Models\Event::class)
            <a href="{{ route('events.create') }}"
               class="group bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white px-6 py-3 rounded-xl font-semibold shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200 flex items-center space-x-2">
                <svg class="w-5 h-5 group-hover:rotate-90 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                </svg>
                <span>Créer un événement</span>
            </a>
            @endcan
        </div>

        @if($events->isEmpty())
        <!-- Empty State -->
        <div class="bg-white/80 backdrop-blur-sm rounded-3xl border border-white shadow-xl p-12 text-center">
            <div class="max-w-md mx-auto">
                <div class="w-24 h-24 mx-auto mb-6 bg-gradient-to-br from-blue-100 to-purple-100 rounded-full flex items-center justify-center">
                    <svg class="w-12 h-12 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-3">Aucun événement pour le moment</h3>
                <p class="text-gray-600 mb-8">Soyez le premier à créer un événement passionnant pour la communauté.</p>
                @can('create', App\Models\Event::class)
                <a href="{{ route('events.create') }}"
                   class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                    </svg>
                    Créer le premier événement
                </a>
                @endcan
            </div>
        </div>
        @else
        <!-- Events Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-8" id="eventsGrid">
            @foreach($events as $event)
            @php
                $seats = (int) ($event->available_seats ?? 0);
                $isFree = (int) $event->price <= 0;
                $description = \Illuminate\Support\Str::limit(strip_tags($event->description), 120);
            @endphp

            <div class="group bg-white rounded-3xl shadow-lg hover:shadow-2xl border border-gray-300/30 overflow-hidden transition-all duration-500 transform hover:-translate-y-2 event-card ">
                <!-- Image Container -->
                <div class="relative h-56 overflow-hidden">
                    <img src="{{ $event->cover_image_url }}"
                         alt="{{ $event->title }}"
                         class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent"></div>

                    <!-- Badges -->
                    <div class="absolute top-4 right-4 flex flex-col space-y-2">
                        <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-semibold {{ $seats > 0 ? 'bg-green-500 text-white shadow-lg' : 'bg-red-500 text-white shadow-lg' }}">
                            {{ $seats > 0 ? $seats . ' places' : 'Complet' }}
                        </span>
                        <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-semibold {{ $isFree ? 'bg-blue-500 text-white shadow-lg' : 'bg-purple-500 text-white shadow-lg' }}">
                            {{ $isFree ? 'Gratuit' : $event->price_for_display }}
                        </span>
                    </div>

                    <!-- Date Overlay -->
                    <div class="absolute bottom-4 left-4">
                        @if($event->start_date)
                        <div class="bg-white/90 backdrop-blur-sm rounded-xl p-3 text-center shadow-lg">
                            <div class="text-sm font-bold text-gray-900 leading-none">
                                {{ $event->start_date->format('d') }}
                            </div>
                            <div class="text-xs text-gray-600 uppercase mt-1">
                                {{ $event->start_date->format('M') }}
                            </div>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Content -->
                <div class="p-6">
                    <h3 class="font-bold text-xl text-gray-900 mb-3 line-clamp-2 leading-tight group-hover:text-blue-600 transition-colors duration-200">
                        {{ $event->title }}
                    </h3>

                    <!-- Meta Info -->
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
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <span>
                                @if($event->start_date)
                                    {{ $event->start_date->translatedFormat('d F Y, H:i') }}
                                @endif
                            </span>
                        </div>
                    </div>

                    <!-- Description -->
                    <p class="text-gray-600 p-4 border bg-slate-50 rounded-lg text-sm mb-6 line-clamp-2 leading-relaxed">
                        {{ $description }}
                    </p>

                    <!-- CTA Button -->
                    <a href="{{ route('events.show', $event) }}"
                       class="group/btn w-full inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200">
                        <span>Voir les détails</span>
                        <svg class="w-4 h-4 ml-2 group-hover/btn:translate-x-1 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Pagination -->
        @if($events->hasPages())
        <div class="mt-12 bg-white/80 backdrop-blur-sm rounded-2xl border border-white shadow-lg p-6">
            {{ $events->links() }}
        </div>
        @endif
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Animation d'entrée des cartes
    const eventCards = document.querySelectorAll('.event-card');

    eventCards.forEach((card, index) => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(30px)';

        setTimeout(() => {
            card.style.transition = 'all 0.6s ease-out';
            card.style.opacity = '1';
            card.style.transform = 'translateY(0)';
        }, index * 100);
    });

    // Recherche en temps réel
    const searchInput = document.querySelector('input[type="text"]');
    if (searchInput) {
        searchInput.addEventListener('input', function(e) {
            const searchTerm = e.target.value.toLowerCase();
            const events = document.querySelectorAll('.event-card');

            events.forEach(event => {
                const title = event.querySelector('h3').textContent.toLowerCase();
                const location = event.querySelector('.text-gray-600 span').textContent.toLowerCase();
                const description = event.querySelector('p').textContent.toLowerCase();

                if (title.includes(searchTerm) || location.includes(searchTerm) || description.includes(searchTerm)) {
                    event.style.display = 'block';
                    // Animation de réapparition
                    event.style.animation = 'fadeIn 0.5s ease-in';
                } else {
                    event.style.display = 'none';
                }
            });
        });
    }

    // Effet de parallaxe sur les images au scroll
    function handleParallax() {
        const scrolled = window.pageYOffset;
        const events = document.querySelectorAll('.event-card');

        events.forEach(event => {
            const rate = scrolled * -0.5;
            const img = event.querySelector('img');
            if (img) {
                img.style.transform = `translateY(${rate}px) scale(1.1)`;
            }
        });
    }

    // Animation au survol améliorée
    eventCards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-8px) scale(1.02)';
        });

        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(-2px) scale(1)';
        });
    });

    // Chargement progressif des images
    const images = document.querySelectorAll('img');
    images.forEach(img => {
        img.addEventListener('load', function() {
            this.style.opacity = '1';
            this.style.transition = 'opacity 0.5s ease-in';
        });

        // Fallback si l'image ne charge pas
        img.addEventListener('error', function() {
            this.src = 'data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNDAwIiBoZWlnaHQ9IjMwMCIgdmlld0JveD0iMCAwIDQwMCAzMDAiIGZpbGw9Im5vbmUiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+CjxyZWN0IHdpZHRoPSI0MDAiIGhlaWdodD0iMzAwIiBmaWxsPSIjRjNGNEY2Ii8+CjxwYXRoIGQ9Ik0xNTAgMTUwSDE1MFYxNzBIMTUwSDE1MFoiIGZpbGw9IiNEOEUxRTgiLz4KPHRleHQgeD0iMjAwIiB5PSIxNjAiIGZpbGw9IiNEOEUxRTgiIHRleHQtYW5jaG9yPSJtaWRkbGUiIGZvbnQtc2l6ZT0iMTgiIGZvbnQtZmFtaWx5PSJBcmlhbCI+SW1hZ2Ugbm90IGF2YWlsYWJsZTwvdGV4dD4KPC9zdmc+';
        });
    });

    // Animation CSS pour les apparitions
    const style = document.createElement('style');
    style.textContent = `
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .event-card {
            animation: fadeIn 0.6s ease-out;
        }

        img {
            opacity: 0;
            transition: opacity 0.5s ease-in;
        }

        img.loaded {
            opacity: 1;
        }
    `;
    document.head.appendChild(style);

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

    eventCards.forEach(card => {
        observer.observe(card);
    });

    // Smooth scroll pour les ancres
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
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
@endpush

<style>
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

/* Amélioration du style de pagination */
.pagination {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 0.5rem;
}

.pagination .page-link {
    padding: 0.5rem 1rem;
    border: 1px solid #e5e7eb;
    border-radius: 0.75rem;
    color: #6b7280;
    text-decoration: none;
    transition: all 0.2s;
}

.pagination .page-link:hover {
    background-color: #f3f4f6;
    border-color: #d1d5db;
}

.pagination .active .page-link {
    background: linear-gradient(135deg, #3b82f6, #8b5cf6);
    border-color: #3b82f6;
    color: white;
}
</style>
