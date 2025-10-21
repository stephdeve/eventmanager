<div class="max-w-3xl mx-auto py-8">
    <h1 class="text-2xl font-semibold text-gray-900 mb-6">Paramètres interactifs</h1>

    <form wire:submit.prevent="save" class="space-y-5 bg-white border border-gray-200 rounded-xl p-6">
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700">Coût d'un vote premium (coins)</label>
                <input type="number" wire:model.defer="premium_vote_cost" min="1" class="mt-1 w-full rounded-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500" />
                @error('premium_vote_cost')<div class="text-sm text-red-600">{{ $message }}</div>@enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Prix d'un coin (minor units, XOF)</label>
                <input type="number" wire:model.defer="coin_price_minor" min="1" class="mt-1 w-full rounded-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500" />
                @error('coin_price_minor')<div class="text-sm text-red-600">{{ $message }}</div>@enderror
            </div>
        </div>

        <div class="pt-2">
            <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">Sauvegarder</button>
        </div>
    </form>
</div>
