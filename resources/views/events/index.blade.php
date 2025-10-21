@extends('layouts.app')

@section('title', 'Événements à venir')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 to-blue-50/20 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header Section -->
        <div class="mb-12">
            <div class="inline-flex items-center gap-2 bg-white/80 backdrop-blur-sm rounded-xl px-4 py-2 border border-gray-100 shadow-sm mb-4">
                <div class="w-2 h-2 bg-gradient-to-r from-blue-500 to-purple-600 rounded-full animate-pulse"></div>
                <span class="text-sm font-medium text-gray-600">Événements à venir</span>
            </div>
            <h1 class="text-3xl font-bold bg-gradient-to-r from-gray-900 to-blue-900 bg-clip-text text-transparent mb-4">
                Découvrez des Expériences Uniques
            </h1>
            <p class="text-lg text-gray-600 max-w-2xl ">
                Rejoignez notre communauté dynamique et participez à des événements mémorables
            </p>
        </div>

        <!-- Stats Cards -->
        @if(!$events->isEmpty())
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
            <div class="group bg-white/90 backdrop-blur-sm rounded-2xl p-6 border  shadow-md hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                <div class="flex items-center">
                    <div class="p-3 bg-gradient-to-br from-blue-100 to-blue-200 rounded-xl mr-4 group-hover:scale-105 transition-transform duration-300">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <div>
                        <div class="text-2xl font-bold text-gray-900">{{ $events->count() }}</div>
                        <div class="text-sm text-gray-600 font-medium">Événements</div>
                    </div>
                </div>
            </div>

            <div class="group bg-white/90 backdrop-blur-sm rounded-2xl p-6 border  shadow-md hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                <div class="flex items-center">
                    <div class="p-3 bg-gradient-to-br from-green-100 to-emerald-200 rounded-xl mr-4 group-hover:scale-105 transition-transform duration-300">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                    </div>
                    <div>
                        <div class="text-2xl font-bold text-gray-900">{{ $events->sum('available_seats') }}</div>
                        <div class="text-sm text-gray-600 font-medium">Places disponibles</div>
                    </div>
                </div>
            </div>

            <div class="group bg-white/90 backdrop-blur-sm rounded-2xl p-6 border  shadow-md hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                <div class="flex items-center">
                    <div class="p-3 bg-gradient-to-br from-purple-100 to-pink-200 rounded-xl mr-4 group-hover:scale-105 transition-transform duration-300">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"/>
                        </svg>
                    </div>
                    <div>
                        <div class="text-2xl font-bold text-gray-900">{{ $events->where('price', 0)->count() }}</div>
                        <div class="text-sm text-gray-600 font-medium">Événements gratuits</div>
                    </div>
                </div>
            </div>
        </div>
        @endif

        <!-- Action Bar -->
        <div class="flex flex-col lg:flex-row justify-between items-center gap-4 mb-8 p-6 bg-white/80 backdrop-blur-sm rounded-2xl shadow-lg border">
            <div class="flex flex-col sm:flex-row items-center gap-3 w-full lg:w-auto">
                <div class="relative flex-1 lg:flex-none">
                    <input type="text"
                           placeholder="Rechercher un événement..."
                           class="pl-10 pr-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 bg-white/90 backdrop-blur-sm w-full lg:w-64 transition-all duration-200 text-gray-700 placeholder-gray-500 text-sm">
                    <svg class="w-4 h-4 text-gray-400 absolute left-3 top-1/2 transform -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>

                <!-- Filtres supplémentaires -->
                <div class="flex items-center  gap-2">
                    {{-- <select class="px-3 py-3  border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 bg-white/90 backdrop-blur-sm text-gray-700 text-sm transition-all duration-200">
                        <option>Tous les types</option>
                        <option>Gratuits</option>
                        <option>Payants</option>
                    </select> --}}

                    <select class="px-3 py-3 border border-gray-200 rounded-xl w-full focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 bg-white/90 backdrop-blur-sm text-gray-700 text-sm transition-all duration-200 min-w-40">
                        <option>Prochainement</option>
                        <option>Cette semaine</option>
                        <option>Ce mois</option>
                    </select>
                </div>
            </div>

            @can('create', App\Models\Event::class)
            <a href="{{ route('events.create') }}"
               class="group bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white px-6 py-3 rounded-xl font-semibold shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200 flex items-center space-x-2 mt-4 lg:mt-0">
                <svg class="w-4 h-4 group-hover:rotate-90 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                </svg>
                <span class="text-sm">Créer un événement</span>
            </a>
            @endcan
        </div>

        @if($events->isEmpty())
        <!-- Empty State -->
        <div class="bg-white/90 backdrop-blur-sm rounded-2xl border border-gray-100 shadow-lg p-8 text-center">
            <div class="max-w-md mx-auto">
                <div class="w-20 h-20 mx-auto mb-4 bg-gradient-to-br from-blue-100 to-purple-100 rounded-full flex items-center justify-center">
                    <svg class="w-10 h-10 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">Aucun événement programmé</h3>
                <p class="text-gray-600 mb-6 text-sm">
                    Soyez le premier à créer un événement passionnant.
                </p>
                @can('create', App\Models\Event::class)
                <a href="{{ route('events.create') }}"
                   class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200 text-sm">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                    </svg>
                    Créer le premier événement
                </a>
                @endcan
            </div>
        </div>
        @else
        <!-- Events Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6 mb-12" id="eventsGrid">
            @foreach($events as $event)
            @php
                $seats = (int) ($event->available_seats ?? 0);
                $isFree = (int) $event->price <= 0;
                $description = \Illuminate\Support\Str::limit(strip_tags($event->description), 100);
                $isUpcoming = $event->start_date && $event->start_date->isFuture();
            @endphp

            <div class="group bg-white rounded-3xl shadow-lg hover:shadow-xl border border-gray-100 overflow-hidden transition-all duration-300 transform hover:-translate-y-2 event-card" data-interactive="{{ $event->is_interactive ? 1 : 0 }}">
                <!-- Image Container -->
                <div class="relative h-56 overflow-hidden">
                    <img src="{{ $event->cover_image_url }}"
                         alt="{{ $event->title }}"
                         class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent"></div>

                    <!-- Date Overlay -->
                    @if($event->start_date)
                    <div class="absolute bottom-4 left-4">
                        <div class="bg-white/95 backdrop-blur-sm rounded-lg p-2 text-center shadow-lg">
                            <div class="text-lg font-bold text-gray-900 leading-none">
                                {{ $event->start_date->format('d') }}
                            </div>
                            <div class="text-xs text-gray-600 uppercase mt-1">
                                {{ $event->start_date->format('M') }}
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- Badges -->
                    <div class="absolute top-4 right-4 flex flex-col space-y-2">
                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold {{ $seats > 0 ? 'bg-green-500 text-white shadow-md' : 'bg-red-500 text-white shadow-md' }}">
                            {{ $seats > 0 ? $seats . ' places' : 'Complet' }}
                        </span>
                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold {{ $isFree ? 'bg-blue-500 text-white shadow-md' : 'bg-purple-500 text-white shadow-md' }}">
                            {{ $isFree ? 'Gratuit' : $event->price_for_display }}
                        </span>
                        @if($event->is_interactive)
                            @if(!empty($event->slug))
                                <a href="{{ route('interactive.events.show', ['event' => $event->slug]) }}" class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-600 text-white shadow-md hover:bg-emerald-700">
                                    @if(method_exists($event, 'isInteractiveActive') && $event->isInteractiveActive())
                                        <span class="w-1.5 h-1.5 bg-white rounded-full mr-1.5 animate-pulse"></span>
                                    @endif
                                    Interactif
                                </a>
                            @else
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-600 text-white shadow-md">
                                    Interactif
                                </span>
                            @endif
                        @endif
                    </div>
                </div>

                <!-- Content -->
                <div class="p-6">
                    <!-- Status Badge -->
                    @if($isUpcoming)
                    <div class="inline-flex items-center px-3 py-1 bg-blue-50 text-blue-700 rounded-full text-xs font-semibold mb-3">
                        <div class="w-1.5 h-1.5 bg-blue-500 rounded-full mr-1.5 animate-pulse"></div>
                        À venir
                    </div>
                    @endif

                    <h3 class="font-bold text-lg text-gray-900  line-clamp-2 leading-tight group-hover:text-blue-600 transition-colors duration-200 min-h-[3rem]">
                        {{ $event->title }}
                    </h3>

                    <!-- Meta Info -->
                    <div class="space-y-2 mb-4">
                        <div class="flex items-center text-gray-600 text-sm">
                            <svg class="w-4 h-4 mr-2 text-blue-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            <span class="truncate">{{ $event->location }}</span>
                        </div>

                        <div class="flex items-center text-gray-600 text-sm">
                            <svg class="w-4 h-4 mr-2 text-purple-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <span>
                                @if($event->start_date)
                                    {{ $event->start_date->translatedFormat('d M Y, H:i') }}
                                @endif
                            </span>
                        </div>
                    </div>

                    <!-- Description -->
                    <p class="text-gray-600 text-sm p-3 bg-gray-50 rounded-lg mb-4 line-clamp-2 leading-relaxed">
                        {{ $description }}
                    </p>

                    <!-- CTA Button -->
                    <div class="flex flex-col sm:flex-row gap-2">
                        <a href="{{ route('events.show', $event) }}"
                           class="group/btn flex-1 inline-flex items-center justify-center px-4 py-3 bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white font-semibold rounded-lg shadow-md hover:shadow-lg transform hover:-translate-y-0.5 transition-all duration-200 text-sm">
                            <span>Voir les détails</span>
                            <svg class="w-3 h-3 ml-2 group-hover/btn:translate-x-1 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </a>
                        @if($event->is_interactive && !empty($event->slug))
                        <a href="{{ route('interactive.events.show', ['event' => $event->slug]) }}?tab=votes"
                           class="flex-1 inline-flex items-center justify-center px-4 py-3 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold rounded-lg shadow-md hover:shadow-lg transform hover:-translate-y-0.5 transition-all duration-200 text-sm">
                            <span>Expérience interactive</span>
                            <svg class="w-3 h-3 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M12 5l7 7-7 7"/>
                            </svg>
                        </a>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Pagination -->
        @if($events->hasPages())
        <div class="mt-12 bg-white/80 backdrop-blur-sm rounded-2xl border border-gray-100 shadow-lg p-6">
            <div class="flex justify-center">
                {{ $events->links('vendor.pagination.tailwind') }}
            </div>
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

    const observer = new IntersectionObserver((entries) => {
        entries.forEach((entry, index) => {
            if (entry.isIntersecting) {
                setTimeout(() => {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                    entry.target.style.transition = 'all 0.4s ease-out';
                }, index * 50);
            }
        });
    }, {
        threshold: 0.1
    });

    eventCards.forEach((card) => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(20px)';
        observer.observe(card);
    });

    // Filtre: n'afficher que les événements interactifs si ?interactive=1
    const params = new URLSearchParams(window.location.search);
    const interactiveOnly = params.get('interactive') === '1';
    if (interactiveOnly) {
        eventCards.forEach((card) => {
            const isInteractive = card.getAttribute('data-interactive') === '1';
            if (!isInteractive) {
                card.style.display = 'none';
            }
        });
    }

    // Recherche en temps réel
    const searchInput = document.querySelector('input[type="text"]');
    if (searchInput) {
        let searchTimeout;

        searchInput.addEventListener('input', function(e) {
            clearTimeout(searchTimeout);

            searchTimeout = setTimeout(() => {
                const searchTerm = e.target.value.toLowerCase().trim();
                const events = document.querySelectorAll('.event-card');

                events.forEach((event) => {
                    const title = event.querySelector('h3').textContent.toLowerCase();
                    const location = event.querySelector('.text-gray-600 span').textContent.toLowerCase();
                    const description = event.querySelector('p').textContent.toLowerCase();

                    const matches = title.includes(searchTerm) ||
                                  location.includes(searchTerm) ||
                                  description.includes(searchTerm);

                    if (matches || searchTerm === '') {
                        event.style.display = 'block';
                        event.style.animation = 'fadeIn 0.3s ease-out';
                    } else {
                        event.style.display = 'none';
                    }
                });
            }, 300);
        });
    }

    // Effets de hover
    eventCards.forEach(card => {
        const img = card.querySelector('img');

        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-6px)';
            if (img) img.style.transform = 'scale(1.05)';
        });

        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(-2px)';
            if (img) img.style.transform = 'scale(1)';
        });
    });

    // Chargement des images
    const images = document.querySelectorAll('img');
    images.forEach(img => {
        img.addEventListener('load', function() {
            this.style.opacity = '1';
        });

        img.addEventListener('error', function() {
            this.src = `data:image/svg+xml;base64,${btoa(`
                <svg width="400" height="200" viewBox="0 0 400 200" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <rect width="400" height="200" fill="#F3F4F6"/>
                    <text x="200" y="110" fill="#9CA3AF" text-anchor="middle" font-family="Arial" font-size="14">Image non disponible</text>
                </svg>
            `)}`;
        });
    });

    // Styles d'animation
    const style = document.createElement('style');
    style.textContent = `
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        /* Pagination compacte */
        .pagination {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 0.5rem;
        }

        .pagination .page-link {
            padding: 0.5rem 0.75rem;
            border: 1px solid #e5e7eb;
            border-radius: 0.5rem;
            color: #6b7280;
            text-decoration: none;
            font-size: 0.875rem;
            font-weight: 500;
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
    `;
    document.head.appendChild(style);
});
</script>
@endpush
