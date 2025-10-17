@extends('layouts.app')

@section('title', $event->title . ' — Promotion')

@push('meta')
    @php
        $ogTitle = $event->title;
        $ogDescription = Illuminate\Support\Str::limit(strip_tags($event->description ?? ''), 180);
        $ogImage = $event->cover_image_url;
        $ogUrl = route('promo.show', $event->slug) . ($ref ? ('?ref=' . urlencode($ref)) : '');
    @endphp
    <link rel="canonical" href="{{ $ogUrl }}">
    <meta name="description" content="{{ $ogDescription }}">
    <meta property="og:locale" content="fr_FR">
    <meta property="og:type" content="website">
    <meta property="og:title" content="{{ $ogTitle }}">
    <meta property="og:description" content="{{ $ogDescription }}">
    <meta property="og:image" content="{{ $ogImage }}">
    <meta property="og:url" content="{{ $ogUrl }}">
    <meta property="og:site_name" content="{{ config('app.name', 'EventManager') }}">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $ogTitle }}">
    <meta name="twitter:description" content="{{ $ogDescription }}">
    <meta name="twitter:image" content="{{ $ogImage }}">
@endpush

@section('content')
<div class="py-12">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white shadow-xl sm:rounded-3xl overflow-hidden">
            <div class="relative h-64 w-full overflow-hidden">
                <img src="{{ $event->cover_image_url }}" alt="{{ $event->title }}" class="w-full h-full object-cover">
                <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/40 to-transparent"></div>
                <div class="absolute bottom-0 left-0 right-0 p-6 text-white">
                    <h1 class="text-3xl font-bold">{{ $event->title }}</h1>
                </div>
            </div>

            @php
                $now = now();
                $isFull = (!$event->is_capacity_unlimited && (int) $event->available_seats <= 0);
                if ($event->end_date && $now->gt($event->end_date)) { $state = 'Terminé'; $stateClass = 'bg-gray-100 text-gray-800'; }
                elseif ($isFull) { $state = 'Complet'; $stateClass = 'bg-red-100 text-red-800'; }
                elseif ($event->start_date && $now->lt($event->start_date)) { $state = 'À venir'; $stateClass = 'bg-blue-100 text-blue-800'; }
                else { $state = 'En cours'; $stateClass = 'bg-green-100 text-green-800'; }
                $almostFull = (!$event->is_capacity_unlimited && $event->available_seats > 0 && (
                    $event->available_seats <= 5 || ($event->capacity && ($event->available_seats / max(1,$event->capacity)) <= 0.1)
                ));
            @endphp

            <div class="px-6 py-8 sm:px-10">
                <div class="flex flex-wrap gap-3 mb-4">
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold {{ $stateClass }}">{{ $state }}</span>
                    @if($event->is_capacity_unlimited)
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-green-100 text-green-800">Places illimitées</span>
                    @elseif($event->available_seats > 0)
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-green-100 text-green-800">{{ $event->available_seats }} places restantes</span>
                    @else
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-red-100 text-red-800">Complet</span>
                    @endif
                    @if($almostFull)
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-orange-100 text-orange-800">Presque complet</span>
                    @endif
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold {{ $event->price > 0 ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-800' }}">
                        {{ $event->price > 0 ? \App\Support\Currency::format($event->price, $event->currency ?? 'XOF') : 'Gratuit' }}
                    </span>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <div class="lg:col-span-2 space-y-6">
                        <div class="border rounded-xl p-4">
                            <h2 class="text-lg font-semibold text-gray-900">Détails</h2>
                            <dl class="mt-3 space-y-2 text-sm text-gray-700">
                                <div class="flex gap-2">
                                    <dt class="w-28 text-gray-500">Dates</dt>
                                    <dd class="flex-1">
                                        @if($event->start_date)
                                            {{ $event->start_date->translatedFormat('d/m/Y H\hi') }}
                                            @if($event->end_date)
                                                → {{ $event->end_date->translatedFormat('d/m/Y H\hi') }}
                                            @endif
                                        @else
                                            À confirmer
                                        @endif
                                    </dd>
                                </div>
                                <div class="flex gap-2">
                                    <dt class="w-28 text-gray-500">Lieu</dt>
                                    <dd class="flex-1">
                                        {{ $event->location }}
                                        @if($event->google_maps_url)
                                            <a class="ml-2 text-indigo-600 hover:text-indigo-700 underline" target="_blank" rel="noopener" href="{{ $event->google_maps_url }}">Voir sur Google Maps</a>
                                        @endif
                                    </dd>
                                </div>
                            </dl>
                        </div>

                        <div class="border rounded-xl p-4">
                            <h2 class="text-lg font-semibold text-gray-900">Description</h2>
                            <div class="mt-3 prose max-w-none">
                                {!! nl2br(e($event->description)) !!}
                            </div>
                        </div>

                        @if($event->start_date && now()->lt($event->start_date))
                            <div class="border rounded-xl p-4 bg-blue-50 border-blue-200">
                                <div class="text-sm font-semibold text-blue-900">Débute dans</div>
                                <div id="promo-countdown" data-start="{{ $event->start_date->toIso8601String() }}" class="mt-1 text-2xl font-bold text-blue-800">
                                    <span class="js-countdown">--j --h --m --s</span>
                                </div>
                            </div>
                        @endif

                        @if(isset($recommendedEvents) && $recommendedEvents->isNotEmpty())
                            <div class="border rounded-xl p-4">
                                <h2 class="text-lg font-semibold text-gray-900 mb-3">Événements similaires</h2>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    @foreach($recommendedEvents as $rec)
                                        <a href="{{ route('promo.show', $rec->slug) }}" class="group border rounded-lg overflow-hidden hover:shadow transition">
                                            <div class="h-32 w-full overflow-hidden bg-gray-100">
                                                <img src="{{ $rec->cover_image_url }}" alt="{{ $rec->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform">
                                            </div>
                                            <div class="p-3">
                                                <div class="font-semibold text-gray-900">{{ $rec->title }}</div>
                                                <div class="text-xs text-gray-600 mt-1">
                                                    @if($rec->start_date) {{ $rec->start_date->translatedFormat('d/m/Y H\hi') }} @endif — {{ $rec->location }}
                                                </div>
                                                <div class="mt-2 text-sm font-semibold {{ $rec->price>0 ? 'text-blue-700' : 'text-gray-700' }}">
                                                    {{ $rec->price>0 ? \App\Support\Currency::format($rec->price, $rec->currency ?? 'XOF') : 'Gratuit' }}
                                                </div>
                                            </div>
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>

                    <div>
                        <div class="border rounded-xl p-5 sticky top-6">
                            <a href="{{ route('events.show', $event) }}{{ $ref ? ('?ref=' . urlencode($ref)) : '' }}"
                               class="w-full inline-flex items-center justify-center gap-2 px-4 py-3 bg-indigo-600 text-white font-semibold rounded-lg hover:bg-indigo-700 transition-colors duration-200">
                                Participer maintenant
                            </a>
                            <p class="mt-3 text-xs text-gray-600">Vous serez redirigé vers la page officielle pour finaliser votre inscription.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const el = document.getElementById('promo-countdown');
    if (!el) return;
    const start = new Date(el.getAttribute('data-start'));
    const out = el.querySelector('.js-countdown');
    function updateCountdown() {
        const now = new Date();
        let diff = Math.max(0, start - now);
        const sec = Math.floor(diff / 1000) % 60;
        const min = Math.floor(diff / (1000*60)) % 60;
        const hr = Math.floor(diff / (1000*60*60)) % 24;
        const d = Math.floor(diff / (1000*60*60*24));
        if (out) {
            out.textContent = `${d}j ${hr}h ${min}m ${sec}s`;
        }
        if (diff > 0) setTimeout(updateCountdown, 1000);
        else el.textContent = 'En cours';
    }
    updateCountdown();
});
</script>
@endpush
@endsection
