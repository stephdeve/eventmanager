@extends('layouts.app')

@section('title', 'Historique des paiements')

@section('content')
    <div class="space-y-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-neutral-100">Historique des paiements</h1>
                <p class="mt-1 text-sm text-gray-600 dark:text-neutral-400">Aperçu des règlements liés à vos événements et à
                    votre abonnement.</p>
            </div>
            <a href="{{ route('subscriptions.plans') }}"
                class="inline-flex items-center rounded-lg bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow hover:bg-indigo-500">Gérer
                mon abonnement</a>
        </div>

        <div class="grid gap-6 lg:grid-cols-3">
            <div class="lg:col-span-2 bg-white shadow rounded-xl dark:bg-neutral-900 dark:border dark:border-neutral-800">
                <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between dark:border-neutral-800">
                    <h2 class="text-lg font-medium text-gray-900 dark:text-neutral-100">Paiements des événements</h2>
                    <span class="text-xs text-gray-500 dark:text-neutral-500">Derniers 50</span>
                </div>
                <div class="divide-y divide-gray-100 dark:divide-neutral-800">
                    @forelse($eventPayments as $reg)
                        <div class="px-6 py-4 flex items-center justify-between">
                            <div class="min-w-0">
                                <p class="text-sm font-semibold text-gray-900 dark:text-neutral-100">
                                    {{ $reg->event->title }}
                                </p>
                                <p class="mt-0.5 text-xs text-gray-500 dark:text-neutral-500">Participant:
                                    {{ $reg->user->name }}</p>
                            </div>
                            <div class="flex items-center gap-4">
                                <span
                                    class="text-sm font-medium {{ $reg->payment_status === 'paid' ? 'text-emerald-600' : ($reg->payment_status === 'pending' ? 'text-amber-600' : 'text-gray-500 dark:text-neutral-400') }}">
                                    {{ strtoupper($reg->payment_status) }}
                                </span>
                                <span
                                    class="text-sm text-gray-600 dark:text-neutral-400">{{ optional($reg->created_at)->translatedFormat('d M Y') }}</span>
                                <a href="{{ route('events.show', $reg->event) }}"
                                    class="text-sm text-indigo-600 hover:text-indigo-500 dark:text-indigo-300 dark:hover:text-indigo-400">Voir</a>
                            </div>
                        </div>
                    @empty
                        <div class="px-6 py-8 text-center text-sm text-gray-500 dark:text-neutral-500">Aucun paiement
                            enregistré pour le moment.</div>
                    @endforelse
                </div>
            </div>

            <div class="bg-white shadow rounded-xl p-6 dark:bg-neutral-900 dark:border dark:border-neutral-800">
                <h2 class="text-lg font-medium text-gray-900 dark:text-neutral-100">Mon abonnement</h2>
                <p class="mt-2 text-sm text-gray-600 dark:text-neutral-400">Rappel de votre offre actuelle.</p>
                <div class="mt-4 rounded-lg border border-gray-200 p-4 dark:border-neutral-800">
                    <p class="text-sm text-gray-500 dark:text-neutral-500">Offre en cours</p>
                    <p class="mt-1 text-xl font-bold text-gray-900 dark:text-neutral-100">
                        {{ ucfirst($user->subscription_plan ?? '—') }}</p>
                    <p class="mt-2 text-sm {{ $user->hasActiveSubscription() ? 'text-emerald-600' : 'text-amber-600' }}">
                        {{ $user->hasActiveSubscription() ? 'Actif' : 'Inactif / expiré' }}
                    </p>
                    @php
                        $prices = ['basic' => 30000, 'premium' => 60000, 'pro' => 90000];
                        $price = $prices[$user->subscription_plan ?? ''] ?? null;
                    @endphp
                    <p class="mt-2 text-sm text-gray-700 dark:text-neutral-300">
                        Prix mensuel: <span
                            class="font-semibold">{{ $price ? number_format($price / 100, 2, ',', ' ') . ' €' : '—' }}</span>
                    </p>
                    <p class="mt-2 text-xs text-gray-500 dark:text-neutral-500">Expiration:
                        {{ optional($user->subscription_expires_at)->translatedFormat('d M Y \à H\hi') ?? '—' }}</p>
                    <div class="mt-4 flex gap-2">
                        <a href="{{ route('subscriptions.plans') }}"
                            class="inline-flex items-center rounded-lg bg-indigo-600 px-3 py-2 text-xs font-semibold text-white hover:bg-indigo-500">Renouveler
                            / Changer d’offre</a>
                        <a href="{{ route('dashboard') }}"
                            class="inline-flex items-center rounded-lg border border-gray-200 px-3 py-2 text-xs font-semibold text-gray-700 hover:bg-gray-50 dark:border-neutral-800 dark:text-neutral-300 dark:hover:bg-neutral-800">Retour
                            dashboard</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
