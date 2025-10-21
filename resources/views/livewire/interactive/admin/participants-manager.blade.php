<div class="max-w-5xl mx-auto py-8">
    <h1 class="text-2xl font-semibold text-gray-900 mb-6">Participants</h1>

    <form wire:submit.prevent="save" class="space-y-5 bg-white border border-gray-200 rounded-xl p-6 mb-6">
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700">Nom</label>
                <input type="text" wire:model.defer="name" class="mt-1 w-full rounded-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500" />
                @error('name')<div class="text-sm text-red-600">{{ $message }}</div>@enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Pays</label>
                <input type="text" wire:model.defer="country" class="mt-1 w-full rounded-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500" />
                @error('country')<div class="text-sm text-red-600">{{ $message }}</div>@enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Photo (chemin)</label>
                <input type="text" wire:model.defer="photo_path" class="mt-1 w-full rounded-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500" />
                @error('photo_path')<div class="text-sm text-red-600">{{ $message }}</div>@enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Vidéo (URL)</label>
                <input type="text" wire:model.defer="video_url" class="mt-1 w-full rounded-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500" />
                @error('video_url')<div class="text-sm text-red-600">{{ $message }}</div>@enderror
            </div>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700">Bio</label>
            <textarea rows="3" wire:model.defer="bio" class="mt-1 w-full rounded-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500"></textarea>
            @error('bio')<div class="text-sm text-red-600">{{ $message }}</div>@enderror
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
                    <th class="px-4 py-2 text-left text-xs font-semibold text-gray-600">Nom</th>
                    <th class="px-4 py-2 text-left text-xs font-semibold text-gray-600">Pays</th>
                    <th class="px-4 py-2 text-left text-xs font-semibold text-gray-600">Votes</th>
                    <th class="px-4 py-2 text-right text-xs font-semibold text-gray-600">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($event->participants as $p)
                    <tr>
                        <td class="px-4 py-2 text-sm font-medium text-gray-900">{{ $p->name }}</td>
                        <td class="px-4 py-2 text-sm text-gray-700">{{ $p->country }}</td>
                        <td class="px-4 py-2 text-sm text-gray-700">{{ $p->score_total }}</td>
                        <td class="px-4 py-2 text-sm text-right">
                            <button wire:click="edit({{ $p->id }})" class="px-3 py-1.5 text-xs bg-white border border-gray-300 rounded-md hover:bg-gray-50">Modifier</button>
                            <button wire:click="delete({{ $p->id }})" class="ml-2 px-3 py-1.5 text-xs bg-red-600 text-white rounded-md hover:bg-red-700">Supprimer</button>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="px-4 py-6 text-sm text-gray-500">Aucun participant.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
