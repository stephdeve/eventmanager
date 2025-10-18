@extends('layouts.app')

@section('title', $event->title)

@push('meta')
    @php
        $ogTitle = $event->title;
        $ogDescription = \Illuminate\Support\Str::limit(strip_tags($event->description ?? ''), 180);
        $ogImage = $event->cover_image_url;
        $ogUrl = route('events.show', $event);
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
<div class="min-h-screen py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Bouton de retour -->
        <div class="mb-6">
            <a href="{{ route('events.index') }}"
               class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 hover:border-gray-400 transition-all duration-200 shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Retour aux événements
            </a>
        </div>

        <!-- Carte principale -->
        <div class="bg-white rounded-2xl shadow-lg border border-gray-200 overflow-hidden">
            <!-- Section Hero -->
            <div class="relative h-80 bg-gray-900">
                <img src="{{ $event->cover_image_url }}"
                     alt="{{ $event->title }}"
                     class="w-full h-full object-cover">
                <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/40 to-transparent"></div>

                <div class="absolute bottom-0 left-0 right-0 p-8">
                    <h1 class="text-4xl font-bold text-white mb-4">{{ $event->title }}</h1>

                    <div class="flex flex-wrap items-center gap-6 text-white/90">
                        <div class="flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            <span class="font-medium">
                                @if($event->start_date)
                                    {{ $event->start_date->translatedFormat('d M Y, H\\hi') }}
                                @endif
                            </span>
                        </div>


                        <div class="flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            <span class="font-medium">
                                {{ $event->location }}
                                @if($event->google_maps_url)
                                    <a href="{{ $event->google_maps_url }}" target="_blank" rel="noopener" class="ml-3 underline decoration-white/40 hover:decoration-white">Voir sur Google Maps</a>
                                @endif
                            </span>
                        </div>

                        <div class="flex items-center gap-2 font-semibold">
                            <span>{{ \App\Support\Currency::format($event->price, $event->currency ?? 'XOF') }}</span>
                        </div>

                        @if($event->start_date && now()->lt($event->start_date))
                            <div id="countdown" data-start="{{ $event->start_date->toIso8601String() }}" class="mt-6 inline-flex items-center gap-3 px-4 py-2 rounded-lg bg-white/10 text-white backdrop-blur-sm">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <span class="text-sm font-semibold">Débute dans</span>
                                <span class="js-countdown text-lg font-bold"></span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="p-8">
                <!-- Grille principale -->
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <!-- Contenu principal -->
                    <div class="lg:col-span-2 space-y-8">
                        <!-- Badges -->
                        <div class="flex flex-wrap gap-3">
                            <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-semibold {{ ($event->is_capacity_unlimited || $event->available_seats > 0) ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                @if($event->is_capacity_unlimited)
                                    Places illimitées
                                @elseif($event->available_seats > 0)
                                    {{ $event->available_seats }} place{{ $event->available_seats > 1 ? 's' : '' }} disponible{{ $event->available_seats > 1 ? 's' : '' }}
                                @else
                                    Complet
                                @endif
                            </span>

                            <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-semibold {{ $event->price > 0 ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-800' }}">
                                {{ $event->price > 0 ? \App\Support\Currency::format($event->price, $event->currency) : 'Gratuit' }}
                            </span>

                            @php
                                $now = now();
                                $isFull = (!$event->is_capacity_unlimited && (int) $event->available_seats <= 0);
                                if ($event->end_date && $now->gt($event->end_date)) {
                                    $state = 'Terminé';
                                    $stateClass = 'bg-gray-100 text-gray-800';
                                } elseif ($isFull) {
                                    $state = 'Complet';
                                    $stateClass = 'bg-red-100 text-red-800';
                                } elseif ($event->start_date && $now->lt($event->start_date)) {
                                    $state = 'À venir';
                                    $stateClass = 'bg-blue-100 text-blue-800';
                                } else {
                                    $state = 'En cours';
                                    $stateClass = 'bg-green-100 text-green-800';
                                }
                            @endphp
                            <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-semibold {{ $stateClass }}">{{ $state }}</span>

                            @if($event->is_restricted_18)
                                <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-semibold bg-amber-100 text-amber-800">
                                    +18
                                </span>
                            @endif

                            @if($event->end_date)
                                <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-semibold bg-purple-100 text-purple-800">
                                    Durée : {{ $event->start_date->diffInHours($event->end_date) }}h
                                </span>
                            @endif
                        </div>

                        <!-- Description -->
                        <div>
                            <h2 class="text-2xl font-bold text-gray-900 mb-4">Description</h2>
                            <div class="prose prose-lg max-w-none text-gray-700 leading-relaxed p-6 border rounded-xl bg-gray-50">
                                {!! nl2br(e($event->description)) !!}
                            </div>
                        </div>

                        @if(isset($recommendedEvents) && $recommendedEvents->isNotEmpty())
                            <div class="pt-6 border-t border-gray-200">
                                <h2 class="text-2xl font-bold text-gray-900 mb-4">Événements similaires</h2>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    @foreach($recommendedEvents as $rec)
                                        <a href="{{ route('events.show', $rec) }}" class="group block border border-gray-200 rounded-xl overflow-hidden hover:border-gray-300 hover:shadow transition">
                                            <div class="w-full bg-gray-100">
                                                <div class="w-full aspect-[16/9] overflow-hidden">
                                                    <img src="{{ $rec->cover_image_url }}" alt="{{ $rec->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                                </div>
                                            </div>
                                            <div class="p-4">
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

                        <!-- Organisateur -->
                        <div class="pt-6 border-t border-gray-200">
                            <h2 class="text-2xl font-bold text-gray-900 mb-4">Organisateur</h2>
                            <div class="bg-gray-50 rounded-xl px-5 py-4 border border-gray-200">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0">
                                        <div class="w-16 h-16 bg-gradient-to-r from-blue-600 to-purple-600 rounded-full flex items-center justify-center">
                                            <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M12 14.016q2.531 0 5.273 1.102t2.742 2.883v2.016h-16.031v-2.016q0-1.781 2.742-2.883t5.273-1.102zM12 12q-1.641 0-2.813-1.172t-1.172-2.813 1.172-2.836 2.813-1.195 2.813 1.195 1.172 2.836-1.172 2.813-2.813 1.172z"/>
                                            </svg>
                                        </div>
                                    </div>
                                    <div class="ml-6">
                                        <h3 class="text-xl font-semibold text-gray-900">{{ $event->organizer->name }}</h3>
                                        <p class="text-gray-600">Organisateur de l'événement</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Participants -->
                        @can('viewAttendees', $event)
                            <div class="pt-6 border-t border-gray-200">
                                <div class="flex items-center justify-between mb-6">
                                    <h2 class="text-2xl font-bold text-gray-900">Participants</h2>
                                    <a href="{{ route('events.attendees', $event) }}"
                                       class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 transition-colors duration-200">
                                        Gérer les inscrits
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                        </svg>
                                    </a>
                                </div>

                                @if($event->attendees->isNotEmpty())
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        @foreach($event->attendees->take(4) as $attendee)
                                            <div class="bg-white border border-gray-200 rounded-xl p-4 hover:border-gray-300 transition-colors duration-200">
                                                <div class="flex items-center">
                                                    <div class="flex-shrink-0">
                                                        <div class="w-12 h-12 bg-gradient-to-r from-blue-100 to-purple-100 rounded-full flex items-center justify-center">
                                                            <svg class="w-6 h-6 text-blue-600" fill="currentColor" viewBox="0 0 24 24">
                                                                <path d="M12 14.016q2.531 0 5.273 1.102t2.742 2.883v2.016h-16.031v-2.016q0-1.781 2.742-2.883t5.273-1.102zM12 12q-1.641 0-2.813-1.172t-1.172-2.813 1.172-2.836 2.813-1.195 2.813 1.195 1.172 2.836-1.172 2.813-2.813 1.172z"/>
                                                            </svg>
                                                        </div>
                                                    </div>
                                                    <div class="ml-4 flex-1">
                                                        <h4 class="text-sm font-semibold text-gray-900">{{ $attendee->name }}</h4>
                                                        <p class="text-xs text-gray-600">Inscrit le {{ $attendee->pivot->created_at->translatedFormat('d/m/Y') }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>

                                    @if($event->attendees->count() > 4)
                                        <div class="mt-6 text-center">
                                            <a href="{{ route('events.attendees', $event) }}"
                                               class="text-blue-600 font-semibold hover:text-blue-700 transition-colors duration-200">
                                                Voir les {{ $event->attendees->count() - 4 }} autres participants...
                                            </a>
                                        </div>
                                    @endif
                                @else
                                    <div class="text-center py-12">
                                        <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                        </svg>
                                        <p class="text-gray-600">Aucun participant pour le moment.</p>
                                    </div>
                                @endif
                            </div>
                        @endcan

                        <!-- Avis des participants -->
                        <div class="pt-6 border-t border-gray-200">
                            <div class="flex items-center justify-between mb-4">
                                <h2 class="text-2xl font-bold text-gray-900">Avis des participants</h2>
                                @if(isset($avgRating) && $avgRating > 0)
                                    <div class="flex items-center gap-2 text-yellow-600">
                                        <span class="font-semibold">{{ number_format($avgRating, 1) }}/5</span>
                                        <span>
                                            @for($i=1;$i<=5;$i++)
                                                @if($i <= floor($avgRating))
                                                    ★
                                                @else
                                                    ☆
                                                @endif
                                            @endfor
                                        </span>
                                    </div>
                                @endif
                            </div>

                            @if(isset($reviews) && $reviews->isNotEmpty())
                                <div class="space-y-4">
                                    @foreach($reviews as $review)
                                        <div class="border border-gray-200 rounded-lg p-4">
                                            <div class="flex items-center justify-between">
                                                <div class="text-sm font-semibold text-gray-900">{{ optional($review->user)->name ?? 'Participant' }}</div>
                                                <div class="text-yellow-600">
                                                    @for($i=1;$i<=5;$i++)
                                                        @if($i <= (int) $review->rating)★@else☆@endif
                                                    @endfor
                                                </div>
                                            </div>
                                            <p class="mt-2 text-sm text-gray-700">{{ $review->comment }}</p>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <p class="text-gray-600 text-sm">Aucun avis pour le moment.</p>
                            @endif

                            @if(isset($canReview) && $canReview)
                                <div class="mt-6 border border-gray-200 rounded-lg p-4">
                                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Laisser un avis</h3>
                                    <form method="POST" action="{{ route('events.reviews.store', $event) }}" class="space-y-3">
                                        @csrf
                                        <div>
                                            <label for="rating" class="block text-sm font-medium text-gray-700">Note</label>
                                            <select id="rating" name="rating" class="mt-1 w-32 rounded-md border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                                                @for($i=5;$i>=1;$i--)
                                                    <option value="{{ $i }}">{{ $i }} / 5</option>
                                                @endfor
                                            </select>
                                            @error('rating')<p class="text-sm text-red-600">{{ $message }}</p>@enderror
                                        </div>
                                        <div>
                                            <label for="comment" class="block text-sm font-medium text-gray-700">Commentaire</label>
                                            <textarea id="comment" name="comment" rows="3" class="mt-1 w-full rounded-md border-gray-300 focus:border-blue-500 focus:ring-blue-500" placeholder="Partagez votre expérience..."></textarea>
                                            @error('comment')<p class="text-sm text-red-600">{{ $message }}</p>@enderror
                                        </div>
                                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white font-semibold rounded-md hover:bg-blue-700">Envoyer</button>
                                    </form>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Sidebar avec actions -->
                    <div class="space-y-6">
                        <!-- Actions administrateur -->
                        @if(auth()->check() && (auth()->user()->can('update', $event) || auth()->user()->can('delete', $event)))
                            <div class="bg-white border border-gray-200 rounded-xl p-6">
                                <h3 class="text-lg font-semibold text-gray-900 mb-4">Gestion</h3>
                                <div class="space-y-3">
                                    @can('update', $event)
                                        <a href="{{ route('events.edit', $event) }}"
                                           class="w-full inline-flex items-center justify-center gap-2 px-4 py-3 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition-colors duration-200">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                            </svg>
                                            Modifier l'événement
                                        </a>
                                    @endcan

                                    @can('delete', $event)
                                        <button onclick="openDeleteModal()"
                                                class="w-full inline-flex items-center justify-center gap-2 px-4 py-3 bg-white border border-red-300 text-red-700 font-semibold rounded-lg hover:bg-red-50 transition-colors duration-200">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                            Supprimer l'événement
                                        </button>
                                    @endcan
                                </div>

                                <!-- Section lien de promotion -->
                                @can('update', $event)
                                    <div class="mt-6 pt-6 border-t border-gray-200">
                                        <h4 class="text-sm font-semibold text-gray-900 mb-3">Lien de promotion</h4>
                                        @php
                                            $plan = optional(auth()->user())->subscription_plan;
                                            $eligible = in_array($plan, ['premium','pro'], true);
                                        @endphp
                                        @if($eligible)
                                            @if($event->shareable_link)
                                                <div class="space-y-3">
                                                    <div class="flex gap-2">
                                                        <input type="text"
                                                               readonly
                                                               value="{{ $event->shareable_link }}"
                                                               class="flex-1 px-3 py-2 border border-gray-300 rounded-lg text-sm">
                                                        <button type="button"
                                                                onclick="copyToClipboard('{{ $event->shareable_link }}', this)"
                                                                class="px-4 py-2 bg-blue-600 text-white text-sm font-semibold rounded-lg hover:bg-blue-700 transition-colors duration-200">
                                                            Copier
                                                        </button>
                                                    </div>
                                                    <div class="flex gap-4 text-xs text-gray-600">
                                                        <span>Clics: <strong>{{ (int) $event->promo_clicks }}</strong></span>
                                                        <span>Inscriptions: <strong>{{ (int) $event->promo_registrations }}</strong></span>
                                                    </div>
                                                </div>
                                            @else
                                                <form method="POST" action="{{ route('events.generate-share', $event) }}">
                                                    @csrf
                                                    <button type="submit"
                                                            class="w-full px-4 py-3 bg-green-600 text-white font-semibold rounded-lg hover:bg-green-700 transition-colors duration-200">
                                                        Générer le lien de promotion
                                                    </button>
                                                </form>
                                            @endif
                                        @else
                                            <div class="text-center">
                                                <p class="text-sm text-gray-600 mb-3">Fonctionnalité réservée aux abonnements Premium et Pro.</p>
                                                <a href="{{ route('subscriptions.plans') }}"
                                                   class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-semibold rounded-lg hover:bg-blue-700 transition-colors duration-200">
                                                    Voir les offres
                                                </a>
                                            </div>
                                        @endif
                                    </div>
                                @endcan
                            </div>
                        @endif

                        <!-- Actions utilisateur -->
                        <div class="bg-white border border-gray-200 rounded-xl p-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Participation</h3>

                            @if(auth()->check() && auth()->user()->isStudent())
                                @if($event->attendees->contains(auth()->id()))
                                    <form action="{{ route('events.cancel-registration', $event) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="w-full inline-flex items-center justify-center gap-2 px-4 py-3 bg-red-600 text-white font-semibold rounded-lg hover:bg-red-700 transition-colors duration-200">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                            </svg>
                                            Annuler l'inscription
                                        </button>
                                    </form>
                                @endif

                                @if(($event->is_capacity_unlimited || $event->available_seats > 0) && (!$event->end_date || now()->lt($event->end_date)))
                                    <form action="{{ route('events.register', $event) }}" method="POST" class="space-y-4 mt-4">
                                        @csrf
                                        @if(request()->filled('ref'))
                                            <input type="hidden" name="ref" value="{{ request('ref') }}">
                                        @endif

                                        @if($event->is_restricted_18)
                                            <div class="bg-amber-50 border border-amber-200 rounded-lg p-4">
                                                <label class="flex items-start gap-3 cursor-pointer">
                                                    <input type="checkbox"
                                                           id="confirm_age"
                                                           name="confirm_age"
                                                           value="1"
                                                           class="mt-1 w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500"
                                                           required>
                                                    <div>
                                                        <span class="block text-sm font-semibold text-amber-900">Je confirme avoir au moins 18 ans</span>
                                                        <span class="block text-xs text-amber-700 mt-1">Une vérification d'identité pourra être demandée sur place</span>
                                                    </div>
                                                </label>
                                            </div>
                                            @error('confirm_age')
                                                <p class="text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        @endif

                                        <div>
                                            <label for="quantity" class="block text-sm font-medium text-gray-900">Quantité</label>
                                            <input type="number"
                                                   id="quantity"
                                                   name="quantity"
                                                   value="1"
                                                   min="1"
                                                   @if(!$event->is_capacity_unlimited) max="{{ (int) $event->available_seats }}" @endif
                                                   class="mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                        </div>

                                        @if(($event->price ?? 0) > 0)
                                            <fieldset class="border border-gray-200 rounded-lg p-4">
                                                <legend class="text-sm font-semibold text-gray-900 px-2">Mode de paiement</legend>
                                                <div class="mt-3 space-y-3">
                                                    @if($event->allow_payment_numeric)
                                                    <label class="flex items-center gap-3 p-3 rounded-lg border-2 border-transparent hover:border-blue-200 cursor-pointer transition-colors duration-200">
                                                        <input type="radio"
                                                               name="payment_method"
                                                               value="kkiapay"
                                                               class="w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500"
                                                               required>
                                                        <div>
                                                            <span class="block text-sm font-medium text-gray-900">Payer maintenant</span>
                                                            <span class="block text-xs text-gray-600">Paiement sécurisé via Kkiapay</span>
                                                        </div>
                                                    </label>
                                                    @endif
                                                    @if($event->allow_payment_physical)
                                                    <label class="flex items-center gap-3 p-3 rounded-lg border-2 border-transparent hover:border-blue-200 cursor-pointer transition-colors duration-200">
                                                        <input type="radio"
                                                               name="payment_method"
                                                               value="physical"
                                                               class="w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500"
                                                               required>
                                                        <div>
                                                            <span class="block text-sm font-medium text-gray-900">Payer sur place</span>
                                                            <span class="block text-xs text-gray-600">Le jour de l'événement</span>
                                                        </div>
                                                    </label>
                                                    @endif
                                                </div>
                                                @error('payment_method')
                                                    <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                                                @enderror
                                            </fieldset>
                                        @endif

                                        <button type="submit"
                                                class="w-full inline-flex items-center justify-center gap-2 px-4 py-3 bg-green-600 text-white font-semibold rounded-lg hover:bg-green-700 transition-colors duration-200">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                                            </svg>
                                            Acheter des billets
                                        </button>
                                    </form>
                                @else
                                    <button disabled
                                            class="w-full px-4 py-3 bg-gray-300 text-gray-500 font-semibold rounded-lg cursor-not-allowed mt-4">
                                        Inscription non disponible
                                    </button>
                                @endif
                            @elseif(!auth()->check())
                                <a href="{{ route('login') }}"
                                   class="w-full inline-flex items-center justify-center gap-2 px-4 py-3 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition-colors duration-200">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                                    </svg>
                                    Se connecter pour s'inscrire
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal de confirmation de suppression -->
@can('delete', $event)
<div id="deleteModal" class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity z-50 hidden">
    <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center w-full mx-auto  sm:p-0">
        <div class="relative transform overflow-hidden rounded-lg bg-white px-4 pb-4 pt-5 text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg sm:p-6">
            <div class="sm:flex sm:items-start">
                <div class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                    <svg class="h-6 w-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.35 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                    </svg>
                </div>
                <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left">
                    <h3 class="text-lg font-semibold text-gray-900">Confirmer la suppression</h3>
                    <div class="mt-2">
                        <p class="text-sm text-gray-600">
                            Cette action supprimera définitivement l'événement « {{ $event->title }} » ainsi que toutes ses inscriptions associées. Voulez-vous continuer ?
                        </p>
                    </div>
                </div>
            </div>
            <div class="mt-5 sm:mt-4 sm:flex sm:flex-row-reverse">
                <form action="{{ route('events.destroy', $event) }}" method="POST" class="inline-block">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                            class="inline-flex w-full justify-center rounded-md bg-red-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-500 sm:ml-3 sm:w-auto">
                        Supprimer définitivement
                    </button>
                </form>
                <button onclick="closeDeleteModal()"
                        type="button"
                        class="mt-3 inline-flex w-full justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto">
                    Annuler
                </button>
            </div>
        </div>
    </div>
</div>
@endcan
@endsection

@push('scripts')
<script>
function copyToClipboard(text, btn) {
    if (navigator.clipboard && navigator.clipboard.writeText) {
        navigator.clipboard.writeText(text).then(function() {
            const button = btn;
            const originalText = button.textContent;
            button.textContent = 'Copié !';
            button.classList.remove('bg-blue-600', 'hover:bg-blue-700');
            button.classList.add('bg-green-600', 'hover:bg-green-700');

            setTimeout(() => {
                button.textContent = originalText;
                button.classList.remove('bg-green-600', 'hover:bg-green-700');
                button.classList.add('bg-blue-600', 'hover:bg-blue-700');
            }, 2000);
        }).catch(fallbackCopy);
    } else {
        fallbackCopy();
    }

    function fallbackCopy(err) {
        try {
            const ta = document.createElement('textarea');
            ta.value = text;
            ta.style.position = 'fixed';
            ta.style.top = '-1000px';
            document.body.appendChild(ta);
            ta.focus();
            ta.select();
            const ok = document.execCommand('copy');
            document.body.removeChild(ta);
            if (!ok) throw new Error('execCommand failed');
            if (btn) {
                const originalText = btn.textContent;
                btn.textContent = 'Copié !';
                setTimeout(() => { btn.textContent = originalText; }, 2000);
            }
        } catch (e) {
            console.error('Erreur lors de la copie: ', e || err);
            alert('Erreur lors de la copie du lien');
        }
    }
}

// Gestion du modal de suppression
function openDeleteModal() {
    const modal = document.getElementById('deleteModal');
    if (modal) {
        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden'; // Empêche le scroll
    }
}

function closeDeleteModal() {
    const modal = document.getElementById('deleteModal');
    if (modal) {
        modal.classList.add('hidden');
        document.body.style.overflow = ''; // Réactive le scroll
    }
}

// Fermer le modal en cliquant en dehors
document.addEventListener('DOMContentLoaded', function() {
    const modal = document.getElementById('deleteModal');
    if (modal) {
        modal.addEventListener('click', function(e) {
            if (e.target === modal) {
                closeDeleteModal();
            }
        });
    }

    // Fermer le modal avec la touche Escape
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeDeleteModal();
        }
    });
});

// Countdown to start date
document.addEventListener('DOMContentLoaded', function() {
    const el = document.getElementById('countdown');
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

// Animation d'entrée des éléments
document.addEventListener('DOMContentLoaded', function() {
    const elements = document.querySelectorAll('.bg-white');
    elements.forEach((el, index) => {
        el.style.opacity = '0';
        el.style.transform = 'translateY(20px)';

        setTimeout(() => {
            el.style.transition = 'all 0.6s ease-out';
            el.style.opacity = '1';
            el.style.transform = 'translateY(0)';
        }, index * 100);
    });
});

// Gestion des interactions
document.addEventListener('DOMContentLoaded', function() {
    // Animation au survol des cartes
    const cards = document.querySelectorAll('.bg-white.border');
    cards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-4px)';
            this.style.boxShadow = '0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04)';
        });

        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
            this.style.boxShadow = '';
        });
    });
});
</script>

<style>
/* Style pour empêcher le flash du modal */
#deleteModal {
    opacity: 0;
    transition: opacity 0.3s ease-in-out;
}

#deleteModal:not(.hidden) {
    opacity: 1;
    display: flex !important;
}

/* Animation d'entrée du modal */
#deleteModal:not(.hidden) > div {
    animation: modalEnter 0.3s ease-out;
}

@keyframes modalEnter {
    from {
        opacity: 0;
        transform: scale(0.9) translateY(-10px);
    }
    to {
        opacity: 1;
        transform: scale(1) translateY(0);
    }
}
</style>
@endpush
