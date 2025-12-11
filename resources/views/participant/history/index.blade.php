@extends('layouts.app')

@section('title', 'Mes participations')

@push('styles')
<style>
    .participation-card { transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); }
    .participation-card:hover { transform: translateY(-4px); box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.15); }
</style>
@endpush

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 via-white to-blue-50/30">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex lg:flex-row lg:items-center flex-col lg:justify-between mb-4">
                <div>
                    <h1 class="text-4xl font-bold text-slate-900 mb-2">Mes participations</h1>
                    <p class="text-lg text-slate-600">Historique complet de tous vos événements</p>
                </div>
                <a href="{{ route('dashboard') }}" class="inline-flex items-center px-4 py-2 bg-white border border-slate-300 rounded-xl hover:bg-slate-50">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Tableau de bord
                </a>
            </div>
        </div>

        <!-- Stats -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-gradient-to-br from-blue-500 to-cyan-600 rounded-2xl p-6 text-white shadow-xl">
                <p class="text-sm font-medium text-blue-100">Total</p>
                <p class="text-3xl font-bold mt-2">{{ number_format($stats['total_participations']) }}</p>
            </div>
            <div class="bg-gradient-to-br from-emerald-500 to-green-600 rounded-2xl p-6 text-white shadow-xl">
                <p class="text-sm font-medium text-emerald-100">À venir</p>
                <p class="text-3xl font-bold mt-2">{{ number_format($stats['upcoming_events']) }}</p>
            </div>
            <div class="bg-gradient-to-br from-purple-500 to-indigo-600 rounded-2xl p-6 text-white shadow-xl">
                <p class="text-sm font-medium text-purple-100">Dépenses totales</p>
                <p class="text-3xl font-bold mt-2">{{ \App\Support\Currency::format($stats['total_spent'], 'XOF') }}</p>
            </div>
            <div class="bg-gradient-to-br from-orange-500 to-red-600 rounded-2xl p-6 text-white shadow-xl">
                <p class="text-sm font-medium text-orange-100">Interactifs</p>
                <p class="text-3xl font-bold mt-2">{{ number_format($stats['interactive_events']) }}</p>
            </div>
        </div>

        <!-- Timeline Chart -->
        <div class="bg-white rounded-2xl p-6 shadow-lg border border-slate-100 mb-8">
            <h3 class="text-xl font-bold text-slate-900 mb-4">Participations (12 derniers mois)</h3>
            <div class="w-full h-full relative" >
                <canvas id="timelineChart"></canvas>
            </div>
        </div>

        <!-- Filters -->
        <div class="bg-white rounded-2xl p-6 shadow-lg border border-slate-100 mb-8">
            <form method="GET" class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <input type="text" name="search" value="{{ $filters['search'] }}" placeholder="Rechercher..." class="px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                    <select name="status" class="px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                        <option value="all">Tous les statuts</option>
                        <option value="upcoming" {{ $filters['status'] == 'upcoming' ? 'selected' : '' }}>À venir</option>
                        <option value="past" {{ $filters['status'] == 'past' ? 'selected' : '' }}>Passés</option>
                    </select>
                    <select name="payment" class="px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                        <option value="all">Tous les paiements</option>
                        <option value="paid" {{ $filters['payment'] == 'paid' ? 'selected' : '' }}>Payés</option>
                        <option value="unpaid" {{ $filters['payment'] == 'unpaid' ? 'selected' : '' }}>Non payés</option>
                    </select>
                    <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Filtrer</button>
                </div>
            </form>
        </div>

        <!-- List -->
        <div class="space-y-6">
    @forelse($participations as $participation)
        @php $event = $participation->event; @endphp
        {{-- CARD CONTAINER (Dark Mode Neutral Slate-800) --}}
        <div
            class="participation-card bg-white dark:bg-neutral-800/50 rounded-3xl p-6 md:p-8 shadow-xl dark:shadow-2xl dark:shadow-slate-900/50 border border-slate-100 dark:border-neutral-800 transition duration-300 hover:shadow-2xl dark:hover:border-purple-500/50">
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
                            @if($event->start_date->isFuture())
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
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-y-6 gap-x-6 text-sm mt-4">

                        {{-- Date & Time --}}
                        <div class="flex items-center">
                            <svg class="w-5 h-5 mr-2 text-green-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <span class="font-medium text-slate-700 dark:text-slate-300">
                                {{ $event->start_date->format('d/m/Y H:i') }}
                            </span>
                        </div>

                        {{-- Location --}}
                        <div class="flex items-center">
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

                        {{-- Statut Paiement --}}
                        <div class="flex items-center">
                            <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8c-1.657 0-3 1.119-3 2.5S10.343 13 12 13s3 1.119 3 2.5S13.657 18 12 18m0-10V6m0 12v-2m8-4a8 8 0 11-16 0 8 8 0 0116 0z" />
                            </svg>
                            <span class="font-medium text-slate-700 dark:text-slate-300">
                                {{ $participation->payment_status }}
                            </span>
                        </div>

                        {{-- Code Réservation --}}
                        <div class="flex items-center">
                            <svg class="w-5 h-5 mr-2 text-yellow-500" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z" />
                            </svg>
                            <span class="font-medium text-slate-700 dark:text-slate-300 truncate"
                                title="{{ $participation->qr_code_data ?? 'N/A' }}">
                                {{ substr($participation->qr_code_data ?? 'N/A', 0, 12) }}...
                            </span>
                        </div>
                    </div>
                </div>

                {{-- ACTIONS (Dark Mode Neutral Backgrounds for Buttons) --}}
                <div
                    class="flex flex-row md:flex-col gap-2 mt-4 md:mt-0 pt-4 md:pt-0 border-t md:border-t-0 md:border-l border-slate-100 dark:border-slate-700 w-full md:w-auto md:pl-6 justify-end">

                    {{-- Voir événement (Bleu - Action primaire) --}}
                    <a href="{{ route('events.show', $event) }}"
                        class="flex-1 justify-center inline-flex items-center px-4 py-2 bg-blue-50 text-blue-700 dark:bg-blue-800/50 dark:text-blue-300 rounded-xl hover:bg-blue-100 dark:hover:bg-blue-800 transition-colors text-sm font-semibold whitespace-nowrap">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                        Voir événement
                    </a>

                    {{-- Mon billet (Vert - Action de billet) --}}
                    <a href="{{ route('registrations.show', $participation->qr_code_data) }}"
                        class="flex-1 justify-center inline-flex items-center px-4 py-2 bg-emerald-50 text-emerald-700 dark:bg-emerald-800/50 dark:text-emerald-300 rounded-xl hover:bg-emerald-100 dark:hover:bg-emerald-800 transition-colors text-sm font-semibold whitespace-nowrap">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z" />
                        </svg>
                        Mon billet
                    </a>
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
            <h3 class="text-xl font-bold text-slate-800 dark:text-slate-200 mb-3">Aucune participation trouvée</h3>
            <p class="text-slate-500 dark:text-slate-400 mb-8">Parcourez les événements disponibles et inscrivez-vous.</p>
            {{-- Bouton Découvrir (Couleur d'accentuation) --}}
            <a href="{{ route('events.index') }}"
                class="inline-flex items-center px-8 py-3 bg-purple-600 text-white rounded-xl hover:bg-purple-700 dark:bg-purple-500 dark:hover:bg-purple-600 transition-colors font-bold shadow-lg shadow-purple-500/30">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
                Découvrir les événements
            </a>
        </div>
    @endforelse
</div>

        @if($participations->hasPages())
            <div class="mt-8">{{ $participations->links() }}</div>
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
            // Destroy existing instance if exists
            if (window.participantChartInstance) {
                window.participantChartInstance.destroy();
            }

            // Create new chart without responsive resize
            window.participantChartInstance = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: @json($timelineData['labels'] ?? []),
                    datasets: [{
                        label: 'Participations',
                        data: @json($timelineData['data'] ?? []),
                        borderColor: 'rgb(59, 130, 246)',
                        backgroundColor: 'rgba(59, 130, 246, 0.1)',
                        tension: 0.4,
                        fill: true
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: true,
                    aspectRatio: 3,
                    animation: false, // Disable to prevent resize
                    plugins: {
                        legend: { display: false }
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
}, { once: true });
</script>
@endpush
