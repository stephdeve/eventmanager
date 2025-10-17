@extends('layouts.app')

@section('title', 'Liste des participants - ' . $event->title)

@section('content')
<div class="min-h-screen bg-gray-50/30 py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Live Alerts -->
        <div id="live-alerts" class="space-y-3 mb-6 hidden">
            <!-- Alerts injected by Echo -->
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="p-6">
                <!-- Header -->
                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4 mb-8">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900 mb-2">
                            Participants - {{ $event->title }}
                        </h1>
                        <p class="text-gray-600 text-sm">
                            Gestion des inscriptions et validation des billets
                        </p>
                    </div>
                    <div class="flex flex-wrap gap-3">
                        <a href="{{ route('events.show', $event) }}"
                           class="inline-flex items-center px-4 py-2.5 bg-white border border-gray-300 rounded-xl text-sm font-medium text-gray-700 hover:bg-gray-50 hover:border-gray-400 transition-all duration-200 shadow-sm hover:shadow-md">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                            </svg>
                            Retour
                        </a>
                        <a href="{{ route('scanner') }}"
                           class="inline-flex items-center px-4 py-2.5 bg-gradient-to-r from-indigo-600 to-purple-600 border border-transparent rounded-xl text-sm font-medium text-white hover:from-indigo-700 hover:to-purple-700 transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zM17 8h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/>
                            </svg>
                            Scanner un billet
                        </a>
                        @php $qs = http_build_query($filters ?? []); @endphp
                        <a href="{{ route('events.attendees.export.csv', $event) }}{{ $qs ? ('?'.$qs) : '' }}"
                           class="inline-flex items-center px-4 py-2.5 bg-white border border-gray-300 rounded-xl text-sm font-medium text-gray-700 hover:bg-gray-50 hover:border-gray-400 transition-all duration-200 shadow-sm hover:shadow-md">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16h8M8 12h8M8 8h8M4 6h16M4 18h16"/>
                            </svg>
                            Export CSV
                        </a>
                        <a href="{{ route('events.attendees.export.pdf', $event) }}{{ $qs ? ('?'.$qs) : '' }}"
                           class="inline-flex items-center px-4 py-2.5 bg-white border border-gray-300 rounded-xl text-sm font-medium text-gray-700 hover:bg-gray-50 hover:border-gray-400 transition-all duration-200 shadow-sm hover:shadow-md">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6H6m6 0h6"/>
                            </svg>
                            Export PDF
                        </a>
                    </div>
                </div>

                <!-- Filtres -->
                <div class="mb-6">
                    <form method="GET" action="{{ route('events.attendees', $event) }}" class="bg-white rounded-2xl border border-gray-200 p-4">
                        <div class="grid grid-cols-1 md:grid-cols-5 gap-4 items-end">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Statut paiement</label>
                                <select name="status" class="mt-1 w-full rounded-xl border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="">Tous</option>
                                    @foreach(['paid' => 'Payé', 'unpaid' => 'Non payé', 'pending' => 'En attente', 'failed' => 'Échec'] as $val => $label)
                                        <option value="{{ $val }}" @selected(($filters['status'] ?? '') === $val)>{{ $label }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Méthode</label>
                                <select name="method" class="mt-1 w-full rounded-xl border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="">Toutes</option>
                                    @foreach(['physical' => 'Physique', 'numeric' => 'En ligne', 'free' => 'Gratuit'] as $val => $label)
                                        <option value="{{ $val }}" @selected(($filters['method'] ?? '') === $val)>{{ $label }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Du</label>
                                <input type="date" name="from" value="{{ $filters['from'] ?? '' }}" class="mt-1 w-full rounded-xl border-gray-300 focus:border-indigo-500 focus:ring-indigo-500" />
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Au</label>
                                <input type="date" name="to" value="{{ $filters['to'] ?? '' }}" class="mt-1 w-full rounded-xl border-gray-300 focus:border-indigo-500 focus:ring-indigo-500" />
                            </div>
                            <div class="flex gap-2">
                                <button type="submit" class="inline-flex items-center px-4 py-2.5 bg-indigo-600 text-white rounded-xl hover:bg-indigo-700">Filtrer</button>
                                <a href="{{ route('events.attendees', $event) }}" class="inline-flex items-center px-4 py-2.5 bg-white border border-gray-300 rounded-xl text-gray-700 hover:bg-gray-50">Réinitialiser</a>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Statistiques compactes -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
                    <div class="bg-gradient-to-br from-blue-50 to-indigo-50 p-5 rounded-2xl border border-blue-100">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-blue-900/80 mb-1">Total des inscriptions</p>
                                <p class="text-2xl font-bold text-blue-900">{{ $statistics['total'] }}</p>
                            </div>
                            <div class="p-3 bg-blue-100 rounded-xl">
                                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div class="bg-gradient-to-br from-green-50 to-emerald-50 p-5 rounded-2xl border border-green-100">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-green-900/80 mb-1">Billets validés</p>
                                <p class="text-2xl font-bold text-green-900">{{ $statistics['validated'] }}</p>
                            </div>
                            <div class="p-3 bg-green-100 rounded-xl">
                                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div class="bg-gradient-to-br from-cyan-50 to-blue-50 p-5 rounded-2xl border border-cyan-100">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-cyan-900/80 mb-1">Places restantes</p>
                                <p class="text-2xl font-bold text-cyan-900">{{ $statistics['remaining'] }}</p>
                            </div>
                            <div class="p-3 bg-cyan-100 rounded-xl">
                                <svg class="w-6 h-6 text-cyan-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z"/>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Statistiques paiements / transferts -->
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
                    <div class="bg-gradient-to-br from-emerald-50 to-green-50 p-5 rounded-2xl border border-emerald-100">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-emerald-900/80 mb-1">Tickets payés</p>
                                <p class="text-2xl font-bold text-emerald-900">{{ $statistics['paid_tickets'] }}</p>
                            </div>
                            <div class="p-3 bg-emerald-100 rounded-xl">
                                <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gradient-to-br from-yellow-50 to-amber-50 p-5 rounded-2xl border border-yellow-100">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-yellow-900/80 mb-1">Tickets non payés</p>
                                <p class="text-2xl font-bold text-yellow-900">{{ $statistics['unpaid_tickets'] }}</p>
                            </div>
                            <div class="p-3 bg-yellow-100 rounded-xl">
                                <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gradient-to-br from-cyan-50 to-blue-50 p-5 rounded-2xl border border-cyan-100">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-cyan-900/80 mb-1">Tickets transférés</p>
                                <p class="text-2xl font-bold text-cyan-900">{{ $statistics['transfers'] }}</p>
                            </div>
                            <div class="p-3 bg-cyan-100 rounded-xl">
                                <svg class="w-6 h-6 text-cyan-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gradient-to-br from-rose-50 to-pink-50 p-5 rounded-2xl border border-rose-100">
                        @php $rev = (int)($statistics['revenue_minor'] ?? 0); $currency = $event->currency ?? 'XOF'; @endphp
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-rose-900/80 mb-1">Revenus générés</p>
                                <p class="text-2xl font-bold text-rose-900">{{ \App\Support\Currency::format($rev, $currency) }}</p>
                            </div>
                            <div class="p-3 bg-rose-100 rounded-xl">
                                <svg class="w-6 h-6 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 1.119-3 2.5S10.343 13 12 13s3 1.119 3 2.5S13.657 18 12 18m0-10V6m0 12v-2m8-4a8 8 0 11-16 0 8 8 0 0116 0z"/></svg>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Liste des participants -->
                <div class="bg-white rounded-2xl border border-gray-200 overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50/80">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Participant</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date d'inscription</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Statut paiement</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Validation</th>
                                    <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($attendees as $registration)
                                    <tr class="hover:bg-gray-50/50 transition-colors duration-150 {{ $registration->is_validated ? 'bg-green-50/30' : '' }}">
                                        <!-- Participant -->
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0 h-10 w-10 bg-gradient-to-br from-indigo-100 to-purple-100 rounded-xl flex items-center justify-center">
                                                    <span class="text-sm font-medium text-indigo-600">
                                                        {{ substr($registration->user->name, 0, 1) }}
                                                    </span>
                                                </div>
                                                <div class="ml-4">
                                                    <div class="text-sm font-medium text-gray-900">
                                                        {{ $registration->user->name }}
                                                    </div>
                                                    <div class="text-sm text-gray-500">
                                                        {{ $registration->user->email }}
                                                    </div>
                                                </div>
                                            </div>
                                        </td>

                                        <!-- Date d'inscription -->
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">
                                                {{ $registration->created_at->isoFormat('D MMM YYYY') }}
                                            </div>
                                            <div class="text-sm text-gray-500">
                                                {{ $registration->created_at->format('H:i') }}
                                            </div>
                                        </td>

                                        <!-- Statut paiement -->
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @php $ps = $registration->payment_status; @endphp
                                            @if($ps === 'paid')
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 border border-green-200">
                                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                                    </svg>
                                                    Payé
                                                </span>
                                            @elseif($ps === 'unpaid')
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 border border-yellow-200">
                                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                                    </svg>
                                                    Non payé
                                                </span>
                                            @elseif($ps === 'pending')
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-orange-100 text-orange-800 border border-orange-200">
                                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                    </svg>
                                                    En attente
                                                </span>
                                            @elseif($ps === 'failed')
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 border border-red-200">
                                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                                    </svg>
                                                    Échec
                                                </span>
                                            @endif
                                        </td>

                                        <!-- Validation -->
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if($registration->is_validated)
                                                <div class="flex items-center">
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 border border-green-200">
                                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                                        </svg>
                                                        Validé
                                                    </span>
                                                    @if($registration->validated_at)
                                                        <span class="ml-2 text-xs text-gray-500">
                                                            {{ $registration->validated_at->diffForHumans() }}
                                                        </span>
                                                    @endif
                                                </div>
                                            @else
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800 border border-gray-200">
                                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                    </svg>
                                                    En attente
                                                </span>
                                            @endif
                                        </td>

                                        <!-- Actions -->
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <div class="flex items-center justify-end space-x-2">
                                                @if(!$registration->is_validated)
                                                    <form action="{{ route('registrations.validate', $registration) }}" method="POST" class="inline">
                                                        @csrf
                                                        <button type="submit"
                                                                class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-lg text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-200 shadow-sm hover:shadow-md">
                                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                                            </svg>
                                                            Valider
                                                        </button>
                                                    </form>
                                                @endif

                                                @can('validate', $registration)
                                                    @if($registration->payment_status === 'unpaid')
                                                        <form action="{{ route('registrations.mark_paid', $registration) }}" method="POST" class="inline">
                                                            @csrf
                                                            <button type="submit"
                                                                    class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-lg text-white bg-emerald-600 hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 transition-all duration-200 shadow-sm hover:shadow-md">
                                                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"/>
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
                                        <td colspan="5" class="px-6 py-8 text-center text-gray-500">
                                            <div class="flex flex-col items-center">
                                                <svg class="w-12 h-12 text-gray-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.75 9.75l4.5 4.5m0-4.5l-4.5 4.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                </svg>
                                                <p class="text-sm font-medium">Aucun participant pour le moment</p>
                                                <p class="text-xs text-gray-400 mt-1">Les participants apparaîtront ici une fois inscrits</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Pagination -->
                @if($attendees->hasPages())
                    <div class="mt-6 bg-white/50 backdrop-blur-sm rounded-xl p-4 border border-gray-100">
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
    document.addEventListener('DOMContentLoaded', function () {
        if (!window.Echo) {
            return;
        }

        const alertsContainer = document.getElementById('live-alerts');

        const renderAlert = (payload) => {
            if (!alertsContainer) {
                return;
            }

            const wrapper = document.createElement('div');
            wrapper.className = 'rounded-xl border border-indigo-200 bg-gradient-to-r from-indigo-50 to-blue-50 px-4 py-3 shadow-lg flex items-start gap-3 animate-fade-in';
            wrapper.innerHTML = `
                <div class="mt-0.5 text-indigo-600">
                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div class="text-sm text-indigo-900">
                    <p class="font-semibold">Billet validé en temps réel</p>
                    <p class="mt-1">
                        <span class="font-medium">${payload.attendee?.name ?? 'Participant inconnu'}</span>
                        vient d'être validé pour
                        <span class="font-medium">${payload.event?.title ?? 'Événement'}</span>.
                    </p>
                    <p class="text-xs text-indigo-600 mt-1">
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

    /* Style personnalisé pour la pagination */
    .pagination {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 0.5rem;
    }

    .pagination .page-link {
        padding: 0.5rem 0.75rem;
        border: 1px solid #e5e7eb;
        border-radius: 0.5rem;
        color: #6b7280;
        text-decoration: none;
        font-size: 0.875rem;
        font-weight: 500;
        transition: all 0.2s;
    }

    .pagination .page-link:hover {
        background-color: #f3f4f6;
        border-color: #d1d5db;
    }

    .pagination .active .page-link {
        background: linear-gradient(135deg, #3b82f6, #8b5cf6);
        border-color: #3b82f6;
        color: white;
    }
</style>
@endpush
