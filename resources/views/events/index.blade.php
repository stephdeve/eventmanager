@extends('layouts.app')

@section('title', 'Événements à venir')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-semibold text-gray-800">Événements à venir</h2>
                    @can('create', App\Models\Event::class)
                        <a href="{{ route('events.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring ring-indigo-300 disabled:opacity-25 transition ease-in-out duration-150">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            Créer un événement
                        </a>
                    @endcan
                </div>

                @if($events->isEmpty())
                    <div class="text-center py-12">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">Aucun événement à venir</h3>
                        <p class="mt-1 text-sm text-gray-500">Revenez plus tard pour voir les prochains événements.</p>
                    </div>
                @else
                    <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                        @foreach($events as $event)
                            <a href="{{ route('events.show', $event) }}" class="block border rounded-lg overflow-hidden shadow-sm hover:shadow-md transition-shadow duration-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                @if($event->cover_image)
                                    <div class="h-48 bg-gray-200 overflow-hidden">
                                        <img src="{{ asset('storage/' . $event->cover_image) }}" alt="{{ $event->title }}" class="w-full h-full object-cover">
                                    </div>
                                @else
                                    <div class="h-48 bg-gradient-to-r from-indigo-500 to-purple-600 flex items-center justify-center">
                                        <svg class="h-16 w-16 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                    </div>
                                @endif
                                
                                <div class="p-6">
                                    <div class="flex justify-between items-start">
                                        <div>
                                            <h3 class="text-lg font-semibold text-gray-900">{{ $event->title }}</h3>
                                            <p class="mt-1 text-sm text-gray-500">
                                                <svg class="inline-block w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                </svg>
                                                {{ $event->location }}
                                            </p>
                                        </div>
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800">
                                            {{ $event->available_seats - $event->registrations_count }} places restantes
                                        </span>
                                    </div>
                                    
                                    <p class="mt-3 text-sm text-gray-600 line-clamp-2">
                                        {{ $event->description }}
                                    </p>
                                    
                                    <div class="mt-4 flex items-center justify-between">
                                        <div class="flex items-center text-sm text-gray-500">
                                            <svg class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                            </svg>
                                            {{ $event->start_date->format('d/m/Y H:i') }}
                                        </div>
                                        <span class="text-sm font-medium text-indigo-600 hover:text-indigo-500 inline-flex items-center">
                                            Voir les détails →
                                        </span>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                    
                    <div class="mt-6">
                        {{ $events->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
