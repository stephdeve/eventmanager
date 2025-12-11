@extends('layouts.app')

@section('title', 'Historique des événements')

@push('styles')
    <style>
        .history-card {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .history-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.15);
        }

        .filter-badge {
            transition: all 0.2s;
        }

        .filter-badge:hover {
            transform: scale(1.05);
        }
    </style>
@endpush

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-slate-50 via-white to-purple-50/30">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <!-- En-tête -->
            <div class="mb-8">
                <div class="flex lg:flex-row lg:items-center flex-col lg:justify-between mb-4">
                    <div>
                        <h1 class="text-4xl font-bold text-slate-900 mb-2">Historique des événements</h1>
                        <p class="text-lg text-slate-600">Vue complète de tous vos événements</p>
                    </div>
                    <div class="flex gap-3">
                        <a href="{{ route('dashboard') }}"
                            class="inline-flex items-center px-4 py-2 bg-white border border-slate-300 rounded-xl hover:bg-slate-50 transition-colors">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                            </svg>
                            Tableau de bord
                        </a>
                        <a href="{{ route('organizer.history.export-all') }}"
                            class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-emerald-600 to-green-600 text-white rounded-xl hover:from-emerald-700 hover:to-green-700 transition-all shadow-lg">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            Exporter tout (CSV)
                        </a>
                    </div>
                </div>
            </div>

            <!-- Statistiques globales -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                <div class="bg-gradient-to-br from-purple-500 to-indigo-600 rounded-2xl p-6 text-white shadow-xl">
                    <p class="text-sm font-medium text-purple-100">Total événements</p>
                    <p class="text-3xl font-bold mt-2">{{ number_format($stats['total_events']) }}</p>
                </div>
                <div class="bg-gradient-to-br from-blue-500 to-cyan-600 rounded-2xl p-6 text-white shadow-xl">
                    <p class="text-sm font-medium text-blue-100">Participants totaux</p>
                    <p class="text-3xl font-bold mt-2">{{ number_format($stats['total_participants']) }}</p>
                </div>
                <div class="bg-gradient-to-br from-emerald-500 to-green-600 rounded-2xl p-6 text-white shadow-xl">
                    <p class="text-sm font-medium text-emerald-100">Revenus totaux</p>
                    <p class="text-3xl font-bold mt-2">{{ \App\Support\Currency::format($stats['total_revenue'], 'XOF') }}
                    </p>
                </div>
                <div class="bg-gradient-to-br from-orange-500 to-red-600 rounded-2xl p-6 text-white shadow-xl">
                    <p class="text-sm font-medium text-orange-100">Moyenne participants</p>
                    <p class="text-3xl font-bold mt-2">{{ number_format($stats['avg_attendance']) }}</p>
                </div>
            </div>

            <!-- Timeline Chart -->
            <div class="bg-white rounded-2xl p-6 shadow-lg border border-slate-100 mb-8">
                <h3 class="text-xl font-bold text-slate-900 mb-4">Événements créés (12 derniers mois)</h3>
                <div class="w-full h-full relative" >
                    <canvas id="timelineChart"></canvas>
                </div>
            </div>

            <!-- Filtres -->
            <div class="bg-white rounded-2xl p-6 shadow-lg border border-slate-100 mb-8">
                <form method="GET" action="{{ route('organizer.events.history') }}" class="space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-5 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-2">Recherche</label>
                            <input type="text" name="search" value="{{ $filters['search'] }}"
                                placeholder="Titre, lieu..."
                                class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-2">Statut</label>
                            <select name="status"
                                class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-purple-500">
                                <option value="all" {{ $filters['status'] == 'all' ? 'selected' : '' }}>Tous</option>
                                <option value="upcoming" {{ $filters['status'] == 'upcoming' ? 'selected' : '' }}>À venir
                                </option>
                                <option value="ongoing" {{ $filters['status'] == 'ongoing' ? 'selected' : '' }}>En cours
                                </option>
                                <option value="past" {{ $filters['status'] == 'past' ? 'selected' : '' }}>Passés</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-2">Type</label>
                            <select name="type"
                                class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-purple-500">
                                <option value="all" {{ $filters['type'] == 'all' ? 'selected' : '' }}>Tous</option>
                                <option value="paid" {{ $filters['type'] == 'paid' ? 'selected' : '' }}>Payants</option>
                                <option value="free" {{ $filters['type'] == 'free' ? 'selected' : '' }}>Gratuits</option>
                                <option value="interactive" {{ $filters['type'] == 'interactive' ? 'selected' : '' }}>
                                    Interactifs</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-2">Capacité</label>
                            <select name="capacity"
                                class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-purple-500">
                                <option value="all" {{ $filters['capacity'] == 'all' ? 'selected' : '' }}>Toutes
                                </option>
                                <option value="available" {{ $filters['capacity'] == 'available' ? 'selected' : '' }}>
                                    Places disponibles</option>
                                <option value="full" {{ $filters['capacity'] == 'full' ? 'selected' : '' }}>Complet
                                </option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-2">Trier par</label>
                            <select name="sort_by"
                                class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-purple-500">
                                <option value="start_date" {{ $filters['sort_by'] == 'start_date' ? 'selected' : '' }}>Date
                                </option>
                                <option value="participants" {{ $filters['sort_by'] == 'participants' ? 'selected' : '' }}>
                                    Participants</option>
                                <option value="revenue" {{ $filters['sort_by'] == 'revenue' ? 'selected' : '' }}>Revenus
                                </option>
                                <option value="title" {{ $filters['sort_by'] == 'title' ? 'selected' : '' }}>Titre
                                </option>
                            </select>
                        </div>
                    </div>
                    <div class="flex items-center gap-4">
                        <button type="submit"
                            class="px-6 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition-colors">
                            Filtrer
                        </button>
                        <a href="{{ route('organizer.events.history') }}"
                            class="px-6 py-2 rounded-lg bg-red-600 text-white hover:bg-red-700 transition-colors">
                            Réinitialiser
                        </a>
                    </div>
                </form>
            </div>

            <!-- Liste des événements -->
            <div class="space-y-6">
                @forelse($events as $event)
                    {{-- CARD CONTAINER (Dark Mode Neutral Slate-800) --}}
                    <div
                        class="history-card bg-white dark:bg-neutral-800/50 rounded-3xl p-6 md:p-8 shadow-xl dark:shadow-2xl dark:shadow-slate-900/50 border border-slate-100 dark:border-neutral-800 transition duration-300 hover:shadow-2xl dark:hover:border-purple-500/50">
                        <div class="flex flex-col md:flex-row items-start justify-between">

                            {{-- MAIN CONTENT (TITLE & DETAILS) --}}
                            <div class="flex-1 w-full md:pr-6">

                                {{-- HEADER & BADGES --}}
                                <div class="flex flex-col sm:flex-row sm:items-center gap-3 mb-8">
                                    <h3 class="text-2xl font-extrabold text-slate-900 dark:text-white leading-tight">
                                        {{ $event->title }}
                                    </h3>

                                    {{-- BADGES (Couleurs atténuées en Dark Mode pour rester neutre) --}}
                                    <div class="flex flex-wrap gap-2">
                                        @if ($event->is_interactive)
                                            {{-- Badge Interactif (Violet atténué) --}}
                                            <span
                                                class="badge badge-interactive inline-flex items-center bg-purple-100 text-purple-700 dark:bg-purple-900/50 dark:text-purple-300 text-xs font-semibold px-3 py-1 rounded-lg">
                                                <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                                </svg>
                                                Interactif
                                            </span>
                                        @endif

                                        @if ($event->start_date->isFuture())
                                            {{-- Badge À venir (Bleu atténué) --}}
                                            <span
                                                class="badge badge-status-future inline-flex items-center bg-blue-100 text-blue-700 dark:bg-blue-900/50 dark:text-blue-300 text-xs font-semibold px-3 py-1 rounded-lg">
                                                <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2.5"
                                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                                À venir
                                            </span>
                                        @elseif($event->start_date->isToday())
                                            {{-- Badge En cours (Vert atténué) --}}
                                            <span
                                                class="badge badge-status-current inline-flex items-center bg-green-100 text-green-700 dark:bg-green-900/50 dark:text-green-300 text-xs font-semibold px-3 py-1 rounded-lg">
                                                <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2.5"
                                                        d="M5.636 18.364a9 9 0 010-12.728m12.728 0a9 9 0 010 12.728m-9.9-2.828a1 1 0 000 1.414m2.828-9.9a1 1 0 000 1.414m5.656-5.656a1 1 0 000 1.414m-7.07 7.07a1 1 0 000 1.414z" />
                                                </svg>
                                                En cours
                                            </span>
                                        @else
                                            {{-- Badge Passé (Gris neutre renforcé) --}}
                                            <span
                                                class="badge badge-status-past inline-flex items-center bg-slate-100 text-slate-600 dark:bg-slate-600 dark:text-slate-100 text-xs font-semibold px-3 py-1 rounded-lg">
                                                <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2.5"
                                                        d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                                Passé
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                {{-- INFO GRID (Texte et icônes neutres) --}}
                                <div class="grid grid-cols-2 lg:grid-cols-4 gap-y-6 gap-x-6 text-sm mt-4 ">

                                    {{-- Date & Time --}}
                                    <div class="flex items-center">
                                        <svg class="w-5 h-5 mr-2 text-green-600 " fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        <span class="font-medium text-slate-700 dark:text-slate-300">
                                            {{ optional($event->start_date)->format('d/m/Y H:i') }}
                                        </span>
                                    </div>

                                    {{-- Participants --}}
                                    <div class="flex items-center">
                                        <svg class="w-5 h-5 mr-2 text-yellow-500" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                        </svg>
                                        <span class="font-medium text-slate-700 dark:text-slate-300">
                                            {{ $event->registrations_count }} participant(s)
                                        </span>
                                    </div>

                                    {{-- Revenue --}}
                                    <div class="flex items-center">
                                        <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 8c-1.657 0-3 1.119-3 2.5S10.343 13 12 13s3 1.119 3 2.5S13.657 18 12 18m0-10V6m0 12v-2m8-4a8 8 0 11-16 0 8 8 0 0116 0z" />
                                        </svg>
                                        <span class="font-medium text-slate-700 dark:text-slate-300">
                                            {{ \App\Support\Currency::format($event->total_revenue_minor ?? 0, $event->currency ?? 'XOF') }}
                                        </span>
                                    </div>

                                    {{-- Location --}}
                                    <div class="flex items-center ">
                                        <svg class="w-5 h-5 mr-2 text-red-600" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        </svg>
                                        <span class="font-medium text-slate-700 dark:text-slate-300 truncate"
                                            title="{{ $event->location }}">
                                            {{ $event->location }}
                                        </span>
                                    </div>
                                </div>
                            </div>

                            {{-- ACTIONS (Dark Mode Neutral Backgrounds for Buttons) --}}
                            <div
                                class="flex flex-row md:flex-col gap-2 mt-4 md:mt-0 pt-4 md:pt-0 border-t md:border-t-0 md:border-l border-slate-100 dark:border-slate-700 w-full md:w-auto md:pl-6 justify-end">

                                {{-- Voir (Bleu - Action primaire) --}}
                                <a href="{{ route('events.show', $event) }}"
                                    class="flex-1 justify-center inline-flex items-center px-4 py-2 bg-blue-50 text-blue-700 dark:bg-blue-800/50 dark:text-blue-300 rounded-xl hover:bg-blue-100 dark:hover:bg-blue-800 transition-colors text-sm font-semibold whitespace-nowrap">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                    Voir
                                </a>

                                {{-- CSV (Émeraude - Action d'export) --}}
                                <form method="POST" action="{{ route('organizer.events.export', $event) }}"
                                    class="flex-1">
                                    @csrf
                                    <button type="submit" name="format" value="csv"
                                        class="w-full inline-flex items-center justify-center px-4 py-2 bg-emerald-50 text-emerald-700 dark:bg-emerald-800/50 dark:text-emerald-300 rounded-xl hover:bg-emerald-100 dark:hover:bg-emerald-800 transition-colors text-sm font-semibold whitespace-nowrap">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 13h6m-3-3v6m5 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                        CSV
                                    </button>
                                </form>

                                {{-- PDF (Rouge - Action d'export) --}}
                                <form method="POST" action="{{ route('organizer.events.export', $event) }}"
                                    class="flex-1">
                                    @csrf
                                    <button type="submit" name="format" value="pdf"
                                        class="w-full inline-flex items-center justify-center px-4 py-2 bg-red-50 text-red-700 dark:bg-red-800/50 dark:text-red-300 rounded-xl hover:bg-red-100 dark:hover:bg-red-800 transition-colors text-sm font-semibold whitespace-nowrap">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3 10h18M3 14h18m-9-4v8m-7 0h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                        </svg>
                                        PDF
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                    {{-- EMPTY STATE (Neutral pour l'état vide) --}}
                    <div
                        class="bg-white dark:bg-neutral-900 rounded-3xl p-12 text-center shadow-xl dark:shadow-2xl dark:shadow-slate-900/50 border border-slate-100 dark:border-neutral-800">
                        <div
                            class="w-20 h-20 mx-auto bg-slate-50 dark:bg-neutral-800 rounded-3xl flex items-center justify-center mb-6">
                            <svg class="w-10 h-10 text-slate-400 dark:text-slate-500" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-slate-800 dark:text-slate-200 mb-3">Aucun événement trouvé</h3>
                        <p class="text-slate-500 dark:text-slate-400 mb-8">Essayez de modifier vos filtres ou créez votre
                            premier événement.</p>
                        {{-- Bouton Créer (Couleur d'accentuation) --}}
                        <a href="{{ route('events.create') }}"
                            class="inline-flex items-center px-8 py-3 bg-purple-600 text-white rounded-xl hover:bg-purple-700 dark:bg-purple-500 dark:hover:bg-purple-600 transition-colors font-bold shadow-lg shadow-purple-500/30">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Créer un événement
                        </a>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            @if ($events->hasPages())
                <div class="mt-8">
                    {{ $events->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('timelineChart');
            if (ctx && typeof Chart !== 'undefined') {
                try {
                    // Destroy existing chart if it exists
                    if (window.timelineChartInstance) {
                        window.timelineChartInstance.destroy();
                    }

                    // Create new chart with fixed dimensions to prevent infinite resize
                    window.timelineChartInstance = new Chart(ctx, {
                        type: 'line',
                        data: {
                            labels: @json($timelineData['labels'] ?? []),
                            datasets: [{
                                label: 'Événements créés',
                                data: @json($timelineData['data'] ?? []),
                                borderColor: 'rgb(147, 51, 234)',
                                backgroundColor: 'rgba(147, 51, 234, 0.1)',
                                tension: 0.4,
                                fill: true
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: true,
                            aspectRatio: 3,
                            animation: false, // Disable animation to prevent resize loops
                            plugins: {
                                legend: {
                                    display: false
                                }
                            },
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    ticks: {
                                        stepSize: 1,
                                        precision: 0
                                    }
                                }
                            }
                        }
                    });
                } catch (error) {
                    console.error('Error creating chart:', error);
                    if (ctx) ctx.style.display = 'none';
                }
            }
        }, {
            once: true
        });
    </script>
@endpush
