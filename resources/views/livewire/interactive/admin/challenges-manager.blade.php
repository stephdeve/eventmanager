<div class="max-w-5xl mx-auto py-8">
    <h1 class="text-2xl font-semibold text-gray-900 mb-6">Défis</h1>

    <form wire:submit.prevent="save" class="space-y-5 bg-white border border-gray-200 rounded-xl p-6 mb-6">
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700">Titre</label>
                <input type="text" wire:model.defer="title" class="mt-1 w-full rounded-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500" />
                @error('title')<div class="text-sm text-red-600">{{ $message }}</div>@enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Type</label>
                <input type="text" wire:model.defer="type" class="mt-1 w-full rounded-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500" />
                @error('type')<div class="text-sm text-red-600">{{ $message }}</div>@enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Date</label>
                <input type="datetime-local" wire:model.defer="date" class="mt-1 w-full rounded-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500" />
                @error('date')<div class="text-sm text-red-600">{{ $message }}</div>@enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Points max</label>
                <input type="number" wire:model.defer="max_points" class="mt-1 w-full rounded-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500" />
                @error('max_points')<div class="text-sm text-red-600">{{ $message }}</div>@enderror
            </div>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700">Description</label>
            <textarea rows="3" wire:model.defer="description" class="mt-1 w-full rounded-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500"></textarea>
            @error('description')<div class="text-sm text-red-600">{{ $message }}</div>@enderror
        </div>
        <div class="pt-2">
            <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">{{ $editingId ? 'Mettre à jour' : 'Ajouter' }}</button>
            @if($editingId)
                <button type="button" wire:click="resetForm" class="ml-2 inline-flex items-center px-4 py-2 bg-white border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50">Annuler</button>
            @endif
        </div>
    </form>

    <div class="bg-white border border-gray-200 rounded-xl overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-2 text-left text-xs font-semibold text-gray-600">Titre</th>
                    <th class="px-4 py-2 text-left text-xs font-semibold text-gray-600">Type</th>
                    <th class="px-4 py-2 text-left text-xs font-semibold text-gray-600">Date</th>
                    <th class="px-4 py-2 text-left text-xs font-semibold text-gray-600">Max</th>
                    <th class="px-4 py-2 text-right text-xs font-semibold text-gray-600">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($event->challenges as $c)
                    <tr>
                        <td class="px-4 py-2 text-sm font-medium text-gray-900">{{ $c->title }}</td>
                        <td class="px-4 py-2 text-sm text-gray-700">{{ $c->type }}</td>
                        <td class="px-4 py-2 text-sm text-gray-700">{{ optional($c->date)->translatedFormat('d/m/Y H:i') }}</td>
                        <td class="px-4 py-2 text-sm text-gray-700">{{ $c->max_points }}</td>
                        <td class="px-4 py-2 text-sm text-right">
                            <button wire:click="edit({{ $c->id }})" class="px-3 py-1.5 text-xs bg-white border border-gray-300 rounded-md hover:bg-gray-50">Modifier</button>
                            <button wire:click="delete({{ $c->id }})" class="ml-2 px-3 py-1.5 text-xs bg-red-600 text-white rounded-md hover:bg-red-700">Supprimer</button>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="px-4 py-6 text-sm text-gray-500">Aucun défi.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
