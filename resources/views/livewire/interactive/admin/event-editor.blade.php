<div class="max-w-4xl mx-auto py-8">
    <h1 class="text-2xl font-semibold text-gray-900 mb-6">Éditer l'événement interactif</h1>

    <form wire:submit.prevent="save" class="space-y-5 bg-white border border-gray-200 rounded-xl p-6">
        <div>
            <label class="block text-sm font-medium text-gray-700">Titre</label>
            <input type="text" wire:model.defer="title" class="mt-1 w-full rounded-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500" />
            @error('title')<div class="text-sm text-red-600">{{ $message }}</div>@enderror
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 border-t pt-6">
            <div>
                <label class="block text-sm font-medium text-gray-700">Activer l'expérience interactive</label>
                <div class="mt-2 flex items-center gap-3">
                    <input type="checkbox" wire:model.defer="is_interactive" class="h-4 w-4 text-indigo-600 border-gray-300 rounded" />
                    <span class="text-sm text-gray-600">Active les onglets Votes/Classement sur la page publique</span>
                </div>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Page interactive publique</label>
                <div class="mt-2 flex items-center gap-3">
                    <input type="checkbox" wire:model.defer="interactive_public" class="h-4 w-4 text-indigo-600 border-gray-300 rounded" />
                    <span class="text-sm text-gray-600">Consultation sans connexion (votes nécessitent connexion)</span>
                </div>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Début de l'expérience</label>
                <input type="datetime-local" wire:model.defer="interactive_starts_at" class="mt-1 w-full rounded-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500" />
                @error('interactive_starts_at')<div class="text-sm text-red-600">{{ $message }}</div>@enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Fin de l'expérience</label>
                <input type="datetime-local" wire:model.defer="interactive_ends_at" class="mt-1 w-full rounded-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500" />
                @error('interactive_ends_at')<div class="text-sm text-red-600">{{ $message }}</div>@enderror
            </div>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700">Description</label>
            <textarea rows="5" wire:model.defer="description" class="mt-1 w-full rounded-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500"></textarea>
            @error('description')<div class="text-sm text-red-600">{{ $message }}</div>@enderror
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700">Début</label>
                <input type="datetime-local" wire:model.defer="start_date" class="mt-1 w-full rounded-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500" />
                @error('start_date')<div class="text-sm text-red-600">{{ $message }}</div>@enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Fin</label>
                <input type="datetime-local" wire:model.defer="end_date" class="mt-1 w-full rounded-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500" />
                @error('end_date')<div class="text-sm text-red-600">{{ $message }}</div>@enderror
            </div>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700">Statut</label>
                <select wire:model.defer="status" class="mt-1 w-full rounded-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                    <option value="draft">Brouillon</option>
                    <option value="published">Publié</option>
                    <option value="running">En cours</option>
                    <option value="finished">Terminé</option>
                </select>
                @error('status')<div class="text-sm text-red-600">{{ $message }}</div>@enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">YouTube URL</label>
                <input type="text" wire:model.defer="youtube_url" class="mt-1 w-full rounded-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500" />
                @error('youtube_url')<div class="text-sm text-red-600">{{ $message }}</div>@enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">TikTok URL</label>
                <input type="text" wire:model.defer="tiktok_url" class="mt-1 w-full rounded-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500" />
                @error('tiktok_url')<div class="text-sm text-red-600">{{ $message }}</div>@enderror
            </div>
        </div>

        <div class="pt-4 border-t">
            <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">Sauvegarder</button>
        </div>
    </form>
</div>
