@extends('layouts.app')

@section('title', 'Événements à venir')

@push('styles')
<style>
    .dashboard-card {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .dashboard-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.15);
    }

    .event-card {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .event-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.15);
    }

    .pulse-dot {
        animation: pulse 2s infinite;
    }

    @keyframes pulse {
        0%, 100% {
            opacity: 1;
        }
        50% {
            opacity: 0.5;
        }
    }

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
</style>
@endpush

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 via-white to-indigo-50/30 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header Section -->
        <div class="mb-12">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
                <div class="flex-1">
                    <div class="inline-flex items-center gap-3 bg-white/80 backdrop-blur-sm rounded-2xl px-4 py-3 border border-slate-200 shadow-sm mb-4">
                        <div class="w-2 h-2 bg-gradient-to-r from-indigo-500 to-purple-600 rounded-full pulse-dot"></div>
                        <span class="text-sm font-semibold text-slate-700">Événements à venir</span>
                    </div>
                    <h1 class="text-4xl font-bold bg-gradient-to-r from-slate-800 to-indigo-600 bg-clip-text text-transparent mb-4">
                        Découvrez des Expériences Uniques
                    </h1>
                    <p class="text-lg text-slate-600 max-w-2xl">
                        Rejoignez notre communauté dynamique et participez à des événements mémorables
                    </p>
                </div>

                @can('create', App\Models\Event::class)
                <a href="{{ route('events.create') }}"
                   class="group inline-flex items-center px-6 py-4 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white font-semibold rounded-xl shadow-lg transition-all duration-200 transform hover:scale-105">
                    <svg class="w-5 h-5 mr-2 group-hover:rotate-90 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                    </svg>
                    Créer un événement
                </a>
                @endcan
            </div>
        </div>

        <!-- Stats Cards - NOUVELLES STATISTIQUES -->
        @if(!$events->isEmpty())
        @php
            $totalEvents = $events->count();
            $interactiveEvents = $events->where('is_interactive', true)->count();
            $upcomingEvents = $events->filter(function($event) {
                return $event->start_date && $event->start_date->isFuture();
            })->count();
            $thisWeekEvents = $events->filter(function($event) {
                return $event->start_date && $event->start_date->between(now(), now()->addWeek());
            })->count();
        @endphp

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
            <!-- Total des événements -->
            <div class="dashboard-card bg-gradient-to-br from-blue-500 to-indigo-600 rounded-2xl p-6 shadow-xl text-white relative overflow-hidden">
                <div class="absolute top-0 right-0 w-24 h-24 bg-white/10 rounded-full -translate-y-12 translate-x-12"></div>
                <div class="relative z-10">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-blue-100 mb-1">Total des événements</p>
                            <p class="text-2xl font-bold">{{ $totalEvents }}</p>
                        </div>
                        <div class="p-3 bg-white/20 rounded-xl">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Événements interactifs -->
            <div class="dashboard-card bg-gradient-to-br from-emerald-500 to-green-500 rounded-2xl p-6 shadow-xl text-white relative overflow-hidden">
                <div class="absolute top-0 right-0 w-24 h-24 bg-white/10 rounded-full -translate-y-12 translate-x-12"></div>
                <div class="relative z-10">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-emerald-100 mb-1">Événements interactifs</p>
                            <p class="text-2xl font-bold">{{ $interactiveEvents }}</p>
                        </div>
                        <div class="p-3 bg-white/20 rounded-xl">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Événements à venir -->
            <div class="dashboard-card bg-gradient-to-br from-amber-500 to-orange-500 rounded-2xl p-6 shadow-xl text-white relative overflow-hidden">
                <div class="absolute top-0 right-0 w-24 h-24 bg-white/10 rounded-full -translate-y-12 translate-x-12"></div>
                <div class="relative z-10">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-amber-100 mb-1">À venir</p>
                            <p class="text-2xl font-bold">{{ $upcomingEvents }}</p>
                        </div>
                        <div class="p-3 bg-white/20 rounded-xl">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Cette semaine -->
            <div class="dashboard-card bg-gradient-to-br from-purple-500 to-fuchsia-600 rounded-2xl p-6 shadow-xl text-white relative overflow-hidden">
                <div class="absolute top-0 right-0 w-24 h-24 bg-white/10 rounded-full -translate-y-12 translate-x-12"></div>
                <div class="relative z-10">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-purple-100 mb-1">Cette semaine</p>
                            <p class="text-2xl font-bold">{{ $thisWeekEvents }}</p>
                        </div>
                        <div class="p-3 bg-white/20 rounded-xl">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif

        <!-- Action Bar -->
        <div class="dashboard-card bg-white rounded-2xl p-6 shadow-xl border border-slate-100 mb-8">
            <div class="flex flex-col lg:flex-row justify-between items-center gap-6">
                <div class="flex flex-col sm:flex-row items-center gap-4 w-full lg:w-auto">
                    <!-- Recherche -->
                    <div class="relative flex-1 lg:flex-none min-w-[280px]">
                        <input type="text"
                               placeholder="Rechercher un événement..."
                               class="pl-12 pr-4 py-3.5 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 bg-white/90 backdrop-blur-sm w-full transition-all duration-200 text-slate-700 placeholder-slate-500 text-sm font-medium">
                        <svg class="w-5 h-5 text-slate-400 absolute left-4 top-1/2 transform -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </div>

                    <!-- Filtres -->
                    <div class="flex items-center gap-3">
                        <select class="px-4 py-3.5 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 bg-white/90 backdrop-blur-sm text-slate-700 text-sm font-medium transition-all duration-200 min-w-40">
                            <option>Tous les événements</option>
                            <option>Événements interactifs</option>
                            <option>Événements standards</option>
                        </select>

                        <select class="px-4 py-3.5 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 bg-white/90 backdrop-blur-sm text-slate-700 text-sm font-medium transition-all duration-200 min-w-40">
                            <option>Prochainement</option>
                            <option>Cette semaine</option>
                            <option>Ce mois-ci</option>
                        </select>
                    </div>
                </div>

                <!-- Boutons d'action -->
                <div class="flex items-center gap-3">
                    <a href="{{ route('events.index', ['interactive' => 1]) }}"
                       class="inline-flex items-center px-6 py-3.5 bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-700 hover:to-teal-700 text-white font-semibold rounded-xl shadow-lg transition-all duration-200 transform hover:scale-105">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/>
                        </svg>
                        Expériences interactives
                    </a>
                </div>
            </div>
        </div>

        @if($events->isEmpty())
        <!-- Empty State -->
        <div class="dashboard-card bg-white rounded-2xl p-12 text-center border border-slate-100">
            <div class="max-w-md mx-auto">
                <div class="w-24 h-24 mx-auto mb-6 bg-gradient-to-br from-slate-100 to-slate-200 rounded-3xl flex items-center justify-center">
                    <svg class="w-12 h-12 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-slate-900 mb-3">Aucun événement programmé</h3>
                <p class="text-slate-600 mb-8 text-base">
                    Soyez le premier à créer un événement passionnant et à rassembler notre communauté.
                </p>
                @can('create', App\Models\Event::class)
                <a href="{{ route('events.create') }}"
                   class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200 text-base">
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
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-8 mb-12" id="eventsGrid">
            @foreach($events as $event)
            @php
                $seats = (int) ($event->available_seats ?? 0);
                $isFree = (int) $event->price <= 0;
                $description = \Illuminate\Support\Str::limit(strip_tags($event->description), 100);
                $isUpcoming = $event->start_date && $event->start_date->isFuture();
                $isInteractive = $event->is_interactive;
            @endphp

            <div class="event-card group bg-white rounded-3xl shadow-lg border border-slate-100 overflow-hidden" data-interactive="{{ $isInteractive ? 1 : 0 }}">
                <!-- Image Container -->
                <div class="relative h-56 overflow-hidden">
                    <img src="{{ $event->cover_image_url }}"
                         alt="{{ $event->title }}"
                         class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent"></div>

                    <!-- Date Overlay -->
                    @if($event->start_date)
                    <div class="absolute bottom-4 left-4">
                        <div class="bg-white/95 backdrop-blur-sm rounded-xl p-3 text-center shadow-xl">
                            <div class="text-xl font-bold text-slate-900 leading-none">
                                {{ $event->start_date->format('d') }}
                            </div>
                            <div class="text-xs font-semibold text-slate-600 uppercase mt-1">
                                {{ $event->start_date->format('M') }}
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- Badges -->
                    <div class="absolute top-4 right-4 flex flex-col space-y-2">
                        @if($seats > 0)
                        <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-bold bg-green-500 text-white shadow-lg">
                            {{ $seats }} places
                        </span>
                        @else
                        <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-bold bg-red-500 text-white shadow-lg">
                            Complet
                        </span>
                        @endif

                        <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-bold {{ $isFree ? 'bg-blue-500 text-white' : 'bg-purple-500 text-white' }} shadow-lg">
                            {{ $isFree ? 'Gratuit' : $event->price_for_display }}
                        </span>

                        @if($isInteractive)
                            @if(!empty($event->slug))
                                <a href="{{ route('interactive.events.show', ['event' => $event->slug]) }}" class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-bold bg-emerald-600 text-white shadow-lg hover:bg-emerald-700 transition-colors duration-200">
                                    @if(method_exists($event, 'isInteractiveActive') && $event->isInteractiveActive())
                                        <span class="w-2 h-2 bg-white rounded-full mr-1.5 pulse-dot"></span>
                                    @endif
                                    Interactif
                                </a>
                            @else
                                <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-bold bg-emerald-600 text-white shadow-lg">
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
                    <div class="inline-flex items-center px-3 py-1.5 bg-blue-50 text-blue-700 rounded-full text-xs font-semibold mb-4 border border-blue-200">
                        <div class="w-2 h-2 bg-blue-500 rounded-full mr-2 pulse-dot"></div>
                        À venir
                    </div>
                    @endif

                    <h3 class="font-bold text-xl text-slate-900 line-clamp-2 leading-tight group-hover:text-indigo-600 transition-colors duration-200 min-h-[3.5rem] mb-3">
                        {{ $event->title }}
                    </h3>

                    <!-- Meta Info -->
                    <div class="space-y-3 mb-4">
                        <div class="flex items-center text-slate-600 text-sm">
                            <svg class="w-5 h-5 mr-3 text-indigo-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            <span class="truncate font-medium">{{ $event->location }}</span>
                        </div>

                        <div class="flex items-center text-slate-600 text-sm">
                            <svg class="w-5 h-5 mr-3 text-purple-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <span class="font-medium">
                                @if($event->start_date)
                                    {{ $event->start_date->translatedFormat('d M Y, H:i') }}
                                @endif
                            </span>
                        </div>
                    </div>

                    <!-- Description -->
                    <p class="text-slate-600 text-sm p-4 bg-slate-50 rounded-xl mb-5 line-clamp-2 leading-relaxed border border-slate-100">
                        {{ $description }}
                    </p>

                    <!-- CTA Button -->
                    <div class="flex flex-col sm:flex-row gap-3">
                        <a href="{{ route('events.show', $event) }}"
                           class="group/btn flex-1 inline-flex items-center justify-center px-5 py-3.5 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200 text-sm">
                            <span>Voir les détails</span>
                            <svg class="w-4 h-4 ml-2 group-hover/btn:translate-x-1 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </a>
                        @if($isInteractive && !empty($event->slug))
                        <a href="{{ route('interactive.events.show', ['event' => $event->slug]) }}?tab=votes"
                           class="flex-1 inline-flex items-center justify-center px-5 py-3.5 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200 text-sm">
                            <span>Expérience interactive</span>
                            <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/>
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
        <div class="dashboard-card bg-white/80 backdrop-blur-sm rounded-2xl p-6 border border-slate-100">
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
                    const location = event.querySelector('.text-slate-600 span').textContent.toLowerCase();
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

    // Effets de hover améliorés
    eventCards.forEach(card => {
        const img = card.querySelector('img');

        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-8px)';
            if (img) img.style.transform = 'scale(1.1)';
        });

        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(-4px)';
            if (img) img.style.transform = 'scale(1.05)';
        });
    });

    // Gestion des images
    const images = document.querySelectorAll('img');
    images.forEach(img => {
        img.addEventListener('load', function() {
            this.style.opacity = '1';
        });

        img.addEventListener('error', function() {
            this.src = `data:image/svg+xml;base64,${btoa(`
                <svg width="400" height="200" viewBox="0 0 400 200" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <rect width="400" height="200" fill="#f8fafc"/>
                    <text x="200" y="110" fill="#94a3b8" text-anchor="middle" font-family="Arial" font-size="14" font-weight="600">Image non disponible</text>
                </svg>
            `)}`;
        });
    });

    // Styles d'animation
    const style = document.createElement('style');
    style.textContent = `
        .pagination {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 0.75rem;
        }

        .pagination .page-link {
            padding: 0.75rem 1rem;
            border: 1px solid #e2e8f0;
            border-radius: 0.75rem;
            color: #64748b;
            text-decoration: none;
            font-size: 0.875rem;
            font-weight: 600;
            transition: all 0.3s;
        }

        .pagination .page-link:hover {
            background-color: #f1f5f9;
            border-color: #cbd5e1;
            transform: translateY(-2px);
        }

        .pagination .active .page-link {
            background: linear-gradient(135deg, #4f46e5, #7c3aed);
            border-color: #4f46e5;
            color: white;
            box-shadow: 0 10px 15px -3px rgba(79, 70, 229, 0.3);
        }
    `;
    document.head.appendChild(style);
});
</script>
@endpush
