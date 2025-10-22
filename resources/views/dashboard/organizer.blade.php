@extends('layouts.app')

@section('title', 'Tableau de bord - Organisateur')

@push('styles')
    <style>
        .dashboard-card {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .dashboard-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.15);
        }

        .chart-container {
            position: relative;
            height: 16rem;
        }

        .occupancy-card {
            background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
            border: 1px solid #e2e8f0;
        }

        .registration-card {
            background: linear-gradient(135deg, #ffffff 0%, #fdf4ff 100%);
            border: 1px solid #f3e8ff;
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
    </style>
@endpush

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-slate-50 via-white to-indigo-50/30">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <!-- En-tête avec bannière d'abonnement -->
            @php
                $user = auth()->user();
                $active = method_exists($user, 'hasActiveSubscription') ? $user->hasActiveSubscription() : false;
                $expiresAt = $user->subscription_expires_at;
                $expired = $expiresAt ? $expiresAt->isPast() : false;
            @endphp

            @if (!$active)
                <div
                    class="mb-8 rounded-2xl bg-gradient-to-r from-amber-50 to-orange-50 border border-amber-200 p-6 shadow-lg">
                    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                        <div class="flex items-start gap-4 flex-1">
                            <div class="flex-shrink-0 p-3 bg-amber-100 rounded-xl">
                                <svg class="w-6 h-6 text-amber-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M12 9v3m0 4h.01M10.29 3.86l-7.4 12.84A1.5 1.5 0 004.2 19.5h15.6a1.5 1.5 0 001.3-2.3L13.7 3.86a1.5 1.5 0 00-2.6 0z" />
                                </svg>
                            </div>
                            <div class="flex-1">
                                <h3 class="text-lg font-bold text-amber-900">Abonnement expiré ou inactif</h3>
                                <p class="mt-1 text-sm text-amber-800">
                                    @if ($expired)
                                        Expiré le {{ $expiresAt->translatedFormat('d M Y à H\\hi') }}.
                                    @endif
                                    Offre actuelle: {{ ucfirst($user->subscription_plan ?? '—') }}. Le renouvellement
                                    réactivera toutes vos fonctionnalités.
                                </p>
                            </div>
                        </div>
                        <a href="{{ route('subscriptions.plans') }}"
                            class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-amber-600 to-orange-600 hover:from-amber-700 hover:to-orange-700 text-white font-semibold rounded-xl shadow-lg transition-all duration-200 transform hover:scale-105">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 10V3L4 14h7v7l9-11h-7z" />
                            </svg>
                            Renouveler maintenant
                        </a>
                    </div>
                </div>
            @endif

            <!-- En-tête principal -->
            <div class="mb-8">
                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
                    <div>
                        <h1
                            class="text-4xl font-bold bg-gradient-to-r from-slate-800 to-indigo-600 bg-clip-text text-transparent mb-2">
                            Tableau de bord
                        </h1>
                        <p class="text-lg text-slate-600">Bienvenue, <span
                                class="font-semibold text-slate-800">{{ $user->name }}</span> 👋 Voici l'aperçu de vos
                            activités.</p>
                    </div>
                    <div class="flex flex-wrap items-center gap-3">
                        <a href="{{ route('events.create') }}"
                            class="inline-flex items-center px-6 py-4 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white font-semibold rounded-xl shadow-lg transition-all duration-200 transform hover:scale-105 group">
                            <svg class="w-5 h-5 mr-2 group-hover:rotate-90 transition-transform" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                            Nouvel événement
                        </a>
                        <a href="{{ route('events.index', ['interactive' => 1]) }}"
                            class="inline-flex items-center px-6 py-4 bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-700 hover:to-teal-700 text-white font-semibold rounded-xl shadow-lg transition-all duration-200 transform hover:scale-105">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            Expériences interactives
                        </a>
                        @if (auth()->user()->isAdmin())
                            <a href="{{ route('interactive.settings') }}"
                                class="inline-flex items-center px-6 py-4 bg-white border border-slate-200 text-slate-800 font-semibold rounded-xl shadow-lg hover:bg-slate-50 transition-all duration-200">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Paramètres interactifs
                            </a>
                        @endif
                    </div>
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
                <div
                    class="dashboard-card bg-gradient-to-br from-emerald-500 to-green-500 rounded-2xl p-6 shadow-xl text-white relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-24 h-24 bg-white/10 rounded-full -translate-y-12 translate-x-12">
                    </div>
                    <div class="relative z-10">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-emerald-100">Revenus totaux</p>
                                <p class="text-2xl font-bold mt-1">{{ $totalRevenueFormatted }}</p>
                            </div>
                            <div class="p-3 bg-white/20 rounded-xl">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8c-1.657 0-3 1.119-3 2.5S10.343 13 12 13s3 1.119 3 2.5S13.657 18 12 18m0-10V6m0 12v-2m8-4a8 8 0 11-16 0 8 8 0 0116 0z" />
                                </svg>
                            </div>
                        </div>
                        <div class="mt-4 pt-4 border-t border-white/20">
                            <div class="flex items-center text-sm text-emerald-100">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                                </svg>
                                Tendance positive
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tickets vendus -->
                <div
                    class="dashboard-card bg-gradient-to-br from-purple-500 to-fuchsia-600 rounded-2xl p-6 shadow-xl text-white relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-24 h-24 bg-white/10 rounded-full -translate-y-12 translate-x-12">
                    </div>
                    <div class="relative z-10">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-purple-100">Tickets vendus</p>
                                <p class="text-2xl font-bold mt-1">{{ number_format($totalTicketsSold) }}</p>
                            </div>
                            <div class="p-3 bg-white/20 rounded-xl">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 10h18M7 15h10M5 20h14M9 5h6" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Événements créés -->
                <div
                    class="dashboard-card bg-gradient-to-br from-blue-500 to-indigo-600 rounded-2xl p-6 shadow-xl text-white relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-24 h-24 bg-white/10 rounded-full -translate-y-12 translate-x-12">
                    </div>
                    <div class="relative z-10">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-blue-100">Événements créés</p>
                                <p class="text-2xl font-bold mt-1">{{ number_format(data_get($stats, 'total_events', 0)) }}
                                </p>
                            </div>
                            <div class="p-3 bg-white/20 rounded-xl">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>



                <!-- Scanner rapide -->
                <a href="{{ route('scanner') }}"
                    class="dashboard-card bg-gradient-to-br from-indigo-600 to-purple-600 rounded-2xl p-6 shadow-xl text-white hover:from-indigo-700 hover:to-purple-700 transition-all duration-200 relative overflow-hidden group">
                    <div
                        class="absolute inset-0 bg-white/5 opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                    </div>
                    <div class="relative z-10">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-indigo-100">Scanner un billet</p>
                                <p class="text-2xl font-bold mt-1">Ouvrir</p>
                            </div>
                            <div class="p-3 bg-white/20 rounded-xl group-hover:bg-white/30 transition-colors duration-200">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z" />
                                </svg>
                            </div>
                        </div>
                        <div
                            class="mt-4 flex items-center text-indigo-100 text-sm group-hover:text-white transition-colors duration-200">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 7l5 5m0 0l-5 5m5-5H6" />
                            </svg>
                            Accès rapide au scanner
                        </div>
                    </div>
                </a>
            </div>
            <!-- Billetterie: synthèse tickets -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="dashboard-card bg-white rounded-2xl p-6 shadow-lg border border-slate-100">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-slate-600">Tickets payés</p>
                            <p class="text-2xl font-bold text-slate-900 mt-1">
                                {{ number_format((int) data_get($financeTotals, 'total_paid_tickets', 0)) }}</p>
                        </div>
                        <div class="p-3 bg-emerald-50 rounded-xl">
                            <svg class="w-8 h-8 text-emerald-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                        </div>
                    </div>
                </div>
                <div class="dashboard-card bg-white rounded-2xl p-6 shadow-lg border border-slate-100">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-slate-600">Tickets non payés</p>
                            <p class="text-2xl font-bold text-slate-900 mt-1">
                                {{ number_format((int) data_get($financeTotals, 'total_unpaid_tickets', 0)) }}</p>
                        </div>
                        <div class="p-3 bg-amber-50 rounded-xl">
                            <svg class="w-8 h-8 text-amber-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                </div>
                <div class="dashboard-card bg-white rounded-2xl p-6 shadow-lg border border-slate-100">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-slate-600">Tickets transférés</p>
                            <p class="text-2xl font-bold text-slate-900 mt-1">
                                {{ number_format((int) data_get($financeTotals, 'total_ticket_transfers', 0)) }}</p>
                        </div>
                        <div class="p-3 bg-cyan-50 rounded-xl">
                            <svg class="w-8 h-8 text-cyan-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 8l4 4m0 0l-4 4m4-4H3" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Graphiques et contenu principal -->
            <div class="grid grid-cols-1 xl:grid-cols-3 gap-8">
                <!-- Colonne principale -->
                <div class="xl:col-span-2 space-y-8">
                    <!-- Graphique évolution des inscriptions -->
                    <div class="dashboard-card bg-white rounded-2xl p-6 shadow-2xl border border-slate-100">
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6">
                            <div>
                                <h3 class="text-xl font-bold text-slate-900">Évolution des inscriptions</h3>
                                <p class="text-sm text-slate-600 mt-1">Tendance sur les 7 derniers jours</p>
                            </div>
                            @php
                                $growth = data_get($charts, 'weekly_registrations.growth_percentage', 0);
                            @endphp
                            <div
                                class="mt-2 sm:mt-0 inline-flex items-center px-3 py-1.5 rounded-full text-sm font-medium {{ $growth >= 0 ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : 'bg-red-50 text-red-700 border border-red-200' }}">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    @if ($growth >= 0)
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                                    @else
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6" />
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
                    <div
                        class="dashboard-card bg-gradient-to-br from-green-600 to-green-800 rounded-2xl p-6 shadow-xl text-white relative overflow-hidden">
                        <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full blur-2xl"></div>
                        <div class="relative z-10">
                            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6">
                                <div>
                                    <h3 class="text-xl font-bold text-white mb-2">Ventes quotidiennes</h3>
                                    <p class="text-indigo-100 text-sm">Performance des ventes sur 14 jours</p>
                                </div>
                                <div class="mt-3 sm:mt-0">
                                    <div
                                        class="inline-flex items-center px-3 py-1.5 rounded-full bg-white/20 text-white text-sm font-medium border border-white/30">
                                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                                        </svg>
                                        +{{ data_get($salesChart ?? [], 'growth_percentage', 0) }}% vs période précédente
                                    </div>
                                </div>
                            </div>
                            <div class="chart-container">
                                <canvas id="daily-sales-chart"></canvas>
                            </div>
                        </div>
                    </div>

                    <!-- Finances par événement -->
                    <div class="mt-12 ">
                        <div class="dashboard-card bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                            <div class="relative bg-gradient-to-r  from-purple-600 to-fuchsia-500 px-6 py-5 overflow-hidden">
                            <div
                                class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full -translate-y-16 translate-x-16">
                            </div>
                            <div
                                class="absolute bottom-0 left-0 w-24 h-24 bg-white/5 rounded-full translate-y-12 -translate-x-12">
                            </div>

                            <div class="relative z-10 flex items-center justify-between">
                                <div class="flex items-center space-x-3">
                                    <div class="p-2 bg-white/20 rounded-xl backdrop-blur-sm">
                                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8c-1.657 0-3 1.119-3 2.5S10.343 13 12 13s3 1.119 3 2.5S13.657 18 12 18m0-10V6m0 12v-2m8-4a8 8 0 11-16 0 8 8 0 0116 0z" />
                                </svg>
                                    </div>
                                    <div>
                                        <h2 class="text-2xl font-bold text-white">Finances par événement</h2>
                                        <p class="text-indigo-100 text-sm mt-1">Vues globales de vos finances par chaque  événement</p>
                                    </div>
                                </div>

                            </div>
                        </div>
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50/80">
                                        <tr>
                                            <th
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Événement</th>
                                            <th
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Ventes (tickets)</th>
                                            <th
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Tickets payés</th>
                                            <th
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Tickets non payés</th>
                                            <th
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Transferts</th>
                                            <th
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Revenus</th>
                                            <th class="px-6 py-3"></th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @forelse(($perEventFinance ?? []) as $row)
                                            <tr class="hover:bg-gray-50/50 transition-colors">
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div class="text-sm font-semibold text-gray-900">
                                                        {{ $row['event']->title }}</div>
                                                    <div class="text-xs text-gray-500">
                                                        {{ optional($row['event']->start_date)?->isoFormat('D MMM YYYY • HH:mm') }}
                                                    </div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                    {{ number_format($row['tickets_sold']) }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-emerald-700">
                                                    {{ number_format($row['paid_tickets']) }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-amber-700">
                                                    {{ number_format($row['unpaid_tickets']) }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-cyan-700">
                                                    {{ number_format($row['transfers']) }}</td>
                                                <td
                                                    class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900">
                                                    {{ \App\Support\Currency::format($row['revenue_minor'], $row['event']->currency ?? 'XOF') }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-right">
                                                    <a href="{{ route('events.attendees', $row['event']) }}"
                                                        class="inline-flex items-center px-3 py-1.5 text-xs font-medium rounded-full bg-indigo-50 text-indigo-700 hover:bg-indigo-100">Voir</a>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="7" class="px-6 py-8 text-center text-gray-500">Aucune
                                                    donnée disponible.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Dernières inscriptions - DESIGN CRÉATIF AVEC SVG -->
                    <div class="dashboard-card bg-white rounded-2xl shadow-xl border border-slate-100 overflow-hidden">
                        <!-- En-tête avec effet de vague -->
                        <div class="relative bg-gradient-to-r from-indigo-600 to-purple-600 px-6 py-5 overflow-hidden">
                            <div
                                class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full -translate-y-16 translate-x-16">
                            </div>
                            <div
                                class="absolute bottom-0 left-0 w-24 h-24 bg-white/5 rounded-full translate-y-12 -translate-x-12">
                            </div>

                            <div class="relative z-10 flex items-center justify-between">
                                <div class="flex items-center space-x-3">
                                    <div class="p-2 bg-white/20 rounded-xl backdrop-blur-sm">
                                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="text-xl font-bold text-white">Dernières inscriptions</h3>
                                        <p class="text-indigo-100 text-sm mt-1">Nouveaux participants récents</p>
                                    </div>
                                </div>
                                <a href="{{ route('events.index') }}"
                                    class="inline-flex items-center px-4 py-2 bg-white/20 text-white font-semibold rounded-xl border border-white/30 shadow-lg hover:bg-white/30 transition-all duration-200 hover:scale-105 backdrop-blur-sm">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
                                    </svg>
                                    Voir tout
                                </a>
                            </div>
                        </div>

                        <!-- Contenu des inscriptions -->
                        <div class="p-6">
                            <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
                                @forelse(data_get($stats, 'recent_registrations', []) as $registration)
                                    <div class="group relative">
                                        <!-- Carte avec effet de bordure animée -->
                                        <div
                                            class="registration-card rounded-2xl p-4 shadow-lg hover:shadow-2xl transition-all duration-300 border border-slate-200 hover:border-indigo-300 bg-gradient-to-br from-white to-slate-50/50 relative overflow-hidden">
                                            <!-- Effet de fond animé au survol -->
                                            <div
                                                class="absolute inset-0 bg-gradient-to-br from-indigo-500/5 to-purple-500/5 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                            </div>

                                            <div class="relative z-10 flex items-center space-x-4">
                                                <!-- Avatar circulaire avec badge de statut -->
                                                <div class="relative flex-shrink-0">
                                                    <div
                                                        class="w-14 h-14 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-2xl flex items-center justify-center text-white font-bold text-lg shadow-lg relative">
                                                        {{ strtoupper(substr($registration->user->name, 0, 1)) }}

                                                        <!-- Badge de statut -->
                                                        <div class="absolute -top-1 -right-1">
                                                            @if ($registration->is_validated)
                                                                <div class="w-6 h-6 bg-emerald-500 rounded-full flex items-center justify-center shadow-lg"
                                                                    title="Validé">
                                                                    <svg class="w-3 h-3 text-white" fill="none"
                                                                        stroke="currentColor" viewBox="0 0 24 24">
                                                                        <path stroke-linecap="round"
                                                                            stroke-linejoin="round" stroke-width="3"
                                                                            d="M5 13l4 4L19 7" />
                                                                    </svg>
                                                                </div>
                                                            @else
                                                                <div class="w-6 h-6 bg-amber-500 rounded-full flex items-center justify-center shadow-lg"
                                                                    title="En attente">
                                                                    <svg class="w-3 h-3 text-white" fill="none"
                                                                        stroke="currentColor" viewBox="0 0 24 24">
                                                                        <path stroke-linecap="round"
                                                                            stroke-linejoin="round" stroke-width="2"
                                                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                                    </svg>
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Informations -->
                                                <div class="flex-1 min-w-0">
                                                    <!-- Nom et événement -->
                                                    <div class="mb-3">
                                                        <p
                                                            class="text-sm font-bold text-slate-900 truncate mb-1 group-hover:text-indigo-700 transition-colors">
                                                            {{ $registration->user->name }}
                                                        </p>
                                                        <div class="flex items-center text-xs text-slate-600 mb-2">
                                                            <svg class="w-3 h-3 mr-1.5 text-indigo-500 flex-shrink-0"
                                                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                                            </svg>
                                                            <span
                                                                class="truncate">{{ $registration->event->title }}</span>
                                                        </div>
                                                    </div>

                                                    <!-- Date et heure avec icônes -->
                                                    <div class="flex items-center justify-between">
                                                        <div class="flex items-center space-x-4 text-xs text-slate-500">
                                                            <div class="flex items-center">
                                                                <svg class="w-3 h-3 mr-1.5 text-slate-400" fill="none"
                                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                                        stroke-width="2"
                                                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                                </svg>
                                                                <span>{{ $registration->created_at->isoFormat('D MMM') }}</span>
                                                            </div>
                                                            <div class="flex items-center">
                                                                <svg class="w-3 h-3 mr-1.5 text-slate-400" fill="none"
                                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                                        stroke-width="2"
                                                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                                </svg>
                                                                <span>{{ $registration->created_at->isoFormat('HH:mm') }}</span>
                                                            </div>
                                                        </div>

                                                        <!-- Action rapide -->
                                                        <a href="{{ route('events.show', $registration['event']) }}"
                                                            class="
                                                            group-hover:opacity-100 transition-all duration-300 p-1.5
                                                            text-slate-400 hover:text-indigo-600 hover:bg-indigo-50
                                                            rounded-lg border">
                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                                viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                            </svg>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Indicateur de nouveau -->
                                            @if ($registration->created_at->diffInHours(now()) < 24)
                                                <div class="absolute top-3 right-3">
                                                    <div
                                                        class="flex items-center space-x-1 px-2 py-1 bg-green-100 text-green-700 rounded-full text-xs font-medium">
                                                        <div class="w-1.5 h-1.5 bg-green-500 rounded-full pulse-dot"></div>
                                                        <span>Nouveau</span>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @empty
                                    <!-- État vide créatif -->
                                    <div class="col-span-2 text-center py-12">
                                        <div class="relative mx-auto w-24 h-24 mb-4">
                                            <!-- Icône principale -->
                                            <div
                                                class="w-full h-full bg-gradient-to-br from-slate-100 to-slate-200 rounded-2xl flex items-center justify-center">
                                                <svg class="w-10 h-10 text-slate-400" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="1.5"
                                                        d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                                                </svg>
                                            </div>
                                            <!-- Élément décoratif -->
                                            <div
                                                class="absolute -top-2 -right-2 w-8 h-8 bg-indigo-100 rounded-full flex items-center justify-center">
                                                <svg class="w-4 h-4 text-indigo-500" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                                </svg>
                                            </div>
                                        </div>
                                        <h4 class="text-lg font-semibold text-slate-700 mb-2">Aucune inscription récente
                                        </h4>
                                        <p class="text-slate-500 text-sm max-w-md mx-auto">
                                            Les nouvelles inscriptions de participants à vos événements apparaîtront ici.
                                        </p>
                                        <div class="mt-4 flex justify-center space-x-3">
                                            <a href="{{ route('events.create') }}"
                                                class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-lg hover:bg-indigo-700 transition-colors">
                                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                                </svg>
                                                Créer un événement
                                            </a>
                                            <a href="{{ route('events.index') }}"
                                                class="inline-flex items-center px-4 py-2 bg-white text-slate-700 text-sm font-medium rounded-lg border border-slate-300 hover:bg-slate-50 transition-colors">
                                                Voir mes événements
                                            </a>
                                        </div>
                                    </div>
                                @endforelse
                            </div>


                        </div>
                    </div>
                </div>

                <!-- Sidebar widgets -->
                <div class="space-y-8">
                    <!-- Alertes capacité -->
                    <div
                        class="dashboard-card bg-gradient-to-br from-orange-50 to-amber-50 rounded-2xl p-6 shadow-lg border border-orange-100">
                        <div class="flex items-center justify-between mb-6">
                            <div>
                                <h3 class="text-xl font-bold text-slate-900 mb-1">Alertes capacité</h3>
                                <p class="text-sm text-amber-600">Événements approchant de la limite</p>
                            </div>
                            <span class="px-3 py-1.5 text-sm font-bold rounded-full bg-amber-500 text-white shadow-sm">
                                {{ count(data_get($widgets, 'capacity_alerts', [])) }}
                            </span>
                        </div>

                        <div class="space-y-4">
                            @forelse(data_get($widgets, 'capacity_alerts', []) as $alert)
                                <div
                                    class="p-4 bg-white rounded-xl border border-amber-200 shadow-sm hover:shadow-md transition-shadow duration-200">
                                    <div class="flex items-start gap-4">
                                        <div class="flex-shrink-0 p-2 bg-amber-500 rounded-lg shadow-sm">
                                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                    d="M12 9v3.75m0 3.75h.007v.008H12z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                    d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <p class="text-sm font-semibold text-slate-900 truncate">
                                                {{ $alert['event']->title }}</p>
                                            <div class="mt-2 flex items-center justify-between">
                                                <div class="flex items-center space-x-4 text-xs">
                                                    <span
                                                        class="px-2 py-1 bg-amber-100 text-amber-800 rounded-full font-medium">
                                                        {{ $alert['remaining'] }} place(s) restante(s)
                                                    </span>
                                                    <span class="text-amber-700">
                                                        {{ $alert['event']->start_date->isoFormat('D MMM') }}
                                                    </span>
                                                </div>
                                                <a href="{{ route('events.edit', $alert['event']) }}"
                                                    class="text-xs text-amber-600 hover:text-amber-700 font-medium">
                                                    Modifier
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-6">
                                    <div
                                        class="w-12 h-12 mx-auto bg-emerald-100 rounded-2xl flex items-center justify-center mb-3">
                                        <svg class="w-6 h-6 text-emerald-500" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>
                                    <p class="text-sm text-slate-600">Aucune alerte de capacité</p>
                                    <p class="text-xs text-slate-500 mt-1">Tout est sous contrôle</p>
                                </div>
                            @endforelse
                        </div>
                    </div>

                    <!-- Taux d'occupation - VERSION COMPACTE ET RESPONSIVE -->
                    <div class="dashboard-card bg-white rounded-2xl p-6 shadow-lg border border-slate-100">
                        <div class="mb-6">
                            <h3 class="text-xl font-bold text-slate-900 mb-1">Taux d'occupation</h3>
                            <p class="text-sm text-slate-600">Performance de vos événements</p>
                        </div>

                        <!-- Layout flex responsive -->
                        <div class="flex flex-col xl:flex-row gap-6 items-start">
                            <!-- Graphique - Prend 40% sur grand écran -->
                            <div class="xl:w-2/5 w-full">
                                <div id="occupancy-chart" class="w-full"></div>
                            </div>

                            <!-- Cartes - Prend 60% sur grand écran -->
                            <div class="xl:w-3/5 w-full">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 max-h-96 overflow-y-auto pr-2">
                                    @forelse(data_get($widgets, 'occupancy_breakdown', []) as $item)
                                        @php
                                            $event = data_get($item, 'event');
                                            $eventTitle = $event ? $event->title : 'Événement inconnu';

                                            $occupancy = data_get(
                                                $item,
                                                'occupancy',
                                                data_get(
                                                    $item,
                                                    'occupancy_rate',
                                                    data_get($item, 'rate', data_get($item, 'percentage', 0)),
                                                ),
                                            );

                                            $occupancy = min((int) $occupancy, 100);

                                            $colorClass =
                                                $occupancy >= 80
                                                    ? 'from-red-500 to-rose-500'
                                                    : ($occupancy >= 60
                                                        ? 'from-amber-500 to-orange-500'
                                                        : ($occupancy >= 40
                                                            ? 'from-blue-500 to-cyan-500'
                                                            : 'from-emerald-500 to-green-500'));
                                        @endphp

                                        <div
                                            class="occupancy-card rounded-xl p-4 shadow-sm hover:shadow-md transition-all duration-200 border border-slate-100">
                                            <div class="flex items-center justify-between mb-3">
                                                <div class="flex-1 min-w-0">
                                                    <p class="text-sm font-semibold text-slate-900 truncate mb-1">
                                                        {{ $eventTitle }}
                                                    </p>
                                                    <p class="text-xs text-slate-500">
                                                        {{ $event && $event->start_date ? $event->start_date->isoFormat('D MMM') : 'N/A' }}
                                                    </p>
                                                </div>
                                                <div class="text-right">
                                                    <div
                                                        class="text-xl font-bold bg-gradient-to-r {{ $colorClass }} bg-clip-text text-transparent">
                                                        {{ $occupancy }}%
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Barre de progression avec label -->
                                            <div class="flex items-center justify-between">
                                                <div class="flex-1 h-2 bg-slate-200 rounded-full overflow-hidden mr-3">
                                                    <div class="h-full bg-gradient-to-r {{ $colorClass }} rounded-full transition-all duration-500"
                                                        style="width: {{ $occupancy }}%"></div>
                                                </div>
                                                <span class="text-xs font-medium text-slate-600 whitespace-nowrap">
                                                    {{ $occupancy }}/100
                                                </span>
                                            </div>
                                        </div>
                                    @empty
                                        <div class="col-span-2 text-center py-8">
                                            <div
                                                class="w-16 h-16 mx-auto bg-slate-100 rounded-2xl flex items-center justify-center mb-3">
                                                <svg class="w-8 h-8 text-slate-400" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="1.5"
                                                        d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                                </svg>
                                            </div>
                                            <p class="text-sm text-slate-500">Pas encore de données d'occupation</p>
                                        </div>
                                    @endforelse
                                </div>
                            </div>
                        </div>

                        <!-- Légende des couleurs -->
                        @if (!empty(data_get($widgets, 'occupancy_breakdown', [])))
                            <div class="mt-6 pt-6 border-t border-slate-100">
                                <div class="flex flex-wrap items-center justify-center gap-4 text-xs text-slate-600">
                                    <div class="flex items-center">
                                        <div class="w-3 h-3 bg-gradient-to-r from-emerald-500 to-green-500 rounded mr-2">
                                        </div>
                                        <span>0-39%</span>
                                    </div>
                                    <div class="flex items-center">
                                        <div class="w-3 h-3 bg-gradient-to-r from-blue-500 to-cyan-500 rounded mr-2"></div>
                                        <span>40-59%</span>
                                    </div>
                                    <div class="flex items-center">
                                        <div class="w-3 h-3 bg-gradient-to-r from-amber-500 to-orange-500 rounded mr-2">
                                        </div>
                                        <span>60-79%</span>
                                    </div>
                                    <div class="flex items-center">
                                        <div class="w-3 h-3 bg-gradient-to-r from-red-500 to-rose-500 rounded mr-2"></div>
                                        <span>80-100%</span>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- Événements à venir - DESIGN CRÉATIF SANS GRADIENT -->
                    <div class="dashboard-card bg-white rounded-2xl shadow-xl border border-slate-100 overflow-hidden">
                        <!-- En-tête avec design moderne -->
                        <div class="relative bg-gradient-to-r from-slate-50 to-white px-6 py-5 border-b border-slate-100">
                            <div
                                class="absolute top-0 right-0 w-20 h-20 bg-indigo-50 rounded-full -translate-y-10 translate-x-10">
                            </div>
                            <div class="relative z-10 flex items-center justify-between">
                                <div class="flex items-center space-x-3">
                                    <div class="p-2 bg-indigo-100 rounded-xl">
                                        <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="text-xl font-bold text-slate-900">Événements à venir</h3>
                                        <p class="text-slate-600 text-sm mt-1">Prochaines dates importantes</p>
                                    </div>
                                </div>
                                <a href="{{ route('events.index') }}"
                                    class="inline-flex items-center px-4 py-2 bg-white text-indigo-600 font-semibold rounded-xl border border-indigo-200 shadow-sm hover:shadow-md transition-all duration-200 hover:scale-105 hover:bg-indigo-50">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
                                    </svg>
                                    Voir tout
                                </a>
                            </div>
                        </div>

                        <!-- Contenu des événements -->
                        <div class="p-6">
                            <div class="space-y-4">
                                @forelse(data_get($widgets, 'upcoming_overview', []) as $upcoming)
                                    <div class="group relative">
                                        <!-- Carte événement avec effet de bordure -->
                                        <div
                                            class="bg-gradient-to-br from-white to-slate-50/50 rounded-2xl p-4 shadow-lg hover:shadow-xl transition-all duration-300 border border-slate-200 hover:border-indigo-300 relative overflow-hidden">
                                            <!-- Effet de fond animé au survol -->
                                            <div
                                                class="absolute inset-0 bg-gradient-to-br from-indigo-500/3 to-blue-500/3 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                            </div>

                                            <div class="relative z-10 flex items-start space-x-4">
                                                <!-- Badge de date créatif -->
                                                <div class="flex-shrink-0 relative">
                                                    <div
                                                        class="w-16 h-16 bg-gradient-to-br from-indigo-500 to-blue-600 rounded-2xl flex flex-col items-center justify-center text-white font-bold shadow-lg">
                                                        <span
                                                            class="text-lg leading-5">{{ $upcoming['event']->start_date->isoFormat('DD') }}</span>
                                                        <span
                                                            class="text-xs leading-3 opacity-90">{{ $upcoming['event']->start_date->isoFormat('MMM') }}</span>
                                                    </div>
                                                    <!-- Indicateur de jour -->
                                                    <div
                                                        class="absolute -top-1 -right-1 w-6 h-6 bg-amber-500 rounded-full flex items-center justify-center shadow-lg">
                                                        <svg class="w-3 h-3 text-white" fill="none"
                                                            stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                        </svg>
                                                    </div>
                                                </div>

                                                <!-- Contenu principal -->
                                                <div class="flex-1 min-w-0">
                                                    <!-- Titre et localisation -->
                                                    <div class="mb-3">
                                                        <p
                                                            class="text-sm font-bold text-slate-900 truncate mb-2 group-hover:text-indigo-700 transition-colors">
                                                            {{ $upcoming['event']->title }}
                                                        </p>

                                                        <div class="flex items-center space-x-4 text-xs text-slate-600">
                                                            <!-- Heure -->
                                                            <div class="flex items-center">
                                                                <svg class="w-3.5 h-3.5 mr-1.5 text-slate-400"
                                                                    fill="none" stroke="currentColor"
                                                                    viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                                        stroke-width="2"
                                                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                                </svg>
                                                                <span>{{ $upcoming['event']->start_date->isoFormat('HH:mm') }}</span>
                                                            </div>

                                                            <!-- Localisation -->
                                                            @if ($upcoming['event']->location)
                                                                <div class="flex items-center">
                                                                    <svg class="w-3.5 h-3.5 mr-1.5 text-slate-400"
                                                                        fill="none" stroke="currentColor"
                                                                        viewBox="0 0 24 24">
                                                                        <path stroke-linecap="round"
                                                                            stroke-linejoin="round" stroke-width="2"
                                                                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                                                        <path stroke-linecap="round"
                                                                            stroke-linejoin="round" stroke-width="2"
                                                                            d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                                                    </svg>
                                                                    <span
                                                                        class="truncate max-w-[120px]">{{ $upcoming['event']->location }}</span>
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>

                                                    <!-- Barre de progression des inscriptions -->
                                                    <div class="flex items-center flex-wrap justify-between">
                                                        <div class="flex items-center space-x-3">
                                                            <!-- Icône participants -->
                                                            <div class="flex items-center text-xs text-slate-500">
                                                                <svg class="w-3.5 h-3.5 mr-1 text-indigo-500"
                                                                    fill="none" stroke="currentColor"
                                                                    viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                                        stroke-width="2"
                                                                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                                                </svg>
                                                                <span>{{ $upcoming['registrations'] }} inscrit(s)</span>
                                                            </div>
                                                        </div>
                                                        <!-- Action rapide -->
                                                        <a href="{{ route('events.attendees', $upcoming['event']) }}"
                                                            class=" border group-hover:opacity-100 flex space-x-2 items-center transition-all duration-300 p-1.5 text-slate-400 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg">
                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                                viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                            </svg>
                                                            <p>Voir la liste des inscriptions</p>

                                                        </a>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Indicateur de proximité -->
                                            @php
                                                $daysUntilEvent = $upcoming['event']->start_date->diffInDays(now());
                                            @endphp
                                            @if ($daysUntilEvent <= 7)
                                                <div class="absolute top-3 right-3">
                                                    <div
                                                        class="flex items-center space-x-1 px-2 py-1 {{ $daysUntilEvent <= 3 ? 'bg-red-100 text-red-700' : 'bg-amber-100 text-amber-700' }} rounded-full text-xs font-medium">
                                                        @if ($daysUntilEvent <= 1)
                                                            <svg class="w-3 h-3" fill="none" stroke="currentColor"
                                                                viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                                            </svg>
                                                            <span>Bientôt</span>
                                                        @elseif($daysUntilEvent <= 3)
                                                            <span>Proche</span>
                                                        @else
                                                            <span>À venir</span>
                                                        @endif
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @empty
                                    <!-- État vide créatif -->
                                    <div class="text-center py-12">
                                        <div class="relative mx-auto w-20 h-20 mb-4">
                                            <!-- Icône calendrier -->
                                            <div
                                                class="w-full h-full bg-slate-100 rounded-2xl flex items-center justify-center">
                                                <svg class="w-10 h-10 text-slate-400" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="1.5"
                                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                </svg>
                                            </div>
                                            <!-- Élément décoratif + -->
                                            <div
                                                class="absolute -top-2 -right-2 w-8 h-8 bg-indigo-100 rounded-full flex items-center justify-center">
                                                <svg class="w-4 h-4 text-indigo-500" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                                </svg>
                                            </div>
                                        </div>
                                        <h4 class="text-lg font-semibold text-slate-700 mb-2">Aucun événement programmé
                                        </h4>
                                        <p class="text-slate-500 text-sm max-w-md mx-auto mb-4">
                                            Planifiez vos prochains événements pour les voir apparaître ici.
                                        </p>
                                        <a href="{{ route('events.create') }}"
                                            class="inline-flex items-center px-5 py-2.5 bg-indigo-600 text-white font-medium rounded-xl hover:bg-indigo-700 transition-colors shadow-lg hover:shadow-xl">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
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



            <!-- Sections restantes (Finances et Événements à venir détaillés) -->
            <!-- ... (garder les sections existantes inchangées) ... -->

        </div>
    </div>
@endsection

@push('scripts')
    <script>
        (function() {
            function load(src, testFn, fallbackSrc) {
                return new Promise(function(resolve) {
                    if (testFn()) return resolve();
                    var s = document.createElement('script');
                    s.src = src;
                    s.onload = resolve;
                    s.onerror = function() {
                        var lf = document.createElement('script');
                        lf.src = fallbackSrc;
                        lf.onload = resolve;
                        document.head.appendChild(lf);
                    };
                    document.head.appendChild(s);
                });
            }
            window.loadDashboardLibs = function() {
                return Promise.all([
                    load('https://cdn.jsdelivr.net/npm/chart.js@4.4.6/dist/chart.umd.min.js', function() {
                        return !!window.Chart;
                    }, '{{ asset('vendor/chart.js/chart.umd.min.js') }}'),
                    load('https://cdn.jsdelivr.net/npm/apexcharts', function() {
                        return !!window.ApexCharts;
                    }, '{{ asset('vendor/apexcharts/apexcharts.min.js') }}'),
                ]);
            };
        })();
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            window.loadDashboardLibs().then(function() {
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
                                legend: {
                                    display: false
                                },
                                tooltip: {
                                    backgroundColor: 'rgba(255, 255, 255, 0.95)',
                                    titleColor: '#1f2937',
                                    bodyColor: '#4b5563',
                                    borderColor: '#e5e7eb',
                                    borderWidth: 1,
                                    callbacks: {
                                        label: (context) =>
                                            `${context.parsed.y} inscription${context.parsed.y > 1 ? 's' : ''}`
                                    }
                                }
                            },
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    grid: {
                                        color: 'rgba(0, 0, 0, 0.05)'
                                    },
                                    ticks: {
                                        stepSize: 5
                                    }
                                },
                                x: {
                                    grid: {
                                        display: false
                                    }
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
                            height: 280,
                            toolbar: {
                                show: false
                            },
                            fontFamily: 'Inter, sans-serif',
                            background: 'transparent'
                        },
                        series: occupancySeries,
                        labels: occupancyLabels,
                        plotOptions: {
                            radialBar: {
                                track: {
                                    background: '#f1f5f9',
                                    strokeWidth: '100%',
                                    margin: 5
                                },
                                hollow: {
                                    size: '50%',
                                    background: 'transparent'
                                },
                                dataLabels: {
                                    name: {
                                        fontSize: '14px',
                                        fontWeight: '600',
                                        color: '#475569'
                                    },
                                    value: {
                                        fontSize: '24px',
                                        fontWeight: '800',
                                        color: '#1e293b',
                                        formatter: (val) => `${Math.round(val)}%`,
                                    },
                                    total: {
                                        show: true,
                                        label: 'Moyenne',
                                        color: '#64748b',
                                        fontSize: '14px',
                                        fontWeight: '600',
                                        formatter: () => {
                                            if (!occupancySeries.length) return '0%';
                                            const sum = occupancySeries.reduce((acc, value) => acc +
                                                value, 0);
                                            return `${Math.round(sum / occupancySeries.length)}%`;
                                        }
                                    }
                                }
                            }
                        },
                        colors: ['#6366f1', '#22d3ee', '#f97316', '#f59e0b', '#10b981', '#8b5cf6'],
                        stroke: {
                            lineCap: 'round'
                        }
                    };

                    const apexChart = new ApexCharts(occupancyContainer, apexOptions);
                    apexChart.render();
                }

                // Graphique des ventes quotidiennes - MODE CLAIR
                const salesCanvas = document.getElementById('daily-sales-chart');
                if (salesCanvas) {
                    const salesLabels = @json(data_get($salesChart ?? [], 'labels', []));
                    const salesSeriesMinor = @json(data_get($salesChart ?? [], 'series_minor', []));
                    const salesSeriesMajor = salesSeriesMinor.map(v => (v || 0) / 100);

                    new Chart(salesCanvas, {
                        type: 'bar',
                        data: {
                            labels: salesLabels,
                            datasets: [{
                                label: 'Ventes quotidiennes',
                                data: salesSeriesMajor,
                                backgroundColor: 'yellow',
                                borderWidth: 1,
                                borderRadius: 12,
                                borderSkipped: false,
                                fill: true,
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    grid: {
                                        color: 'rgba(255, 255, 255, 0.2)',
                                        drawBorder: false
                                    },
                                    ticks: {
                                        color: 'rgba(255, 255, 255, 0.9)',
                                        callback: (value) => {
                                            return new Intl.NumberFormat('fr-FR', {
                                                style: 'currency',
                                                currency: 'XOF',
                                                maximumFractionDigits: 0
                                            }).format(value);
                                        }
                                    }
                                },
                                x: {
                                    grid: {
                                        display: false,
                                        drawBorder: false
                                    },
                                    ticks: {
                                        color: 'rgba(255, 255, 255, 0.9)',
                                        maxRotation: 0
                                    }
                                }
                            },
                            plugins: {
                                legend: {
                                    display: false
                                },
                                tooltip: {
                                    backgroundColor: 'rgba(255, 255, 255, 0.95)',
                                    titleColor: '#1f2937',
                                    bodyColor: '#4b5563',
                                    borderColor: '#e5e7eb',
                                    borderWidth: 1,
                                    callbacks: {
                                        label: (ctx) => {
                                            return new Intl.NumberFormat('fr-FR', {
                                                style: 'currency',
                                                currency: 'XOF',
                                                maximumFractionDigits: 0
                                            }).format(ctx.parsed.y);
                                        }
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
