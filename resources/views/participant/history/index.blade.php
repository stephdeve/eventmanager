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
            <div class="flex items-center justify-between mb-4">
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
            <div style="position: relative; height: 300px;">
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
        <div class="space-y-4">
            @forelse($participations as $participation)
                @php $event = $participation->event; @endphp
                <div class="participation-card bg-white rounded-2xl p-6 shadow-lg border border-slate-100">
                    <div class="flex items-start justify-between">
                        <div class="flex-1">
                            <div class="flex items-center gap-3 mb-3">
                                <h3 class="text-xl font-bold text-slate-900">{{ $event->title }}</h3>
                                @if($event->start_date->isFuture())
                                    <span class="px-3 py-1 bg-blue-100 text-blue-700 text-xs font-semibold rounded-full">À venir</span>
                                @else
                                    <span class="px-3 py-1 bg-slate-100 text-slate-700 text-xs font-semibold rounded-full">Passé</span>
                                @endif
                            </div>
                            <div class="grid grid-cols-2 md:grid-cols-3 gap-4 text-sm text-slate-600">
                                <div class="flex items-center">
                                    <svg class="w-4 h-4 mr-2 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                    {{ $event->start_date->format('d/m/Y H:i') }}
                                </div>
                                <div class="flex items-center">
                                    <svg class="w-4 h-4 mr-2 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    </svg>
                                    {{ $event->location }}
                                </div>
                                <div class="flex items-center">
                                    <svg class="w-4 h-4 mr-2 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 1.119-3 2.5S10.343 13 12 13s3 1.119 3 2.5S13.657 18 12 18m0-10V6m0 12v-2m8-4a8 8 0 11-16 0 8 8 0 0116 0z"/>
                                    </svg>
                                    {{ $participation->payment_status }}
                                </div>
                            </div>
                        </div>
                        <div class="flex flex-col gap-2 ml-4">
                            <a href="{{ route('events.show', $event) }}" class="inline-flex items-center px-4 py-2 bg-blue-50 text-blue-700 rounded-lg hover:bg-blue-100 text-sm font-medium">
                                Voir événement
                            </a>
                            <a href="{{ route('registrations.show', $participation->qr_code_data) }}" class="inline-flex items-center px-4 py-2 bg-green-50 text-green-700 rounded-lg hover:bg-green-100 text-sm font-medium">
                                Mon billet
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="bg-white rounded-2xl p-12 text-center">
                    <div class="w-20 h-20 mx-auto bg-slate-100 rounded-2xl flex items-center justify-center mb-4">
                        <svg class="w-10 h-10 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-slate-700 mb-2">Aucune participation</h3>
                    <p class="text-slate-500 mb-6">Parcourez les événements disponibles et inscrivez-vous.</p>
                    <a href="{{ route('events.index') }}" class="inline-flex items-center px-6 py-3 bg-blue-600 text-white rounded-xl hover:bg-blue-700 font-semibold">
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
