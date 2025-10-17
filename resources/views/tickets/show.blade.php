@extends('layouts.app')

@section('title', 'Ticket')

@section('content')
<div class="py-10">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white shadow-xl overflow-hidden sm:rounded-2xl">
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
                            @if($ticket->status === 'used')
                                <span class="text-yellow-200">Utilisé</span>
                            @elseif($ticket->status === 'invalid')
                                <span class="text-red-200">Invalide</span>
                            @else
                                <span class="text-green-200">Valide</span>
                            @endif
                        </p>
                        <p class="mt-1 text-sm">Paiement:
                            @if($ticket->paid)
                                <span class="font-semibold text-green-200">Payé</span>
                            @else
                                <span class="font-semibold text-red-200">Non payé</span>
                            @endif
                            @if($ticket->payment_method)
                                <span class="text-indigo-100">({{ $ticket->payment_method }})</span>
                            @endif
                        </p>
                    </div>
                </div>
            </div>

            <div class="px-6 py-10 sm:px-12">
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <div class="lg:col-span-2 space-y-6">
                        <div class="border border-gray-200 rounded-xl p-6">
                            <h2 class="text-lg font-semibold text-gray-900">Détails de l'événement</h2>
                            <dl class="mt-4 space-y-3 text-sm text-gray-600">
                                <div class="flex items-start">
                                    <dt class="w-32 font-medium text-gray-700">Dates</dt>
                                    <dd class="flex-1">
                                        @if($ticket->event->start_date)
                                            {{ $ticket->event->start_date->translatedFormat('d/m/Y H\hi') }}
                                            @if($ticket->event->end_date)
                                                &nbsp;→&nbsp;{{ $ticket->event->end_date->translatedFormat('d/m/Y H\hi') }}
                                            @endif
                                        @else
                                            À confirmer
                                        @endif
                                    </dd>
                                </div>
                                <div class="flex items-start">
                                    <dt class="w-32 font-medium text-gray-700">Lieu</dt>
                                    <dd class="flex-1">{{ $ticket->event->location }}</dd>
                                </div>
                            </dl>
                        </div>

                        <div class="border border-gray-200 rounded-xl p-6">
                            <h2 class="text-lg font-semibold text-gray-900">Informations</h2>
                            <ul class="mt-4 space-y-2 text-sm text-gray-600 list-disc list-inside">
                                <li>Présentez ce billet (imprimé ou sur mobile) à l'entrée.</li>
                                <li>Le QR code est unique. En cas de transfert, un nouveau QR sera généré.</li>
                                <li>En cas de paiement sur place, prévenez l'agent au scan.</li>
                            </ul>
                        </div>
                    </div>

                    <div class="lg:col-span-1">
                        <div class="border border-dashed border-gray-300 rounded-2xl p-6 text-center space-y-6">
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900">QR Code</h3>
                                <p class="mt-1 text-sm text-gray-500">À présenter à l'entrée</p>
                            </div>

                            @if($ticket->qr_code_path)
                                <img src="{{ asset('storage/' . ltrim($ticket->qr_code_path, '/')) }}" alt="QR Code" class="mx-auto w-48 h-48 object-contain">
                            @else
                                <div class="mx-auto w-48 h-48 flex items-center justify-center bg-gray-100 rounded-lg">
                                    <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4.75 4.75v3.5h3.5v-3.5h-3.5zm0 7v3.5h3.5v-3.5h-3.5zm7-7v3.5h3.5v-3.5h-3.5zm0 7v3.5h3.5v-3.5h-3.5zm7-7v3.5h3.5v-3.5h-3.5zm0 7v3.5h3.5v-3.5h-3.5z" />
                                    </svg>
                                </div>
                                <p class="text-sm text-orange-500">Le QR code est en cours de génération. Actualisez la page dans quelques instants.</p>
                            @endif

                            <div class="space-y-3">
                                <a href="{{ route('events.show', $ticket->event) }}" class="inline-flex items-center justify-center px-4 py-2 border border-indigo-600 text-sm font-medium rounded-md text-indigo-600 bg-white hover:bg-indigo-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    Retour à l'événement
                                </a>
                                <a href="{{ route('dashboard') }}" class="inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-gray-800 hover:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-700">
                                    Tableau de bord
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                @if(session('error'))
                    <div class="mt-6 rounded-lg bg-red-50 border border-red-200 p-4 text-sm text-red-700">{{ session('error') }}</div>
                @endif
                @if(session('success'))
                    <div class="mt-6 rounded-lg bg-green-50 border border-green-200 p-4 text-sm text-green-700">{{ session('success') }}</div>
                @endif

                @if(auth()->check() && auth()->id() === $ticket->owner_user_id && $ticket->event && $ticket->event->allow_ticket_transfer && $ticket->status === 'valid' && (!$ticket->event->end_date || now()->lt($ticket->event->end_date)))
                    <div class="mt-8 border border-gray-200 rounded-xl p-6">
                        <h2 class="text-lg font-semibold text-gray-900">Transférer ce ticket</h2>
                        <p class="mt-1 text-sm text-gray-600">Saisissez l'email du destinataire. Un nouveau QR code sera généré et vous perdrez l'accès à ce ticket.</p>
                        <form class="mt-4 grid grid-cols-1 md:grid-cols-3 gap-3" action="{{ route('tickets.transfer', $ticket->qr_code_data) }}" method="POST">
                            @csrf
                            <div class="md:col-span-2">
                                <label for="recipient_email" class="sr-only">Email du destinataire</label>
                                <input type="email" required name="recipient_email" id="recipient_email" placeholder="destinataire@example.com" class="w-full rounded-md border-gray-300 focus:ring-indigo-500 focus:border-indigo-500" />
                            </div>
                            <div>
                                <button type="submit" class="w-full inline-flex items-center justify-center px-4 py-2 bg-indigo-600 text-white font-medium rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    Transférer le ticket
                                </button>
                            </div>
                        </form>
                        <p class="mt-2 text-xs text-gray-500">Cette action est <span class="font-semibold">irréversible</span>. Le nouveau détenteur recevra le ticket immédiatement.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
