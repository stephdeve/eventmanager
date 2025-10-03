@extends('layouts.app')

@section('title', 'Tableau de bord - Organisateur')

@push('styles')
    <style>
        /* Carte interactive : légère élévation au survol pour dynamiser l'interface */
        .dashboard-card {
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .dashboard-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 32px rgba(79, 70, 229, 0.12);
        }
    </style>
@endpush

@section('content')
<div class="space-y-8">
    <!-- En-tête du tableau de bord -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between">
        <h1 class="text-2xl font-bold text-gray-900">Tableau de bord - Organisateur</h1>
        <div class="mt-4 md:mt-0">
            <a href="{{ route('events.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-800 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                Nouvel événement
            </a>
        </div>
    </div>

    <!-- Cartes synthétiques principales -->
    <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 xl:grid-cols-4">
        <!-- Carte statistique : total des événements -->
        <div class="p-5 bg-white rounded-lg shadow dashboard-card">
            <div class="flex items-center">
                <div class="p-3 rounded-full text-indigo-500 bg-indigo-100">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                </div>
                <div class="ml-5">
                    <p class="text-sm font-medium text-gray-500 truncate">Événements créés</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ number_format(data_get($stats, 'total_events', 0)) }}</p>
                </div>
            </div>
        </div>

        <!-- Carte statistique : événements à venir -->
        <div class="p-5 bg-white rounded-lg shadow dashboard-card">
            <div class="flex items-center">
                <div class="p-3 rounded-full text-green-500 bg-green-100">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                </div>
                <div class="ml-5">
                    <p class="text-sm font-medium text-gray-500 truncate">Événements à venir</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ number_format(data_get($stats, 'upcoming_events', 0)) }}</p>
                </div>
            </div>
        </div>

        <!-- Carte statistique : total inscriptions -->
        <div class="p-5 bg-white rounded-lg shadow dashboard-card">
            <div class="flex items-center">
                <div class="p-3 rounded-full text-blue-500 bg-blue-100">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                </div>
                <div class="ml-5">
                    <p class="text-sm font-medium text-gray-500 truncate">Total d'inscriptions</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ number_format(data_get($stats, 'total_registrations', 0)) }}</p>
                </div>
            </div>
        </div>

        <!-- Carte statistique : raccourci scanner -->
        <a href="{{ route('scanner') }}" class="p-5 bg-white rounded-lg shadow dashboard-card">
            <div class="flex items-center">
                <div class="p-3 rounded-full text-purple-500 bg-purple-100">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path>
                    </svg>
                </div>
                <div class="ml-5">
                    <p class="text-sm font-medium text-gray-500 truncate">Scanner un billet</p>
                    <p class="text-sm font-semibold text-purple-600">Ouvrir le scanner</p>
                </div>
            </div>
        </a>
    </div>

    <!-- Zone principale : graphiques et widgets contextuels -->
    <div class="grid gap-6 lg:grid-cols-3">
        <div class="space-y-6 lg:col-span-2">
            <!-- Graphique linéaire : évolution des inscriptions -->
            <div class="bg-white shadow rounded-lg p-6 dashboard-card">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <h2 class="text-lg font-medium text-gray-900">Évolution des inscriptions</h2>
                        <p class="text-sm text-gray-500">Tendance sur les 7 derniers jours</p>
                    </div>
                    @php
                        $growth = data_get($charts, 'weekly_registrations.growth_percentage', 0);
                    @endphp
                    <div class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold {{ $growth >= 0 ? 'bg-green-50 text-green-600' : 'bg-red-50 text-red-600' }}">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                            @if($growth >= 0)
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 19.5l15-15M19.5 4.5H8.25M19.5 4.5V15.75" />
                            @else
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 4.5l-15 15M4.5 19.5H15.75M4.5 19.5V8.25" />
                            @endif
                        </svg>
                        {{ $growth >= 0 ? '+' : '' }}{{ $growth }}%
                    </div>
                </div>
                <div class="relative h-64">
                    <canvas id="weekly-registrations-chart" class="!h-full"></canvas>

                </div>
            </div>

            <!-- Liste des dernières inscriptions -->
            <div class="bg-white shadow rounded-lg dashboard-card">
                <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
                    <h2 class="text-lg font-medium text-gray-900">Dernières inscriptions</h2>
                    <a href="{{ route('events.index') }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-500">Gérer les événements</a>
                </div>
                <ul class="divide-y divide-gray-200">
                    @forelse(data_get($stats, 'recent_registrations', []) as $registration)
                        <li>
                            <a href="{{ route('events.show', $registration->event) }}" class="block px-6 py-4 hover:bg-gray-50">
                                <div class="flex items-center justify-between">
                                    <p class="text-sm font-medium text-indigo-600 truncate">{{ $registration->event->title }}</p>
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $registration->is_validated ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                        {{ $registration->is_validated ? 'Validé' : 'En attente' }}
                                    </span>
                                </div>
                                <div class="mt-2 flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between text-sm text-gray-500">
                                    <span class="flex items-center">
                                        <svg class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                                        </svg>
                                        {{ $registration->user->name }}
                                    </span>
                                    <span class="flex items-center">
                                        <svg class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path>
                                        </svg>
                                        Inscrit le {{ $registration->created_at->isoFormat('D MMMM YYYY') }}
                                    </span>
                                </div>
                            </a>
                        </li>
                    @empty
                        <li class="px-6 py-8 text-center text-sm text-gray-500">Aucune inscription récente.</li>
                    @endforelse
                </ul>
            </div>
        </div>

        <div class="space-y-6">
            <!-- Widget : alertes de capacité proches de la saturation -->
            <div class="bg-white shadow rounded-lg p-6 dashboard-card">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-lg font-medium text-gray-900">Alertes capacité</h2>
                    <span class="text-xs font-semibold px-2 py-1 rounded-full {{ count(data_get($widgets, 'capacity_alerts', [])) ? 'bg-red-50 text-red-600' : 'bg-gray-100 text-gray-500' }}">
                        {{ count(data_get($widgets, 'capacity_alerts', [])) }} alerte(s)
                    </span>
                </div>
                <div class="space-y-4">
                    @forelse(data_get($widgets, 'capacity_alerts', []) as $alert)
                        <div class="border border-red-100 rounded-lg p-4 bg-red-50/70">
                            <div class="flex items-start">
                                <div class="flex-shrink-0 text-red-500 mt-0.5">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m0 3.75h.007v.008H12z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p class="font-semibold text-sm text-red-700">{{ $alert['event']->title }}</p>
                                    <p class="text-sm text-red-600 mt-1">{{ $alert['remaining'] }} place(s) restante(s)</p>
                                    <p class="text-xs text-red-500 mt-2">Début le {{ $alert['event']->start_date->isoFormat('D MMM YYYY à HH:mm') }}</p>
                                </div>
                            </div>
                        </div>
                    @empty
                        <p class="text-sm text-gray-500">Aucune alerte de capacité pour le moment.</p>
                    @endforelse
                </div>
            </div>

            <!-- Widget : graphique radial du taux d'occupation -->
            <div class="bg-white shadow rounded-lg p-6 dashboard-card">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-lg font-medium text-gray-900">Taux d'occupation</h2>
                    <p class="text-sm text-gray-500">Top événements en cours</p>
                </div>
                <div id="occupancy-chart" class="w-full"></div>
                <ul class="mt-4 space-y-2 text-sm text-gray-600">
                    @forelse(data_get($widgets, 'occupancy_breakdown', []) as $item)
                        <li class="flex items-center justify-between">
                            <span class="font-medium">{{ $item['event']->title }}</span>
                            <span class="text-indigo-600 font-semibold">{{ $item['occupancy'] }}%</span>
                        </li>
                    @empty
                        <li class="text-sm text-gray-500">Pas encore de données d'occupation.</li>
                    @endforelse
                </ul>
            </div>

            <!-- Widget : résumé rapide des événements à venir -->
            <div class="bg-white shadow rounded-lg p-6 dashboard-card">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-lg font-medium text-gray-900">Événements à venir</h2>
                    <a href="{{ route('events.index') }}" class="text-sm text-indigo-600 hover:text-indigo-500">Voir le calendrier</a>
                </div>
                <ul class="space-y-4">
                    @forelse(data_get($widgets, 'upcoming_overview', []) as $upcoming)
                        <li class="flex items-start">
                            <div class="flex-shrink-0 w-12 h-12 bg-indigo-50 text-indigo-600 rounded-lg flex items-center justify-center font-bold">
                                {{ $upcoming['event']->start_date->isoFormat('DD') }}
                            </div>
                            <div class="ml-3">
                                <p class="font-semibold text-gray-900">{{ $upcoming['event']->title }}</p>
                                <p class="text-sm text-gray-500">{{ $upcoming['event']->start_date->isoFormat('dddd D MMM HH:mm') }}</p>
                                <p class="text-xs text-indigo-600 mt-1">{{ $upcoming['registrations'] }} inscrit(s)</p>
                            </div>
                        </li>
                    @empty
                        <li class="text-sm text-gray-500">Aucun événement programmé cette semaine.</li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>

    <!-- Section détaillée : liste des prochains événements -->
    <div class="mt-4">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-lg font-medium text-gray-900">Vos prochains événements</h2>
            <a href="{{ route('events.index') }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-500">Voir tout</a>
        </div>
        <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-3">
            @forelse($upcomingEvents as $event)
                <div class="bg-white overflow-hidden shadow rounded-lg dashboard-card">
                    <div class="px-4 py-5 sm:p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-indigo-500 rounded-md p-3">
                                <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">
                                        {{ optional($event->start_date)->isoFormat('dddd D MMMM YYYY') ?? 'Date à confirmer' }}
                                    </dt>
                                    <dd class="mt-1">
                                        <div class="text-lg font-medium text-gray-900">
                                            <a href="{{ route('events.show', $event) }}" class="hover:text-indigo-600">{{ $event->title }}</a>
                                        </div>
                                    </dd>
                                </dl>
                            </div>
                        </div>
                        <div class="mt-4 flex justify-between items-center">
                            <div class="flex -space-x-1 overflow-hidden">
                                @foreach($event->attendees->take(5) as $attendee)
                                    <img class="inline-block h-6 w-6 rounded-full ring-2 ring-white" src="https://ui-avatars.com/api/?name={{ urlencode($attendee->name) }}&color=7F9CF5&background=EBF4FF" alt="{{ $attendee->name }}">
                                @endforeach
                                @if($event->registrations_count > 5)
                                    <span class="inline-flex items-center justify-center h-6 w-6 rounded-full bg-gray-100 text-xs font-medium text-gray-500">
                                        +{{ $event->registrations_count - 5 }}
                                    </span>
                                @endif
                            </div>
                            <p class="text-sm text-gray-500"><span class="font-semibold text-gray-900">{{ $event->registrations_count }}</span> inscrit(s)</p>
                        </div>
                        <div class="mt-4 flex justify-between text-sm text-gray-500">
                            <span class="flex items-center">
                                <svg class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                {{ $event->location }}
                            </span>
                            <a href="{{ route('events.attendees', $event) }}" class="text-indigo-600 hover:text-indigo-500 font-medium">Voir la liste</a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="md:col-span-2 xl:col-span-3 py-8 text-center text-gray-500">Aucun événement à venir n'est planifié.</div>
            @endforelse
        </div>
    </div>
</div>
@endsection

@push('scripts')
    <!-- Bibliothèques de visualisation (Chart.js + ApexCharts) -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.6/dist/chart.umd.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            /* Graphique linéaire des inscriptions (Chart.js) */
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
                            backgroundColor: 'rgba(79, 70, 229, 0.15)',
                            tension: 0.35,
                            pointRadius: 4,
                            pointHoverRadius: 6,
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        resizeDelay: 200,
                        plugins: {
                            legend: { display: false },
                            tooltip: {
                                callbacks: {
                                    label: (context) => `${context.parsed.y} inscription${context.parsed.y > 1 ? 's' : ''}`
                                }
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: { stepSize: 5 }
                            }
                        }
                    }
                });
            }

            /* Graphique radial des taux d'occupation (ApexCharts) */
            const occupancyContainer = document.querySelector('#occupancy-chart');
            if (occupancyContainer) {
                const occupancySeries = @json(data_get($charts, 'occupancy.series', []));
                const occupancyLabels = @json(data_get($charts, 'occupancy.labels', []));

                const apexOptions = {
                    chart: {
                        type: 'radialBar',
                        height: 320,
                        toolbar: { show: false },
                    },
                    series: occupancySeries,
                    labels: occupancyLabels,
                    plotOptions: {
                        radialBar: {
                            track: { background: '#f3f4f6' },
                            dataLabels: {
                                name: { fontSize: '14px' },
                                value: {
                                    fontSize: '18px',
                                    formatter: (val) => `${Math.round(val)}%`,
                                },
                                total: {
                                    show: true,
                                    label: 'Moyenne',
                                    formatter: () => {
                                        if (!occupancySeries.length) {
                                            return '0%';
                                        }
                                        const sum = occupancySeries.reduce((acc, value) => acc + value, 0);
                                        return `${Math.round(sum / occupancySeries.length)}%`;
                                    }
                                }
                            }
                        }
                    },
                    colors: ['#6366f1', '#22d3ee', '#f97316', '#f59e0b'],
                };

                const apexChart = new ApexCharts(occupancyContainer, apexOptions);
                apexChart.render();
            }
        });
    </script>
@endpush
