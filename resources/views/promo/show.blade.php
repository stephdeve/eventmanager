@extends('layouts.app')

@section('title', $event->title . ' — Promotion')

@section('content')
<div class="py-12">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white shadow-xl sm:rounded-3xl overflow-hidden">
            @if($event->cover_image)
                <div class="h-56 w-full overflow-hidden">
                    <img src="{{ $event->cover_image_url }}" alt="{{ $event->title }}" class="w-full h-full object-cover">
                </div>
            @endif

            <div class="px-6 py-8 sm:px-10">
                <h1 class="text-3xl font-bold text-gray-900">{{ $event->title }}</h1>
                @if($event->start_date)
                    <p class="mt-2 text-sm text-gray-600">
                        {{ $event->start_date->translatedFormat('l d F Y \à H\hi') }} — {{ $event->location }}
                    </p>
                @endif

                <div class="mt-4 text-xl font-semibold text-gray-900">
                    {{ \App\Support\Currency::format($event->price, $event->currency ?? 'XOF') }}
                </div>

                @if($event->description)
                    <p class="mt-6 text-gray-700">
                        {{ \Illuminate\Support\Str::limit(strip_tags($event->description), 200) }}
                    </p>
                @endif

                <div class="mt-8">
                    <a href="{{ route('events.show', $event) }}{{ $ref ? ('?ref=' . urlencode($ref)) : '' }}"
                       class="inline-flex items-center rounded-xl bg-indigo-600 px-5 py-3 text-sm font-semibold text-white shadow hover:bg-indigo-500">
                        En savoir plus / S’inscrire maintenant
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
