@extends('layouts.app')

@section('title', 'Liste des participants - ' . $event->title)

@push('styles')
    <style>
        .dashboard-card {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .dashboard-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.15);
        }

        .registration-card {
            background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
            border: 1px solid #e2e8f0;
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

        .animate-fade-in {
            animation: fadeIn 0.5s ease-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
@endpush

@section('content')
    <div
        class="min-h-screen bg-gradient-to-br from-slate-50 via-white to-indigo-50/30 dark:from-neutral-950 dark:via-neutral-950 dark:to-indigo-950/10 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Live Alerts -->
            <div id="live-alerts" class="space-y-3 mb-6 hidden">
                <!-- Alerts injected by Echo -->
            </div>

            <div
                class="bg-white rounded-2xl shadow-xl border border-slate-100 overflow-hidden dark:bg-neutral-900 dark:border-neutral-800">
                <div class="p-6">
                    <!-- Header -->
                    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6 mb-8">
                        <div>
                            <h1
                                class="text-3xl font-bold bg-gradient-to-r from-slate-800 to-indigo-600 bg-clip-text text-transparent mb-2 dark:from-neutral-100 dark:to-indigo-300">
                                Participants - {{ $event->title }}
                            </h1>
                            <p class="text-lg text-slate-600 dark:text-neutral-400">Gestion des inscriptions et validation
                                des billets</p>
                        </div>
                        <div class="flex flex-wrap items-center gap-3">
                            <a href="{{ route('events.show', $event) }}"
                                class="inline-flex items-center px-4 py-3 bg-white border border-slate-200 text-slate-800 font-semibold rounded-xl shadow-lg hover:bg-slate-50 transition-all duration-200 dark:bg-neutral-900 dark:border-neutral-800 dark:text-neutral-300 dark:hover:bg-neutral-800">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                                </svg>
                                Retour
                            </a>
                            <a href="{{ route('scanner') }}"
                                class="inline-flex items-center px-4 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white font-semibold rounded-xl shadow-lg transition-all duration-200 transform hover:scale-105 group">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zM17 8h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z" />
                                </svg>
                                Scanner un billet
                            </a>
                            @php $qs = http_build_query($filters ?? []); @endphp
                            <a href="{{ route('events.attendees.export.csv', $event) }}{{ $qs ? '?' . $qs : '' }}"
                                class="inline-flex items-center px-4 py-3 bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-700 hover:to-teal-700 text-white font-semibold rounded-xl shadow-lg transition-all duration-200 transform hover:scale-105">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 16h8M8 12h8M8 8h8M4 6h16M4 18h16" />
                                </svg>
                                Export CSV
                            </a>
                            <a href="{{ route('events.attendees.export.pdf', $event) }}{{ $qs ? '?' . $qs : '' }}"
                                class="inline-flex items-center px-4 py-3 bg-gradient-to-r from-cyan-600 to-blue-600 hover:from-cyan-700 hover:to-blue-700 text-white font-semibold rounded-xl shadow-lg transition-all duration-200 transform hover:scale-105">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 6v6m0 0v6m0-6H6m6 0h6" />
                                </svg>
                                Export PDF
                            </a>
                        </div>
                    </div>

                    <!-- Filtres -->
                    <div class="mb-8">
                        <form method="GET" action="{{ route('events.attendees', $event) }}"
                            class="bg-white rounded-2xl border border-slate-200 p-6 shadow-lg overflow-x-auto overflow-hidden dark:bg-neutral-900 dark:border-neutral-800">
                            <div class="grid grid-cols-1 md:grid-cols-5 gap-4 items-end ">
                                <div>
                                    <label
                                        class="block text-sm font-medium text-slate-700 mb-2 dark:text-neutral-300">Statut
                                        paiement</label>
                                    <select name="status"
                                        class="w-full rounded-xl border-slate-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm dark:bg-neutral-900 dark:border-neutral-800 dark:text-neutral-100">
                                        <option value="">Tous</option>
                                        @foreach (['paid' => 'Payé', 'unpaid' => 'Non payé', 'pending' => 'En attente', 'failed' => 'Échec'] as $val => $label)
                                            <option value="{{ $val }}" @selected(($filters['status'] ?? '') === $val)>
                                                {{ $label }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <label
                                        class="block text-sm font-medium text-slate-700 mb-2 dark:text-neutral-300">Méthode</label>
                                    <select name="method"
                                        class="w-full rounded-xl border-slate-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm dark:bg-neutral-900 dark:border-neutral-800 dark:text-neutral-100">
                                        <option value="">Toutes</option>
                                        @foreach (['physical' => 'Physique', 'numeric' => 'En ligne', 'free' => 'Gratuit'] as $val => $label)
                                            <option value="{{ $val }}" @selected(($filters['method'] ?? '') === $val)>
                                                {{ $label }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <label
                                        class="block text-sm font-medium text-slate-700 mb-2 dark:text-neutral-300">Du</label>
                                    <input type="date" name="from" value="{{ $filters['from'] ?? '' }}"
                                        class="w-full rounded-xl border-slate-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm dark:bg-neutral-900 dark:border-neutral-800 dark:text-neutral-100" />

                                </div>
                                <div>
                                    <label
                                        class="block text-sm font-medium text-slate-700 mb-2 dark:text-neutral-300">Au</label>
                                    <input type="date" name="to" value="{{ $filters['to'] ?? '' }}"
                                        class="w-full rounded-xl border-slate-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm dark:bg-neutral-900 dark:border-neutral-800 dark:text-neutral-100" />
                                </div>
                                <div class="flex gap-3">
                                    <button type="submit"
                                        class="inline-flex items-center px-4 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-semibold rounded-xl hover:from-indigo-700 hover:to-purple-700 transition-all duration-200 shadow-lg hover:shadow-xl">Filtrer</button>
                                    <a href="{{ route('events.attendees', $event) }}"
                                        class="inline-flex items-center px-4 py-3 bg-white border border-slate-300 text-slate-700 font-semibold rounded-xl hover:bg-slate-50 transition-all duration-200 shadow-sm hover:shadow-md dark:bg-neutral-900 dark:border-neutral-800 dark:text-neutral-300 dark:hover:bg-neutral-800">Réinitialiser</a>
                                </div>
                            </div>
                        </form>
                    </div>

                    <!-- Statistiques compactes -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                        <div
                            class="dashboard-card bg-gradient-to-br from-blue-500 to-indigo-600 rounded-2xl p-6 shadow-xl text-white relative overflow-hidden">
                            <div
                                class="absolute top-0 right-0 w-24 h-24 bg-white/10 rounded-full -translate-y-12 translate-x-12">
                            </div>
                            <div class="relative z-10">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-sm font-medium text-blue-100 mb-1">Total des inscriptions</p>
                                        <p class="text-2xl font-bold">{{ $statistics['total'] }}</p>
                                    </div>
                                    <div class="p-3 bg-white/20 rounded-xl">
                                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div
                            class="dashboard-card bg-gradient-to-br from-emerald-500 to-green-500 rounded-2xl p-6 shadow-xl text-white relative overflow-hidden">
                            <div
                                class="absolute top-0 right-0 w-24 h-24 bg-white/10 rounded-full -translate-y-12 translate-x-12">
                            </div>
                            <div class="relative z-10">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-sm font-medium text-emerald-100 mb-1">Billets validés</p>
                                        <p class="text-2xl font-bold">{{ $statistics['validated'] }}</p>
                                    </div>
                                    <div class="p-3 bg-white/20 rounded-xl">
                                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div
                            class="dashboard-card bg-gradient-to-br from-cyan-500 to-blue-500 rounded-2xl p-6 shadow-xl text-white relative overflow-hidden">
                            <div
                                class="absolute top-0 right-0 w-24 h-24 bg-white/10 rounded-full -translate-y-12 translate-x-12">
                            </div>
                            <div class="relative z-10">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-sm font-medium text-cyan-100 mb-1">Places restantes</p>
                                        <p class="text-2xl font-bold">{{ $statistics['remaining'] }}</p>
                                    </div>
                                    <div class="p-3 bg-white/20 rounded-xl">
                                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" />
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Statistiques paiements / transferts -->
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                        <div
                            class="dashboard-card bg-gradient-to-br from-emerald-500 to-green-500 rounded-2xl p-6 shadow-xl text-white relative overflow-hidden">
                            <div
                                class="absolute top-0 right-0 w-20 h-20 bg-white/10 rounded-full -translate-y-10 translate-x-10">
                            </div>
                            <div class="relative z-10">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-sm font-medium text-emerald-100 mb-1">Tickets payés</p>
                                        <p class="text-2xl font-bold">{{ $statistics['paid_tickets'] }}</p>
                                    </div>
                                    <div class="p-3 bg-white/20 rounded-xl">
                                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M5 13l4 4L19 7" />
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div
                            class="dashboard-card bg-gradient-to-br from-amber-500 to-orange-500 rounded-2xl p-6 shadow-xl text-white relative overflow-hidden">
                            <div
                                class="absolute top-0 right-0 w-20 h-20 bg-white/10 rounded-full -translate-y-10 translate-x-10">
                            </div>
                            <div class="relative z-10">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-sm font-medium text-amber-100 mb-1">Tickets non payés</p>
                                        <p class="text-2xl font-bold">{{ $statistics['unpaid_tickets'] }}</p>
                                    </div>
                                    <div class="p-3 bg-white/20 rounded-xl">
                                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div
                            class="dashboard-card bg-gradient-to-br from-cyan-500 to-blue-500 rounded-2xl p-6 shadow-xl text-white relative overflow-hidden">
                            <div
                                class="absolute top-0 right-0 w-20 h-20 bg-white/10 rounded-full -translate-y-10 translate-x-10">
                            </div>
                            <div class="relative z-10">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-sm font-medium text-cyan-100 mb-1">Tickets transférés</p>
                                        <p class="text-2xl font-bold">{{ $statistics['transfers'] }}</p>
                                    </div>
                                    <div class="p-3 bg-white/20 rounded-xl">
                                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M17 8l4 4m0 0l-4 4m4-4H3" />
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div
                            class="dashboard-card bg-gradient-to-br from-rose-500 to-pink-500 rounded-2xl p-6 shadow-xl text-white relative overflow-hidden">
                            <div
                                class="absolute top-0 right-0 w-20 h-20 bg-white/10 rounded-full -translate-y-10 translate-x-10">
                            </div>
                            @php
                                $rev = (int) ($statistics['revenue_minor'] ?? 0);
                                $currency = $event->currency ?? 'XOF';
                            @endphp
                            <div class="relative z-10">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-sm font-medium text-rose-100 mb-1">Revenus générés</p>
                                        <p class="text-2xl font-bold">{{ \App\Support\Currency::format($rev, $currency) }}
                                        </p>
                                    </div>
                                    <div class="p-3 bg-white/20 rounded-xl">
                                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 8c-1.657 0-3 1.119-3 2.5S10.343 13 12 13s3 1.119 3 2.5S13.657 18 12 18m0-10V6m0 12v-2m8-4a8 8 0 11-16 0 8 8 0 0116 0z" />
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Liste des participants -->
                    <div
                        class="dashboard-card bg-white rounded-2xl shadow-xl border border-slate-100 overflow-hidden dark:bg-neutral-900 dark:border-neutral-800">
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-slate-200 dark:divide-neutral-800">
                                <thead class="bg-slate-50/80 dark:bg-neutral-900/80">
                                    <tr>
                                        <th scope="col"
                                            class="px-6 py-4 text-left text-xs font-semibold text-slate-700 uppercase tracking-wider dark:text-neutral-400">
                                            Participant</th>
                                        <th scope="col"
                                            class="px-6 py-4 text-left text-xs font-semibold text-slate-700 uppercase tracking-wider dark:text-neutral-400">
                                            Date d'inscription</th>
                                        <th scope="col"
                                            class="px-6 py-4 text-left text-xs font-semibold text-slate-700 uppercase tracking-wider dark:text-neutral-400">
                                            Statut paiement</th>
                                        <th scope="col"
                                            class="px-6 py-4 text-left text-xs font-semibold text-slate-700 uppercase tracking-wider dark:text-neutral-400">
                                            Validation</th>
                                        <th scope="col"
                                            class="px-6 py-4 text-right text-xs font-semibold text-slate-700 uppercase tracking-wider dark:text-neutral-400">
                                            Actions</th>
                                    </tr>
                                </thead>
                                <tbody
                                    class="bg-white divide-y divide-slate-200 dark:bg-neutral-900 dark:divide-neutral-800">
                                    @forelse($attendees as $registration)
                                        <tr
                                            class="hover:bg-slate-50/50 dark:hover:bg-neutral-800/50 transition-colors duration-150 {{ $registration->is_validated ? 'bg-emerald-50/30 dark:bg-emerald-500/10' : '' }}">
                                            <!-- Participant -->
                                            <td class="px-6 py-5 whitespace-nowrap">
                                                <div class="flex items-center">
                                                    <div
                                                        class="flex-shrink-0 h-12 w-12 bg-gradient-to-br from-indigo-100 to-purple-100 rounded-2xl flex items-center justify-center shadow-sm">
                                                        <span class="text-base font-bold text-indigo-600">
                                                            {{ substr($registration->user->name, 0, 1) }}
                                                        </span>
                                                    </div>
                                                    <div class="ml-4">
                                                        <div
                                                            class="text-base font-semibold text-slate-900 dark:text-neutral-100">
                                                            {{ $registration->user->name }}
                                                        </div>
                                                        <div class="text-sm text-slate-500 dark:text-neutral-400">
                                                            {{ $registration->user->email }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>

                                            <!-- Date d'inscription -->
                                            <td class="px-6 py-5 whitespace-nowrap">
                                                <div class="text-sm font-medium text-slate-900 dark:text-neutral-100">
                                                    {{ $registration->created_at->isoFormat('D MMM YYYY') }}
                                                </div>
                                                <div class="text-sm text-slate-500 dark:text-neutral-400">
                                                    {{ $registration->created_at->format('H:i') }}
                                                </div>
                                            </td>

                                            <!-- Statut paiement -->
                                            <td class="px-6 py-5 whitespace-nowrap">
                                                @php $ps = $registration->payment_status; @endphp
                                                @if ($ps === 'paid')
                                                    <span
                                                        class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-800 border border-emerald-200 shadow-sm">
                                                        <svg class="w-3 h-3 mr-1.5" fill="none" stroke="currentColor"
                                                            viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2" d="M5 13l4 4L19 7" />
                                                        </svg>
                                                        Payé
                                                    </span>
                                                @elseif($ps === 'unpaid')
                                                    <span
                                                        class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-semibold bg-amber-100 text-amber-800 border border-amber-200 shadow-sm">
                                                        <svg class="w-3 h-3 mr-1.5" fill="none" stroke="currentColor"
                                                            viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                                        </svg>
                                                        Non payé
                                                    </span>
                                                @elseif($ps === 'pending')
                                                    <span
                                                        class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-semibold bg-orange-100 text-orange-800 border border-orange-200 shadow-sm">
                                                        <svg class="w-3 h-3 mr-1.5" fill="none" stroke="currentColor"
                                                            viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                        </svg>
                                                        En attente
                                                    </span>
                                                @elseif($ps === 'failed')
                                                    <span
                                                        class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-semibold bg-red-100 text-red-800 border border-red-200 shadow-sm">
                                                        <svg class="w-3 h-3 mr-1.5" fill="none" stroke="currentColor"
                                                            viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                        </svg>
                                                        Échec
                                                    </span>
                                                @endif
                                            </td>

                                            <!-- Validation -->
                                            <td class="px-6 py-5 whitespace-nowrap">
                                                @if ($registration->is_validated)
                                                    <div class="flex items-center">
                                                        <span
                                                            class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-800 border border-emerald-200 shadow-sm">
                                                            <svg class="w-3 h-3 mr-1.5" fill="none"
                                                                stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2" d="M5 13l4 4L19 7" />
                                                            </svg>
                                                            Validé
                                                        </span>
                                                        @if ($registration->validated_at)
                                                            <span class="ml-3 text-xs text-slate-500">
                                                                {{ $registration->validated_at->diffForHumans() }}
                                                            </span>
                                                        @endif
                                                    </div>
                                                @else
                                                    <span
                                                        class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-semibold bg-slate-100 text-slate-800 border border-slate-200 shadow-sm dark:bg-neutral-900/60 dark:text-neutral-300 dark:border-neutral-800">
                                                        <svg class="w-3 h-3 mr-1.5" fill="none" stroke="currentColor"
                                                            viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                        </svg>
                                                        En attente
                                                    </span>
                                                @endif
                                            </td>

                                            <!-- Actions -->
                                            <td class="px-6 py-5 whitespace-nowrap text-right text-sm font-medium">
                                                <div class="flex items-center justify-end space-x-3">
                                                    @if (!$registration->is_validated)
                                                        <form
                                                            action="{{ route('registrations.validate', $registration) }}"
                                                            method="POST" class="inline">
                                                            @csrf
                                                            <button type="submit"
                                                                class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-semibold rounded-xl text-white bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                                                                <svg class="w-4 h-4 mr-1.5" fill="none"
                                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                                        stroke-width="2" d="M5 13l4 4L19 7" />
                                                                </svg>
                                                                Valider
                                                            </button>
                                                        </form>
                                                    @endif

                                                    @can('validate', $registration)
                                                        @if ($registration->payment_status === 'unpaid')
                                                            <form
                                                                action="{{ route('registrations.mark_paid', $registration) }}"
                                                                method="POST" class="inline">
                                                                @csrf
                                                                <button type="submit"
                                                                    class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-semibold rounded-xl text-white bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-700 hover:to-teal-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                                                                    <svg class="w-4 h-4 mr-1.5" fill="none"
                                                                        stroke="currentColor" viewBox="0 0 24 24">
                                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                                            stroke-width="2"
                                                                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1" />
                                                                    </svg>
                                                                    Marquer payé
                                                                </button>
                                                            </form>
                                                        @endif
                                                    @endcan
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="px-6 py-12 text-center">
                                                <div class="flex flex-col items-center">
                                                    <div
                                                        class="w-16 h-16 bg-slate-100 rounded-2xl flex items-center justify-center mb-4">
                                                        <svg class="w-8 h-8 text-slate-400" fill="none"
                                                            stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="1.5"
                                                                d="M9.75 9.75l4.5 4.5m0-4.5l-4.5 4.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                        </svg>
                                                    </div>
                                                    <p class="text-base font-semibold text-slate-700">Aucun participant
                                                        pour le moment</p>
                                                    <p class="text-sm text-slate-500 mt-1">Les participants apparaîtront
                                                        ici une fois inscrits</p>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Pagination -->
                    @if ($attendees->hasPages())
                        <div
                            class="mt-8 bg-white/50 backdrop-blur-sm rounded-xl p-6 border border-slate-100 dark:bg-neutral-900/80 dark:border-neutral-800">
                            {{ $attendees->links('vendor.pagination.tailwind') }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            if (!window.Echo) {
                return;
            }

            const alertsContainer = document.getElementById('live-alerts');

            const renderAlert = (payload) => {
                if (!alertsContainer) {
                    return;
                }

                const wrapper = document.createElement('div');
                wrapper.className =
                    'rounded-2xl border border-indigo-200 bg-gradient-to-r from-indigo-50 to-blue-50 px-6 py-4 shadow-xl flex items-start gap-4 animate-fade-in';
                wrapper.innerHTML = `
                <div class="mt-0.5 text-indigo-600">
                    <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div class="text-sm text-indigo-900">
                    <p class="font-bold text-base">Billet validé en temps réel</p>
                    <p class="mt-1">
                        <span class="font-semibold">${payload.attendee?.name ?? 'Participant inconnu'}</span>
                        vient d'être validé pour
                        <span class="font-semibold">${payload.event?.title ?? 'Événement'}</span>.
                    </p>
                    <p class="text-xs text-indigo-600 mt-2">
                        ${new Date(payload.validated_at ?? Date.now()).toLocaleString()}
                    </p>
                </div>
            `;

                alertsContainer.appendChild(wrapper);
                alertsContainer.classList.remove('hidden');

                setTimeout(() => {
                    wrapper.classList.add('opacity-0', 'transition', 'duration-500');
                    setTimeout(() => {
                        wrapper.remove();
                        if (!alertsContainer.children.length) {
                            alertsContainer.classList.add('hidden');
                        }
                    }, 500);
                }, 8000);
            };

            window.Echo
                .private('events.{{ $event->id }}')
                .listen('.ticket.validated', (event) => {
                    renderAlert(event);
                });
        });
    </script>

    <style>
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
    </style>
@endpush
