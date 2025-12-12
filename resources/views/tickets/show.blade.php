@extends('layouts.app')

@section('title', 'Ticket')

@section('content')
    <div class="py-10">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div
                class="bg-white shadow-xl overflow-hidden sm:rounded-2xl dark:bg-neutral-900 dark:border dark:border-neutral-800">
                <div class="bg-indigo-600 px-6 py-10 sm:px-12">
                    <div class="flex items-center justify-between gap-6">
                        <div>
                            <p class="text-indigo-100 text-sm uppercase tracking-widest">Votre billet</p>
                            <h1 class="mt-2 text-3xl font-bold text-white">{{ $ticket->event->title }}</h1>
                            <p class="mt-2 text-indigo-100 text-sm">Propriétaire: {{ optional($ticket->owner)->name }}</p>
                        </div>
                        <div class="text-indigo-100 text-right">
                            <p class="text-sm">Statut</p>
                            <p class="text-xl font-semibold">
                                @if ($ticket->status === 'used')
                                    <span class="text-yellow-200">Utilisé</span>
                                @elseif($ticket->status === 'invalid')
                                    <span class="text-red-200">Invalide</span>
                                @else
                                    <span class="text-green-200">Valide</span>
                                @endif
                            </p>
                            <p class="mt-1 text-sm">Paiement:
                                @if ($ticket->paid)
                                    <span class="font-semibold text-green-200">Payé</span>
                                @else
                                    <span class="font-semibold text-red-200">Non payé</span>
                                @endif
                                @if ($ticket->payment_method)
                                    <span class="text-indigo-100">({{ $ticket->payment_method }})</span>
                                @endif
                            </p>
                        </div>
                    </div>
                </div>

                <div class="px-6 py-10 sm:px-12">
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                        <div class="lg:col-span-2 space-y-6">
                            <div
                                class="border border-gray-200 rounded-xl p-6 dark:border-neutral-800 dark:bg-neutral-900/60">
                                <h2 class="text-lg font-semibold text-gray-900 dark:text-neutral-100">Détails de l'événement
                                </h2>
                                <dl class="mt-4 space-y-3 text-sm text-gray-600 dark:text-neutral-400">
                                    <div class="flex items-start">
                                        <dt class="w-32 font-medium text-gray-700 dark:text-neutral-300">Dates</dt>
                                        <dd class="flex-1">
                                            @if ($ticket->event->start_date)
                                                {{ $ticket->event->start_date->translatedFormat('d/m/Y H\hi') }}
                                                @if ($ticket->event->end_date)
                                                    &nbsp;→&nbsp;{{ $ticket->event->end_date->translatedFormat('d/m/Y H\hi') }}
                                                @endif
                                            @else
                                                À confirmer
                                            @endif
                                        </dd>
                                    </div>
                                    <div class="flex items-start">
                                        <dt class="w-32 font-medium text-gray-700 dark:text-neutral-300">Lieu</dt>
                                        <dd class="flex-1">{{ $ticket->event->location }}</dd>
                                    </div>
                                </dl>
                            </div>

                            <div
                                class="border border-gray-200 rounded-xl p-6 dark:border-neutral-800 dark:bg-neutral-900/60">
                                <h2 class="text-lg font-semibold text-gray-900 dark:text-neutral-100">Informations</h2>
                                <ul
                                    class="mt-4 space-y-2 text-sm text-gray-600 list-disc list-inside dark:text-neutral-400">
                                    <li>Présentez ce billet (imprimé ou sur mobile) à l'entrée.</li>
                                    <li>Le QR code est unique. En cas de transfert, un nouveau QR sera généré.</li>
                                    <li>En cas de paiement sur place, prévenez l'agent au scan.</li>
                                </ul>
                            </div>

                            @php
                                $validations = $ticket->validations()->orderBy('validation_date', 'desc')->get();
                                $validatedToday = $ticket->isValidatedToday();
                                $eventDuration = $ticket->event->start_date && $ticket->event->end_date 
                                    ? $ticket->event->start_date->diffInDays($ticket->event->end_date) + 1 
                                    : 1;
                                $isMultiDay = $eventDuration > 1;
                            @endphp

                            @if($isMultiDay || $validations->count() > 0)
                                <div class="border border-gray-200 rounded-xl p-6 dark:border-neutral-800 dark:bg-neutral-900/60">
                                    <div class="flex items-center justify-between mb-4">
                                        <h2 class="text-lg font-semibold text-gray-900 dark:text-neutral-100">
                                            Historique des validations
                                        </h2>
                                        @if($isMultiDay)
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-indigo-100 text-indigo-800 dark:bg-indigo-900/30 dark:text-indigo-300">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                </svg>
                                                Événement {{ $eventDuration }} jours
                                            </span>
                                        @endif
                                    </div>

                                    @if($validatedToday)
                                        @php
                                            $todayValidation = $validations->firstWhere('validation_date', today());
                                        @endphp
                                        <div class="mb-4 p-4 bg-green-50 border border-green-200 rounded-lg dark:bg-green-950/30 dark:border-green-900/40">
                                            <div class="flex items-center gap-2">
                                                <svg class="w-5 h-5 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                                <span class="text-sm font-semibold text-green-800 dark:text-green-200">
                                                    ✓ Validé aujourd'hui à {{ $todayValidation->validated_at->format('H:i') }}
                                                </span>
                                            </div>
                                        </div>
                                    @endif

                                    @if($isMultiDay)
                                        <div class="mb-4 flex items-center justify-between p-3 bg-gray-50 dark:bg-neutral-800/50 rounded-lg">
                                            <span class="text-sm font-medium text-gray-700 dark:text-neutral-300">
                                                Validations effectuées:
                                            </span>
                                            <span class="text-lg font-bold text-indigo-600 dark:text-indigo-400">
                                                {{ $validations->count() }} / {{ $eventDuration }}
                                            </span>
                                        </div>

                                        <div class="mb-4">
                                            <div class="h-2 w-full bg-gray-200 dark:bg-neutral-700 rounded-full overflow-hidden">
                                                <div class="h-2 bg-gradient-to-r from-indigo-600 to-purple-600 transition-all duration-500" 
                                                     style="width: {{ ($validations->count() / $eventDuration) * 100 }}%">
                                                </div>
                                            </div>
                                        </div>
                                    @endif

                                    @if($validations->count() > 0)
                                        <div class="space-y-2">
                                            <p class="text-xs font-semibold text-gray-500 dark:text-neutral-400 uppercase tracking-wider mb-3">
                                                Historique
                                            </p>
                                            @foreach($validations as $validation)
                                                <div class="flex items-center gap-3 p-3 bg-white dark:bg-neutral-900 border border-gray-200 dark:border-neutral-700 rounded-lg hover:shadow-sm transition-shadow">
                                                    <div class="flex-shrink-0">
                                                        <div class="w-10 h-10 rounded-full bg-indigo-100 dark:bg-indigo-900/30 flex items-center justify-center">
                                                            <svg class="w-5 h-5 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                                            </svg>
                                                        </div>
                                                    </div>
                                                    <div class="flex-1 min-w-0">
                                                        <p class="text-sm font-medium text-gray-900 dark:text-neutral-100">
                                                            {{ $validation->validation_date->translatedFormat('d F Y') }}
                                                            @if($validation->validation_date->isToday())
                                                                <span class="ml-2 inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300">
                                                                    Aujourd'hui
                                                                </span>
                                                            @endif
                                                        </p>
                                                        <p class="text-xs text-gray-500 dark:text-neutral-400">
                                                            Scanné à {{ $validation->validated_at->format('H:i') }}
                                                            @if($validation->validator)
                                                                par {{ $validation->validator->name }}
                                                            @endif
                                                        </p>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    @else
                                        <div class="text-center py-8">
                                            <svg class="w-12 h-12 mx-auto text-gray-300 dark:text-neutral-600 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            <p class="text-sm text-gray-500 dark:text-neutral-400">
                                                Aucune validation enregistrée
                                            </p>
                                            <p class="text-xs text-gray-400 dark:text-neutral-500 mt-1">
                                                Présentez ce ticket à l'entrée pour le valider
                                            </p>
                                        </div>
                                    @endif
                                </div>
                            @endif
                        </div>

                        <div class="lg:col-span-1">
                            <div
                                class="border border-dashed border-gray-300 rounded-2xl p-6 text-center space-y-6 dark:border-neutral-700 dark:bg-neutral-900/60">
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-900 dark:text-neutral-100">QR Code</h3>
                                    <p class="mt-1 text-sm text-gray-500 dark:text-neutral-400">À présenter à l'entrée</p>
                                </div>

                                @if ($ticket->qr_code_path)
                                    <img src="{{ asset('storage/' . ltrim($ticket->qr_code_path, '/')) }}" alt="QR Code"
                                        class="mx-auto w-48 h-48 object-contain">
                                @else
                                    <div
                                        class="mx-auto w-48 h-48 flex items-center justify-center bg-gray-100 rounded-lg dark:bg-neutral-900/60">
                                        <svg class="w-12 h-12 text-gray-400 dark:text-neutral-500" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                d="M4.75 4.75v3.5h3.5v-3.5h-3.5zm0 7v3.5h3.5v-3.5h-3.5zm7-7v3.5h3.5v-3.5h-3.5zm0 7v3.5h3.5v-3.5h-3.5zm7-7v3.5h3.5v-3.5h-3.5zm0 7v3.5h3.5v-3.5h-3.5z" />
                                        </svg>
                                    </div>
                                    <p class="text-sm text-orange-500">Le QR code est en cours de génération. Actualisez la
                                        page dans quelques instants.</p>
                                @endif

                                <div class="space-y-3">
                                    <a href="{{ route('events.show', $ticket->event) }}"
                                        class="inline-flex items-center justify-center px-4 py-2 border border-indigo-600 text-sm font-medium rounded-md text-indigo-600 bg-white hover:bg-indigo-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                        Retour à l'événement
                                    </a>
                                    <a href="{{ route('dashboard') }}"
                                        class="inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-gray-800 hover:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-700">
                                        Tableau de bord
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if (session('error'))
                        <div
                            class="mt-6 rounded-lg bg-red-50 border border-red-200 p-4 text-sm text-red-700 dark:bg-red-950/30 dark:border-red-900/40 dark:text-red-300">
                            {{ session('error') }}</div>
                    @endif
                    @if (session('success'))
                        <div
                            class="mt-6 rounded-lg bg-green-50 border border-green-200 p-4 text-sm text-green-700 dark:bg-green-950/30 dark:border-green-900/40 dark:text-green-300">
                            {{ session('success') }}</div>
                    @endif

                    @if (auth()->check() &&
                            auth()->id() === $ticket->owner_user_id &&
                            $ticket->event &&
                            $ticket->event->allow_ticket_transfer &&
                            $ticket->status === 'valid' &&
                            (!$ticket->event->end_date || now()->lt($ticket->event->end_date)))
                        <div
                            class="mt-8 border border-indigo-200 bg-indigo-50 rounded-xl p-6 dark:bg-neutral-900/60 dark:border-neutral-800">
                            <h2 class="text-lg font-semibold text-gray-900 dark:text-neutral-100">Transférer ce ticket</h2>
                            <p class="mt-1 text-sm text-gray-600 dark:text-neutral-400">Entrez l'email du destinataire. Un
                                nouveau QR sera généré et vous perdrez l'accès à ce ticket.</p>
                            <form class="mt-4 grid grid-cols-1 sm:grid-cols-3 gap-3"
                                action="{{ route('tickets.transfer', $ticket->qr_code_data) }}" method="POST">
                                @csrf
                                <div class="sm:col-span-2">
                                    <label for="recipient_email" class="sr-only">Email du destinataire</label>
                                    <input type="email" required name="recipient_email" id="recipient_email"
                                        placeholder="destinataire@example.com"
                                        class="w-full rounded-md border-gray-300 focus:ring-indigo-500 focus:border-indigo-500 px-3 py-2" />
                                </div>
                                <div class="flex items-center">
                                    <button type="submit"
                                        class="inline-flex items-center justify-center px-4 py-2 min-w-[180px] bg-indigo-600 text-white text-sm font-medium rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                        Confirmer le transfert
                                    </button>
                                </div>
                            </form>
                            <p class="mt-2 text-xs text-gray-600 dark:text-neutral-400">Action irréversible. Si le
                                destinataire n'a pas de compte, il recevra un email avec son ticket.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
