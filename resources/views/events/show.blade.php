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
<div class="page-gradient py-8">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- En-tête avec bouton de retour -->
        <div class="mb-8">
            <a href="{{ route('events.index') }}" class="back-link">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Retour aux événements
            </a>
        </div>
        <div class="relative mb-6">
            <div class="h-56 md:h-80 w-full overflow-hidden rounded-2xl relative">
                <img src="{{ $event->cover_image_url }}" alt="{{ $event->title }}" class="absolute inset-0 w-full h-full object-cover">
                <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/30 to-transparent"></div>
                <div class="absolute bottom-0 left-0 right-0 p-6">
                    <h1 class="text-3xl md:text-4xl font-bold text-white">{{ $event->title }}</h1>
                    <div class="mt-3 flex flex-wrap items-center gap-4 text-white/90 text-sm">
                        <span class="inline-flex items-center gap-1">
                            <svg class="h-5 w-5 opacity-90" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            @if($event->start_date) {{ $event->start_date->translatedFormat('d M Y, H\\hi') }} @endif
                        </span>
                        <span class="inline-flex items-center gap-1">
                            <svg class="h-5 w-5 opacity-90" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            {{ $event->location }}
                        </span>
                        <span class="inline-flex items-center gap-1 font-semibold">
                            {{ \App\Support\Currency::format($event->price, $event->currency ?? 'XOF') }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">


            <div class="p-8">
                <!-- En-tête avec titre et actions -->
                <div class="flex flex-col lg:flex-row lg:items-start lg:justify-between gap-6">
                    <div class="flex-1">
                        <h1 class="sr-only">{{ $event->title }}</h1>

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
                            @if($event->start_date)
                                {{ $event->start_date->translatedFormat('l d F Y \\à H\\hi') }}
                            @else
                                Date non définie
                            @endif
                        </div>

                            @if($event->end_date)
                            <div class="flex items-center text-[#6B7280]">
                                <svg class="flex-shrink-0 mr-3 h-5 w-5 text-[#4F46E5]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span class="text-lg">Durée : {{ $event->start_date->diffInHours($event->end_date) }} heures</span>
                            </div>
                            @endif
                        </div>

                        <!-- Badges -->
                        <div class="mt-6 flex flex-wrap gap-3">
                            <span class="badge {{ $event->available_seats > 0 ? 'badge-available' : 'badge-full' }}">
                                @if($event->available_seats > 0)
                                    {{ $event->available_seats }} place{{ $event->available_seats > 1 ? 's' : '' }} disponible{{ $event->available_seats > 1 ? 's' : '' }}
                                @else
                                    Complet
                                @endif
                            </span>

                            <span class="badge {{ $event->price > 0 ? 'badge-price' : 'badge-free' }}">
                                {{ $event->price > 0 ? number_format($event->price / 100, 2, ',', ' ') . ' €' : 'Gratuit' }}
                            </span>

                            @if($event->is_restricted_18)
                                <span class="badge bg-gradient-to-r from-[#F59E0B] to-[#FBBF24] text-white">
                                    +18
                                </span>
                            @endif
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="flex flex-col gap-4 min-w-[280px]">
                        @if(auth()->check() && (auth()->user()->can('update', $event) || auth()->user()->can('delete', $event)))
                            <div class="flex flex-col gap-3">
                                @can('update', $event)
                                    <a href="{{ route('events.edit', $event) }}" class="action-btn text-center">
                                        <svg class="w-5 h-5 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                        Modifier
                                    </a>
                                @endcan

                                @can('delete', $event)
                                    <div x-data="{ isOpen: false }" class="relative">
                                        <button @click="isOpen = true" class="cancel-btn w-full text-center">
                                            <svg class="w-5 h-5 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                            Supprimer
                                        </button>

                                        <!-- Modal de confirmation -->
                                        <div x-show="isOpen" x-cloak class="fixed inset-0 z-50 flex items-center justify-center modal-overlay px-4">
                                            <div x-show="isOpen" x-transition class="modal-content w-full max-w-md p-6">
                                                <div class="flex items-start gap-4">
                                                    <div class="flex h-12 w-12 items-center justify-center rounded-full bg-red-100 text-red-600">
                                                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 9v4m0 4h.01M12 5a7 7 0 017 7c0 3.866-3.134 7-7 7s-7-3.134-7-7 3.134-7 7-7z" />
                                                        </svg>
                                                    </div>
                                                    <div class="space-y-2">
                                                        <h3 class="text-lg font-semibold text-[#1E3A8A]">Confirmer la suppression</h3>
                                                        <p class="text-sm text-[#6B7280]">Cette action supprimera définitivement l'événement « {{ $event->title }} » ainsi que toutes ses inscriptions associées. Voulez-vous continuer ?</p>
                                                    </div>
                                                </div>

                                                <div class="mt-6 flex flex-col gap-2 sm:flex-row sm:justify-end">
                                                    <button type="button" @click="isOpen = false" class="secondary-btn">Annuler</button>
                                                    <form action="{{ route('events.destroy', $event) }}" method="POST" class="inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="action-btn bg-gradient-to-r from-red-600 to-red-500">
                                                            Supprimer définitivement
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endcan
                            </div>
                            @can('update', $event)
                                <div class="mt-4 rounded-lg border border-gray-200 p-4 bg-gray-50">
                                    <h3 class="text-sm font-semibold text-gray-800 mb-2">Lien de promotion</h3>
                                    @php $plan = optional(auth()->user())->subscription_plan; $eligible = in_array($plan, ['premium','pro'], true); @endphp
                                    @if($eligible)
                                        @if($event->shareable_link)
                                            <div class="flex items-center gap-2">
                                                <input type="text" readonly class="w-full border-gray-300 rounded-md text-sm" value="{{ $event->shareable_link }}">
                                                <button type="button" class="px-3 py-2 text-sm rounded-md bg-indigo-600 text-white" onclick="navigator.clipboard.writeText('{{ $event->shareable_link }}')">Copier</button>
                                            </div>
                                            <p class="mt-2 text-xs text-gray-600">Clics: <strong>{{ (int) $event->promo_clicks }}</strong> · Inscriptions: <strong>{{ (int) $event->promo_registrations }}</strong></p>
                                        @else
                                            <form method="POST" action="{{ route('events.generate-share', $event) }}">
                                                @csrf
                                                <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-emerald-600 hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500">
                                                    Générer le lien de promotion
                                                </button>
                                            </form>
                                        @endif
                                    @else
                                        <div class="flex items-start justify-between gap-2">
                                            <p class="text-sm text-gray-600">Fonctionnalité réservée aux abonnements Premium et Pro.</p>
                                            <a href="{{ route('subscriptions.plans') }}" class="inline-flex items-center px-3 py-2 rounded-md bg-indigo-600 text-white text-sm hover:bg-indigo-500">Voir les offres</a>
                                        </div>
                                    @endif
                                </div>
                            @endcan
                        @endif

                        @if(auth()->check() && auth()->user()->isStudent())
                            @if($event->attendees->contains(auth()->id()))
                                <form action="{{ route('events.cancel-registration', $event) }}" method="POST" class="w-full">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="cancel-btn w-full text-center">
                                        <svg class="w-5 h-5 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                        </svg>
                                        Annuler l'inscription
                                    </button>
                                </form>
                            @elseif($event->available_seats > 0 && optional($event->start_date)->isFuture())
                                <form action="{{ route('events.register', $event) }}" method="POST" class="inline-block space-y-3">
                                    @csrf
                                    @if(request()->filled('ref'))
                                        <input type="hidden" name="ref" value="{{ request('ref') }}">
                                    @endif

                                    @if($event->is_restricted_18)
                                        <div class="age-checkbox">
                                            <label class="flex items-start gap-3 cursor-pointer">
                                                <input type="checkbox" id="confirm_age" name="confirm_age" value="1"
                                                    class="mt-1 h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500" required>
                                                <div>
                                                    <span class="block text-sm font-semibold text-[#1E3A8A]">Je confirme avoir au moins 18 ans</span>
                                                    <span class="block text-xs text-[#6B7280] mt-1">Une vérification d'identité pourra être demandée sur place</span>
                                                </div>
                                            </label>
                                        </div>
                                        @error('confirm_age')
                                            <p class="text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    @endif

                                    @if(($event->price ?? 0) > 0)
                                        <fieldset class="payment-fieldset">
                                            <legend class="text-sm font-semibold text-[#1E3A8A] px-2">Mode de paiement</legend>
                                            <div class="mt-3 space-y-3">
                                                <label class="flex items-center gap-3 p-3 rounded-lg border-2 border-transparent hover:border-indigo-200 cursor-pointer transition-colors">
                                                    <input type="radio" name="payment_method" value="kkiapay"
                                                        class="h-4 w-4 text-indigo-600 border-gray-300 focus:ring-indigo-500" checked required>
                                                    <div>
                                                        <span class="block text-sm font-medium text-[#1E3A8A]">Payer maintenant</span>
                                                        <span class="block text-xs text-[#6B7280]">Paiement sécurisé via Kkiapay</span>
                                                    </div>
                                                </label>
                                                <label class="flex items-center gap-3 p-3 rounded-lg border-2 border-transparent hover:border-indigo-200 cursor-pointer transition-colors">
                                                    <input type="radio" name="payment_method" value="physical"
                                                        class="h-4 w-4 text-indigo-600 border-gray-300 focus:ring-indigo-500" required>
                                                    <div>
                                                        <span class="block text-sm font-medium text-[#1E3A8A]">Payer sur place</span>
                                                        <span class="block text-xs text-[#6B7280]">Le jour de l'événement</span>
                                                    </div>
                                                </label>
                                            </div>
                                            @error('payment_method')
                                                <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                                            @enderror
                                        </fieldset>
                                    @endif

                                    <button type="submit" class="action-btn w-full text-center">
                                        <svg class="w-5 h-5 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                                        </svg>
                                        S'inscrire maintenant
                                    </button>
                                </form>
                            @else
                                <button disabled class="secondary-btn w-full text-center cursor-not-allowed opacity-50">
                                    Inscription non disponible
                                </button>
                            @endif
                        @elseif(!auth()->check())
                            <a href="{{ route('login') }}" class="action-btn w-full text-center">
                                <svg class="w-5 h-5 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                                </svg>
                                Se connecter pour s'inscrire
                            </a>
                        @endif
                    </div>
                </div>

                <!-- Description -->
                <div class="mt-12">
                    <h2 class="text-2xl font-bold bg-gradient-to-r from-[#1E3A8A] to-[#4F46E5] bg-clip-text text-transparent mb-6">
                        À propos de cet événement
                    </h2>
                    <div class="description-content text-lg leading-relaxed">
                        {!! nl2br(e($event->description)) !!}
                    </div>
                </div>

                <!-- Organisateur -->
                <div class="mt-12 pt-8 border-t border-[#E0E7FF]">
                    <h2 class="text-2xl font-bold bg-gradient-to-r from-[#1E3A8A] to-[#4F46E5] bg-clip-text text-transparent mb-6">
                        Organisateur
                    </h2>
                    <div class="organizer-card">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="h-16 w-16 rounded-full bg-gradient-to-r from-[#4F46E5] to-[#6366F1] flex items-center justify-center">
                                    <svg class="h-8 w-8 text-white" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12 14.016q2.531 0 5.273 1.102t2.742 2.883v2.016h-16.031v-2.016q0-1.781 2.742-2.883t5.273-1.102zM12 12q-1.641 0-2.813-1.172t-1.172-2.813 1.172-2.836 2.813-1.195 2.813 1.195 1.172 2.836-1.172 2.813-2.813 1.172z"/>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-4">
                                <p class="text-xl font-semibold text-[#1E3A8A]">{{ $event->organizer->name }}</p>
                                <p class="text-[#6B7280]">Organisateur de l'événement</p>
                            </div>
                        </div>
                    </div>
                </div>

                @can('viewAttendees', $event)
                    <div class="mt-12 pt-8 border-t border-[#E0E7FF]">
                        <div class="flex items-center justify-between mb-6">
                            <h2 class="text-2xl font-bold bg-gradient-to-r from-[#1E3A8A] to-[#4F46E5] bg-clip-text text-transparent">
                                Participants
                            </h2>
                            <a href="{{ route('events.attendees', $event) }}" class="secondary-btn">
                                Gérer les inscrits
                                <svg class="w-4 h-4 ml-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </a>
                        </div>

                        @if($event->attendees->isNotEmpty())
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                @foreach($event->attendees->take(6) as $attendee)
                                    <div class="attendee-card">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0">
                                                <div class="h-12 w-12 rounded-full bg-gradient-to-r from-[#E0E7FF] to-[#C7D2FE] flex items-center justify-center">
                                                    <svg class="h-6 w-6 text-[#4F46E5]" fill="currentColor" viewBox="0 0 24 24">
                                                        <path d="M12 14.016q2.531 0 5.273 1.102t2.742 2.883v2.016h-16.031v-2.016q0-1.781 2.742-2.883t5.273-1.102zM12 12q-1.641 0-2.813-1.172t-1.172-2.813 1.172-2.836 2.813-1.195 2.813 1.195 1.172 2.836-1.172 2.813-2.813 1.172z"/>
                                                    </svg>
                                                </div>
                                            </div>
                                            <div class="ml-3 flex-1">
                                                <p class="text-sm font-semibold text-[#1E3A8A]">{{ $attendee->name }}</p>
                                                <p class="text-xs text-[#6B7280]">Inscrit le {{ $attendee->pivot->created_at->translatedFormat('d F Y') }}</p>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            @if($event->attendees->count() > 6)
                                <div class="mt-6 text-center">
                                    <a href="{{ route('events.attendees', $event) }}" class="text-[#4F46E5] font-semibold hover:text-[#3730A3] transition-colors">
                                        Voir les {{ $event->attendees->count() - 6 }} autres participants...
                                    </a>
                                </div>
                            @endif
                        @else
                            <div class="text-center py-8">
                                <svg class="w-16 h-16 mx-auto text-[#9CA3AF]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                </svg>
                                <p class="mt-4 text-[#6B7280]">Aucun participant pour le moment.</p>
                            </div>
                        @endif
                    </div>
                @endcan
            </div>
        </div>
    </div>
</div>
@endsection
