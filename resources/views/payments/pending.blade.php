@extends('layouts.app')

@section('title', 'Finaliser le paiement')

@section('content')
<div class="py-12">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white shadow-xl sm:rounded-3xl overflow-hidden">
            <div class="bg-indigo-600 px-6 py-10 sm:px-10">
                <p class="text-indigo-100 text-sm uppercase tracking-[0.35em]">Paiement requis</p>
                <h1 class="mt-3 text-3xl font-bold text-white">Confirmer l'inscription</h1>
                <p class="mt-2 text-indigo-100 text-sm">
                    Finalise le paiement pour l'événement « {{ $event->title }} ».
                </p>
            </div>

            <div class="px-6 py-10 sm:px-10">
                @php
                    $amountMajor = (int) round(App\Support\Currency::toMajorUnits($event->price, $event->currency));
                    $iso = strtoupper($event->currency ?? 'XOF');
                    $supported = ['XOF','XAF','GNF'];
                    if (!in_array($iso, $supported, true)) { $iso = 'XOF'; }
                @endphp

                <div class="space-y-6">
                    <div class="rounded-2xl border border-gray-200 p-6">
                        <h2 class="text-base font-semibold text-gray-900">Récapitulatif</h2>
                        <dl class="mt-4 space-y-3 text-sm text-gray-600">
                            <div class="flex items-start">
                                <dt class="w-32 font-medium text-gray-700">Événement</dt>
                                <dd class="flex-1">{{ $event->title }}</dd>
                            </div>
                            <div class="flex items-start">
                                <dt class="w-32 font-medium text-gray-700">Lieu</dt>
                                <dd class="flex-1">{{ $event->location }}</dd>
                            </div>
                            <div class="flex items-start">
                                <dt class="w-32 font-medium text-gray-700">Montant</dt>
                                <dd class="flex-1 text-gray-900 font-semibold">{{ App\Support\Currency::format($event->price, $event->currency) }}</dd>
                            </div>
                            <div class="flex items-start">
                                <dt class="w-32 font-medium text-gray-700">Statut</dt>
                                <dd class="flex-1">
                                    <span class="inline-flex items-center rounded-full bg-amber-100 px-3 py-1 text-xs font-semibold text-amber-700">Paiement en attente</span>
                                </dd>
                            </div>
                        </dl>
                    </div>

                    <div class="rounded-2xl bg-indigo-50 border border-indigo-200 p-6">
                        <h2 class="text-base font-semibold text-indigo-900">Étapes suivantes</h2>
                        <p class="mt-2 text-sm text-indigo-800">
                            Clique sur le bouton ci-dessous pour payer via Kkiapay. Tu seras redirigé automatiquement vers ton billet après confirmation.
                        </p>

                        <div class="mt-6 space-y-3">
                            <button id="kkiapay-pay" type="button" class="inline-flex w-full items-center justify-center rounded-xl bg-indigo-600 px-4 py-3 text-sm font-semibold text-white shadow transition hover:bg-indigo-500">
                                Payer avec Kkiapay
                            </button>

                            <a href="{{ route('payments.pending', $registration) }}" class="inline-flex w-full items-center justify-center rounded-xl border border-indigo-200 px-4 py-2 text-sm font-semibold text-indigo-600 hover:bg-indigo-100">
                                Réessayer
                            </a>
                        </div>

                        <p class="mt-4 text-xs text-indigo-700">
                            Si ton paiement est accepté mais que la page ne se met pas à jour, recharge la page. En cas de souci, contacte le support.
                        </p>
                    </div>
                </div>

                <script src="https://cdn.kkiapay.me/k.js"></script>
                <script>
                    (function() {
                        const btn = document.getElementById('kkiapay-pay');
                        const amount = {{ $amountMajor }}; // integer major units (e.g., XOF)
                        const currency = @json($iso);
                        const sandbox = @json((bool) config('services.kkiapay.sandbox'));
                        const apiKey = @json(config('services.kkiapay.public_key'));
                        const name = @json(Auth::user()->name ?? '');
                        const email = @json(Auth::user()->email ?? '');

                        function openWidget() {
                            if (typeof window.openKkiapayWidget !== 'function') {
                                // Fallback for new SDK API
                                if (window.kkiapay && typeof window.kkiapay.open === 'function') {
                                    window.kkiapay.open({ amount, currency, sandbox, api_key: apiKey, name, email });
                                    return;
                                }
                                alert('Le widget de paiement n\'est pas disponible. Veuillez réessayer.');
                                return;
                            }

                            window.openKkiapayWidget({ amount, currency, sandbox, api_key: apiKey, name, email });
                        }

                        function onSuccess(resp) {
                            try {
                                const tx = resp && (resp.transactionId || resp.transaction_id || resp.reference || resp.id);
                                if (tx) {
                                    window.location.href = @json(route('payments.confirm', $registration)) + '?transaction_id=' + encodeURIComponent(tx);
                                    return;
                                }
                            } catch (e) {}
                            alert('Paiement réussi mais impossible de récupérer la transaction. Contactez le support.');
                        }

                        function onFailed(err) {
                            console.error('Kkiapay failed', err);
                            alert('Le paiement a échoué. Veuillez réessayer.');
                        }

                        function onCancelled() {
                            // Optionnel: feedback utilisateur
                        }

                        // Listeners
                        if (typeof window.addSuccessListener === 'function') {
                            window.addSuccessListener(onSuccess);
                        }
                        if (typeof window.addFailedListener === 'function') {
                            window.addFailedListener(onFailed);
                        }
                        if (typeof window.addCancelListener === 'function') {
                            window.addCancelListener(onCancelled);
                        }

                        btn?.addEventListener('click', openWidget);
                    })();
                </script>
            </div>
        </div>
    </div>
</div>
@endsection
