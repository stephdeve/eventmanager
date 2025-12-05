<div x-data="buyCoinsState({
    unit: {{ (int) (\App\Models\Setting::get('interactive.coin_price_minor', 100) ?? 100) }},
    currency: '{{ strtoupper(config('app.currency', 'XOF')) }}'
})" class="w-full">

    <!-- En-tête avec solde et actions -->
    <div class="coins-header">
        <div class="coins-balance-section">
            <div class="coins-icon">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <div class="coins-info">
                <h3>Votre solde de coins</h3>
                <div class="balance" id="wallet-balance">{{ $walletBalance ?? 0 }} COINS</div>
                <div class="rate">1 coin = 100 F CFA</div>
            </div>
        </div>

        <div class="coins-actions">
            @auth
                @if (config('services.kkiapay.public_key'))
                    <button type="button" @click="openBuy = true" class="btn-primary">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Acheter des coins
                    </button>
                @else
                    <button type="button" disabled class="btn-disabled">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                        Paiement indisponible
                    </button>
                @endif
            @else
                <a href="{{ route('login') }}" class="btn-primary">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                    Se connecter pour acheter
                </a>
            @endauth

            <button type="button" wire:click="$refresh" class="btn-secondary">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                </svg>
                Rafraîchir
            </button>
        </div>
    </div>


    <!-- Liste des participants -->
    <div class="participants-grid">
        @foreach ($event->participants as $participant)
            <div class="participant-card-dark">
                <div class="participant-header">
                    <div class="participant-info">
                        <h4 class="participant-name">{{ $participant->name }}</h4>
                        @if ($participant->country)
                            <div class="participant-country">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span>{{ $participant->country }}</span>
                            </div>
                        @endif
                    </div>
                    <div class="participant-score">
                        <div class="score-label">Score total</div>
                        <div class="score-value">{{ $participant->score_total }}</div>
                    </div>
                </div>

                <div class="vote-buttons">
                    <button wire:click="freeVote({{ $participant->id }})" class="btn-vote">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5" />
                        </svg>
                        Vote gratuit
                    </button>

                    <button wire:click="premiumVote({{ $participant->id }})" class="btn-vote">
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
    <div x-show="openBuy" x-cloak class="modal-overlay" @click="openBuy = false">
        <div class="modal-content" @click.stop>
            <div class="modal-header">
                <div class="modal-icon">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div>
                    <h3 class="modal-title">Acheter des coins</h3>
                    <p class="modal-subtitle">Rechargez votre portefeuille virtuel</p>
                </div>
            </div>

            <div class="modal-body">
                <div class="form-group">
                    <label class="form-label">
                        Quantité de coins *
                        <span class="text-gray-500 text-sm font-normal">(minimum 10 coins)</span>
                    </label>
                    <input type="number" min="10" step="1" x-model.number="qty" class="form-input"
                        placeholder="Entrez le nombre de coins">
                </div>

                <div class="quick-amounts">
                    <template x-for="amount in [10, 50, 100]">
                        <button type="button" @click="qty = Math.max(min, (qty||0)+amount)"
                            class="quick-amount-btn">
                            +<span x-text="amount"></span>
                        </button>
                    </template>
                </div>

                <div class="price-summary">
                    <div class="price-row">
                        <span class="price-label">Coût total :</span>
                        <span class="price-value"
                            x-text="(qty && qty>=min ? (qty*unit).toLocaleString('fr-FR') : '0') + ' ' + currency"></span>
                    </div>
                    <div class="price-details">
                        <span x-text="qty || 0"></span> coins × <span x-text="unit.toLocaleString('fr-FR')"></span>
                        <span x-text="currency"></span> par coin
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <div class="footer-actions">
                    <button type="button" @click="openBuy = false" class="btn-cancel">
                        Annuler
                    </button>
                    <button type="button" @click="buy()" :disabled="!(qty && qty >= min)" class="btn-confirm">
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
                    'toast transform transition-all duration-300 ' +
                    (e.detail.type === 'success' ? 'toast-success' :
                        e.detail.type === 'warning' ? 'toast-warning' :
                        'toast-error');
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
        .coins-header {
            display: flex;
            flex-direction: row;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
            margin-bottom: 2rem;
            padding: 1.5rem;
            background: linear-gradient(135deg, #4F46E5 0%, #6366f1 100%);
            border-radius: 16px;
            color: white;
        }

        .coins-balance-section {
            display: flex;
            align-items: center;
            gap: 1rem;
            flex: 1;
        }

        .coins-icon {
            width: 3rem;
            height: 3rem;
            background: linear-gradient(135deg, #F59E0B 0%, #fbbf24 100%);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 6px 15px rgba(245, 158, 11, 0.3);
        }

        .coins-info h3 {
            font-size: 0.875rem;
            font-weight: 600;
            color: rgba(255, 255, 255, 0.9);
            margin-bottom: 0.25rem;
        }

        .coins-info .balance {
            font-size: 1.5rem;
            font-weight: 800;
            color: white;
        }

        .coins-info .rate {
            font-size: 0.75rem;
            color: rgba(255, 255, 255, 0.7);
            margin-top: 0.25rem;
        }

        .coins-actions {
            display: flex;
            flex-wrap: wrap;
            gap: 0.75rem;
            justify-content: flex-end;
        }

        .btn-primary {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.625rem 1rem;
            background: linear-gradient(135deg, #10B981 0%, #059669 100%);
            color: white;
            font-size: 0.875rem;
            font-weight: 600;
            border-radius: 12px;
            border: none;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
            text-decoration: none;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(16, 185, 129, 0.4);
            background: linear-gradient(135deg, #059669 0%, #16A34A 100%);
        }

        .btn-secondary {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.625rem 1rem;
            background: rgba(255, 255, 255, 0.1);
            color: white;
            font-size: 0.875rem;
            font-weight: 600;
            border-radius: 12px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .btn-secondary:hover {
            background: rgba(255, 255, 255, 0.15);
            transform: translateY(-2px);
        }

        .btn-disabled {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.625rem 1rem;
            background: #9ca3af;
            color: #6b7280;
            font-size: 0.875rem;
            font-weight: 600;
            border-radius: 12px;
            border: none;
            cursor: not-allowed;
        }

        /* Version mobile */
        @media (max-width: 768px) {
            .coins-header {
                flex-direction: column;
                align-items: stretch;
                text-align: center;
            }

            .coins-balance-section {
                justify-content: center;
                margin-bottom: 1rem;
            }

            .coins-actions {
                justify-content: center;
            }
        }

        /* Le reste de votre CSS existant */
        .participants-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 1.5rem;
        }

        .participant-card-dark {
            background: white;
            border: 1px solid #e2e8f0;
            border-radius: 16px;
            padding: 1.5rem;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        }

        .participant-card-dark:hover {
            transform: translateY(-4px);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.15);
            border-color: #4F46E5;
        }

        .participant-header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            margin-bottom: 1rem;
        }

        .participant-info {
            flex: 1;
            min-width: 0;
        }

        .participant-name {
            font-size: 0.875rem;
            font-weight: 600;
            color: #1e293b;
            margin-bottom: 0.25rem;
        }

        .participant-country {
            display: flex;
            align-items: center;
            gap: 0.25rem;
            font-size: 0.75rem;
            color: #64748b;
        }

        .participant-score {
            text-align: right;
        }

        .score-label {
            font-size: 0.75rem;
            color: #64748b;
            margin-bottom: 0.25rem;
        }

        .score-value {
            font-size: 1.125rem;
            font-weight: 700;
            color: #1e293b;
        }

        .vote-buttons {
            display: flex;
            gap: 0.5rem;
        }

        .btn-vote {
            flex: 1;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.375rem;
            padding: 0.5rem 0.75rem;
            background: linear-gradient(135deg, #4F46E5 0%, #6366f1 100%);
            color: white;
            font-size: 0.75rem;
            font-weight: 500;
            border-radius: 8px;
            border: none;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .btn-vote:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(79, 70, 229, 0.3);
            background: linear-gradient(135deg, #4338CA 0%, #6366f1 100%);
        }

        .modal-overlay {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.5);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1rem;
            z-index: 70;
        }

        .modal-content {
            background: white;
            border-radius: 16px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
            width: 100%;
            max-width: 28rem;
            position: relative;
        }

        .dark .modal-content {
            background: #0b1220;
            border: 1px solid #1f2937;
            color: #e5e7eb;
        }

        .modal-header {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 1.5rem;
            border-bottom: 1px solid #e5e7eb;
        }

        .modal-icon {
            width: 2.5rem;
            height: 2.5rem;
            background: linear-gradient(135deg, #10B981 0%, #059669 100%);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .modal-title {
            font-size: 1.125rem;
            font-weight: 600;
            color: #1f2937;
        }

        .modal-subtitle {
            font-size: 0.875rem;
            color: #6b7280;
        }

        .modal-body {
            padding: 1.5rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            display: block;
            font-size: 0.875rem;
            font-weight: 600;
            color: #374151;
            margin-bottom: 0.5rem;
        }

        .form-input {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 2px solid #e5e7eb;
            border-radius: 8px;
            font-size: 0.875rem;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .form-input:focus {
            outline: none;
            border-color: #4F46E5;
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
        }

        .quick-amounts {
            display: flex;
            gap: 0.5rem;
            margin-bottom: 1.5rem;
        }

        .quick-amount-btn {
            flex: 1;
            padding: 0.5rem 0.75rem;
            background: #f3f4f6;
            color: #374151;
            font-size: 0.75rem;
            font-weight: 500;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .quick-amount-btn:hover {
            background: #e5e7eb;
        }

        .price-summary {
            background: linear-gradient(135deg, #eff6ff 0%, #f0f9ff 100%);
            border: 1px solid #dbeafe;
            border-radius: 12px;
            padding: 1rem;
        }

        .price-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 0.875rem;
        }

        .price-label {
            color: #4b5563;
        }

        .price-value {
            font-size: 1.125rem;
            font-weight: 700;
            color: #4F46E5;
        }

        .price-details {
            font-size: 0.75rem;
            color: #6b7280;
            margin-top: 0.25rem;
        }

        .modal-footer {
            padding: 1.5rem;
            border-top: 1px solid #e5e7eb;
            background: #f9fafb;
            border-radius: 0 0 16px 16px;
        }

        .footer-actions {
            display: flex;
            justify-content: flex-end;
            gap: 0.75rem;
        }

        .btn-cancel {
            padding: 0.5rem 1rem;
            background: white;
            color: #374151;
            font-size: 0.875rem;
            font-weight: 500;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .btn-cancel:hover {
            background: #f9fafb;
        }

        .btn-confirm {
            padding: 0.5rem 1rem;
            background: linear-gradient(135deg, #10B981 0%, #059669 100%);
            color: white;
            font-size: 0.875rem;
            font-weight: 500;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .btn-confirm:hover:not(:disabled) {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
        }

        .btn-confirm:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

        .toast-container {
            position: fixed;
            top: 1rem;
            right: 1rem;
            z-index: 60;
        }

        .toast {
            max-width: 20rem;
            padding: 0.75rem 1rem;
            border-radius: 12px;
            color: white;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
            transform: translateX(0);
            transition: all 0.3s ease;
            margin-bottom: 0.5rem;
        }

        .toast-success {
            background: linear-gradient(135deg, #10B981 0%, #059669 100%);
        }

        .toast-warning {
            background: linear-gradient(135deg, #F59E0B 0%, #D97706 100%);
        }

        .toast-error {
            background: linear-gradient(135deg, #EF4444 0%, #DC2626 100%);
        }

        @media (max-width: 768px) {
            .coins-header {
                flex-direction: column;
                align-items: stretch;
            }

            .coins-actions {
                justify-content: center;
            }

            .participants-grid {
                grid-template-columns: 1fr;
            }

            .vote-buttons {
                flex-direction: column;
            }

            .footer-actions {
                flex-direction: column;
            }
        }

        [x-cloak] {
            display: none !important;
        }

        /* Dark neutral overrides */
        .dark .participant-card-dark {
            background: #0a0a0a;
            border-color: #262626;
        }

        .dark .participant-name {
            color: #e5e5e5;
        }

        .dark .participant-country {
            color: #a3a3a3;
        }

        .dark .score-label {
            color: #a3a3a3;
        }

        .dark .score-value {
            color: #e5e5e5;
        }

        .dark .quick-amount-btn {
            background: #171717;
            color: #e5e5e5;
            border: 1px solid #262626;
        }

        .dark .quick-amount-btn:hover {
            background: #262626;
        }

        .dark .form-label {
            color: #d4d4d4;
        }

        .dark .form-input {
            background: #0a0a0a;
            border-color: #262626;
            color: #e5e5e5;
        }

        .dark .price-summary {
            background: #0a0a0a;
            border-color: #262626;
        }

        .dark .price-label {
            color: #a3a3a3;
        }

        .dark .modal-content {
            background: #0a0a0a;
            border: 1px solid #262626;
            color: #e5e5e5;
        }

        .dark .modal-footer {
            background: #0a0a0a;
            border-top: 1px solid #262626;
        }

        .dark .btn-cancel {
            background: #0a0a0a;
            color: #d4d4d4;
            border: 1px solid #262626;
        }

        .dark .btn-cancel:hover {
            background: #171717;
        }
    </style>
@endpush
