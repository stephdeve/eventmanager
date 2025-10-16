@extends('layouts.app')

@section('title', 'Choisir un abonnement organisateur')

@section('content')
<div class="py-12">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mb-10">
            <h1 class="text-3xl font-bold text-gray-900">Devenir organisateur</h1>
            <p class="mt-2 text-gray-600">Sélectionnez une formule pour activer votre espace organisateur.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Basic -->
            <div class="rounded-2xl border border-gray-200 bg-white p-6 flex flex-col">
                <h2 class="text-xl font-semibold text-gray-900">Basique</h2>
                <p class="mt-1 text-gray-500">Idéal pour débuter</p>
                <div class="mt-4 text-3xl font-bold text-gray-900">30 000 <span class="text-base font-medium text-gray-500">FCFA / mois</span></div>
                <ul class="mt-6 space-y-2 text-sm text-gray-600">
                    <li>• 50 places max par événement</li>
                    <li>• 10 événements par mois</li>
                    <li>• Pas de lien de promotion</li>
                </ul>
                <div class="mt-auto pt-6">
                    <button type="button"
                        class="kkiapay-subscribe inline-flex w-full items-center justify-center rounded-xl bg-indigo-600 px-4 py-3 text-sm font-semibold text-white shadow transition hover:bg-indigo-500"
                        data-plan="basic" data-amount="30000">
                        Passer à cet abonnement
                    </button>
                </div>
            </div>

            <!-- Premium -->
            <div class="rounded-2xl border border-indigo-200 bg-indigo-50 p-6 flex flex-col">
                <h2 class="text-xl font-semibold text-indigo-900">Premium</h2>
                <p class="mt-1 text-indigo-700">Pour monter en puissance</p>
                <div class="mt-4 text-3xl font-bold text-indigo-900">60 000 <span class="text-base font-medium text-indigo-700">FCFA / mois</span></div>
                <ul class="mt-6 space-y-2 text-sm text-indigo-800">
                    <li>• 150 places max par événement</li>
                    <li>• 30 événements par mois</li>
                    <li>• Lien de promotion + suivi clics/inscriptions</li>
                </ul>
                <div class="mt-auto pt-6">
                    <button type="button"
                        class="kkiapay-subscribe inline-flex w-full items-center justify-center rounded-xl bg-indigo-600 px-4 py-3 text-sm font-semibold text-white shadow transition hover:bg-indigo-500"
                        data-plan="premium" data-amount="60000">
                        Passer à cet abonnement
                    </button>
                </div>
            </div>

            <!-- Pro -->
            <div class="rounded-2xl border border-gray-200 bg-white p-6 flex flex-col">
                <h2 class="text-xl font-semibold text-gray-900">Pro</h2>
                <p class="mt-1 text-gray-500">Pour les pros exigeants</p>
                <div class="mt-4 text-3xl font-bold text-gray-900">90 000 <span class="text-base font-medium text-gray-500">FCFA / mois</span></div>
                <ul class="mt-6 space-y-2 text-sm text-gray-600">
                    <li>• Places illimitées par événement</li>
                    <li>• 100 événements par mois</li>
                    <li>• Lien de promotion + suivi clics/inscriptions</li>
                </ul>
                <div class="mt-auto pt-6">
                    <button type="button"
                        class="kkiapay-subscribe inline-flex w-full items-center justify-center rounded-xl bg-indigo-600 px-4 py-3 text-sm font-semibold text-white shadow transition hover:bg-indigo-500"
                        data-plan="pro" data-amount="90000">
                        Passer à cet abonnement
                    </button>
                </div>
            </div>
        </div>

        <p class="mt-6 text-xs text-gray-500">Le paiement est traité par Kkiapay. Une fois confirmé, votre compte sera automatiquement mis à niveau en organisateur.</p>
    </div>
</div>

<script src="https://cdn.kkiapay.me/k.js"></script>
<script>
(function() {
    const buttons = document.querySelectorAll('.kkiapay-subscribe');
    const currency = 'XOF';
    const sandbox = {{ json_encode((bool) config('services.kkiapay.sandbox')) }};
    const apiKey = @json(config('services.kkiapay.public_key'));
    const name = @json(Auth::user()->name ?? '');
    const email = @json(Auth::user()->email ?? '');
    let selectedPlan = null;

    function openWidget(amount) {
        if (typeof window.openKkiapayWidget !== 'function') {
            if (window.kkiapay && typeof window.kkiapay.open === 'function') {
                window.kkiapay.open({ amount, currency, sandbox, api_key: apiKey, name, email });
                return;
            }
            alert("Le widget de paiement n'est pas disponible. Veuillez réessayer.");
            return;
        }
        window.openKkiapayWidget({ amount, currency, sandbox, api_key: apiKey, name, email });
    }

    function onSuccess(resp) {
        try {
            const tx = resp && (resp.transactionId || resp.transaction_id || resp.reference || resp.id);
            if (tx && selectedPlan) {
                const url = @json(route('subscriptions.confirm')) + '?plan=' + encodeURIComponent(selectedPlan) + '&transaction_id=' + encodeURIComponent(tx);
                window.location.href = url;
                return;
            }
        } catch (e) {}
        alert('Paiement réussi mais impossible de confirmer. Contactez le support.');
    }

    function onFailed(err) {
        console.error('Kkiapay failed', err);
        alert('Le paiement a échoué. Veuillez réessayer.');
    }

    if (typeof window.addSuccessListener === 'function') {
        window.addSuccessListener(onSuccess);
    }
    if (typeof window.addFailedListener === 'function') {
        window.addFailedListener(onFailed);
    }

    buttons.forEach(btn => {
        btn.addEventListener('click', () => {
            selectedPlan = btn.getAttribute('data-plan');
            const amount = parseInt(btn.getAttribute('data-amount'), 10) || 0;
            openWidget(amount);
        });
    });
})();
</script>
@endsection
