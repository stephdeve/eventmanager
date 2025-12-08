<div class="min-h-screen py-8 ">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- En-tête -->
        <div class="text-start mb-8">
            <h1
                class="text-3xl font-bold bg-gradient-to-r from-[#1E3A8A] to-[#4F46E5] bg-clip-text text-transparent mb-3">
                Éditer l'événement interactif
            </h1>
            <p class="text-[#6B7280] text-lg">Modifiez les paramètres de votre événement interactif</p>
        </div>

        <!-- Carte du formulaire -->
        <div class="form-card rounded-2xl border p-8">
            <form wire:submit.prevent="save" class="space-y-8">

                <!-- Section expérience interactive -->
                <div class="border-t border-[#E0E7FF] pt-8">
                    <h3 class="text-xl font-semibold text-[#1E3A8A] mb-6">Configuration interactive</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Activation interactive -->
                        <div class="checkbox-card @if ($is_interactive) checked @endif">
                            <label class="flex items-start space-x-3 cursor-pointer">
                                <input type="checkbox" wire:model.defer="is_interactive"
                                    class="mt-1 h-5 w-5 rounded border-gray-300 text-[#4F46E5] focus:ring-[#4F46E5]">
                                <div class="flex-1">
                                    <span class="block text-sm font-semibold text-[#1E3A8A]">Activer l'expérience
                                        interactive</span>
                                    <span class="mt-1 block text-sm text-[#6B7280]">Active les onglets Votes/Classement
                                        sur la page publique</span>
                                </div>
                            </label>
                        </div>

                        <!-- Page publique -->
                        <div class="checkbox-card @if ($interactive_public) checked @endif">
                            <label class="flex items-start space-x-3 cursor-pointer">
                                <input type="checkbox" wire:model.defer="interactive_public"
                                    class="mt-1 h-5 w-5 rounded border-gray-300 text-[#4F46E5] focus:ring-[#4F46E5]">
                                <div class="flex-1">
                                    <span class="block text-sm font-semibold text-[#1E3A8A]">Page interactive
                                        publique</span>
                                    <span class="mt-1 block text-sm text-[#6B7280]">Consultation sans connexion (votes
                                        nécessitent connexion)</span>
                                </div>
                            </label>
                        </div>
                    </div>

                    <!-- Période interactive -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                        <div class="form-group">
                            <label class="form-label">Début de l'expérience interactive
                                <span class="text-[#6B7280] text-xs font-normal block">Heure locale. Optionnel. Doit
                                    être compris entre la date de début et la date de fin de l'événement.</span>
                            </label>
                            <input type="datetime-local" wire:model.defer="interactive_starts_at"
                                class="form-input @error('interactive_starts_at') error @enderror">
                            @error('interactive_starts_at')
                                <p class="mt-2 text-sm text-red-600 flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label class="form-label">Fin de l'expérience interactive
                                <span class="text-[#6B7280] text-xs font-normal block">Doit être postérieure au début de
                                    l'expérience interactive.</span>
                            </label>
                            <input type="datetime-local" wire:model.defer="interactive_ends_at"
                                class="form-input @error('interactive_ends_at') error @enderror">
                            @error('interactive_ends_at')
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
                </div>

                

                <!-- Statut et Réseaux sociaux -->
                <div class="border-t border-[#E0E7FF] pt-8">
                    <h3 class="text-xl font-semibold text-[#1E3A8A] mb-6">Configuration avancée</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- YouTube -->
                        <div class="form-group">
                            <label class="form-label">
                                YouTube URL
                                <span class="text-[#6B7280] text-sm font-normal">(Optionnel)</span>
                            </label>
                            <input type="text" wire:model.defer="youtube_url"
                                class="form-input @error('youtube_url') error @enderror"
                                placeholder="https://youtube.com/...">
                            @error('youtube_url')
                                <p class="mt-2 text-sm text-red-600 flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- TikTok -->
                        <div class="form-group">
                            <label class="form-label">
                                TikTok URL
                                <span class="text-[#6B7280] text-sm font-normal">(Optionnel)</span>
                            </label>
                            <input type="text" wire:model.defer="tiktok_url"
                                class="form-input @error('tiktok_url') error @enderror"
                                placeholder="https://tiktok.com/...">
                            @error('tiktok_url')
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
                </div>

                <!-- Boutons de soumission -->
                <div
                    class="mt-12 pt-8 border-t border-[#E0E7FF] flex flex-col sm:flex-row justify-end space-y-4 sm:space-y-0 sm:space-x-4">
                    <a href="{{ route('events.show', $event) }}" class="cancel-btn order-2 sm:order-1 text-center">
                        Annuler
                    </a>
                    <button type="submit" class="submit-btn order-1 sm:order-2">
                        <span class="flex items-center justify-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                            Sauvegarder les modifications
                        </span>
                    </button>
                </div>
            </form>
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

        .checkbox-card {
            border: 2px solid #FEF3C7;
            border-radius: 12px;
            background: #FFFBEB;
            padding: 1.25rem;
            transition: all 0.3s ease;
        }

        .checkbox-card:hover {
            border-color: #F59E0B;
            transform: translateY(-2px);
        }

        .checkbox-card.checked {
            border-color: #4F46E5;
            background: #E0E7FF;
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

        .dark .form-input,
        .dark select.form-input {
            background: #0a0a0a;
            border-color: #262626;
            color: #e5e5e5;
        }

        .dark .form-input:focus,
        .dark select.form-input:focus {
            border-color: #4F46E5;
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.2);
        }

        .dark .checkbox-card {
            background: #0a0a0a;
            border-color: #262626;
        }

        .dark .checkbox-card:hover {
            border-color: #404040;
        }

        .dark .checkbox-card.checked {
            background: #0f0f0f;
            border-color: #4F46E5;
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

        .dark .border-\[\#E0E7FF\] {
            border-color: #262626;
        }

        .dark .text-gray-900 {
            color: #e5e5e5;
        }

        .dark .text-[#6B7280] {
            color: #a3a3a3;
        }
    </style>
@endpush

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Compteur de caractères pour la description
            const descriptionTextarea = document.querySelector('textarea[wire\\:model\\.defer="description"]');
            const descriptionCounter = document.getElementById('description-counter');

            if (descriptionTextarea && descriptionCounter) {
                descriptionTextarea.addEventListener('input', () => {
                    const length = descriptionTextarea.value.length;
                    descriptionCounter.textContent = `${length} caractères`;

                    if (length < 50) {
                        descriptionCounter.classList.add('text-red-600');
                    } else {
                        descriptionCounter.classList.remove('text-red-600');
                    }
                });

                // Initialiser le compteur
                descriptionTextarea.dispatchEvent(new Event('input'));
            }

            // Gestion des cartes de checkbox
            const checkboxCards = document.querySelectorAll('.checkbox-card');
            checkboxCards.forEach(card => {
                const checkbox = card.querySelector('input[type="checkbox"]');
                if (checkbox) {
                    // Mettre à jour l'état initial
                    if (checkbox.checked) {
                        card.classList.add('checked');
                    }

                    // Écouter les changements
                    checkbox.addEventListener('change', () => {
                        if (checkbox.checked) {
                            card.classList.add('checked');
                        } else {
                            card.classList.remove('checked');
                        }
                    });
                }
            });

            // Validation des dates
            const startDateInput = document.querySelector('input[wire\\:model\\.defer="start_date"]');
            const endDateInput = document.querySelector('input[wire\\:model\\.defer="end_date"]');

            function validateDates() {
                if (startDateInput && endDateInput && startDateInput.value && endDateInput.value) {
                    const startDate = new Date(startDateInput.value);
                    const endDate = new Date(endDateInput.value);

                    if (endDate <= startDate) {
                        endDateInput.classList.add('error');
                    } else {
                        endDateInput.classList.remove('error');
                    }
                }
            }

            if (startDateInput) startDateInput.addEventListener('change', validateDates);
            if (endDateInput) endDateInput.addEventListener('change', validateDates);
        });
    </script>
@endpush
