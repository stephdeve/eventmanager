@extends('layouts.app')

@section('title', 'Événements à venir')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl">
            <div class="p-6 sm:p-8 bg-white border-b border-gray-100">
                <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                    <div>
                        <h2 class="text-2xl sm:text-3xl font-bold text-gray-900">Événements à venir</h2>
                        <p class="mt-1 text-sm text-gray-600">Découvrez les prochains rendez-vous de la communauté.</p>
                    </div>
                    @can('create', App\Models\Event::class)
                        <a href="{{ route('events.create') }}" class="inline-flex items-center gap-2 rounded-xl bg-indigo-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v12m6-6H6"/></svg>
                            Créer un événement
                        </a>
                    @endcan
                </div>
            </div>

            @if($events->isEmpty())
                <div class="text-center py-16">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">Aucun événement à venir</h3>
                    <p class="mt-1 text-sm text-gray-500">Revenez plus tard pour découvrir de nouveaux événements.</p>
                </div>
            @else
                <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                        @foreach($events as $event)
                            @php
                                $seats = (int) ($event->available_seats ?? 0);
                                $isFree = (int) $event->price <= 0;
                            @endphp
                            <a href="{{ route('events.show', $event) }}" class="group block overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm hover:shadow-lg transition focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                <div class="relative h-44 bg-gray-100">
                                    <img src="{{ $event->cover_image_url }}" alt="{{ $event->title }}" class="absolute inset-0 w-full h-full object-cover">
                                    <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/10 to-transparent opacity-90"></div>
                                    <div class="absolute top-3 right-3">
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium {{ $seats > 0 ? 'bg-white/90 text-gray-900' : 'bg-red-600 text-white' }}">
                                            {{ $seats > 0 ? ($seats . ' places restantes') : 'Complet' }}
                                        </span>
                                    </div>
                                    <div class="absolute bottom-3 left-3 flex items-center gap-2">
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold {{ $isFree ? 'bg-emerald-500 text-white' : 'bg-indigo-600 text-white' }}">
                                            {{ $isFree ? 'Gratuit' : $event->price_for_display }}
                                        </span>
                                    </div>
                                </div>
                                <div class="p-5">
                                    <h3 class="text-base font-semibold text-gray-900 group-hover:text-indigo-700 line-clamp-1">{{ $event->title }}</h3>
                                    <p class="mt-1 text-sm text-gray-500 flex items-center gap-1">
                                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                        {{ $event->location }}
                                    </p>
                                    <p class="mt-1 text-sm text-gray-500 flex items-center gap-1">
                                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                        @if($event->start_date) {{ $event->start_date->translatedFormat('d/m/Y H\hi') }} @endif
                                    </p>
                                    <p class="mt-3 text-sm text-gray-600 line-clamp-2">{{ \Illuminate\Support\Str::limit(strip_tags($event->description), 160) }}</p>
                                    <div class="mt-4 flex items-center justify-between">
                                        <span class="text-sm font-medium text-indigo-600 group-hover:text-indigo-700">Voir les détails</span>
                                        <svg class="w-4 h-4 text-indigo-600 group-hover:text-indigo-700" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
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
