@extends('layouts.app')

@section('title', 'Tableau de bord - Étudiant')

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
            background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
            border: 1px solid #e2e8f0;
        }

        .stat-card {
            background: linear-gradient(135deg, #ffffff 0%, #fef7ff 100%);
        }

        .dark .event-card {
            background: linear-gradient(135deg, #0a0a0a 0%, #171717 100%);
            border-color: #262626;
        }

        .dark .stat-card {
            background: linear-gradient(135deg, #0a0a0a 0%, #171717 100%);
        }

        .pulse-dot {
            animation: pulse 2s infinite;
        }

        @keyframes pulse {

            0%,
            100% {
                opacity: 1;
            }

            50% {
                opacity: 0.5;
            }
        }

        .gradient-text {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        /* Dark neutral overrides */
        .dark .dashboard-card.bg-white {
            background: #0a0a0a;
            border-color: #262626;
        }

        .dark .dashboard-card .border-slate-100,
        .dark .dashboard-card .border-blue-100 {
            border-color: #262626;
        }

        .dark .dashboard-card .text-slate-900 {
            color: #e5e5e5;
        }

        .dark .dashboard-card .text-slate-700 {
            color: #d4d4d4;
        }

        .dark .dashboard-card .text-slate-600,
        .dark .dashboard-card .text-slate-400 {
            color: #a3a3a3;
        }

        .dark .dashboard-card .bg-slate-100 {
            background: #171717;
        }
    </style>
@endpush

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-slate-50 via-white to-blue-50/30">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <!-- En-tête principal -->
            <div class="mb-8">
                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
                    <div>
                        <h1 class="text-4xl font-bold mb-2">
                            Tableau de bord
                        </h1>
                        <p class="text-lg text-slate-600">Bienvenue, <span
                                class="font-semibold text-slate-800">{{ Auth::user()->name }}</span> 👋 Voici vos événements
                            et activités.</p>
                    </div>
                    <div class="flex flex-wrap items-center gap-3">
                        <a href="{{ route('events.index') }}"
                            class="inline-flex items-center px-6 py-4 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-semibold rounded-xl shadow-lg transition-all duration-200 transform hover:scale-105 group">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            Découvrir les événements
                        </a>
                    </div>
                </div>
            </div>

            <!-- Cartes de statistiques principales -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <!-- Prochains événements -->
                <div
                    class="dashboard-card bg-gradient-to-br from-blue-500 to-indigo-600 rounded-2xl p-6 shadow-xl text-white relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-24 h-24 bg-white/10 rounded-full -translate-y-12 translate-x-12">
                    </div>
                    <div class="relative z-10">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-blue-100">Événements à venir</p>
                                <p class="text-2xl font-bold mt-1">{{ $upcomingRegistrations->count() }}</p>
                            </div>
                            <div class="p-3 bg-white/20 rounded-xl">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Événements passés -->
                <div
                    class="dashboard-card bg-gradient-to-br from-emerald-500 to-green-500 rounded-2xl p-6 shadow-xl text-white relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-24 h-24 bg-white/10 rounded-full -translate-y-12 translate-x-12">
                    </div>
                    <div class="relative z-10">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-emerald-100">Événements passés</p>
                                <p class="text-2xl font-bold mt-1">{{ $pastRegistrations->count() }}</p>
                            </div>
                            <div class="p-3 bg-white/20 rounded-xl">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Billets totaux -->
                <div
                    class="dashboard-card bg-gradient-to-br from-purple-500 to-fuchsia-600 rounded-2xl p-6 shadow-xl text-white relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-24 h-24 bg-white/10 rounded-full -translate-y-12 translate-x-12">
                    </div>
                    <div class="relative z-10">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-purple-100">Billets totaux</p>
                                <p class="text-2xl font-bold mt-1">
                                    {{ $upcomingRegistrations->count() + $pastRegistrations->count() }}</p>
                            </div>
                            <div class="p-3 bg-white/20 rounded-xl">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 5v2m0 4v2m0 4v2m-8-10v2m0 4v2m0 4v2m8-14a2 2 0 012 2v14a2 2 0 01-2 2H7a2 2 0 01-2-2V5a2 2 0 012-2h10z" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Contenu principal -->
            <div class="grid grid-cols-1 xl:grid-cols-3 gap-8">
                <!-- Colonne principale -->
                <div class="xl:col-span-2 space-y-8">
                    <!-- Vos prochains événements -->
                    <div class="dashboard-card bg-white rounded-2xl shadow-lg border border-slate-100 overflow-hidden">
                        <div
                            class="flex items-center justify-between px-6 py-5 bg-gradient-to-r from-blue-50 to-indigo-50 border-b border-blue-100">
                            <div class="flex items-center space-x-3">
                                <div class="p-2 bg-blue-100 rounded-xl">
                                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-xl font-bold text-slate-900">Vos prochains événements</h3>
                                    <p class="text-sm text-blue-600 mt-1">Événements auxquels vous êtes inscrit</p>
                                </div>
                            </div>
                            <a href="{{ route('events.index') }}"
                                class="inline-flex items-center px-4 py-2 bg-white text-blue-600 font-semibold rounded-xl border border-blue-200 shadow-sm hover:shadow-md transition-all duration-200 hover:scale-105">
                                Voir tout
                            </a>
                        </div>

                        @if ($upcomingRegistrations->isNotEmpty())
                            <div class="p-6">
                                <div class="space-y-4">
                                    @foreach ($upcomingRegistrations as $registration)
                                        @php
                                            $eventDate =
                                                $registration->event->event_date ?? $registration->event->start_date;
                                        @endphp
                                        <div
                                            class="event-card rounded-xl p-4 shadow-sm hover:shadow-md transition-all duration-300 border border-slate-200 hover:border-blue-300 group">
                                            <div class="flex items-start space-x-4">
                                                <!-- Badge de date -->
                                                <div class="flex-shrink-0">
                                                    <div
                                                        class="w-16 h-16 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-2xl flex flex-col items-center justify-center text-white font-bold shadow-lg">
                                                        <span
                                                            class="text-lg leading-5">{{ $eventDate ? $eventDate->format('d') : '--' }}</span>
                                                        <span
                                                            class="text-xs leading-3 opacity-90">{{ $eventDate ? $eventDate->format('M') : '---' }}</span>
                                                    </div>
                                                </div>

                                                <!-- Contenu -->
                                                <div class="flex-1 min-w-0">
                                                    <div class="flex items-start justify-between mb-3">
                                                        <div class="flex-1 min-w-0">
                                                            <h4
                                                                class="text-sm font-bold text-slate-900 truncate mb-1 group-hover:text-blue-700 transition-colors">
                                                                <a href="{{ route('events.show', $registration->event) }}"
                                                                    class="hover:underline">
                                                                    {{ $registration->event->title }}
                                                                </a>
                                                            </h4>
                                                            <div class="flex items-center space-x-4 text-xs text-slate-600">
                                                                <div class="flex items-center">
                                                                    <svg class="w-3.5 h-3.5 mr-1.5 text-slate-400"
                                                                        fill="none" stroke="currentColor"
                                                                        viewBox="0 0 24 24">
                                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                                            stroke-width="2"
                                                                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                                                    </svg>
                                                                    <span
                                                                        class="truncate">{{ $registration->event->location }}</span>
                                                                </div>
                                                                <div class="flex items-center">
                                                                    <svg class="w-3.5 h-3.5 mr-1.5 text-slate-400"
                                                                        fill="none" stroke="currentColor"
                                                                        viewBox="0 0 24 24">
                                                                        <path stroke-linecap="round"
                                                                            stroke-linejoin="round" stroke-width="2"
                                                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                                    </svg>
                                                                    <span>{{ $eventDate ? $eventDate->format('H:i') : '--:--' }}</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <a href="{{ route('registrations.show', $registration->qr_code_data) }}"
                                                            class="opacity-0 group-hover:opacity-100 transition-all duration-300 p-2 text-slate-400 hover:text-green-600 hover:bg-green-50 rounded-lg">
                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                                viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M15 5v2m0 4v2m0 4v2m-8-10v2m0 4v2m0 4v2m8-14a2 2 0 012 2v14a2 2 0 01-2 2H7a2 2 0 01-2-2V5a2 2 0 012-2h10z" />
                                                            </svg>
                                                        </a>
                                                    </div>

                                                    <!-- Actions -->
                                                    <div class="flex items-center justify-between">
                                                        <div class="flex items-center space-x-3">
                                                            <a href="{{ route('registrations.show', $registration->qr_code_data) }}"
                                                                class="inline-flex items-center gap-2 px-3 py-1.5 bg-green-100 text-green-700 text-xs font-semibold rounded-lg hover:bg-green-200 transition-colors duration-200">
                                                                Voir le billet
                                                            </a>
                                                            @if ($eventDate && $eventDate->isFuture())
                                                                <span class="text-xs text-slate-500">
                                                                    {{ $eventDate->diffForHumans() }}
                                                                </span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @else
                            <!-- État vide -->
                            <div class="p-12 text-center">
                                <div
                                    class="w-20 h-20 mx-auto bg-slate-100 rounded-2xl flex items-center justify-center mb-4">
                                    <svg class="w-10 h-10 text-slate-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                <h4 class="text-lg font-semibold text-slate-700 mb-2">Aucun événement à venir</h4>
                                <p class="text-slate-500 text-sm mb-6">Parcourez les événements disponibles et
                                    inscrivez-vous pour commencer votre expérience.</p>
                                <a href="{{ route('events.index') }}"
                                    class="inline-flex items-center gap-2 px-6 py-3 bg-blue-600 text-white font-medium rounded-xl hover:bg-blue-700 transition-colors">
                                    Découvrir les événements
                                </a>
                            </div>
                        @endif
                    </div>

                    <!-- Événements recommandés -->
                    @if ($recommendedEvents->isNotEmpty())
                        <div class="dashboard-card bg-white rounded-2xl shadow-lg border border-slate-100 overflow-hidden">
                            <div
                                class="flex items-center justify-between px-6 py-5 bg-gradient-to-r from-purple-50 to-pink-50 border-b border-purple-100 dark:border-slate-50/10">
                                <div class="flex items-center space-x-3">
                                    <div class="p-2 bg-purple-100 rounded-xl">
                                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M11.48 3.499a.562.562 0 011.04 0l2.125 5.111a.563.563 0 00.475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 00-.182.557l1.285 5.385a.562.562 0 01-.84.61l-4.725-2.885a.563.563 0 00-.586 0L6.982 20.54a.562.562 0 01-.84-.61l1.285-5.386a.562.562 0 00-.182-.557l-4.204-3.602a.563.563 0 01.321-.988l5.518-.442a.563.563 0 00.475-.345L11.48 3.5z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="text-xl font-bold text-slate-900">Événements recommandés</h3>
                                        <p class="text-sm text-purple-600 mt-1">Découvrez des événements qui pourraient
                                            vous intéresser</p>
                                    </div>
                                </div>
                                <a href="{{ route('events.index') }}"
                                    class="inline-flex items-center px-4 py-2 bg-white text-purple-600 font-semibold rounded-xl border border-purple-200 shadow-sm hover:shadow-md transition-all duration-200 hover:scale-105">
                                    Voir tout
                                </a>
                            </div>

                            <div class="p-6">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    @foreach ($recommendedEvents as $event)
                                        <div
                                            class="event-card rounded-2xl p-4 shadow-sm hover:shadow-md transition-all duration-300 border border-slate-200 hover:border-purple-300 group">
                                            <!-- En-tête de l'événement -->
                                            <div class="flex items-start justify-between mb-4">
                                                <div class="flex-1 min-w-0">
                                                    <h4
                                                        class="text-sm font-bold text-slate-900 truncate mb-1 group-hover:text-purple-700 transition-colors">
                                                        {{ $event->title }}
                                                    </h4>
                                                    <div class="flex items-center space-x-3 text-xs text-slate-600">
                                                        <div class="flex items-center">
                                                            <svg class="w-3 h-3 mr-1" fill="none"
                                                                stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                                            </svg>
                                                            <span class="truncate">{{ $event->location }}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- Badge places -->
                                                <span
                                                    class="inline-flex items-center px-2 py-1 rounded-full text-xs font-semibold {{ $event->available_seats_calculated > 3 ? 'bg-green-100 text-green-700' : ($event->available_seats_calculated > 0 ? 'bg-amber-100 text-amber-700' : 'bg-red-100 text-red-700') }}">
                                                    {{ $event->available_seats_calculated ?? ($event->available_seats ?? 0) }}
                                                    place{{ ($event->available_seats_calculated ?? ($event->available_seats ?? 0)) > 1 ? 's' : '' }}
                                                </span>
                                            </div>

                                            <!-- Date et heure -->
                                            <div class="flex items-center text-xs text-slate-600 mb-4">
                                                <svg class="w-3 h-3 mr-1.5 text-slate-400" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                </svg>
                                                <span>
                                                    @if ($event->event_date)
                                                        {{ $event->event_date->format('d/m/Y H:i') }}
                                                    @else
                                                        Date à confirmer
                                                    @endif
                                                </span>
                                            </div>

                                            <!-- Actions -->
                                            <div class="space-y-3">
                                                <a href="{{ route('events.show', $event) }}"
                                                    class="w-full inline-flex items-center justify-center px-3 py-2 bg-blue-600 text-white text-sm font-semibold rounded-lg hover:bg-blue-700 transition-colors">
                                                    En savoir plus
                                                </a>

                                                @if (auth()->check() && auth()->user()->isStudent())
                                                    @if (($event->price ?? 0) > 0)
                                                        <a href="{{ route('events.show', $event) }}"
                                                            class="w-full inline-flex items-center justify-center gap-2 px-3 py-2 bg-gradient-to-r from-green-600 to-emerald-600 text-white text-sm font-semibold rounded-lg hover:shadow-md transition-all duration-200">
                                                            S'inscrire maintenant
                                                        </a>
                                                    @else
                                                        <form action="{{ route('events.register', $event) }}" method="POST"
                                                            class="space-y-3">
                                                            @csrf
                                                            <button type="submit"
                                                                class="w-full inline-flex items-center justify-center gap-2 px-3 py-2 bg-gradient-to-r from-green-600 to-emerald-600 text-white text-sm font-semibold rounded-lg hover:shadow-md transition-all duration-200">
                                                                S'inscrire maintenant
                                                            </button>
                                                        </form>
                                                    @endif
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Sidebar widgets -->
                <div class="space-y-8">
                    <!-- Actions rapides -->
                    <div class="dashboard-card bg-white rounded-2xl p-6 shadow-lg border border-slate-100">
                        <div class="mb-6">
                            <h3 class="text-xl font-bold text-slate-900 mb-1">Actions rapides</h3>
                            <p class="text-sm text-slate-600">Accédez rapidement aux fonctionnalités principales</p>
                        </div>

                        <div class="space-y-3">
                            <a href="{{ route('events.index') }}"
                                class="flex items-center gap-3 p-3 bg-blue-50 hover:bg-blue-100 rounded-xl transition-colors duration-200 group">
                                <div class="p-2 bg-blue-100 rounded-lg">
                                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 6h16M4 12h16m-7 6h7" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm font-semibold text-slate-900">Explorer les événements</p>
                                    <p class="text-xs text-slate-600">Découvrez de nouveaux événements</p>
                                </div>
                            </a>



                            @if ($upcomingRegistrations->isNotEmpty())
                                <a href="#"
                                    class="flex items-center gap-3 p-3 bg-green-50 hover:bg-green-100 rounded-xl transition-colors duration-200 group">
                                    <div class="p-2 bg-green-100 rounded-lg">
                                        <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-sm font-semibold text-slate-900">Mes billets</p>
                                        <p class="text-xs text-slate-600">{{ $upcomingRegistrations->count() }} billet(s)
                                            actif(s)</p>
                                    </div>
                                </a>
                            @endif
                        </div>
                    </div>

                    <!-- Statistiques de participation -->
                    <div
                        class="dashboard-card bg-gradient-to-br from-emerald-600 via-emerald-700 to-emerald-800 rounded-2xl p-6 shadow-2xl text-white relative overflow-hidden">
                        <!-- Optional decorative element -->
                        <div
                            class="absolute top-0 right-0 w-32 h-32 bg-white/5 rounded-full -translate-y-16 translate-x-8">
                        </div>

                        <div class="relative z-10">
                            <!-- Header Section -->
                            <div class="mb-8">
                                <div class="flex items-start justify-between mb-2">
                                    <div>
                                        <h3 class="text-2xl font-bold text-white mb-1">Votre activité</h3>
                                        <p class="text-emerald-100/80 text-sm font-medium">Résumé de votre participation
                                        </p>
                                    </div>
                                    <!-- Optional icon -->
                                    <div class="bg-white/10 p-2 rounded-lg">
                                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                                            </path>
                                        </svg>
                                    </div>
                                </div>
                            </div>

                            <!-- Stats Grid -->
                            <div class="grid grid-cols-1 gap-4 mb-8">
                                <!-- Past Events -->
                                <div
                                    class="bg-white/5 backdrop-blur-sm rounded-xl p-4 hover:bg-white/10 transition-all duration-200">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center space-x-3">
                                            <div class="bg-emerald-500/20 p-2 rounded-lg">
                                                <svg class="w-4 h-4 text-emerald-300" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                                                    </path>
                                                </svg>
                                            </div>
                                            <span class="text-emerald-100/90 text-sm font-medium">Événements passés</span>
                                        </div>
                                        <span
                                            class="text-2xl font-bold text-white">{{ $pastRegistrations->count() }}</span>
                                    </div>
                                </div>

                                <!-- Total Participation -->
                                <div
                                    class="bg-gradient-to-r from-emerald-500/20 to-emerald-600/20 backdrop-blur-sm rounded-xl p-4 border border-emerald-500/30">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center space-x-3">
                                            <div class="bg-white/20 p-2 rounded-lg">
                                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                                                    </path>
                                                </svg>
                                            </div>
                                            <span class="text-white text-sm font-semibold">Total de participations</span>
                                        </div>
                                        <span
                                            class="text-2xl font-bold text-white">{{ $upcomingRegistrations->count() + $pastRegistrations->count() }}</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Footer Section -->
                            <div class="pt-6 border-t border-white/10">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-emerald-100/70 text-xs font-medium uppercase tracking-wider mb-1">
                                            Membre depuis</p>
                                        <p class="text-white font-bold text-lg">
                                            {{ Auth::user()->created_at->format('M Y') }}</p>
                                    </div>
                                    <!-- Optional button/view all link -->
                                    <button
                                        class="text-sm font-medium text-white bg-white/10 hover:bg-white/20 px-4 py-2 rounded-lg transition-colors duration-200">
                                        Voir détails
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Animation des cartes
            const cards = document.querySelectorAll('.dashboard-card, .event-card');
            cards.forEach((card, index) => {
                card.style.opacity = '0';
                card.style.transform = 'translateY(20px)';

                setTimeout(() => {
                    card.style.transition = 'all 0.6s ease-out';
                    card.style.opacity = '1';
                    card.style.transform = 'translateY(0)';
                }, index * 100);
            });

            // Gestion des formulaires d'inscription
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
                Inscription...
            `;
                    submitButton.disabled = true;
                });
            });

            // Effets de survol interactifs
            const eventCards = document.querySelectorAll('.event-card');
            eventCards.forEach(card => {
                card.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateY(-4px)';
                });

                card.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateY(0)';
                });
            });
        });
    </script>
@endpush
