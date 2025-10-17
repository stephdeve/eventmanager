@extends('layouts.app')
@php use Illuminate\Support\Str; @endphp

@section('title', 'Votre billet')

@section('content')
<div class="py-10">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white shadow-xl overflow-hidden sm:rounded-2xl">
            <div class="bg-indigo-600 px-6 py-12 sm:px-12">
                <div class="flex flex-wrap items-center justify-between gap-6">
                    <div>
                        <p class="text-indigo-100 text-sm uppercase tracking-widest">Confirmation d'inscription</p>
                        <h1 class="mt-2 text-3xl font-bold text-white">{{ $registration->event->title }}</h1>
                        <p class="mt-2 text-indigo-100 text-sm">Organisé par {{ $registration->event->organizer->name }}</p>
                    </div>
                    <div class="text-indigo-100 text-right">
                        <p class="text-sm">Date d'inscription</p>
                        <p class="text-xl font-semibold">{{ $registration->created_at->format('d/m/Y H:i') }}</p>
                        <p class="mt-1 text-sm">Statut :
                            <span class="font-semibold {{ $registration->is_validated ? 'text-green-200' : 'text-yellow-200' }}">
                                {{ $registration->is_validated ? 'Validé' : 'En attente' }}
                            </span>
                        </p>
                    </div>
                </div>
            </div>

            <div class="px-6 py-10 sm:px-12">
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <div class="lg:col-span-2 space-y-6">
                        <div class="border border-gray-200 rounded-xl p-6">
                            <h2 class="text-lg font-semibold text-gray-900">Informations sur l'événement</h2>
                            <dl class="mt-4 space-y-3 text-sm text-gray-600">
                                <div class="flex items-start">
                                    <dt class="w-32 font-medium text-gray-700">Date</dt>
                                    <dd class="flex-1">
                                        @if($registration->event->event_date)
                                            {{ $registration->event->event_date->translatedFormat('l d F Y \à H\hi') }}
                                        @elseif($registration->event->start_date)
                                            {{ $registration->event->start_date->translatedFormat('l d F Y \à H\hi') }}
                                        @else
                                            Date à confirmer
                                        @endif
                                    </dd>
                                </div>
                                <div class="flex items-start">
                                    <dt class="w-32 font-medium text-gray-700">Lieu</dt>
                                    <dd class="flex-1">{{ $registration->event->location }}</dd>
                                </div>
                                <div class="flex items-start">
                                    <dt class="w-32 font-medium text-gray-700">Tarif</dt>
                                    <dd class="flex-1">
                                        @if(isset($registration->event->price))
                                            {{ $registration->event->price > 0 ? number_format($registration->event->price / 100, 2, ',', ' ') . ' €' : 'Gratuit' }}
                                        @else
                                            Non communiqué
                                        @endif
                                    </dd>
                                </div>
                                <div class="flex items-start">
                                    <dt class="w-32 font-medium text-gray-700">Participant</dt>
                                    <dd class="flex-1">{{ $registration->user->name }} ({{ $registration->user->email }})</dd>
                                </div>
                            </dl>
                        </div>

                        <div class="border border-gray-200 rounded-xl p-6">
                            <h2 class="text-lg font-semibold text-gray-900">Instructions importantes</h2>
                            <ul class="mt-4 space-y-2 text-sm text-gray-600 list-disc list-inside">
                                <li>Présentez ce billet (imprimé ou sur mobile) à l'entrée de l'événement.</li>
                                <li>Conservez ce QR code : il sera scanné pour valider votre présence.</li>
                                <li>Arrivez 15 minutes avant le début pour faciliter l'enregistrement.</li>
                            </ul>
                        </div>

                        @if($registration->tickets->count() > 0)
                        <div class="border border-gray-200 rounded-xl p-6">
                            <h2 class="text-lg font-semibold text-gray-900">Vos billets ({{ $registration->tickets->count() }})</h2>
                            <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-4">
                                @foreach($registration->tickets as $ticket)
                                    <div class="border rounded-lg p-4 flex items-center justify-between">
                                        <div>
                                            <p class="text-sm text-gray-900 font-semibold">Billet #{{ $ticket->id }}</p>
                                            <p class="text-xs text-gray-600">QR: {{ Str::limit($ticket->qr_code_data, 10) }}</p>
                                            <div class="mt-1 text-xs">
                                                @if($ticket->status === 'used')
                                                    <span class="inline-flex px-2 py-1 rounded-full bg-yellow-100 text-yellow-800">Utilisé</span>
                                                @elseif($ticket->status === 'invalid')
                                                    <span class="inline-flex px-2 py-1 rounded-full bg-red-100 text-red-800">Invalide</span>
                                                @else
                                                    <span class="inline-flex px-2 py-1 rounded-full bg-green-100 text-green-800">Valide</span>
                                                @endif
                                                @if($ticket->paid)
                                                    <span class="inline-flex ml-2 px-2 py-1 rounded-full bg-green-100 text-green-800">Payé</span>
                                                @elseif($ticket->payment_method === 'physical')
                                                    <span class="inline-flex ml-2 px-2 py-1 rounded-full bg-gray-100 text-gray-800">Paiement sur place</span>
                                                @else
                                                    <span class="inline-flex ml-2 px-2 py-1 rounded-full bg-orange-100 text-orange-800">Paiement en attente</span>
                                                @endif
                                            </div>
                                        </div>
                                        <div>
                                            <a href="{{ route('tickets.show', $ticket->qr_code_data) }}" class="inline-flex items-center px-3 py-2 text-sm font-medium rounded-md border border-indigo-600 text-indigo-600 hover:bg-indigo-50">
                                                Ouvrir
                                            </a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        @endif
                    </div>

                    <div class="lg:col-span-1">
                        <div class="border border-dashed border-gray-300 rounded-2xl p-6 text-center space-y-6">
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900">Votre QR Code</h3>
                                <p class="mt-1 text-sm text-gray-500">Scannez ce code à l'entrée</p>
                            </div>

                            @if($registration->qr_code_path)
                                <img src="{{ asset('storage/' . ltrim($registration->qr_code_path, '/')) }}" alt="QR Code" class="mx-auto w-48 h-48 object-contain">
                            @else
                                <div class="mx-auto w-48 h-48 flex items-center justify-center bg-gray-100 rounded-lg">
                                    <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4.75 4.75v3.5h3.5v-3.5h-3.5zm0 7v3.5h3.5v-3.5h-3.5zm7-7v3.5h3.5v-3.5h-3.5zm0 7v3.5h3.5v-3.5h-3.5zm7-7v3.5h3.5v-3.5h-3.5zm0 7v3.5h3.5v-3.5h-3.5z" />
                                    </svg>
                                </div>
                                <p class="text-sm text-orange-500">Le QR code est en cours de génération. Veuillez actualiser cette page dans quelques instants.</p>
                            @endif

                            <div class="space-y-3">
                                <a href="{{ route('registrations.download', $registration->qr_code_data) }}" class="inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    Télécharger le billet (PDF)
                                </a>
                                <a href="{{ route('events.show', $registration->event) }}" class="inline-flex items-center justify-center px-4 py-2 border border-indigo-600 text-sm font-medium rounded-md text-indigo-600 bg-white hover:bg-indigo-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    Retour à l'événement
                                </a>
                                <a href="{{ route('dashboard') }}" class="inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-gray-800 hover:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-700">
                                    Retour au tableau de bord
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
