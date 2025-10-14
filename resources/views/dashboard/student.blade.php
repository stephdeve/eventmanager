@extends('layouts.app')

@section('title', 'Tableau de bord - Étudiant')

@section('content')
<div class="space-y-6">
    <!-- En-tête -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between">
        <div>
            <div class="flex items-center">
                <h1 class="text-2xl font-bold text-gray-900">Bonjour, {{ Auth::user()->name }} 👋</h1>
                <span class="ml-2 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800">
                    Étudiant
                </span>
            </div>
            <p class="mt-1 text-sm text-gray-500">Bienvenue sur votre tableau de bord. Gérez vos inscriptions aux événements.</p>
        </div>
        <div class="mt-4 md:mt-0">
            <a href="{{ route('events.index') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-200">
                <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
                Voir tous les événements
            </a>
        </div>
    </div>

    <!-- Cartes de statistiques -->
    <div class="grid grid-cols-1 gap-5 mt-6 sm:grid-cols-2 lg:grid-cols-3">
        <!-- Prochains événements -->
        <div class="p-5 bg-white rounded-lg shadow">
            <div class="flex items-center">
                <div class="p-3 rounded-full text-blue-500 bg-blue-100">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                </div>
                <div class="ml-5">
                    <p class="text-sm font-medium text-gray-500 truncate">Événements à venir</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ $upcomingRegistrations->count() }}</p>
                </div>
            </div>
        </div>

        <!-- Événements passés -->
        <div class="p-5 bg-white rounded-lg shadow">
            <div class="flex items-center">
                <div class="p-3 rounded-full text-green-500 bg-green-100">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                </div>
                <div class="ml-5">
                    <p class="text-sm font-medium text-gray-500 truncate">Événements passés</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ $pastRegistrations->count() }}</p>
                </div>
            </div>
        </div>

        <!-- Billets -->
        <div class="p-5 bg-white rounded-lg shadow">
            <div class="flex items-center">
                <div class="p-3 rounded-full text-purple-500 bg-purple-100">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2m-8-10v2m0 4v2m0 4v2m8-14a2 2 0 012 2v14a2 2 0 01-2 2H7a2 2 0 01-2-2V5a2 2 0 012-2h10z"></path>
                    </svg>
                </div>
                <div class="ml-5">
                    <p class="text-sm font-medium text-gray-500 truncate">Billets</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ $upcomingRegistrations->count() + $pastRegistrations->count() }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Vos prochains événements -->
    <div class="mt-8">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-lg font-medium text-gray-900">Vos prochains événements</h2>
            <a href="{{ route('events.index') }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-500">Voir tout</a>
        </div>
        
        @if($upcomingRegistrations->isNotEmpty())
        <div class="bg-white shadow overflow-hidden sm:rounded-md">
            <ul class="divide-y divide-gray-200">
                @foreach($upcomingRegistrations as $registration)
                <li>
                    <div class="px-4 py-4 sm:px-6 hover:bg-gray-50">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                @php
                                    $eventDate = $registration->event->event_date ?? $registration->event->start_date;
                                @endphp
                                <div class="flex-shrink-0 h-10 w-10 rounded-full bg-indigo-100 flex items-center justify-center">
                                    <span class="text-indigo-600 font-medium">
                                        {{ $eventDate ? $eventDate->format('d') : '--' }}
                                    </span>
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-indigo-600">
                                        <a href="{{ route('events.show', $registration->event) }}" class="hover:underline">
                                            {{ $registration->event->title }}
                                        </a>
                                    </div>
                                    <div class="text-sm text-gray-500">
                                        @if($eventDate)
                                            {{ $eventDate->isoFormat('dddd D MMMM YYYY') }}
                                        @else
                                            Date à confirmer
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="ml-2 flex-shrink-0 flex
                            ">
                                <a href="{{ route('registrations.show', $registration->qr_code_data) }}" class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                    Voir le billet
                                </a>
                            </div>
                        </div>
                        <div class="mt-2 sm:flex sm:justify-between">
                            <div class="sm:flex">
                                <p class="flex items-center text-sm text-gray-500">
                                    <svg class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"></path>
                                    </svg>
                                    {{ $registration->event->location }}
                                </p>
                            </div>
                            <div class="mt-2 flex items-center text-sm text-gray-500 sm:mt-0">
                                <svg class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path>
                                </svg>
                                <p>
                                    {{ $eventDate ? $eventDate->format('H:i') : '--:--' }}
                                </p>
                            </div>
                        </div>
                    </div>
                </li>
                @endforeach
            </ul>
        </div>
        @else
        <div class="bg-white overflow-hidden shadow rounded-lg border border-gray-200">
            <div class="px-4 py-8 sm:p-8 text-center">
                <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-indigo-100">
                    <svg class="h-8 w-8 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                </div>
                <h3 class="mt-4 text-lg font-medium text-gray-900">Aucun événement à venir</h3>
                <p class="mt-2 text-sm text-gray-500">Parcourez les événements disponibles et inscrivez-vous pour commencer votre expérience.</p>
                <div class="mt-6">
                    <a href="{{ route('events.index') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-200">
                        <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
                        </svg>
                        Voir les événements
                    </a>
                </div>
            </div>
        </div>
        @endif
    </div>

    <!-- Événements recommandés -->
    @if($recommendedEvents->isNotEmpty())
    <div class="mt-12">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-xl font-semibold text-gray-900">Événements recommandés pour vous</h2>
            <a href="{{ route('events.index') }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-500 transition-colors duration-200">
                Voir tout <span aria-hidden="true">&rarr;</span>
            </a>
        </div>
        
        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
            @foreach($recommendedEvents as $event)
            <div class="bg-white overflow-hidden shadow rounded-lg border border-gray-200 hover:shadow-md transition-shadow duration-300">
                @if($event->cover_image)
                    <div class="h-40 bg-gray-200 overflow-hidden">
                        <img src="{{ asset('storage/' . $event->cover_image) }}" alt="{{ $event->title }}" class="w-full h-full object-cover">
                    </div>
                @else
                    <div class="h-40 bg-gradient-to-r from-indigo-500 to-purple-600 flex items-center justify-center">
                        <svg class="h-12 w-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                @endif
                
                <div class="p-5">
                    <div class="flex items-start justify-between">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">{{ $event->title }}</h3>
                            <p class="mt-1 text-sm text-gray-500 flex items-center">
                                <svg class="flex-shrink-0 mr-1.5 h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                {{ $event->location }}
                            </p>
                        </div>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $event->available_seats_calculated > 3 ? 'bg-green-100 text-green-800' : ($event->available_seats_calculated > 0 ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                            @if(isset($event->available_seats_calculated))
                                {{ $event->available_seats_calculated }} {{ $event->available_seats_calculated > 1 ? 'places' : 'place' }} disponible{{ $event->available_seats_calculated > 1 ? 's' : '' }}
                            @else
                                {{ $event->available_seats ?? 0 }} place{{ $event->available_seats > 1 ? 's' : '' }} disponible{{ $event->available_seats > 1 ? 's' : '' }}
                            @endif
                        </span>
                    </div>
                    
                    <div class="mt-4 flex items-center justify-between">
                        <div class="flex items-center text-sm text-gray-500">
                            <svg class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            @if($event->event_date)
                                {{ $event->event_date->format('d/m/Y H:i') }}
                            @else
                                Date non définie
                            @endif
                        </div>
                    </div>
                    
                    <div class="mt-4 flex flex-col space-y-3">
                        <a href="{{ route('events.show', $event) }}" class="w-full inline-flex justify-center items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-200">
                            En savoir plus
                            <svg class="ml-2 -mr-1 w-4 h-4" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                            </svg>
                        </a>

                        @if(auth()->check() && auth()->user()->isStudent())
                            <form action="{{ route('events.register', $event) }}" method="POST" class="w-full space-y-3">
                                @csrf

                                @if($event->is_restricted_18)
                                    <div class="flex items-start gap-2">
                                        <input type="checkbox" id="confirm_age_{{ $event->id }}" name="confirm_age" value="1" class="mt-1 h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500" required>
                                        <label for="confirm_age_{{ $event->id }}" class="text-sm text-gray-700">Je confirme avoir au moins 18 ans.</label>
                                    </div>
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
                                    </fieldset>
                                @endif

                                <button type="submit" class="w-full inline-flex justify-center items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-emerald-600 hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 transition-colors duration-200">
                                    S'inscrire à cet événement
                                    <svg class="ml-2 -mr-1 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4v16m8-8H4"></path>
                                    </svg>
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif
</div>
@endsection
