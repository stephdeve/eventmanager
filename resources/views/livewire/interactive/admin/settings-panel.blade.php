<div class="min-h-screen py-8 ">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- En-tête -->
        <div class="text-start mb-8">
            <h1 class="text-3xl font-bold bg-gradient-to-r from-[#1E3A8A] to-[#4F46E5] bg-clip-text text-transparent mb-3">
                Paramètres Interactifs
            </h1>
            <p class="text-[#6B7280] text-lg">Configurez le système de votes et de monnaie virtuelle</p>
        </div>

        <!-- Carte des paramètres -->
        <div class="form-card rounded-2xl border p-8">
            <h3 class="text-xl font-semibold text-[#1E3A8A] mb-6">Configuration monétaire</h3>

            <form wire:submit.prevent="save" class="space-y-8">
                <!-- Section Coûts et Prix -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Coût vote premium -->
                    <div class="form-group">
                        <label class="form-label">
                            Coût d'un vote premium *
                            <span class="text-[#6B7280] text-sm font-normal">(en coins)</span>
                        </label>
                        <div class="relative">
                            <input type="number" wire:model.defer="premium_vote_cost" min="1"
                                   class="form-input @error('premium_vote_cost') error @enderror pr-12"
                                   placeholder="Ex: 10" required>
                            <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                <span class="text-[#6B7280] text-sm font-medium">coins</span>
                            </div>
                        </div>
                        <div class="mt-2 text-xs text-[#6B7280]">
                            Nombre de coins nécessaires pour un vote premium
                        </div>
                        @error('premium_vote_cost')
                            <p class="mt-2 text-sm text-red-600 flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Prix d'un coin -->
                    <div class="form-group">
                        <label class="form-label">
                            Prix d'un coin *
                            <span class="text-[#6B7280] text-sm font-normal">(en centimes XOF)</span>
                        </label>
                        <div class="relative">
                            <input type="number" wire:model.defer="coin_price_minor" min="1"
                                   class="form-input @error('coin_price_minor') error @enderror pr-12"
                                   placeholder="Ex: 100" required>
                            <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                <span class="text-[#6B7280] text-sm font-medium">F CFA</span>
                            </div>
                        </div>
                        <div class="mt-2 text-xs text-[#6B7280]">
                            Prix d'un coin en centimes (100 = 1 F CFA)
                        </div>
                        @error('coin_price_minor')
                            <p class="mt-2 text-sm text-red-600 flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                </div>

                <!-- Section Informations calculées -->
                <div class="border-t border-[#E0E7FF] pt-8">
                    <h4 class="text-lg font-semibold text-[#1E3A8A] mb-4">Informations calculées</h4>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Coût réel vote premium -->
                        <div class="bg-blue-50 border border-blue-200 rounded-xl p-4">
                            <div class="flex items-center gap-2 mb-2">
                                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <span class="font-semibold text-blue-900">Coût réel d'un vote premium</span>
                            </div>
                            <div class="text-2xl font-bold text-blue-700" id="real-vote-cost">
                                @if($premium_vote_cost && $coin_price_minor)
                                    {{ number_format(($premium_vote_cost * $coin_price_minor) / 100, 0, ',', ' ') }} F CFA
                                @else
                                    -
                                @endif
                            </div>
                            <div class="text-xs text-blue-600 mt-1">
                                Coût réel en francs CFA
                            </div>
                        </div>

                        <!-- Valeur d'un coin -->
                        <div class="bg-green-50 border border-green-200 rounded-xl p-4">
                            <div class="flex items-center gap-2 mb-2">
                                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 8l3 5m0 0l3-5m-3 5v4m-3-5h6m-6 3h6m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <span class="font-semibold text-green-900">Valeur d'un coin</span>
                            </div>
                            <div class="text-2xl font-bold text-green-700" id="coin-value">
                                @if($coin_price_minor)
                                    {{ number_format($coin_price_minor / 100, 2, ',', ' ') }} F CFA
                                @else
                                    -
                                @endif
                            </div>
                            <div class="text-xs text-green-600 mt-1">
                                Valeur réelle d'un coin
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Section Exemple -->
                <div class="border-t border-[#E0E7FF] pt-8">
                    <h4 class="text-lg font-semibold text-[#1E3A8A] mb-4">Exemple de calcul</h4>

                    <div class="bg-amber-50 border border-amber-200 rounded-xl p-4">
                        <div class="text-sm text-amber-800">
                            <p class="mb-2"><strong>Scénario :</strong> Un participant achète 10 coins</p>

                            <div class="space-y-1 text-xs">
                                <div class="flex justify-between">
                                    <span>Prix d'un coin :</span>
                                    <span id="example-coin-price">
                                        @if($coin_price_minor)
                                            {{ number_format($coin_price_minor / 100, 2, ',', ' ') }} F CFA
                                        @else
                                            -
                                        @endif
                                    </span>
                                </div>
                                <div class="flex justify-between">
                                    <span>Coût total :</span>
                                    <span id="example-total-cost">
                                        @if($coin_price_minor)
                                            {{ number_format(($coin_price_minor * 10) / 100, 0, ',', ' ') }} F CFA
                                        @else
                                            -
                                        @endif
                                    </span>
                                </div>
                                <div class="flex justify-between">
                                    <span>Votes premium possibles :</span>
                                    <span id="example-votes-possible">
                                        @if($premium_vote_cost)
                                            {{ floor(10 / $premium_vote_cost) }}
                                        @else
                                            -
                                        @endif
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Bouton de sauvegarde -->
                <div class="flex flex-col sm:flex-row justify-end space-y-4 sm:space-y-0 sm:space-x-4 pt-8 border-t border-[#E0E7FF]">
                    <button type="submit" class="submit-btn">
                        <span class="flex items-center justify-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            Sauvegarder les paramètres
                        </span>
                    </button>
                </div>
            </form>
        </div>

        <!-- Informations supplémentaires -->
        <div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white rounded-xl p-6 border border-gray-200 text-center">
                <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center mx-auto mb-3">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                    </svg>
                </div>
                <h4 class="font-semibold text-gray-900 mb-2">Votes Premium</h4>
                <p class="text-sm text-gray-600">Les votes premium ont plus de poids dans le classement</p>
            </div>

            <div class="bg-white rounded-xl p-6 border border-gray-200 text-center">
                <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center mx-auto mb-3">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <h4 class="font-semibold text-gray-900 mb-2">Système de Coins</h4>
                <p class="text-sm text-gray-600">Monnaie virtuelle achetable par les participants</p>
            </div>

            <div class="bg-white rounded-xl p-6 border border-gray-200 text-center">
                <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center mx-auto mb-3">
                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                    </svg>
                </div>
                <h4 class="font-semibold text-gray-900 mb-2">Sécurisé</h4>
                <p class="text-sm text-gray-600">Transactions sécurisées avec suivi en temps réel</p>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .form-gradient {
        background: linear-gradient(135deg, #F9FAFB 0%, #FFFFFF 50%, #E0E7FF 100%);
    }

    .form-card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(20px);
        box-shadow:
            0 20px 40px rgba(79, 70, 229, 0.08),
            inset 0 1px 0 rgba(255, 255, 255, 0.6);
    }

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

    .submit-btn {
        background: linear-gradient(135deg, #4F46E5 0%, #6366F1 100%);
        color: white;
        padding: 0.875rem 2rem;
        border: none;
        border-radius: 12px;
        font-weight: 600;
        font-size: 0.95rem;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .submit-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 12px 25px rgba(79, 70, 229, 0.3);
    }

    .submit-btn:active {
        transform: translateY(0);
    }

    @media (max-width: 768px) {
        .form-grid {
            grid-template-columns: 1fr;
        }
    }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Mise à jour en temps réel des calculs
    function updateCalculations() {
        const voteCost = parseFloat(document.querySelector('input[wire\\:model\\.defer="premium_vote_cost"]')?.value) || 0;
        const coinPrice = parseFloat(document.querySelector('input[wire\\:model\\.defer="coin_price_minor"]')?.value) || 0;

        // Coût réel vote premium
        const realVoteCost = document.getElementById('real-vote-cost');
        if (realVoteCost && voteCost && coinPrice) {
            const cost = (voteCost * coinPrice) / 100;
            realVoteCost.textContent = new Intl.NumberFormat('fr-FR', {
                maximumFractionDigits: 0
            }).format(cost) + ' F CFA';
        }

        // Valeur d'un coin
        const coinValue = document.getElementById('coin-value');
        if (coinValue && coinPrice) {
            const value = coinPrice / 100;
            coinValue.textContent = new Intl.NumberFormat('fr-FR', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            }).format(value) + ' F CFA';
        }

        // Exemple de calcul
        const exampleCoinPrice = document.getElementById('example-coin-price');
        const exampleTotalCost = document.getElementById('example-total-cost');
        const exampleVotesPossible = document.getElementById('example-votes-possible');

        if (exampleCoinPrice && coinPrice) {
            exampleCoinPrice.textContent = new Intl.NumberFormat('fr-FR', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            }).format(coinPrice / 100) + ' F CFA';
        }

        if (exampleTotalCost && coinPrice) {
            const totalCost = (coinPrice * 10) / 100;
            exampleTotalCost.textContent = new Intl.NumberFormat('fr-FR', {
                maximumFractionDigits: 0
            }).format(totalCost) + ' F CFA';
        }

        if (exampleVotesPossible && voteCost) {
            exampleVotesPossible.textContent = Math.floor(10 / voteCost);
        }
    }

    // Écouter les changements sur les inputs
    const inputs = document.querySelectorAll('input[type="number"]');
    inputs.forEach(input => {
        input.addEventListener('input', updateCalculations);
        input.addEventListener('change', updateCalculations);
    });

    // Initialiser les calculs
    updateCalculations();
});
</script>
@endpush
