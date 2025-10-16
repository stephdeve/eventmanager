@extends('layouts.app')

@section('title', 'Tableau de bord - Organisateur')

@push('styles')
<style>
    /* Design System basé sur votre palette Indigo Royale */
    :root {
        --indigo-primary: #4F46E5;
        --indigo-light: #E0E7FF;
        --blue-dark: #1E3A8A;
        --gray-soft: #F9FAFB;
        --gray-neutral: #6B7280;
        --white: #FFFFFF;
    }

    .dashboard-gradient {
        background: linear-gradient(135deg, var(--gray-soft) 0%, var(--white) 50%, var(--indigo-light) 100%);
    }

    .glass-card {
        background: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.2);
        box-shadow:
            0 8px 32px rgba(79, 70, 229, 0.08),
            inset 0 1px 0 rgba(255, 255, 255, 0.6);
    }

    .stat-card {
        background: linear-gradient(135deg, var(--white) 0%, var(--gray-soft) 100%);
        border: 1px solid var(--indigo-light);
        border-radius: 20px;
        position: relative;
        overflow: hidden;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .stat-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 3px;
        background: linear-gradient(90deg, var(--indigo-primary), #6366F1);
        transform: scaleX(0);
        transition: transform 0.3s ease;
    }

    .stat-card:hover::before {
        transform: scaleX(1);
    }

    .stat-card:hover {
        transform: translateY(-8px);
        box-shadow:
            0 20px 40px rgba(79, 70, 229, 0.15),
            0 8px 16px rgba(79, 70, 229, 0.1);
    }

    .primary-action {
        background: linear-gradient(135deg, var(--indigo-primary) 0%, #6366F1 100%);
        color: var(--white);
        border-radius: 16px;
        position: relative;
        overflow: hidden;
        transition: all 0.3s ease;
    }

    .primary-action::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
        transition: left 0.5s ease;
    }

    .primary-action:hover::before {
        left: 100%;
    }

    .primary-action:hover {
        transform: translateY(-2px);
        box-shadow: 0 12px 30px rgba(79, 70, 229, 0.4);
    }

    .floating-element {
        animation: float 6s ease-in-out infinite;
    }

    @keyframes float {
        0%, 100% { transform: translateY(0px) rotate(0deg); }
        50% { transform: translateY(-10px) rotate(2deg); }
    }

    .pulse-glow {
        animation: pulse-glow 2s ease-in-out infinite alternate;
    }

    @keyframes pulse-glow {
        from { box-shadow: 0 0 20px rgba(79, 70, 229, 0.3); }
        to { box-shadow: 0 0 30px rgba(79, 70, 229, 0.5); }
    }

    .gradient-text {
        background: linear-gradient(135deg, var(--blue-dark) 0%, var(--indigo-primary) 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .avatar-group {
        display: flex;
    }

    .avatar {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        border: 2px solid var(--white);
        margin-left: -8px;
        background: linear-gradient(135deg, var(--indigo-primary), #6366F1);
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--white);
        font-size: 0.75rem;
        font-weight: 600;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .avatar:first-child {
        margin-left: 0;
    }

    .event-card {
        background: var(--white);
        border: 1px solid var(--indigo-light);
        border-radius: 16px;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .event-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, var(--indigo-primary), #6366F1);
        transform: scaleX(0);
        transition: transform 0.3s ease;
    }

    .event-card:hover::before {
        transform: scaleX(1);
    }

    .event-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 28px rgba(79, 70, 229, 0.15);
    }

    .alert-badge {
        animation: alert-pulse 2s infinite;
    }

    @keyframes alert-pulse {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.05); }
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .stat-card {
            margin-bottom: 1rem;
        }

        .glass-card {
            backdrop-filter: none;
            background: var(--white);
        }
    }

    /* Custom Scrollbar */
    ::-webkit-scrollbar {
        width: 6px;
    }

    ::-webkit-scrollbar-track {
        background: var(--gray-soft);
    }

    ::-webkit-scrollbar-thumb {
        background: var(--indigo-light);
        border-radius: 3px;
    }

    ::-webkit-scrollbar-thumb:hover {
        background: var(--indigo-primary);
    }
</style>
@endpush

@section('content')
<div class="min-h-screen dashboard-gradient">
    <!-- Header Navigation -->
    <div class="glass-card border-b">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col sm:flex-row justify-between items-center py-4 space-y-4 sm:space-y-0">
                <!-- Logo et Titre -->
                <div class="flex items-center space-x-4">
                    <div class="w-10 h-10 bg-gradient-to-br from-[#4F46E5] to-[#6366F1] rounded-xl flex items-center justify-center text-white font-bold shadow-lg">
                        EM
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold gradient-text">Tableau de bord</h1>
                        <p class="text-sm text-[#6B7280] hidden sm:block">Organisateur • {{ auth()->user()->name }}</p>
                    </div>
                </div>

                <!-- Actions -->
                <div class="flex items-center space-x-3">
                    <!-- Notification -->
                    <button class="relative p-3 rounded-xl bg-[#F9FAFB] text-[#6B7280] hover:bg-[#E0E7FF] hover:text-[#4F46E5] transition-all duration-200">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-5 5v-5zM10.24 8.56a5.97 5.97 0 01-4.66-7.4 1 1 0 00-.68-1.23A10.96 10.96 0 003.5 6.5a11 11 0 005.74 10.74 1 1 0 001.23-.68 5.97 5.97 0 01-1.23-7.98z"/>
                        </svg>
                        <span class="absolute top-2 right-2 w-2 h-2 bg-red-500 rounded-full"></span>
                    </button>

                    <!-- Nouvel événement -->
                    <a href="{{ route('events.create') }}" class="primary-action px-6 py-3 font-semibold text-sm uppercase tracking-widest flex items-center space-x-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                        </svg>
                        <span>Nouvel événement</span>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="space-y-8">
            <!-- Section Statistiques Principales -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Événements créés -->
                <div class="stat-card p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-[#6B7280]">Événements créés</p>
                            <p class="text-3xl font-bold text-[#1E3A8A] mt-2">{{ number_format(data_get($stats, 'total_events', 0)) }}</p>
                        </div>
                        <div class="p-3 rounded-xl bg-[#E0E7FF] text-[#4F46E5] floating-element">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </div>
                    </div>
                    <div class="mt-4 flex items-center text-sm text-green-600">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                        </svg>
                        +12% ce mois
                    </div>
                </div>

                <!-- Événements à venir -->
                <div class="stat-card p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-[#6B7280]">À venir</p>
                            <p class="text-3xl font-bold text-[#1E3A8A] mt-2">{{ number_format(data_get($stats, 'upcoming_events', 0)) }}</p>
                        </div>
                        <div class="p-3 rounded-xl bg-green-50 text-green-600 floating-element">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                            </svg>
                        </div>
                    </div>
                    <div class="mt-4 text-sm text-[#6B7280]">
                        Prochain: {{ optional($upcomingEvents->first())->start_date?->diffForHumans() ?? 'Aucun' }}
                    </div>
                </div>

                <!-- Total inscriptions -->
                <div class="stat-card p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-[#6B7280]">Inscriptions</p>
                            <p class="text-3xl font-bold text-[#1E3A8A] mt-2">{{ number_format(data_get($stats, 'total_registrations', 0)) }}</p>
                        </div>
                        <div class="p-3 rounded-xl bg-blue-50 text-blue-600 floating-element">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                            </svg>
                        </div>
                    </div>
                    <div class="mt-4 flex items-center text-sm text-green-600">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                        </svg>
                        +8% cette semaine
                    </div>
                </div>

                <!-- Scanner rapide -->
                <a href="{{ route('scanner') }}" class="primary-action p-6 flex flex-col justify-between">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-white/90">Scanner</p>
                            <p class="text-xl font-bold text-white mt-2">Billets QR</p>
                        </div>
                        <div class="p-3 rounded-xl bg-white/20 text-white floating-element">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/>
                            </svg>
                        </div>
                    </div>
                    <div class="mt-4 flex items-center text-sm text-white/80">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                        </svg>
                        Ouvrir le scanner
                    </div>
                </a>
            </div>

            <!-- Grille Principale -->
            <div class="grid grid-cols-1 xl:grid-cols-3 gap-8">
                <!-- Colonne Principale -->
                <div class="xl:col-span-2 space-y-8">
                    <!-- Graphique des inscriptions -->
                    <div class="glass-card rounded-2xl p-6">
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between mb-6 space-y-4 sm:space-y-0">
                            <div>
                                <h2 class="text-xl font-semibold text-[#1E3A8A]">Évolution des inscriptions</h2>
                                <p class="text-sm text-[#6B7280]">Performance sur les 7 derniers jours</p>
                            </div>
                            @php
                                $growth = data_get($charts, 'weekly_registrations.growth_percentage', 0);
                            @endphp
                            <div class="flex items-center space-x-2">
                                <span class="text-sm text-[#6B7280]">Tendance:</span>
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold {{ $growth >= 0 ? 'bg-green-50 text-green-700' : 'bg-red-50 text-red-700' }}">
                                    {{ $growth >= 0 ? '+' : '' }}{{ $growth }}%
                                </span>
                            </div>
                        </div>
                        <div class="h-80">
                            <canvas id="weekly-registrations-chart"></canvas>
                        </div>
                    </div>

                    <!-- Dernières inscriptions -->
                    <div class="glass-card rounded-2xl overflow-hidden">
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between px-6 py-4 border-b border-[#E0E7FF] space-y-2 sm:space-y-0">
                            <h2 class="text-xl font-semibold text-[#1E3A8A]">Inscriptions récentes</h2>
                            <a href="{{ route('events.index') }}" class="text-sm font-medium text-[#4F46E5] hover:text-[#3730A3] transition-colors flex items-center">
                                Voir tout
                                <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </a>
                        </div>
                        <div class="divide-y divide-[#E0E7FF]">
                            @forelse(data_get($stats, 'recent_registrations', []) as $registration)
                                <div class="px-6 py-4 hover:bg-[#F9FAFB] transition-colors">
                                    <div class="flex flex-col sm:flex-row sm:items-center justify-between space-y-3 sm:space-y-0">
                                        <div class="flex items-center space-x-4">
                                            <div class="w-12 h-12 bg-gradient-to-br from-[#4F46E5] to-[#6366F1] rounded-xl flex items-center justify-center text-white font-semibold text-sm shadow-lg">
                                                {{ substr($registration->user->name, 0, 2) }}
                                            </div>
                                            <div>
                                                <p class="font-semibold text-[#1E3A8A]">{{ $registration->user->name }}</p>
                                                <p class="text-sm text-[#6B7280]">{{ $registration->event->title }}</p>
                                            </div>
                                        </div>
                                        <div class="flex items-center space-x-4">
                                            <span class="text-sm text-[#6B7280]">{{ $registration->created_at->diffForHumans() }}</span>
                                            <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $registration->is_validated ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                                {{ $registration->is_validated ? '✓ Validé' : 'En attente' }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="px-6 py-12 text-center text-[#6B7280]">
                                    <svg class="w-16 h-16 mx-auto text-[#E0E7FF]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                    <p class="mt-4 text-lg font-medium">Aucune inscription récente</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- Sidebar Widgets -->
                <div class="space-y-8">
                    <!-- Alertes capacité -->
                    <div class="glass-card rounded-2xl p-6">
                        <div class="flex items-center justify-between mb-6">
                            <h2 class="text-xl font-semibold text-[#1E3A8A]">Alertes capacité</h2>
                            <span class="text-xs font-semibold px-3 py-1 rounded-full {{ count(data_get($widgets, 'capacity_alerts', [])) ? 'bg-red-50 text-red-600 alert-badge' : 'bg-[#F9FAFB] text-[#6B7280]' }}">
                                {{ count(data_get($widgets, 'capacity_alerts', [])) }}
                            </span>
                        </div>
                        <div class="space-y-4">
                            @forelse(data_get($widgets, 'capacity_alerts', []) as $alert)
                                <div class="p-4 bg-red-50 border border-red-200 rounded-xl">
                                    <div class="flex items-start space-x-3">
                                        <div class="flex-shrink-0 w-3 h-3 bg-red-500 rounded-full mt-1.5"></div>
                                        <div class="flex-1 min-w-0">
                                            <p class="text-sm font-semibold text-red-900 truncate">{{ $alert['event']->title }}</p>
                                            <p class="text-sm text-red-700 mt-1">{{ $alert['remaining'] }} place(s) restante(s)</p>
                                            <p class="text-xs text-red-600 mt-2">{{ $alert['event']->start_date->isoFormat('D MMM à HH:mm') }}</p>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <p class="text-sm text-[#6B7280] text-center py-4">Aucune alerte de capacité</p>
                            @endforelse
                        </div>
                    </div>

                    <!-- Taux d'occupation -->
                    <div class="glass-card rounded-2xl p-6">
                        <div class="flex items-center justify-between mb-6">
                            <h2 class="text-xl font-semibold text-[#1E3A8A]">Taux d'occupation</h2>
                            <p class="text-sm text-[#6B7280]">Top événements</p>
                        </div>
                        <div id="occupancy-chart" class="w-full"></div>
                        <div class="mt-6 space-y-3">
                            @forelse(data_get($widgets, 'occupancy_breakdown', []) as $item)
                                <div class="flex items-center justify-between text-sm">
                                    <span class="font-medium text-[#1E3A8A] truncate">{{ $item['event']->title }}</span>
                                    <span class="text-[#4F46E5] font-semibold">{{ $item['occupancy'] }}%</span>
                                </div>
                            @empty
                                <p class="text-sm text-[#6B7280] text-center py-2">Pas de données d'occupation</p>
                            @endforelse
                        </div>
                    </div>

                    <!-- Événements à venir -->
                    <div class="glass-card rounded-2xl p-6">
                        <div class="flex items-center justify-between mb-6">
                            <h2 class="text-xl font-semibold text-[#1E3A8A]">À venir cette semaine</h2>
                            <a href="{{ route('events.index') }}" class="text-sm text-[#4F46E5] hover:text-[#3730A3] transition-colors">
                                Calendrier
                            </a>
                        </div>
                        <div class="space-y-4">
                            @forelse(data_get($widgets, 'upcoming_overview', []) as $upcoming)
                                <div class="flex items-start space-x-4 p-3 rounded-xl hover:bg-[#F9FAFB] transition-colors">
                                    <div class="flex-shrink-0 w-14 h-14 bg-gradient-to-br from-[#4F46E5] to-[#6366F1] text-white rounded-xl flex flex-col items-center justify-center font-bold shadow-lg">
                                        <span class="text-xs leading-3">{{ $upcoming['event']->start_date->isoFormat('MMM') }}</span>
                                        <span class="text-lg leading-5">{{ $upcoming['event']->start_date->isoFormat('DD') }}</span>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="font-semibold text-[#1E3A8A] truncate">{{ $upcoming['event']->title }}</p>
                                        <p class="text-sm text-[#6B7280]">{{ $upcoming['event']->start_date->isoFormat('HH:mm') }}</p>
                                        <p class="text-xs text-[#4F46E5] mt-1 font-semibold">{{ $upcoming['registrations'] }} inscrit(s)</p>
                                    </div>
                                </div>
                            @empty
                                <p class="text-sm text-[#6B7280] text-center py-4">Aucun événement cette semaine</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

            <!-- Prochains Événements Détail -->
            <div class="glass-card rounded-2xl p-8">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between mb-8 space-y-4 sm:space-y-0">
                    <h2 class="text-2xl font-bold gradient-text">Vos prochains événements</h2>
                    <a href="{{ route('events.index') }}" class="text-sm font-medium text-[#4F46E5] hover:text-[#3730A3] transition-colors flex items-center">
                        Voir tout
                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
                    @forelse($upcomingEvents as $event)
                        <div class="event-card p-6">
                            <div class="flex items-start justify-between mb-4">
                                <div class="flex-1">
                                    <h3 class="font-bold text-[#1E3A8A] text-lg mb-2">
                                        <a href="{{ route('events.show', $event) }}" class="hover:text-[#4F46E5] transition-colors">{{ $event->title }}</a>
                                    </h3>
                                    <p class="text-sm text-[#6B7280]">{{ $event->start_date->isoFormat('dddd D MMMM YYYY à HH:mm') }}</p>
                                </div>
                                <div class="flex-shrink-0 ml-4">
                                    <div class="w-14 h-14 bg-gradient-to-br from-[#4F46E5] to-[#6366F1] rounded-xl flex items-center justify-center text-white font-bold text-lg shadow-lg">
                                        {{ $event->start_date->isoFormat('DD') }}
                                    </div>
                                </div>
                            </div>

                            <div class="flex items-center space-x-2 mb-4">
                                <svg class="w-4 h-4 text-[#6B7280]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                                <span class="text-sm text-[#6B7280]">{{ $event->location }}</span>
                            </div>

                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-3">
                                    <div class="avatar-group">
                                        @foreach($event->attendees->take(3) as $attendee)
                                            <div class="avatar" title="{{ $attendee->name }}">
                                                {{ substr($attendee->name, 0, 1) }}
                                            </div>
                                        @endforeach
                                        @if($event->registrations_count > 3)
                                            <div class="avatar bg-[#F9FAFB] text-[#6B7280] border-[#E0E7FF]">
                                                +{{ $event->registrations_count - 3 }}
                                            </div>
                                        @endif
                                    </div>
                                    <span class="text-sm text-[#6B7280]">{{ $event->registrations_count }} inscrit(s)</span>
                                </div>
                                <a href="{{ route('events.attendees', $event) }}" class="text-[#4F46E5] hover:text-[#3730A3] text-sm font-semibold transition-colors">
                                    Gérer
                                </a>
                            </div>
                        </div>
                    @empty
                        <div class="md:col-span-2 xl:col-span-3 py-12 text-center text-[#6B7280]">
                            <svg class="w-20 h-20 mx-auto text-[#E0E7FF]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            <p class="mt-4 text-xl font-semibold">Aucun événement à venir</p>
                            <p class="mt-2">Créez votre premier événement pour commencer</p>
                            <a href="{{ route('events.create') }}" class="primary-action inline-flex items-center px-8 py-4 mt-6 font-semibold">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                </svg>
                                Créer un événement
                            </a>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.6/dist/chart.umd.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Graphique des inscriptions
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
                        borderColor: '#4F46E5',
                        backgroundColor: 'rgba(79, 70, 229, 0.1)',
                        tension: 0.4,
                        pointBackgroundColor: '#4F46E5',
                        pointBorderColor: '#FFFFFF',
                        pointBorderWidth: 2,
                        pointRadius: 6,
                        pointHoverRadius: 8,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: 'rgba(255, 255, 255, 0.95)',
                            titleColor: '#1E3A8A',
                            bodyColor: '#6B7280',
                            borderColor: '#E0E7FF',
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

        // Graphique d'occupation
        const occupancyContainer = document.querySelector('#occupancy-chart');
        if (occupancyContainer) {
            const occupancySeries = @json(data_get($charts, 'occupancy.series', []));
            const occupancyLabels = @json(data_get($charts, 'occupancy.labels', []));

            const apexOptions = {
                chart: {
                    type: 'radialBar',
                    height: 300,
                    toolbar: { show: false },
                },
                series: occupancySeries,
                labels: occupancyLabels,
                plotOptions: {
                    radialBar: {
                        track: { background: '#E0E7FF' },
                        dataLabels: {
                            name: {
                                fontSize: '14px',
                                color: '#6B7280'
                            },
                            value: {
                                fontSize: '18px',
                                color: '#1E3A8A',
                                fontWeight: 'bold',
                                formatter: (val) => `${Math.round(val)}%`,
                            }
                        }
                    }
                },
                colors: ['#4F46E5', '#6366F1', '#818CF8', '#A5B4FC'],
            };

            const apexChart = new ApexCharts(occupancyContainer, apexOptions);
            apexChart.render();
        }
    });
</script>
@endpush
