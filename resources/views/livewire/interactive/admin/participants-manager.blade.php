<div class="min-h-screen py-8 ">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- En-tête -->
        <div class="text-start mb-8">
            <h1
                class="text-3xl font-bold bg-gradient-to-r from-[#1E3A8A] to-[#4F46E5] dark:from-green-500 dark:to-green-600 bg-clip-text text-transparent mb-3">
                Gestion des Participants
            </h1>
            <p class="text-[#6B7280] text-lg">Ajoutez et gérez les participants de votre événement interactif</p>
        </div>

        <!-- Formulaire d'ajout/édition -->
        <div class="form-card rounded-2xl border p-8 mb-8">
            <h3 class="text-xl font-semibold text-[#1E3A8A] mb-6">
                {{ $editingId ? 'Modifier le participant' : 'Ajouter un nouveau participant' }}
            </h3>

            <form wire:submit.prevent="save" class="space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Nom -->
                    <div class="form-group">
                        <label class="form-label">
                            Nom complet *
                            <span class="text-[#6B7280] text-sm font-normal">(Nom du participant)</span>
                        </label>
                        <input type="text" wire:model.defer="name" class="form-input @error('name') error @enderror"
                            placeholder="Ex: Jean Dupont, Marie Curie..." required>
                        @error('name')
                            <p class="mt-2 text-sm text-red-600 flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Pays -->
                    <div class="form-group">
                        <label class="form-label">
                            Pays *
                            <span class="text-[#6B7280] text-sm font-normal">(Nationalité)</span>
                        </label>
                        <input type="text" wire:model.defer="country"
                            class="form-input @error('country') error @enderror"
                            placeholder="Ex: France, Belgique, Canada...">
                        @error('country')
                            <p class="mt-2 text-sm text-red-600 flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Photo -->
                    <div class="form-group">
                        <label class="form-label">
                            Photo
                            <span class="text-[#6B7280] text-sm font-normal">(Chemin de l'image)</span>
                        </label>
                        <input type="text" wire:model.defer="photo_path"
                            class="form-input @error('photo_path') error @enderror"
                            placeholder="Ex: /images/participants/photo.jpg">
                        @error('photo_path')
                            <p class="mt-2 text-sm text-red-600 flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Vidéo -->
                    <div class="form-group">
                        <label class="form-label">
                            Vidéo de présentation
                            <span class="text-[#6B7280] text-sm font-normal">(URL YouTube, TikTok...)</span>
                        </label>
                        <input type="text" wire:model.defer="video_url"
                            class="form-input @error('video_url') error @enderror"
                            placeholder="Ex: https://youtube.com/watch?v=...">
                        @error('video_url')
                            <p class="mt-2 text-sm text-red-600 flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                </div>

                <!-- Bio -->
                <div class="form-group">
                    <label class="form-label">
                        Biographie
                        <span class="text-[#6B7280] text-sm font-normal">(Présentation du participant)</span>
                    </label>
                    <textarea rows="3" wire:model.defer="bio" class="form-input @error('bio') error @enderror resize-none"
                        placeholder="Décrivez le parcours, les compétences ou la présentation du participant..."></textarea>
                    <div class="flex justify-between text-xs text-[#6B7280] mt-1">
                        <span>Présentation optionnelle</span>
                        <span id="bio-counter">{{ strlen($bio ?? '') }} caractères</span>
                    </div>
                    @error('bio')
                        <p class="mt-2 text-sm text-red-600 flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Boutons -->
                <div class="flex flex-col sm:flex-row justify-start space-y-4 sm:space-y-0 sm:space-x-4 pt-4">
                    <button type="button" wire:click="save" wire:loading.attr="disabled" wire:target="save" class="submit-btn">
                        <span class="flex items-center justify-center">
                            @if ($editingId)
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7" />
                                </svg>
                                Mettre à jour
                            @else
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 4v16m8-8H4" />
                                </svg>
                                Ajouter le participant
                            @endif
                        </span>
                    </button>

                    @if ($editingId)
                        <button type="button" wire:click="resetForm" class="cancel-btn">
                            <span class="flex items-center justify-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12" />
                                </svg>
                                Annuler
                            </span>
                        </button>
                    @endif
                </div>
            </form>
        </div>

        <!-- Liste des participants -->
        <div class="form-card rounded-2xl border p-8">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-xl font-semibold text-[#1E3A8A]">Liste des participants</h3>
                <div class="text-sm text-gray-500">
                    {{ $event->participants->count() }} participant(s) inscrit(s)
                </div>
            </div>

            @if ($event->participants->count() > 0)
                <div class="overflow-hidden rounded-xl border border-gray-200">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gradient-to-r from-gray-50 to-blue-50">
                            <tr>
                                <th
                                    class="px-6 py-4 text-left text-xs font-semibold text-[#1E3A8A] uppercase tracking-wider">
                                    Participant
                                </th>
                                <th
                                    class="px-6 py-4 text-left text-xs font-semibold text-[#1E3A8A] uppercase tracking-wider">
                                    Pays
                                </th>
                                <th
                                    class="px-6 py-4 text-left text-xs font-semibold text-[#1E3A8A] uppercase tracking-wider">
                                    Score
                                </th>
                                <th
                                    class="px-6 py-4 text-right text-xs font-semibold text-[#1E3A8A] uppercase tracking-wider">
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 bg-white">
                            @foreach ($event->participants as $participant)
                                <tr class="hover:bg-gray-50 transition-colors duration-150">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center space-x-3">
                                            @if ($participant->photo_path)
                                                <div
                                                    class="flex-shrink-0 w-10 h-10 bg-gray-200 rounded-full overflow-hidden">
                                                    <img src="{{ $participant->photo_path }}"
                                                        alt="{{ $participant->name }}"
                                                        class="w-full h-full object-cover">
                                                </div>
                                            @else
                                                <div
                                                    class="flex-shrink-0 w-10 h-10 bg-gradient-to-r from-blue-500 to-purple-600 rounded-full flex items-center justify-center text-white font-semibold text-sm">
                                                    {{ substr($participant->name, 0, 1) }}
                                                </div>
                                            @endif
                                            <div>
                                                <div class="text-sm font-semibold text-gray-900">
                                                    {{ $participant->name }}</div>
                                                @if ($participant->bio)
                                                    <div class="text-xs text-gray-500 mt-1 line-clamp-1">
                                                        {{ \Illuminate\Support\Str::limit($participant->bio, 50) }}
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center gap-2">
                                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            <span class="text-sm text-gray-700">{{ $participant->country }}</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center gap-2">
                                            <span
                                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5" />
                                                </svg>
                                                {{ $participant->score_total }} pts
                                            </span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <div class="flex justify-end space-x-2">
                                            <button wire:click="edit({{ $participant->id }})"
                                                class="inline-flex items-center px-3 py-1.5 border border-gray-300 rounded-lg text-xs font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                </svg>
                                                Modifier
                                            </button>
                                            <button wire:click="delete({{ $participant->id }})"
                                                onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce participant ?')"
                                                class="inline-flex items-center px-3 py-1.5 border border-transparent rounded-lg text-xs font-medium text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors">
                                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                                Supprimer
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-12">
                    <div class="w-16 h-16 bg-gray-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                    <h4 class="text-lg font-semibold text-gray-900 mb-2">Aucun participant</h4>
                    <p class="text-gray-500 text-sm">Commencez par ajouter votre premier participant !</p>
                </div>
            @endif
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

        .cancel-btn {
            background: white;
            color: #6B7280;
            border: 2px solid #E5E7EB;
            padding: 0.875rem 2rem;
            border-radius: 12px;
            font-weight: 600;
            font-size: 0.95rem;
            transition: all 0.3s ease;
        }

        .cancel-btn:hover {
            border-color: #4F46E5;
            color: #4F46E5;
            transform: translateY(-1px);
        }

        .line-clamp-1 {
            display: -webkit-box;
            -webkit-line-clamp: 1;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        @media (max-width: 768px) {
            .form-grid {
                grid-template-columns: 1fr;
            }
        }

        /* Dark neutral overrides (scoped) */
        .dark .form-card {
            background: #0a0a0a;
            border-color: #262626;
        }

        .dark .form-label {
            color: #d4d4d4;
        }

        .dark .form-input {
            background: #0a0a0a;
            border-color: #262626;
            color: #e5e5e5;
        }

        .dark .form-input:focus {
            border-color: #4F46E5;
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.2);
        }

        .dark .cancel-btn {
            background: #0a0a0a;
            color: #d4d4d4;
            border-color: #262626;
        }

        .dark .cancel-btn:hover {
            background: #171717;
            border-color: #404040;
            color: #e5e5e5;
        }

        /* Table & list surfaces */
        .dark .form-card .overflow-hidden {
            background: #0a0a0a;
            border-color: #262626;
        }

        .dark .form-card table {
            background: #0a0a0a;
        }

        .dark .form-card thead {
            background: #0f0f0f;
        }

        .dark .form-card tbody tr:hover {
            background: #171717;
        }

        /* Utility remaps inside this component */
        .dark .form-card .bg-white {
            background: #0a0a0a;
        }

        .dark .form-card .hover\:bg-gray-50:hover {
            background: #171717;
        }

        .dark .form-card .border-gray-200 {
            border-color: #262626;
        }

        .dark .form-card .border-gray-300 {
            border-color: #404040;
        }

        .dark .form-card .text-gray-900 {
            color: #e5e5e5;
        }

        .dark .form-card .text-gray-700 {
            color: #d4d4d4;
        }

        .dark .form-card .text-gray-600 {
            color: #a3a3a3;
        }

        .dark .form-card .text-gray-500 {
            color: #9ca3af;
        }

        .dark .form-card .text-gray-400 {
            color: #9ca3af;
        }
    </style>
@endpush

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const bioTextarea = document.querySelector('textarea[wire\\:model\\.defer="bio"]');
            const bioCounter = document.getElementById('bio-counter');

            if (bioTextarea && bioCounter) {
                bioTextarea.addEventListener('input', () => {
                    const length = bioTextarea.value.length;
                    bioCounter.textContent = `${length} caractères`;
                });

                bioTextarea.dispatchEvent(new Event('input'));
            }
        });
    </script>
@endpush
