@extends('layouts.app')

@section('title', $title ?? 'Résultat de validation')

@section('content')
<div class="min-h-screen bg-gray-100 py-10">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white shadow-xl sm:rounded-2xl overflow-hidden">
            <div class="px-6 py-6 sm:px-8 border-b border-gray-200 flex items-center justify-between">
                <h1 class="text-xl font-semibold text-gray-900">{{ $title ?? 'Résultat de validation' }}</h1>
                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium {{ ($status ?? 'success') === 'success' ? 'bg-emerald-100 text-emerald-800' : 'bg-red-100 text-red-800' }}">
                    {{ ($status ?? 'success') === 'success' ? 'Succès' : 'Erreur' }}
                </span>
            </div>

            <div class="px-6 py-8 sm:px-8">
                <div class="mb-6">
                    <div class="rounded-lg p-4 {{ ($status ?? 'success') === 'success' ? 'bg-emerald-50 border border-emerald-200 text-emerald-900' : 'bg-rose-50 border border-rose-200 text-rose-900' }}">
                        <div class="flex items-start gap-3">
                            <div class="flex-shrink-0">
                                @if(($status ?? 'success') === 'success')
                                    <svg class="h-6 w-6 text-emerald-600" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                @else
                                    <svg class="h-6 w-6 text-rose-600" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z" />
                                    </svg>
                                @endif
                            </div>
                            <div>
                                <h3 class="font-medium">{{ $title ?? '' }}</h3>
                                @if(!empty($message))
                                    <p class="mt-1 text-sm">{{ $message }}</p>
                                @endif
                                @if(!empty($notice))
                                    <div class="mt-3 text-sm rounded-md border border-amber-200 bg-amber-50 text-amber-900 px-3 py-2">
                                        {{ $notice }}
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-3">
                        <div>
                            <div class="text-xs uppercase text-gray-500">Événement</div>
                            <div class="text-sm font-medium text-gray-900">
                                @if(($type ?? '') === 'ticket')
                                    {{ optional(optional($ticket ?? null)->event)->title ?? '—' }}
                                @else
                                    {{ optional(optional($registration ?? null)->event)->title ?? '—' }}
                                @endif
                            </div>
                        </div>
                        <div>
                            <div class="text-xs uppercase text-gray-500">Participant</div>
                            <div class="text-sm font-medium text-gray-900">
                                @if(($type ?? '') === 'ticket')
                                    {{ optional(optional($ticket ?? null)->owner)->name ?? '—' }}
                                @else
                                    {{ optional(optional($registration ?? null)->user)->name ?? '—' }}
                                @endif
                            </div>
                        </div>
                        <div>
                            <div class="text-xs uppercase text-gray-500">Statut</div>
                            <div class="text-sm font-medium {{ ($status ?? 'success') === 'success' ? 'text-emerald-700' : 'text-rose-700' }}">
                                {{ ($status ?? 'success') === 'success' ? 'Validé' : 'Non validé' }}
                            </div>
                        </div>
                    </div>

                    <div class="space-y-3">
                        <div>
                            <div class="text-xs uppercase text-gray-500">Date</div>
                            <div class="text-sm font-medium text-gray-900">{{ now()->format('d/m/Y H:i') }}</div>
                        </div>
                        @if(($type ?? '') === 'ticket')
                            <div>
                                <div class="text-xs uppercase text-gray-500">Méthode de paiement</div>
                                <div class="text-sm font-medium text-gray-900">{{ ($ticket->payment_method ?? null) ?: '—' }}</div>
                            </div>
                            <div>
                                <div class="text-xs uppercase text-gray-500">Payé</div>
                                <div class="text-sm font-medium text-gray-900">{{ isset($ticket) ? ($ticket->paid ? 'Oui' : 'Non') : '—' }}</div>
                            </div>
                        @elseif(($type ?? '') === 'registration')
                            <div>
                                <div class="text-xs uppercase text-gray-500">Statut paiement</div>
                                <div class="text-sm font-medium text-gray-900">{{ strtoupper($registration->payment_status ?? '—') }}</div>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="mt-8 flex flex-col sm:flex-row gap-3">
                    <a href="{{ route('scanner') }}" class="inline-flex items-center justify-center px-4 py-2 rounded-lg text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        Retour au scanner
                    </a>
                    <a href="{{ route('dashboard') }}" class="inline-flex items-center justify-center px-4 py-2 rounded-lg text-sm font-medium text-gray-700 bg-white border border-gray-200 hover:bg-gray-50">
                        Aller au tableau de bord
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
