<div x-data="buyCoinsState({
    unit: {{ (int) (\App\Models\Setting::get('interactive.coin_price_minor', 100) ?? 100) }},
    currency: '{{ strtoupper(config('app.currency', 'XOF')) }}'
})" class="w-full">

    <!-- En-tête avec solde et actions (dark) -->
    <div
        class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8 p-6 bg-gradient-to-r from-slate-800 to-slate-700 rounded-2xl border border-slate-700 text-slate-200">
        <div class="flex items-center gap-4">
            <div
                class="w-12 h-12 bg-gradient-to-r from-yellow-400 to-yellow-500 rounded-xl flex items-center justify-center shadow-lg">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <div>
                <div class="text-sm font-medium text-slate-300">Votre solde de coins</div>
                <div class="text-2xl font-bold text-white" id="wallet-balance">{{ $walletBalance ?? 0 }}</div>
                <div class="text-xs text-slate-400 mt-1">1 coin = 100 F CFA</div>
            </div>
        </div>

        <div class="flex flex-wrap gap-3">
            @auth
                @if (config('services.kkiapay.public_key'))
                    <button type="button" @click="openBuy = true"
                        class="inline-flex items-center gap-2 px-4 py-2.5 bg-gradient-to-r from-emerald-600 to-green-600 text-white text-sm font-semibold rounded-xl hover:from-emerald-700 hover:to-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 transition-all duration-200 shadow-sm hover:shadow-md">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Acheter des coins
                    </button>
                @else
                    <button type="button" disabled
                        class="inline-flex items-center gap-2 px-4 py-2.5 bg-gray-300 text-gray-600 text-sm font-semibold rounded-xl cursor-not-allowed">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                        Paiement indisponible
                    </button>
                @endif
            @else
                <a href="{{ route('login') }}"
                    class="inline-flex items-center gap-2 px-4 py-2.5 bg-gradient-to-r from-emerald-600 to-green-600 text-white text-sm font-semibold rounded-xl hover:from-emerald-700 hover:to-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 transition-all duration-200 shadow-sm hover:shadow-md">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                    Se connecter pour acheter
                </a>
            @endauth

            <button type="button" wire:click="$refresh"
                class="inline-flex items-center gap-2 px-4 py-2.5 bg-slate-900 border border-slate-600 text-slate-300 text-sm font-semibold rounded-xl hover:bg-slate-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-slate-500 transition-all duration-200">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                </svg>
                Rafraîchir
            </button>
        </div>
    </div>

    <!-- Liste des participants (dark cards) -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach ($event->participants as $participant)
            <div
                class="bg-slate-900 rounded-2xl border border-slate-700 p-6 shadow-sm hover:shadow-md transition-all duration-200 hover:-translate-y-1">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex-1 min-w-0">
                        <h4 class="font-semibold text-slate-100 text-sm truncate">{{ $participant->name }}</h4>
                        @if ($participant->country)
                            <div class="flex items-center gap-1 mt-1">
                                <svg class="w-3 h-3 text-gray-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span class="text-xs text-slate-400">{{ $participant->country }}</span>
                            </div>
                        @endif
                    </div>
                    <div class="text-right">
                        <div class="text-xs text-slate-400 mb-1">Score total</div>
                        <div class="text-lg font-bold text-slate-100">{{ $participant->score_total }}</div>
                    </div>
                </div>

                <div class="flex gap-2">
                    <button wire:click="freeVote({{ $participant->id }})"
                        class="flex-1 inline-flex items-center justify-center gap-2 px-3 py-2 bg-gradient-to-r from-fuchsia-600 to-violet-600 text-white text-xs font-medium rounded-lg hover:from-fuchsia-700 hover:to-violet-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-fuchsia-500 transition-all duration-200">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5" />
                        </svg>
                        Vote gratuit
                    </button>

                    <button wire:click="premiumVote({{ $participant->id }})"
                        class="flex-1 inline-flex items-center justify-center gap-2 px-3 py-2 bg-gradient-to-r from-fuchsia-600 to-violet-600 text-white text-xs font-medium rounded-lg hover:from-fuchsia-700 hover:to-violet-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-fuchsia-500 transition-all duration-200">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Vote premium
                    </button>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Modal d'achat de coins -->
    <div x-show="openBuy" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4">
        <div class="fixed inset-0 bg-black/50 transition-opacity" @click="openBuy = false"></div>

        <div class="relative bg-white rounded-2xl shadow-xl w-full max-w-md transform transition-all">
            <!-- En-tête du modal -->
            <div class="px-6 py-4 border-b border-gray-200">
                <div class="flex items-center gap-3">
                    <div
                        class="w-10 h-10 bg-gradient-to-r from-emerald-500 to-green-500 rounded-xl flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900">Acheter des coins</h3>
                        <p class="text-sm text-gray-600">Rechargez votre portefeuille virtuel</p>
                    </div>
                </div>
            </div>

            <!-- Contenu du modal -->
            <div class="p-6 space-y-6">
                <!-- Quantité -->
                <div class="form-group">
                    <label class="form-label">
                        Quantité de coins *
                        <span class="text-[#6B7280] text-sm font-normal">(minimum 10 coins)</span>
                    </label>
                    <input type="number" min="10" step="1" x-model.number="qty"
                        class="form-input @error('qty') error @enderror" placeholder="Entrez le nombre de coins">
                </div>

                <!-- Boutons rapides -->
                <div class="flex gap-2">
                    <template x-for="amount in [10, 50, 100]">
                        <button type="button" @click="qty = Math.max(min, (qty||0)+amount)"
                            class="flex-1 px-3 py-2 bg-gray-100 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-colors">
                            +<span x-text="amount"></span>
                        </button>
                    </template>
                </div>

                <!-- Résumé du prix -->
                <div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-xl p-4 border border-blue-200">
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-gray-600">Coût total :</span>
                        <span class="text-lg font-bold text-blue-700"
                            x-text="(qty && qty>=min ? (qty*unit).toLocaleString('fr-FR') : '0') + ' ' + currency"></span>
                    </div>
                    <div class="text-xs text-gray-500 mt-1">
                        <span x-text="qty || 0"></span> coins × <span
                            x-text="unit.toLocaleString('fr-FR')"></span> <span x-text="currency"></span> par coin
                    </div>
                </div>
            </div>

            <!-- Actions du modal -->
            <div class="px-6 py-4 border-t border-gray-200 bg-gray-50 rounded-b-2xl">
                <div class="flex justify-end gap-3">
                    <button type="button" @click="openBuy = false"
                        class="px-4 py-2 bg-white border border-gray-300 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-colors">
                        Annuler
                    </button>
                    <button type="button" @click="buy()" :disabled="!(qty && qty >= min)"
                        class="px-4 py-2 bg-gradient-to-r from-emerald-600 to-green-600 text-white text-sm font-medium rounded-lg hover:from-emerald-700 hover:to-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 disabled:opacity-50 disabled:cursor-not-allowed transition-all duration-200">
                        Procéder au paiement
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('livewire:init', () => {
            window.addEventListener('toast', (e) => {
                const container = document.getElementById('toast-container') || document.body;
                const toast = document.createElement('div');
                toast.className =
                    'fixed z-60 top-4 right-4 max-w-sm px-4 z-60 py-3 rounded-xl shadow-lg text-white transform transition-all duration-300 ' +
                    (e.detail.type === 'success' ? 'bg-gradient-to-r from-emerald-600 to-green-600' :
                        e.detail.type === 'warning' ? 'bg-gradient-to-r from-amber-600 to-orange-600' :
                        'bg-gradient-to-r from-gray-800 to-gray-700');
                toast.textContent = e.detail.message || '';
                container.appendChild(toast);

                setTimeout(() => {
                    toast.style.opacity = '0';
                    toast.style.transform = 'translateX(100%)';
                    setTimeout(() => toast.remove(), 300);
                }, 3500);
            });
        });

        window.buyCoinsState = function(opts) {
            return {
                openBuy: false,
                qty: 10,
                unit: Number(opts.unit || 100),
                currency: String(opts.currency || 'XOF'),
                min: 10,

                async buy() {
                    const qty = Number(this.qty || 0);
                    if (!qty || qty < this.min) return;

                    try {
                        const res = await fetch("{{ route('coins.checkout') }}", {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'Accept': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content
                            },
                            body: JSON.stringify({
                                coins: qty
                            })
                        });

                        const data = await res.json();

                        if (!data || !data.success || data.provider !== 'kkiapay') {
                            window.dispatchEvent(new CustomEvent('toast', {
                                detail: {
                                    type: 'error',
                                    message: 'Paiement indisponible pour le moment.'
                                }
                            }));
                            return;
                        }

                        // Initialisation Kkiapay
                        async function ensureKkiapay() {
                            return new Promise((resolve) => {
                                if (window.kkiapay || window.openKkiapayWidget) return resolve();
                                const script = document.createElement('script');
                                script.src = 'https://cdn.kkiapay.me/k.js';
                                script.onload = () => resolve();
                                document.head.appendChild(script);
                            });
                        }

                        await ensureKkiapay();

                        // Configuration du widget
                        const self = this;

                        function onSuccess(resp) {
                            try {
                                const transactionId = resp?.transactionId || resp?.transaction_id || resp
                                    ?.reference || resp?.id;
                                if (!transactionId) throw new Error('Transaction manquante');

                                fetch("{{ route('coins.confirm') }}", {
                                        method: 'POST',
                                        headers: {
                                            'Content-Type': 'application/json',
                                            'Accept': 'application/json',
                                            'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]')
                                                .content
                                        },
                                        body: JSON.stringify({
                                            transaction_id: transactionId,
                                            coins: qty
                                        })
                                    })
                                    .then(r => r.json())
                                    .then(response => {
                                        if (response?.success) {
                                            const balanceElement = document.getElementById('wallet-balance');
                                            if (balanceElement && typeof response.balance !== 'undefined') {
                                                balanceElement.textContent = response.balance;
                                            }
                                            window.dispatchEvent(new CustomEvent('toast', {
                                                detail: {
                                                    type: 'success',
                                                    message: 'Coins crédités avec succès !'
                                                }
                                            }));
                                            self.openBuy = false;
                                            self.qty = 10;
                                        } else {
                                            window.dispatchEvent(new CustomEvent('toast', {
                                                detail: {
                                                    type: 'error',
                                                    message: response?.message ||
                                                        'Erreur de confirmation'
                                                }
                                            }));
                                        }
                                    })
                                    .catch(() => {
                                        window.dispatchEvent(new CustomEvent('toast', {
                                            detail: {
                                                type: 'error',
                                                message: 'Erreur de confirmation'
                                            }
                                        }));
                                    });
                            } catch (error) {
                                window.dispatchEvent(new CustomEvent('toast', {
                                    detail: {
                                        type: 'warning',
                                        message: 'Paiement réussi mais confirmation en attente'
                                    }
                                }));
                            }
                        }

                        function onFailed(error) {
                            console.error('Kkiapay failed:', error);
                            window.dispatchEvent(new CustomEvent('toast', {
                                detail: {
                                    type: 'error',
                                    message: 'Paiement échoué'
                                }
                            }));
                        }

                        function onCancelled() {
                            window.dispatchEvent(new CustomEvent('toast', {
                                detail: {
                                    type: 'info',
                                    message: 'Paiement annulé'
                                }
                            }));
                        }

                        // Écouteurs d'événements
                        if (typeof window.addSuccessListener === 'function') window.addSuccessListener(onSuccess);
                        if (typeof window.addFailedListener === 'function') window.addFailedListener(onFailed);
                        if (typeof window.addCancelListener === 'function') window.addCancelListener(onCancelled);

                        // Ouverture du widget
                        const name = @json(Auth::user()->name ?? '');
                        const email = @json(Auth::user()->email ?? '');

                        const opened = window.openKkiapayWidget?.({
                            amount: Number(data.amount),
                            currency: data.currency || 'XOF',
                            api_key: data.public_key,
                            sandbox: !!data.sandbox,
                            name: name || '',
                            email: email || ''
                        }) || window.kkiapay?.open?.({
                            amount: Number(data.amount),
                            currency: data.currency || 'XOF',
                            api_key: data.public_key,
                            sandbox: !!data.sandbox,
                            name: window.CURRENT_USER_NAME || '',
                            email: window.CURRENT_USER_EMAIL || ''
                        });

                        if (!opened) {
                            window.dispatchEvent(new CustomEvent('toast', {
                                detail: {
                                    type: 'error',
                                    message: 'Widget de paiement indisponible'
                                }
                            }));
                        }
                    } catch (error) {
                        console.error('Buy error:', error);
                        window.dispatchEvent(new CustomEvent('toast', {
                            detail: {
                                type: 'error',
                                message: 'Erreur réseau'
                            }
                        }));
                    }
                }
            };
        }
    </script>
</div>

@push('styles')
    <style>
        .form-group {
            position: relative;
        }

        .form-label {
            display: block;
            font-weight: 600;
            color: #1E3A8A;
            margin-bottom: 0.5rem;
            font-size: 0.9rem;
        }

        .form-input {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 2px solid #E5E7EB;
            border-radius: 12px;
            background: white;
            transition: all 0.3s ease;
            font-size: 0.95rem;
        }

        .form-input:focus {
            outline: none;
            border-color: #4F46E5;
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
            transform: translateY(-1px);
        }

        .form-input.error {
            border-color: #EF4444;
            box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.1);
        }

        [x-cloak] {
            display: none !important;
        }
    </style>
@endpush
