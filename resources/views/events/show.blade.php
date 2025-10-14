@extends('layouts.app')

@section('title', $event->title)

@section('content')
<div class="py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- En-tête avec bouton de retour -->
        <div class="mb-6">
            <a href="{{ route('events.index') }}" class="inline-flex items-center text-indigo-600 hover:text-indigo-900">
                <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Retour aux événements
            </a>
        </div>

        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <!-- Image de couverture -->
            @if($event->cover_image)
                <div class="h-64 w-full overflow-hidden">
                    <img src="{{ asset('storage/' . $event->cover_image) }}" alt="{{ $event->title }}" class="w-full h-full object-cover">
                </div>
            @endif

            <div class="p-6">
                <div class="flex flex-col md:flex-row md:items-start md:justify-between">
                    <div class="flex-1">
                        <h1 class="text-3xl font-bold text-gray-900">{{ $event->title }}</h1>
                        
                        <div class="mt-4 flex items-center text-sm text-gray-500">
                            <svg class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            {{ $event->location }}
                        </div>

                        <div class="mt-2 flex items-center text-sm text-gray-500">
                            <svg class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            @if($event->event_date)
                                {{ $event->event_date->format('l d F Y \à H\hi') }}
                            @else
                                Date non définie
                            @endif
                        </div>

                        @if($event->end_date)
                        <div class="mt-1 flex items-center text-sm text-gray-500">
                            <svg class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Durée : {{ $event->start_date->diffInHours($event->end_date) }} heures
                        </div>
                        @endif

                        <div class="mt-4">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $event->available_seats > 0 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                @if($event->available_seats > 0)
                                    {{ $event->available_seats }} place{{ $event->available_seats > 1 ? 's' : '' }} disponible{{ $event->available_seats > 1 ? 's' : '' }}
                                @else
                                    Complet
                                @endif
                            </span>
                            
                            <span class="ml-2 inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                                {{ $event->price > 0 ? number_format($event->price / 100, 2, ',', ' ') . ' €' : 'Gratuit' }}
                            </span>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="mt-6 md:mt-0 md:ml-6 space-y-4">
                        @if(auth()->check() && (auth()->user()->can('update', $event) || auth()->user()->can('delete', $event)))
                            <div class="flex flex-wrap gap-2">
                                @can('update', $event)
                                    <a href="{{ route('events.edit', $event) }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                        Modifier l'événement
                                    </a>
                                @endcan

                                @can('delete', $event)
                                    <div x-data="{ isOpen: false }" class="relative">
                                        <form x-ref="deleteForm" action="{{ route('events.destroy', $event) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" @click="isOpen = true" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                                Supprimer l'événement
                                            </button>
                                        </form>

                                        <div x-show="isOpen" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/60 px-4">
                                            <div x-show="isOpen" x-transition class="w-full max-w-md rounded-2xl bg-white p-6 shadow-2xl">
                                                <div class="flex items-start gap-3">
                                                    <div class="flex h-10 w-10 items-center justify-center rounded-full bg-red-100 text-red-600">
                                                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 9v4m0 4h.01M12 5a7 7 0 017 7c0 3.866-3.134 7-7 7s-7-3.134-7-7 3.134-7 7-7z" />
                                                        </svg>
                                                    </div>
                                                    <div class="space-y-2">
                                                        <h3 class="text-lg font-semibold text-slate-900">Confirmer la suppression</h3>
                                                        <p class="text-sm text-slate-600">Cette action supprimera définitivement l'événement « {{ $event->title }} » ainsi que toutes ses inscriptions associées. Voulez-vous continuer ?</p>
                                                    </div>
                                                </div>

                                                <div class="mt-6 flex flex-col gap-2 sm:flex-row sm:justify-end">
                                                    <button type="button" @click="isOpen = false" class="inline-flex items-center justify-center rounded-xl border border-slate-200 px-4 py-2 text-sm font-semibold text-slate-600 transition hover:bg-slate-50">Annuler</button>
                                                    <button type="button" @click="$refs.deleteForm.submit()" class="inline-flex items-center justify-center rounded-xl bg-red-600 px-4 py-2 text-sm font-semibold text-white shadow hover:bg-red-500">Supprimer définitivement</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endcan
                            </div>
                        @endif

                        @if(auth()->check() && auth()->user()->isStudent())
                            @if($event->attendees->contains(auth()->id()))
                                <form action="{{ route('events.cancel-registration', $event) }}" method="POST" class="inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                        <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                        Annuler l'inscription
                                    </button>
                                </form>
                            @elseif($event->available_seats > 0 && optional($event->event_date)->isFuture())
                                <form action="{{ route('events.register', $event) }}" method="POST" class="inline-block space-y-3">
                                    @csrf

                                    @if($event->is_restricted_18)
                                        <div class="flex items-start gap-2">
                                            <input type="checkbox" id="confirm_age" name="confirm_age" value="1" class="mt-1 h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500" required>
                                            <label for="confirm_age" class="text-sm text-gray-700">Je confirme avoir au moins 18 ans.</label>
                                        </div>
                                        @error('confirm_age')
                                            <p class="text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    @endif

                                    @if(($event->price ?? 0) > 0)
                                        <fieldset class="border border-gray-200 rounded-lg p-3">
                                            <legend class="text-sm font-medium text-gray-700">Mode de paiement</legend>
                                            <div class="mt-2 space-y-2">
                                                <label class="flex items-center gap-2 text-sm text-gray-700">
                                                    <input type="radio" name="payment_method" value="kkiapay" class="h-4 w-4 text-indigo-600 border-gray-300 focus:ring-indigo-500" checked required>
                                                    Payer maintenant (Kkiapay)
                                                </label>
                                                <label class="flex items-center gap-2 text-sm text-gray-700">
                                                    <input type="radio" name="payment_method" value="physical" class="h-4 w-4 text-indigo-600 border-gray-300 focus:ring-indigo-500" required>
                                                    Payer sur place le jour de l'événement
                                                </label>
                                            </div>
                                            @error('payment_method')
                                                <p class="text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </fieldset>
                                    @endif

                                    <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                        <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                                        </svg>
                                        S'inscrire
                                    </button>
                                </form>
                            @else
                                <button disabled class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-gray-400 cursor-not-allowed">
                                    Inscription non disponible
                                </button>
                            @endif
                        @elseif(!auth()->check())
                            <a href="{{ route('login') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Connectez-vous pour vous inscrire
                            </a>
                        @endif
                    </div>
                </div>

                <!-- Description -->
                <div class="mt-8">
                    <h2 class="text-lg font-medium text-gray-900">Description</h2>
                    <div class="mt-2 prose max-w-none">
                        {!! nl2br(e($event->description)) !!}
                    </div>
                </div>

                <!-- Organisateur -->
                <div class="mt-8 pt-6 border-top border-gray-200"></div>

                <div class="mt-8 pt-6 border-t border-gray-200">
                    <h2 class="text-lg font-medium text-gray-900">Organisé par</h2>
                    <div class="mt-2 flex items-center">
                        <div class="flex-shrink-0">
                            <svg class="h-10 w-10 text-gray-400" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 14.016q2.531 0 5.273 1.102t2.742 2.883v2.016h-16.031v-2.016q0-1.781 2.742-2.883t5.273-1.102zM12 12q-1.641 0-2.813-1.172t-1.172-2.813 1.172-2.836 2.813-1.195 2.813 1.195 1.172 2.836-1.172 2.813-2.813 1.172z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-900">{{ $event->organizer->name }}</p>
                            <p class="text-sm text-gray-500">Organisateur</p>
                        </div>
                    </div>
                </div>

                @can('viewAttendees', $event)
                    <div class="mt-10">
                        <div class="flex items-center justify-between">
                            <h2 class="text-lg font-medium text-gray-900">Participants</h2>
                            <a href="{{ route('events.attendees', $event) }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-500">
                                Gérer les inscrits →
                            </a>
                        </div>

                        @if($event->attendees->isNotEmpty())
                            <div class="mt-4 grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">
                                @foreach($event->attendees->take(6) as $attendee)
                                    <div class="bg-gray-50 p-4 rounded-lg flex items-center">
                                        <div class="flex-shrink-0">
                                            <svg class="h-10 w-10 text-gray-400" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M12 14.016q2.531 0 5.273 1.102t2.742 2.883v2.016h-16.031v-2.016q0-1.781 2.742-2.883t5.273-1.102zM12 12q-1.641 0-2.813-1.172t-1.172-2.813 1.172-2.836 2.813-1.195 2.813 1.195 1.172 2.836-1.172 2.813-2.813 1.172z"></path>
                                            </svg>
                                        </div>
                                        <div class="ml-3">
                                            <p class="text-sm font-medium text-gray-900">{{ $attendee->name }}</p>
                                            <p class="text-sm text-gray-500">Inscrit le {{ $attendee->pivot->created_at->format('d/m/Y') }}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="mt-2 text-sm text-gray-500">Aucun participant pour le moment.</p>
                        @endif
                    </div>
                @endcan
            </div>
        </div>
    </div>
</div>
@endsection
