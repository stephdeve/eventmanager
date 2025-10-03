@extends('layouts.app')

@section('title', 'Liste des participants - ' . $event->title)

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div id="live-alerts" class="space-y-3 mb-4 hidden">
            <!-- Alerts injected by Echo -->
        </div>

        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <div class="flex justify-between items-center mb-6">
                    <h1 class="text-2xl font-semibold text-gray-900">
                        Participants - {{ $event->title }}
                    </h1>
                    <div class="space-x-2">
                        <a href="{{ route('events.show', $event) }}" class="inline-flex items-center px-4 py-2 bg-gray-100 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Retour à l'événement
                        </a>
                        <a href="{{ route('scanner') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Scanner un billet
                        </a>
                    </div>
                </div>

                <!-- Statistiques -->
                <div class="bg-gray-50 p-4 rounded-lg mb-6">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="bg-white p-4 rounded-lg shadow">
                            <div class="text-sm font-medium text-gray-500">Total des inscriptions</div>
                            <div class="mt-1 text-3xl font-semibold text-gray-900">{{ $statistics['total'] }}</div>
                        </div>
                        <div class="bg-white p-4 rounded-lg shadow">
                            <div class="text-sm font-medium text-gray-500">Billets validés</div>
                            <div class="mt-1 text-3xl font-semibold text-green-600">
                                {{ $statistics['validated'] }}
                            </div>
                        </div>
                        <div class="bg-white p-4 rounded-lg shadow">
                            <div class="text-sm font-medium text-gray-500">Places restantes</div>
                            <div class="mt-1 text-3xl font-semibold text-blue-600">
                                {{ $statistics['remaining'] }}
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Liste des participants -->
                <div class="bg-white shadow overflow-hidden sm:rounded-md">
                    <ul class="divide-y divide-gray-200">
                        @forelse($attendees as $registration)
                            <li class="{{ $registration->is_validated ? 'bg-green-50' : '' }}">
                                <div class="px-4 py-4 flex items-center sm:px-6">
                                    <div class="min-w-0 flex-1 sm:flex sm:items-center sm:justify-between">
                                        <div class="truncate">
                                            <div class="flex text-sm">
                                                <p class="font-medium text-indigo-600 truncate">
                                                    {{ $registration->user->name }}
                                                </p>
                                                <p class="ml-1 flex-shrink-0 font-normal text-gray-500">
                                                    &middot; {{ $registration->user->email }}
                                                </p>
                                            </div>
                                            <div class="mt-2 flex">
                                                <div class="flex items-center text-sm text-gray-500">
                                                    <p>
                                                        Inscrit le 
                                                        <time datetime="{{ $registration->created_at->toDateTimeString() }}">
                                                            {{ $registration->created_at->isoFormat('D MMMM YYYY à HH:mm') }}
                                                        </time>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mt-4 flex-shrink-0 sm:mt-0 sm:ml-5">
                                            <div class="flex items-center space-x-2">
                                                @if($registration->is_validated)
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                        Validé
                                                    </span>
                                                    <span class="text-sm text-gray-500">
                                                        @if($registration->validated_at)
                                                            {{ $registration->validated_at->diffForHumans() }}
                                                        @else
                                                            Validation en cours
                                                        @endif
                                                    </span>
                                                @else
                                                    <form action="{{ route('registrations.validate', $registration) }}" method="POST" class="inline">
                                                        @csrf
                                                        <button type="submit" class="px-3 py-1 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                                            Valider l'entrée
                                                        </button>
                                                    </form>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="ml-5 flex-shrink-0">
                                        <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                </div>
                            </li>
                        @empty
                            <li class="py-4 text-center text-gray-500">
                                Aucun participant pour le moment.
                            </li>
                        @endforelse
                    </ul>
                </div>

                <!-- Pagination -->
                @if($attendees->hasPages())
                    <div class="mt-4">
                        {{ $attendees->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
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
                wrapper.className = 'rounded-lg border border-indigo-100 bg-indigo-50 px-4 py-3 shadow-sm flex items-start gap-3 animate-fade-in';
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
@endpush
@endsection
