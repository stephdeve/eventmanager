@extends('layouts.app')

@section('content')
    <div class="space-y-10">
        <div class="rounded-3xl bg-gradient-to-br from-indigo-500 via-purple-500 to-sky-500 p-8 text-white shadow-xl">
            <div class="flex flex-col gap-6 md:flex-row md:items-center md:justify-between">
                <div>
                    <p class="text-xs uppercase tracking-wide text-white/70">Administration</p>
                    <h1 class="mt-2 text-3xl font-bold">Tableau de bord Super Admin</h1>
                    <p class="mt-3 text-sm text-white/80">Suivez l'activité de la plateforme en temps réel : utilisateurs,
                        inscriptions, événements et organisateurs les plus actifs.</p>
                </div>
                <div class="grid grid-cols-2 gap-4 md:grid-cols-4">
                    <div class="rounded-2xl bg-white/10 p-4 backdrop-blur">
                        <p class="text-xs uppercase tracking-wide text-white/70">Utilisateurs</p>
                        <p class="mt-2 text-2xl font-semibold">{{ number_format($metrics['total_users']) }}</p>
                    </div>
                    <div class="rounded-2xl bg-white/10 p-4 backdrop-blur">
                        <p class="text-xs uppercase tracking-wide text-white/70">Événements</p>
                        <p class="mt-2 text-2xl font-semibold">{{ number_format($metrics['total_events']) }}</p>
                    </div>
                    <div class="rounded-2xl bg-white/10 p-4 backdrop-blur">
                        <p class="text-xs uppercase tracking-wide text-white/70">Inscriptions</p>
                        <p class="mt-2 text-2xl font-semibold">{{ number_format($metrics['total_registrations']) }}</p>
                    </div>
                    <div class="rounded-2xl bg-white/10 p-4 backdrop-blur">
                        <p class="text-xs uppercase tracking-wide text-white/70">Billets validés</p>
                        <p class="mt-2 text-2xl font-semibold">{{ number_format($metrics['validated_registrations']) }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 gap-8 lg:grid-cols-2">
            <div class="rounded-3xl bg-white p-5 shadow-xl dark:bg-neutral-900 dark:border dark:border-neutral-800">
                <div class="flex items-center justify-between">
                    <h2 class="text-base font-semibold text-slate-800 dark:text-neutral-200">Répartition des rôles</h2>
                </div>
                <div class="mt-4">
                    <canvas id="chartRoleDistribution" height="210"></canvas>
                </div>
            </div>

            <div class="rounded-3xl bg-white p-6 shadow-xl dark:bg-neutral-900 dark:border dark:border-neutral-800">
                <div class="flex items-center justify-between">
                    <h2 class="text-lg font-semibold text-slate-800 dark:text-neutral-200">Inscriptions mensuelles</h2>
                    <span
                        class="rounded-full bg-indigo-50 px-3 py-1 text-xs font-semibold text-indigo-600 dark:bg-indigo-500/10 dark:text-indigo-300">6
                        derniers mois</span>
                </div>
                <div class="mt-6">
                    <canvas id="chartMonthlyRegistrations" height="260"></canvas>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 gap-8 lg:grid-cols-2">
            <div class="rounded-3xl bg-white p-6 shadow-xl dark:bg-neutral-900 dark:border dark:border-neutral-800">
                <div class="flex items-center justify-between">
                    <h2 class="text-lg font-semibold text-slate-800 dark:text-neutral-200">Participation par événement</h2>
                    <span class="text-xs text-slate-400 dark:text-neutral-500">Top 5</span>
                </div>
                <div class="mt-6">
                    <canvas id="chartParticipation" height="260"></canvas>
                </div>
            </div>

            <div class="rounded-3xl bg-white p-6 shadow-xl dark:bg-neutral-900 dark:border dark:border-neutral-800">
                <div class="flex items-center justify-between">
                    <h2 class="text-lg font-semibold text-slate-800 dark:text-neutral-200">Capacité vs Inscriptions</h2>
                    <span class="text-xs text-slate-400 dark:text-neutral-500">Top 5 événements</span>
                </div>
                <div class="mt-6">
                    <canvas id="chartCapacity" height="260"></canvas>
                </div>
            </div>
        </div>

        <div class="rounded-3xl bg-white p-6 shadow-xl dark:bg-neutral-900 dark:border dark:border-neutral-800">
            <div class="flex items-center justify-between">
                <h2 class="text-lg font-semibold text-slate-800 dark:text-neutral-200">Organisateurs les plus actifs</h2>
                <span class="text-xs text-slate-400 dark:text-neutral-500">Top 5</span>
            </div>
            <div class="mt-6">
                <canvas id="chartOrganizers" height="260"></canvas>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script type="module">
        import {
            initAdminDashboardCharts
        } from '{{ Vite::asset('resources/js/components/admin-dashboard-charts.js') }}';

        initAdminDashboardCharts({
            roleDistribution: @json($charts['roles']),
            monthlyRegistrations: @json($charts['monthly_registrations']),
            participation: @json($charts['participation']),
            capacity: @json($charts['capacity']),
            organizers: @json($charts['organizers'])
        });
    </script>
@endpush
