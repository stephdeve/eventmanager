<div x-data="buyCoinsState({ unit: {{ (int) (\App\Models\Setting::get('interactive.coin_price_minor', 100) ?? 100) }}, currency: '{{ strtoupper(config('app.currency', 'XOF')) }}' })">
    <div class="mb-4 flex items-center justify-between">
        <div class="text-sm text-gray-700">Solde coins: <span id="wallet-balance" class="font-semibold">{{ $walletBalance ?? 0 }}</span></div>
        <div class="flex items-center gap-2">
            @auth
                @if(config('services.kkiapay.public_key'))
                    <button type="button" @click="openBuy = true" class="px-3 py-1.5 text-xs bg-emerald-600 text-white rounded-md">Acheter des coins</button>
                @else
                    <button type="button" disabled class="px-3 py-1.5 text-xs bg-gray-300 text-gray-600 rounded-md cursor-not-allowed">Paiement indisponible</button>
                @endif
            @else
                <a href="{{ route('login') }}" class="px-3 py-1.5 text-xs bg-emerald-600 text-white rounded-md">Se connecter pour acheter</a>
            @endauth
            <button type="button" wire:click="$refresh" class="px-3 py-1.5 text-xs bg-white border border-gray-300 rounded-md hover:bg-gray-50">Rafraîchir</button>
        </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
        @foreach($event->participants as $p)
            <div class="border rounded-xl p-4 bg-white">
                <div class="flex items-center justify-between">
                    <div>
                        <div class="font-semibold text-gray-900">{{ $p->name }}</div>
                        <div class="text-xs text-gray-500">{{ $p->country }}</div>
                    </div>
                    <div class="text-right">
                        <div class="text-xs text-gray-500">Votes</div>
                        <div class="text-lg font-bold">{{ $p->score_total }}</div>
                    </div>
                </div>
                <div class="mt-3 flex gap-2">
                    <button wire:click="freeVote({{ $p->id }})" class="px-3 py-1.5 text-xs bg-indigo-600 text-white rounded-md">Vote gratuit</button>
                    <button wire:click="premiumVote({{ $p->id }})" class="px-3 py-1.5 text-xs bg-emerald-600 text-white rounded-md">Vote premium</button>
                </div>
            </div>
        @endforeach
    </div>

    <div x-show="openBuy" x-cloak class="fixed inset-0 z-50 flex items-center justify-center">
        <div class="fixed inset-0 bg-black/50" @click="openBuy = false"></div>
        <div class="relative bg-white rounded-xl shadow-xl w-full max-w-md p-6">
            <h3 class="text-base font-semibold text-gray-900 mb-4">Acheter des coins</h3>
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Quantité</label>
                    <input type="number" min="10" step="1" x-model.number="qty" class="mt-1 w-full rounded-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500" />
                </div>
                <div class="flex gap-2">
                    <button type="button" @click="qty = Math.max(min, (qty||0)+10)" class="px-3 py-1.5 text-xs rounded-md bg-gray-100 hover:bg-gray-200">+10</button>
                    <button type="button" @click="qty = Math.max(min, (qty||0)+50)" class="px-3 py-1.5 text-xs rounded-md bg-gray-100 hover:bg-gray-200">+50</button>
                    <button type="button" @click="qty = Math.max(min, (qty||0)+100)" class="px-3 py-1.5 text-xs rounded-md bg-gray-100 hover:bg-gray-200">+100</button>
                </div>
                <div class="text-sm text-gray-600">Total: <span class="font-semibold" x-text="(qty && qty>=min ? qty*unit : 0) + ' ' + currency"></span></div>
            </div>
            <div class="mt-6 flex justify-end gap-2">
                <button type="button" @click="openBuy = false" class="px-3 py-2 text-sm bg-white border border-gray-300 rounded-md hover:bg-gray-50">Annuler</button>
                <button type="button" @click="buy()" :disabled="!(qty && qty>=min)" class="px-3 py-2 text-sm bg-emerald-600 text-white rounded-md disabled:opacity-50">Payer</button>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('livewire:init', () => {
            window.addEventListener('toast', (e) => {
                const container = document.getElementById('toast-container') || document.body;
                const t = document.createElement('div');
                t.className = 'mb-2 max-w-sm px-4 py-3 rounded shadow text-white ' + (e.detail.type === 'success' ? 'bg-emerald-600' : e.detail.type === 'warning' ? 'bg-amber-600' : 'bg-gray-800');
                t.textContent = e.detail.message || '';
                container.appendChild(t);
                setTimeout(() => t.remove(), 3500);
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
                        const res = await fetch("{{ route('coins.checkout') }}", { method: 'POST', headers: { 'Content-Type': 'application/json', 'Accept': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content }, body: JSON.stringify({ coins: qty }) });
                        const data = await res.json();
                        if (!data || !data.success || data.provider !== 'kkiapay') { alert('Paiement indisponible.'); return; }
                        async function ensureKkiapay() { return new Promise((resolve) => { if (window.kkiapay || window.openKkiapayWidget) return resolve(); const s = document.createElement('script'); s.src = 'https://cdn.kkiapay.me/k.js'; s.onload = () => resolve(); document.head.appendChild(s); }); }
                        await ensureKkiapay();
                        function openWidget(amount, currency, apiKey, sandbox) {
                            if (typeof window.openKkiapayWidget === 'function') { window.openKkiapayWidget({ amount, currency, api_key: apiKey, sandbox, name: window.CURRENT_USER_NAME || '', email: '' }); return true; }
                            if (window.kkiapay && typeof window.kkiapay.open === 'function') { window.kkiapay.open({ amount, currency, api_key: apiKey, sandbox, name: window.CURRENT_USER_NAME || '', email: '' }); return true; }
                            return false;
                        }
                        const self = this;
                        function onSuccess(resp) {
                            try {
                                const tx = resp && (resp.transactionId || resp.transaction_id || resp.reference || resp.id);
                                if (!tx) throw new Error('Transaction manquante');
                                fetch("{{ route('coins.confirm') }}", { method: 'POST', headers: { 'Content-Type': 'application/json', 'Accept': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content }, body: JSON.stringify({ transaction_id: tx, coins: qty }) })
                                    .then(r => r.json())
                                    .then(j => {
                                        if (j && j.success) {
                                            const bal = document.getElementById('wallet-balance');
                                            if (bal && typeof j.balance !== 'undefined') bal.textContent = j.balance;
                                            window.dispatchEvent(new CustomEvent('toast', { detail: { type: 'success', message: 'Coins crédités.' } }));
                                            self.openBuy = false;
                                        } else {
                                            alert((j && j.message) || 'Confirmation impossible.');
                                        }
                                    })
                                    .catch(() => alert('Erreur de confirmation.'));
                            } catch (e) { alert('Paiement réussi mais la confirmation a échoué.'); }
                        }
                        function onFailed(err) { console.error('Kkiapay failed', err); alert('Paiement échoué.'); }
                        function onCancelled() {}
                        if (typeof window.addSuccessListener === 'function') window.addSuccessListener(onSuccess);
                        if (typeof window.addFailedListener === 'function') window.addFailedListener(onFailed);
                        if (typeof window.addCancelListener === 'function') window.addCancelListener(onCancelled);
                        const opened = openWidget(Number(data.amount), data.currency || 'XOF', data.public_key, !!data.sandbox);
                        if (!opened) alert('Widget Kkiapay indisponible.');
                    } catch (_) { alert('Réseau indisponible.'); }
                }
            };
        }
    </script>
</div>
