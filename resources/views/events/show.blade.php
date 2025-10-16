@extends('layouts.app')

@section('title', $event->title)

@push('styles')
<style>
    .page-gradient {
        background: linear-gradient(135deg, #F9FAFB 0%, #FFFFFF 50%, #E0E7FF 100%);
        min-height: 100vh;
    }

    .event-card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.2);
        box-shadow:
            0 20px 40px rgba(79, 70, 229, 0.08),
            inset 0 1px 0 rgba(255, 255, 255, 0.6);
    }

    .cover-image {
        height: 400px;
        width: 100%;
        object-fit: cover;
        border-radius: 20px 20px 0 0;
    }

    .info-card {
        background: white;
        border: 2px solid #E0E7FF;
        border-radius: 12px;
        padding: 1.5rem;
        transition: all 0.3s ease;
    }

    .info-card:hover {
        border-color: #4F46E5;
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(79, 70, 229, 0.1);
    }

    .action-btn {
        background: linear-gradient(135deg, #4F46E5 0%, #6366F1 100%);
        color: white;
        padding: 0.75rem 1.5rem;
        border: none;
        border-radius: 12px;
        font-weight: 600;
        font-size: 0.95rem;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .action-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 12px 25px rgba(79, 70, 229, 0.3);
    }

    .cancel-btn {
        background: white;
        color: #6B7280;
        border: 2px solid #E5E7EB;
        padding: 0.75rem 1.5rem;
        border-radius: 12px;
        font-weight: 600;
        font-size: 0.95rem;
        transition: all 0.3s ease;
    }

    .cancel-btn:hover {
        border-color: #EF4444;
        color: #EF4444;
        transform: translateY(-1px);
    }

    .secondary-btn {
        background: white;
        color: #6B7280;
        border: 2px solid #E5E7EB;
        padding: 0.75rem 1.5rem;
        border-radius: 12px;
        font-weight: 600;
        font-size: 0.95rem;
        transition: all 0.3s ease;
    }

    .secondary-btn:hover {
        border-color: #4F46E5;
        color: #4F46E5;
        transform: translateY(-1px);
    }

    .badge {
        display: inline-flex;
        align-items: center;
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-size: 0.875rem;
        font-weight: 600;
    }

    .badge-available {
        background: linear-gradient(135deg, #10B981 0%, #34D399 100%);
        color: white;
    }

    .badge-full {
        background: linear-gradient(135deg, #EF4444 0%, #F87171 100%);
        color: white;
    }

    .badge-price {
        background: linear-gradient(135deg, #3B82F6 0%, #60A5FA 100%);
        color: white;
    }

    .badge-free {
        background: linear-gradient(135deg, #6B7280 0%, #9CA3AF 100%);
        color: white;
    }

    .attendee-card {
        background: white;
        border: 2px solid #F3F4F6;
        border-radius: 12px;
        padding: 1.25rem;
        transition: all 0.3s ease;
    }

    .attendee-card:hover {
        border-color: #4F46E5;
        transform: translateY(-2px);
    }

    .age-checkbox {
        border: 2px solid #E0E7FF;
        border-radius: 12px;
        background: #F8FAFC;
        padding: 1rem;
        transition: all 0.3s ease;
    }

    .age-checkbox:has(input:checked) {
        border-color: #4F46E5;
        background: #E0E7FF;
    }

    .payment-fieldset {
        border: 2px solid #E0E7FF;
        border-radius: 12px;
        background: #F8FAFC;
        padding: 1.25rem;
        transition: all 0.3s ease;
    }

    .payment-fieldset:hover {
        border-color: #4F46E5;
    }

    .back-link {
        display: inline-flex;
        align-items: center;
        color: #4F46E5;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.3s ease;
        padding: 0.5rem 1rem;
        border-radius: 8px;
        background: white;
        border: 2px solid #E0E7FF;
    }

    .back-link:hover {
        color: white;
        background: #4F46E5;
        transform: translateX(-4px);
    }

    .description-content {
        line-height: 1.7;
        color: #4B5563;
    }

    .description-content p {
        margin-bottom: 1rem;
    }

    .organizer-card {
        background: linear-gradient(135deg, #F8FAFC 0%, #FFFFFF 100%);
        border: 2px solid #E0E7FF;
        border-radius: 16px;
        padding: 1.5rem;
        transition: all 0.3s ease;
    }

    .organizer-card:hover {
        border-color: #4F46E5;
        transform: translateY(-2px);
    }

    .modal-overlay {
        background: rgba(15, 23, 42, 0.6);
        backdrop-filter: blur(8px);
    }

    .modal-content {
        background: white;
        border-radius: 20px;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
    }
</style>
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

        <!-- Carte principale de l'événement -->
        <div class="event-card rounded-2xl overflow-hidden">
            <!-- Image de couverture -->
            @if($event->cover_image)
                <div class="relative">
                    <img src="{{ asset('storage/' . $event->cover_image) }}" alt="{{ $event->title }}" class="cover-image">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent"></div>
                </div>
            @endif

            <div class="p-8">
                <!-- En-tête avec titre et actions -->
                <div class="flex flex-col lg:flex-row lg:items-start lg:justify-between gap-6">
                    <div class="flex-1">
                        <h1 class="text-4xl font-bold bg-gradient-to-r from-[#1E3A8A] to-[#4F46E5] bg-clip-text text-transparent mb-4">
                            {{ $event->title }}
                        </h1>

                        <!-- Informations principales -->
                        <div class="space-y-3">
                            <div class="flex items-center text-[#6B7280]">
                                <svg class="flex-shrink-0 mr-3 h-5 w-5 text-[#4F46E5]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                <span class="text-lg">{{ $event->location }}</span>
                            </div>

                            <div class="flex items-center text-[#6B7280]">
                                <svg class="flex-shrink-0 mr-3 h-5 w-5 text-[#4F46E5]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                <span class="text-lg">
                                    @if($event->start_date)
                                        {{ $event->start_date->translatedFormat('l d F Y \à H\hi') }}
                                    @else
                                        Date non définie
                                    @endif
                                </span>
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
                                <form action="{{ route('events.register', $event) }}" method="POST" class="space-y-4">
                                    @csrf

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
