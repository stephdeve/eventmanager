@extends('layouts.app')

@section('title', 'Tableau de bord - Organisateur')

@push('styles')
    <style>
        /* Animation douce pour les cartes */
        .dashboard-card {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .dashboard-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }

        /* Style personnalisé pour les graphiques */
        .chart-container {
            position: relative;
            height: 16rem;
        }
    </style>
@endpush

@section('content')
<div class="min-h-screen bg-gray-50/30">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- En-tête avec bannière d'abonnement -->
        @php
            $user = auth()->user();
            $active = method_exists($user, 'hasActiveSubscription') ? $user->hasActiveSubscription() : false;
            $expiresAt = $user->subscription_expires_at;
            $expired = $expiresAt ? $expiresAt->isPast() : false;
        @endphp

        @if(!$active)
            <div class="mb-8 rounded-2xl bg-gradient-to-r from-amber-50 to-orange-50 border border-amber-200 p-6 shadow-sm">
                <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                    <div class="flex items-start gap-4 flex-1">
                        <div class="flex-shrink-0 p-2 bg-amber-100 rounded-lg">
                            <svg class="w-6 h-6 text-amber-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 9v3m0 4h.01M10.29 3.86l-7.4 12.84A1.5 1.5 0 004.2 19.5h15.6a1.5 1.5 0 001.3-2.3L13.7 3.86a1.5 1.5 0 00-2.6 0z"/>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <h3 class="text-lg font-semibold text-amber-900">Abonnement expiré ou inactif</h3>
                            <p class="mt-1 text-sm text-amber-800">
                                @if($expired)
                                    Expiré le {{ $expiresAt->translatedFormat('d M Y à H\\hi') }}.
                                @endif
                                Offre actuelle: {{ ucfirst($user->subscription_plan ?? '—') }}. Le renouvellement réactivera toutes vos fonctionnalités.
                            </p>
                        </div>
                    </div>
                    <a href="{{ route('subscriptions.plans') }}"
                       class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-amber-600 to-orange-600 hover:from-amber-700 hover:to-orange-700 text-white font-semibold rounded-xl shadow-lg transition-all duration-200 transform hover:scale-105">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                        Renouveler maintenant
                    </a>
                </div>
            </div>
        @endif

        <!-- En-tête principal -->
        <div class="mb-8">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Tableau de bord</h1>
                    <p class="mt-2 text-gray-600">Bienvenue, {{ $user->name }} 👋 Voici l'aperçu de vos activités.</p>
                </div>
                <a href="{{ route('events.create') }}"
                   class="inline-flex items-center px-6 py-4 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white font-semibold rounded-xl shadow-lg transition-all duration-200 transform hover:scale-105 group">
                    <svg class="w-5 h-5 mr-2 group-hover:rotate-90 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                    </svg>
                    Nouvel événement
                </a>
            </div>
        </div>

        <!-- Cartes de synthèse principales -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            @php
                $totalRevenueMinor = (int) data_get($financeTotals ?? [], 'total_revenue_minor', 0);
                $totalTicketsSold = (int) data_get($financeTotals ?? [], 'total_tickets_sold', 0);
                $currencyCode = 'XOF';
                $totalRevenueFormatted = \App\Support\Currency::format($totalRevenueMinor, $currencyCode);
            @endphp

            <!-- Revenus totaux -->
            <div class="dashboard-card bg-white rounded-2xl p-6 shadow-lg border ">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Revenus totaux</p>
                        <p class="text-2xl font-bold text-gray-900 mt-1">{{ $totalRevenueFormatted }}</p>
                    </div>
                    <div class="p-3 bg-emerald-50 rounded-xl">
                        <svg class="w-8 h-8 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 1.119-3 2.5S10.343 13 12 13s3 1.119 3 2.5S13.657 18 12 18m0-10V6m0 12v-2m8-4a8 8 0 11-16 0 8 8 0 0116 0z"/>
                        </svg>
                    </div>
                </div>
                <div class="mt-4 pt-4 border-t border-gray-100">
                    <div class="flex items-center text-sm text-emerald-600">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                        </svg>
                        Tendance positive
                    </div>
                </div>
            </div>

            <!-- Tickets vendus -->
            <div class="dashboard-card bg-white rounded-2xl p-6 shadow-lg border ">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Tickets vendus</p>
                        <p class="text-2xl font-bold text-gray-900 mt-1">{{ number_format($totalTicketsSold) }}</p>
                    </div>
                    <div class="p-3 bg-fuchsia-50 rounded-xl">
                        <svg class="w-8 h-8 text-fuchsia-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h10M5 20h14M9 5h6"/>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Événements créés -->
            <div class="dashboard-card bg-white rounded-2xl p-6 shadow-lg border ">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Événements créés</p>
                        <p class="text-2xl font-bold text-gray-900 mt-1">{{ number_format(data_get($stats, 'total_events', 0)) }}</p>
                    </div>
                    <div class="p-3 bg-indigo-50 rounded-xl">
                        <svg class="w-8 h-8 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Scanner rapide -->
            <a href="{{ route('scanner') }}" class="dashboard-card bg-gradient-to-br from-purple-600 to-indigo-700 rounded-2xl p-6 shadow-lg text-white hover:from-purple-700 hover:to-indigo-800 transition-all duration-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-purple-100">Scanner un billet</p>
                        <p class="text-2xl font-bold mt-1">Ouvrir</p>
                    </div>
                    <div class="p-3 bg-white/20 rounded-xl backdrop-blur-sm">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/>
                        </svg>
                    </div>
                </div>
                <div class="mt-4 flex items-center text-purple-100 text-sm">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                    </svg>
                    Accès rapide au scanner
                </div>
            </a>
        </div>

        <!-- Graphiques et contenu principal -->
        <div class="grid grid-cols-1 xl:grid-cols-3 gap-8">
            <!-- Colonne principale -->
            <div class="xl:col-span-2 space-y-8">
                <!-- Graphique évolution des inscriptions -->
                <div class="dashboard-card bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">Évolution des inscriptions</h3>
                            <p class="text-sm text-gray-600 mt-1">Tendance sur les 7 derniers jours</p>
                        </div>
                        @php
                            $growth = data_get($charts, 'weekly_registrations.growth_percentage', 0);
                        @endphp
                        <div class="mt-2 sm:mt-0 inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $growth >= 0 ? 'bg-green-50 text-green-700' : 'bg-red-50 text-red-700' }}">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                @if($growth >= 0)
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                                @else
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6"/>
                                @endif
                            </svg>
                            {{ $growth >= 0 ? '+' : '' }}{{ $growth }}%
                        </div>
                    </div>
                    <div class="chart-container">
                        <canvas id="weekly-registrations-chart"></canvas>
                    </div>
                </div>

                <!-- Graphique ventes quotidiennes -->
                <div class="dashboard-card bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold text-gray-900">Ventes quotidiennes</h3>
                        <p class="text-sm text-gray-600 mt-1">Montants journaliers sur 14 jours</p>
                    </div>
                    <div class="chart-container">
                        <canvas id="daily-sales-chart"></canvas>
                    </div>
                </div>

                <!-- Dernières inscriptions -->
                <div class="dashboard-card bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
                        <h3 class="text-lg font-semibold text-gray-900">Dernières inscriptions</h3>
                        <a href="{{ route('events.index') }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-500 transition-colors">
                            Gérer les événements
                        </a>
                    </div>
                    <div class="divide-y divide-gray-100">
                        @forelse(data_get($stats, 'recent_registrations', []) as $registration)
                            <div class="px-6 py-4 hover:bg-gray-50/50 transition-colors">
                                <div class="flex items-center justify-between">
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-semibold text-gray-900 truncate">
                                            {{ $registration->event->title }}
                                        </p>
                                        <div class="mt-1 flex flex-col sm:flex-row sm:items-center gap-2 text-sm text-gray-600">
                                            <span class="flex items-center">
                                                <svg class="w-4 h-4 mr-1.5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                                                </svg>
                                                {{ $registration->user->name }}
                                            </span>
                                            <span class="flex items-center">
                                                <svg class="w-4 h-4 mr-1.5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/>
                                                </svg>
                                                {{ $registration->created_at->isoFormat('D MMM YYYY') }}
                                            </span>
                                        </div>
                                    </div>
                                    <span class="ml-4 px-3 py-1 text-xs font-medium rounded-full {{ $registration->is_validated ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                        {{ $registration->is_validated ? 'Validé' : 'En attente' }}
                                    </span>
                                </div>
                            </div>
                        @empty
                            <div class="px-6 py-8 text-center text-gray-500">
                                <svg class="w-12 h-12 mx-auto text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.75 9.75l4.5 4.5m0-4.5l-4.5 4.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <p class="mt-2 text-sm">Aucune inscription récente</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Sidebar widgets -->
            <div class="space-y-8">
                <!-- Alertes capacité -->
                <div class="dashboard-card bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold text-gray-900">Alertes capacité</h3>
                        <span class="px-3 py-1 text-sm font-medium rounded-full {{ count(data_get($widgets, 'capacity_alerts', [])) ? 'bg-red-100 text-red-800' : 'bg-gray-100 text-gray-600' }}">
                            {{ count(data_get($widgets, 'capacity_alerts', [])) }}
                        </span>
                    </div>
                    <div class="space-y-3">
                        @forelse(data_get($widgets, 'capacity_alerts', []) as $alert)
                            <div class="p-4 bg-red-50 border border-red-200 rounded-xl">
                                <div class="flex items-start gap-3">
                                    <div class="flex-shrink-0 p-1.5 bg-red-100 rounded-lg">
                                        <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 9v3.75m0 3.75h.007v.008H12z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                    </div>
                                    <div class="flex-1">
                                        <p class="text-sm font-semibold text-red-900">{{ $alert['event']->title }}</p>
                                        <p class="text-sm text-red-700 mt-1">{{ $alert['remaining'] }} place(s) restante(s)</p>
                                        <p class="text-xs text-red-600 mt-2">
                                            Début le {{ $alert['event']->start_date->isoFormat('D MMM YYYY à HH:mm') }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-4">
                                <div class="p-2 bg-green-50 rounded-lg inline-flex">
                                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                                <p class="mt-2 text-sm text-gray-600">Aucune alerte de capacité</p>
                            </div>
                        @endforelse
                    </div>
                </div>

                <!-- Taux d'occupation -->
                <div class="dashboard-card bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                    <div class="mb-4">
                        <h3 class="text-lg font-semibold text-gray-900">Taux d'occupation</h3>
                        <p class="text-sm text-gray-600 mt-1">Top événements en cours</p>
                    </div>
                    <div id="occupancy-chart" class="w-full"></div>
                    <div class="mt-4 space-y-3">
                        @forelse(data_get($widgets, 'occupancy_breakdown', []) as $item)
                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                <span class="text-sm font-medium text-gray-900 truncate flex-1 mr-2">
                                    {{ $item['event']->title }}
                                </span>
                                <span class="text-sm font-semibold text-indigo-600 whitespace-nowrap">
                                    {{ $item['occupancy'] }}%
                                </span>
                            </div>
                        @empty
                            <p class="text-sm text-gray-500 text-center py-4">Pas encore de données d'occupation</p>
                        @endforelse
                    </div>
                </div>

                <!-- Événements à venir -->
                <div class="dashboard-card bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold text-gray-900">Événements à venir</h3>
                        <a href="{{ route('events.index') }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-500 transition-colors">
                            Voir tout
                        </a>
                    </div>
                    <div class="space-y-4">
                        @forelse(data_get($widgets, 'upcoming_overview', []) as $upcoming)
                            <div class="flex items-start gap-4 p-3 hover:bg-gray-50 rounded-lg transition-colors">
                                <div class="flex-shrink-0 w-12 h-12 bg-gradient-to-br from-indigo-500 to-purple-600 text-white rounded-xl flex flex-col items-center justify-center font-bold">
                                    <span class="text-xs leading-3">{{ $upcoming['event']->start_date->isoFormat('DD') }}</span>
                                    <span class="text-[10px] leading-3 opacity-90">{{ $upcoming['event']->start_date->isoFormat('MMM') }}</span>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-semibold text-gray-900 truncate">{{ $upcoming['event']->title }}</p>
                                    <p class="text-xs text-gray-600 mt-1">{{ $upcoming['event']->start_date->isoFormat('HH:mm') }} • {{ $upcoming['registrations'] }} inscrit(s)</p>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-4">
                                <svg class="w-12 h-12 mx-auto text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                <p class="mt-2 text-sm text-gray-600">Aucun événement programmé</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        <!-- Section événements à venir détaillée -->
        <div class="mt-12">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-2xl font-bold text-gray-900">Vos prochains événements</h2>
                <a href="{{ route('events.index') }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-500 transition-colors">
                    Voir tout →
                </a>
            </div>
            <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-3">
                @forelse($upcomingEvents as $event)
                    <div class="dashboard-card bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                        <div class="p-6">
                            <div class="flex items-start justify-between mb-4">
                                <div class="flex-1">
                                    <h3 class="text-lg font-semibold text-gray-900 mb-2">
                                        <a href="{{ route('events.show', $event) }}" class="hover:text-indigo-600 transition-colors">
                                            {{ $event->title }}
                                        </a>
                                    </h3>
                                    <p class="text-sm text-gray-600 mb-3">
                                        {{ optional($event->start_date)->isoFormat('dddd D MMMM YYYY [à] HH:mm') ?? 'Date à confirmer' }}
                                    </p>
                                </div>
                            </div>

                            <div class="flex items-center justify-between mb-4">
                                <div class="flex items-center text-sm text-gray-600">
                                    <svg class="w-4 h-4 mr-1.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                    {{ $event->location }}
                                </div>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800">
                                    {{ $event->registrations_count }} inscrit(s)
                                </span>
                            </div>

                            <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                                <div class="flex -space-x-2">
                                    @foreach($event->attendees->take(4) as $attendee)
                                        <img class="w-8 h-8 rounded-full border-2 border-white bg-gray-300"
                                             src="https://ui-avatars.com/api/?name={{ urlencode($attendee->name) }}&color=7F9CF5&background=EBF4FF"
                                             alt="{{ $attendee->name }}"
                                             title="{{ $attendee->name }}">
                                    @endforeach
                                    @if($event->registrations_count > 4)
                                        <div class="w-8 h-8 rounded-full border-2 border-white bg-gray-100 flex items-center justify-center text-xs font-medium text-gray-600">
                                            +{{ $event->registrations_count - 4 }}
                                        </div>
                                    @endif
                                </div>
                                <a href="{{ route('events.attendees', $event) }}"
                                   class="text-sm font-medium text-indigo-600 hover:text-indigo-500 transition-colors">
                                    Voir la liste
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="md:col-span-2 xl:col-span-3">
                        <div class="text-center py-12">
                            <svg class="w-16 h-16 mx-auto text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            <h3 class="mt-4 text-lg font-medium text-gray-900">Aucun événement à venir</h3>
                            <p class="mt-2 text-gray-600">Commencez par créer votre premier événement</p>
                            <a href="{{ route('events.create') }}" class="mt-4 inline-flex items-center px-6 py-3 bg-indigo-600 text-white font-medium rounded-lg hover:bg-indigo-700 transition-colors">
                                Créer un événement
                            </a>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    (function () {
        function load(src, testFn, fallbackSrc) {
            return new Promise(function (resolve) {
                if (testFn()) return resolve();
                var s = document.createElement('script');
                s.src = src;
                s.onload = resolve;
                s.onerror = function () {
                    var lf = document.createElement('script');
                    lf.src = fallbackSrc;
                    lf.onload = resolve;
                    document.head.appendChild(lf);
                };
                document.head.appendChild(s);
            });
        }
        window.loadDashboardLibs = function () {
            return Promise.all([
                load('https://cdn.jsdelivr.net/npm/chart.js@4.4.6/dist/chart.umd.min.js', function(){ return !!window.Chart; }, '{{ asset('vendor/chart.js/chart.umd.min.js') }}'),
                load('https://cdn.jsdelivr.net/npm/apexcharts', function(){ return !!window.ApexCharts; }, '{{ asset('vendor/apexcharts/apexcharts.min.js') }}'),
            ]);
        };
    })();
</script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        window.loadDashboardLibs().then(function () {
            // Graphique des inscriptions hebdomadaires
            const weeklyCanvas = document.getElementById('weekly-registrations-chart');
            if (weeklyCanvas) {
                const weeklyLabels = @json(data_get($charts, 'weekly_registrations.labels', []));
                const weeklySeries = @json(data_get($charts, 'weekly_registrations.series', []));

                new Chart(weeklyCanvas, {
                    type: 'line',
                    data: {
                        labels: weeklyLabels,
                        datasets: [{
                            label: 'Inscriptions',
                            data: weeklySeries,
                            fill: true,
                            borderColor: '#4f46e5',
                            backgroundColor: 'rgba(79, 70, 229, 0.1)',
                            tension: 0.4,
                            pointBackgroundColor: '#4f46e5',
                            pointBorderColor: '#ffffff',
                            pointBorderWidth: 2,
                            pointRadius: 4,
                            pointHoverRadius: 6,
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: { display: false },
                            tooltip: {
                                backgroundColor: 'rgba(255, 255, 255, 0.95)',
                                titleColor: '#1f2937',
                                bodyColor: '#4b5563',
                                borderColor: '#e5e7eb',
                                borderWidth: 1,
                                callbacks: {
                                    label: (context) => `${context.parsed.y} inscription${context.parsed.y > 1 ? 's' : ''}`
                                }
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                grid: { color: 'rgba(0, 0, 0, 0.05)' },
                                ticks: { stepSize: 5 }
                            },
                            x: {
                                grid: { display: false }
                            }
                        }
                    }
                });
            }

            // Graphique radial d'occupation
            const occupancyContainer = document.querySelector('#occupancy-chart');
            if (occupancyContainer) {
                const occupancySeries = @json(data_get($charts, 'occupancy.series', []));
                const occupancyLabels = @json(data_get($charts, 'occupancy.labels', []));

                const apexOptions = {
                    chart: {
                        type: 'radialBar',
                        height: 300,
                        toolbar: { show: false },
                        fontFamily: 'Inter, sans-serif'
                    },
                    series: occupancySeries,
                    labels: occupancyLabels,
                    plotOptions: {
                        radialBar: {
                            track: { background: '#f3f4f6' },
                            dataLabels: {
                                name: {
                                    fontSize: '14px',
                                    fontWeight: '600',
                                    color: '#6b7280'
                                },
                                value: {
                                    fontSize: '20px',
                                    fontWeight: '700',
                                    color: '#1f2937',
                                    formatter: (val) => `${Math.round(val)}%`,
                                },
                                total: {
                                    show: true,
                                    label: 'Moyenne',
                                    color: '#6b7280',
                                    fontSize: '14px',
                                    formatter: () => {
                                        if (!occupancySeries.length) return '0%';
                                        const sum = occupancySeries.reduce((acc, value) => acc + value, 0);
                                        return `${Math.round(sum / occupancySeries.length)}%`;
                                    }
                                }
                            }
                        }
                    },
                    colors: ['#6366f1', '#22d3ee', '#f97316', '#f59e0b', '#10b981'],
                };

                const apexChart = new ApexCharts(occupancyContainer, apexOptions);
                apexChart.render();
            }

            // Graphique des ventes quotidiennes
            const salesCanvas = document.getElementById('daily-sales-chart');
            if (salesCanvas) {
                const salesLabels = @json(data_get($salesChart ?? [], 'labels', []));
                const salesSeriesMinor = @json(data_get($salesChart ?? [], 'series_minor', []));
                const salesSeriesMajor = salesSeriesMinor.map(v => (v || 0) / 100);
                const currencyFormatter = new Intl.NumberFormat('fr-FR', {
                    style: 'currency',
                    currency: 'XOF',
                    maximumFractionDigits: 0
                });

                new Chart(salesCanvas, {
                    type: 'bar',
                    data: {
                        labels: salesLabels,
                        datasets: [{
                            label: 'Ventes (par jour)',
                            data: salesSeriesMajor,
                            backgroundColor: 'rgba(16, 185, 129, 0.2)',
                            borderColor: '#10b981',
                            borderWidth: 2,
                            borderRadius: 8,
                            borderSkipped: false,
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            y: {
                                beginAtZero: true,
                                grid: { color: 'rgba(0, 0, 0, 0.05)' },
                                ticks: {
                                    callback: (value) => currencyFormatter.format(value),
                                }
                            },
                            x: {
                                grid: { display: false }
                            }
                        },
                        plugins: {
                            legend: { display: false },
                            tooltip: {
                                backgroundColor: 'rgba(255, 255, 255, 0.95)',
                                titleColor: '#1f2937',
                                bodyColor: '#4b5563',
                                borderColor: '#e5e7eb',
                                borderWidth: 1,
                                callbacks: {
                                    label: (ctx) => currencyFormatter.format(ctx.parsed.y)
                                }
                            }
                        }
                    }
                });
            }
        });
    });
</script>
@endpush
