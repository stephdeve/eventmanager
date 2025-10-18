@extends('layouts.app')

@section('title', 'Créer un nouvel événement')

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

    .file-upload {
        border: 2px dashed #E5E7EB;
        border-radius: 12px;
        padding: 2rem;
        text-align: center;
        transition: all 0.3s ease;
        background: #F9FAFB;
        cursor: pointer;
    }

    .file-upload:hover {
        border-color: #4F46E5;
        background: #E0E7FF;
    }

    .file-upload.dragover {
        border-color: #4F46E5;
        background: #E0E7FF;
        transform: scale(1.02);
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

    .preview-image {
        max-width: 200px;
        max-height: 150px;
        border-radius: 8px;
        margin-top: 1rem;
        display: none;
    }

    .currency-select {
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236B7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='m6 8 4 4 4-4'/%3e%3c/svg%3e");
        background-position: right 0.5rem center;
        background-repeat: no-repeat;
        background-size: 1.5em 1.5em;
        padding-right: 2.5rem;
        -webkit-appearance: none;
        -moz-appearance: none;
        appearance: none;
    }

    @media (max-width: 768px) {
        .form-grid {
            grid-template-columns: 1fr;
        }
    }
</style>
@endpush

@section('content')
<div class="min-h-screen py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- En-tête -->
        <div class="text-start mb-8">
            <h1 class="text-3xl font-bold bg-gradient-to-r from-[#1E3A8A] to-[#4F46E5] bg-clip-text text-transparent mb-3">
                Créer un nouvel événement
            </h1>
            <p class="text-[#6B7280] text-lg">Remplissez les informations de votre événement pour commencer</p>
        </div>

        <!-- Carte du formulaire -->
        <div class="form-card rounded-2xl border  p-8">
            <form action="{{ route('events.store') }}" method="POST" enctype="multipart/form-data" id="eventForm">
                @csrf

                <div class="grid form-grid gap-8">
                    <!-- Colonne de gauche -->
                    <div class="space-y-6">
                        <!-- Titre -->
                        <div class="form-group ">
                            <label for="title" class="form-label">
                                Titre de l'événement *
                                <span class="text-[#6B7280] text-sm font-normal">(Soyez créatif !)</span>
                            </label>
                            <input type="text" name="title" id="title" value="{{ old('title') }}"
                                class="form-input @error('title') error @enderror"
                                placeholder="Ex: Conférence Tech 2024" required autofocus>
                            @error('title')
                                <p class="mt-2 text-sm text-red-600 flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Catégorie -->
                        <div class="form-group">
                            <label for="category" class="form-label">Catégorie</label>
                            <select name="category" id="category" class="form-input">
                                <option value="">— Sélectionner —</option>
                                @foreach(($categories ?? []) as $key => $label)
                                    <option value="{{ $key }}" @selected(old('category')===$key)>{{ $label }}</option>
                                @endforeach
                            </select>
                            @error('category')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Description -->
                        <div class="form-group ">
                            <label for="description" class="form-label">
                                Description *
                                <span class="text-[#6B7280] text-sm font-normal">(Décrivez votre événement)</span>
                            </label>
                            <textarea name="description" id="description" rows="5"
                                class="form-input @error('description') error @enderror resize-none"
                                placeholder="Décrivez en détail votre événement, ses objectifs, et ce que les participants peuvent en attendre..."
                                required>{{ old('description') }}</textarea>
                            <div class="flex justify-between text-xs text-[#6B7280] mt-1">
                                <span>Minimum 50 caractères</span>
                                <span id="description-counter">0 caractères</span>
                            </div>
                            @error('description')
                                <p class="mt-2 text-sm text-red-600 flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Date et heure -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="form-group">
                                <label for="start_date" class="form-label">Date de début *</label>
                                <input type="datetime-local" name="start_date" id="start_date"
                                    value="{{ old('start_date') }}"
                                    class="form-input @error('start_date') error @enderror" required>
                                @error('start_date')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="end_date" class="form-label">Date de fin *</label>
                                <input type="datetime-local" name="end_date" id="end_date"
                                    value="{{ old('end_date') }}"
                                    class="form-input @error('end_date') error @enderror" required>
                                @error('end_date')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Heures par jour (optionnel) -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="form-group">
                                <label for="daily_start_time" class="form-label">Heure de début (par jour)</label>
                                <input type="time" name="daily_start_time" id="daily_start_time" value="{{ old('daily_start_time') }}" class="form-input @error('daily_start_time') error @enderror">
                                @error('daily_start_time')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="daily_end_time" class="form-label">Heure de fin (par jour)</label>
                                <input type="time" name="daily_end_time" id="daily_end_time" value="{{ old('daily_end_time') }}" class="form-input @error('daily_end_time') error @enderror">
                                @error('daily_end_time')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Colonne de droite -->
                    <div class="space-y-6">
                        <!-- Lieu -->
                        <div class="form-group">
                            <label for="location" class="form-label">
                                Lieu *
                                <span class="text-[#6B7280] text-sm font-normal">(Adresse ou lieu virtuel)</span>
                            </label>
                            <input type="text" name="location" id="location" value="{{ old('location') }}"
                                class="form-input @error('location') error @enderror"
                                placeholder="Ex: Paris Event Center ou Lien Zoom" required>
                            @error('location')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Image de couverture -->
                        <div class="form-group">
                            <label class="form-label">Image de couverture</label>
                            <div class="file-upload" id="file-upload-area">
                                <input type="file" name="cover_image" id="cover_image" class="hidden" accept="image/*">
                                <div class="text-center">
                                    <svg class="w-12 h-12 mx-auto text-[#6B7280] mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                    <p class="text-sm text-[#6B7280] mb-2">
                                        <span class="font-semibold text-[#4F46E5]">Cliquez pour uploader</span> ou glissez-déposez
                                    </p>
                                    <p class="text-xs text-[#6B7280]">PNG, JPG, JPEG jusqu'à 5MB</p>
                                </div>
                            </div>
                            <img id="image-preview" class="preview-image" alt="Aperçu de l'image">
                            @error('cover_image')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                         <!-- Capacité -->
                         <div class="space-y-2">
                            <div class="checkbox-card" id="capacity-card">
                                <label class="flex items-start space-x-3 cursor-pointer">
                                    <input type="checkbox" id="is_capacity_unlimited" name="is_capacity_unlimited" value="1"
                                           class="mt-1 h-5 w-5 rounded border-gray-300 text-[#4F46E5] focus:ring-[#4F46E5]"

                                           >
                                    <div>
                                        <span class="block text-sm font-semibold text-[#1E3A8A]">Places illimitées</span>
                                        <span class="block text-xs text-[#6B7280]">Décochez pour définir une capacité maximale</span>
                                    </div>
                                </label>
                            </div>
                            <div class="form-group" id="capacity-group">
                                <label for="capacity" class="form-label">Capacité maximale</label>
                                <input type="number" name="capacity" id="capacity" min="1"
                                       value=""
                                       class="form-input @error('capacity') error @enderror" placeholder="50">
                                @error('capacity')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                         <!-- Type d'événement et Paiement -->
                         <div class="space-y-4">
                            <div class="form-group">
                                <label class="form-label">Type d'événement</label>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                    <label class="checkbox-card">
                                        <input type="radio" name="payment_type" value="free" class="hidden" @checked(old('payment_type', ($event->price ?? 0) > 0 ? 'paid' : 'free')==='free')>
                                        <span class="block text-sm font-semibold text-[#1E3A8A]">Gratuit</span>
                                    </label>
                                    <label class="checkbox-card">
                                        <input type="radio" name="payment_type" value="paid" class="hidden" @checked(old('payment_type', ($event->price ?? 0) > 0 ? 'paid' : 'free')==='paid')>
                                        <span class="block text-sm font-semibold text-[#1E3A8A]">Payant</span>
                                    </label>
                                </div>
                                @error('payment_type')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4" id="price-section">
                                <div class="form-group">
                                    <label for="price" class="form-label">Prix</label>
                                    <div class="relative">
                                        <input type="number" name="price" id="price" min="0" step="0.01"
                                               value=""
                                               class="form-input @error('price') error @enderror pr-12">
                                        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                            <span class="text-[#6B7280] text-sm" id="currency-symbol">

                                            </span>
                                        </div>
                                    </div>
                                    @error('price')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="currency" class="form-label">Devise *</label>
                                    <select name="currency" id="currency" class="form-input currency-select @error('currency') error @enderror">
                                        @foreach($currencies as $code => $data)
                                            <option value="{{ $code }}" data-symbol="{{ $data['symbol'] ?? $code }}">
                                                {{ $code }} — {{ $data['name'] ?? $code }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('currency')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <!-- Méthodes de paiement disponibles -->
                            <div class="form-group" id="payment-methods">
                                <label class="form-label">Méthodes de paiement disponibles</label>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                    <label class="checkbox-card flex items-center gap-3">
                                        <input type="checkbox" name="allow_payment_numeric" value="1" class="h-5 w-5 rounded border-gray-300 text-[#4F46E5] focus:ring-[#4F46E5]">
                                        <span class="text-sm">Paiement numérique (Kkiapay)</span>
                                    </label>
                                    <label class="checkbox-card flex items-center gap-3">
                                        <input type="checkbox" name="allow_payment_physical" value="1" class="h-5 w-5 rounded border-gray-300 text-[#4F46E5] focus:ring-[#4F46E5]">
                                        <span class="text-sm">Paiement sur place</span>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <!-- Politique de transfert de ticket -->
                        <div class="checkbox-card">
                            <label class="flex items-start space-x-3 cursor-pointer">
                                <input id="allow_ticket_transfer" name="allow_ticket_transfer" type="checkbox" value="1" class="mt-1 h-5 w-5 rounded border-gray-300 text-[#4F46E5] focus:ring-[#4F46E5]">
                                <div class="flex-1">
                                    <span class="block text-sm font-semibold text-[#1E3A8A]">Autoriser le transfert de tickets</span>
                                    <span class="mt-1 block text-sm text-[#6B7280]">Les participants peuvent transférer leur ticket à une autre personne.</span>
                                </div>
                            </label>
                        </div>

                        <!-- Section remplacée par capacité illimitée + type + prix/devise plus bas -->


                        <!-- Section devise déplacée dans la section paiement ci-dessus -->

                        <!-- Restriction d'âge -->
                        <div class="checkbox-card @if(old('is_restricted_18')) checked @endif" id="age-restriction-card">
                            <div class="flex items-start space-x-3">
                                <input id="is_restricted_18" name="is_restricted_18" type="checkbox" value="1"
                                    class="mt-1 h-5 w-5 rounded border-gray-300 text-[#4F46E5] focus:ring-[#4F46E5]"
                                    {{ old('is_restricted_18') ? 'checked' : '' }}>
                                <div class="flex-1">
                                    <label for="is_restricted_18" class="block text-sm font-semibold text-[#1E3A8A]">
                                        Événement réservé aux majeurs
                                    </label>
                                    <p class="mt-1 text-sm text-[#6B7280]">
                                        Les participants devront confirmer avoir au moins 18 ans lors de l'inscription.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Boutons de soumission -->
                <div class="mt-12 pt-8 border-t border-[#E0E7FF] flex flex-col sm:flex-row justify-end space-y-4 sm:space-y-0 sm:space-x-4">
                    <a href="{{ route('dashboard') }}" class="cancel-btn order-2 sm:order-1 text-center">
                        Annuler
                    </a>
                    <button type="submit" class="submit-btn order-1 sm:order-2">
                        <span class="flex items-center justify-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                            </svg>
                            Créer l'événement
                        </span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Gestion de l'upload d'image
    const fileUploadArea = document.getElementById('file-upload-area');
    const coverImageInput = document.getElementById('cover_image');
    const imagePreview = document.getElementById('image-preview');

    fileUploadArea.addEventListener('click', () => coverImageInput.click());

    fileUploadArea.addEventListener('dragover', (e) => {
        e.preventDefault();
        fileUploadArea.classList.add('dragover');
    });

    fileUploadArea.addEventListener('dragleave', () => {
        fileUploadArea.classList.remove('dragover');
    });

    fileUploadArea.addEventListener('drop', (e) => {
        e.preventDefault();
        fileUploadArea.classList.remove('dragover');
        const files = e.dataTransfer.files;
        if (files.length > 0) {
            coverImageInput.files = files;
            previewImage(files[0]);
        }
    });

    coverImageInput.addEventListener('change', (e) => {
        if (e.target.files.length > 0) {
            previewImage(e.target.files[0]);
        }
    });

    function previewImage(file) {
        if (file.type.startsWith('image/')) {
            const reader = new FileReader();
            reader.onload = (e) => {
                imagePreview.src = e.target.result;
                imagePreview.style.display = 'block';
                fileUploadArea.style.display = 'none';
            };
            reader.readAsDataURL(file);
        }
    }

    // Compteur de caractères pour la description
    const descriptionTextarea = document.getElementById('description');
    const descriptionCounter = document.getElementById('description-counter');

    descriptionTextarea.addEventListener('input', () => {
        const length = descriptionTextarea.value.length;
        descriptionCounter.textContent = `${length} caractères`;

        if (length < 50) {
            descriptionCounter.classList.add('text-red-600');
        } else {
            descriptionCounter.classList.remove('text-red-600');
        }
    });

    // Gestion de la devise
    const currencySelect = document.getElementById('currency');
    const currencySymbol = document.getElementById('currency-symbol');

    currencySelect.addEventListener('change', () => {
        const selectedOption = currencySelect.options[currencySelect.selectedIndex];
        currencySymbol.textContent = selectedOption.getAttribute('data-symbol');
    });

    // Validation des dates
    const startDateInput = document.getElementById('start_date');
    const endDateInput = document.getElementById('end_date');

    // Définir les valeurs par défaut
    const now = new Date();
    const defaultStart = new Date(now.getTime() + 24 * 60 * 60 * 1000);
    const defaultEnd = new Date(defaultStart.getTime() + 2 * 60 * 60 * 1000);

    if (!startDateInput.value) {
        startDateInput.value = defaultStart.toISOString().slice(0, 16);
    }

    if (!endDateInput.value) {
        endDateInput.value = defaultEnd.toISOString().slice(0, 16);
    }

    function validateDates() {
        const startDate = new Date(startDateInput.value);
        const endDate = new Date(endDateInput.value);

        if (endDate <= startDate) {
            endDateInput.setCustomValidity('La date de fin doit être postérieure à la date de début');
            endDateInput.classList.add('error');
        } else {
            endDateInput.setCustomValidity('');
            endDateInput.classList.remove('error');
        }
    }

    startDateInput.addEventListener('change', validateDates);
    endDateInput.addEventListener('change', validateDates);

    // Gestion de la carte de restriction d'âge
    const ageCheckbox = document.getElementById('is_restricted_18');
    const ageCard = document.getElementById('age-restriction-card');

    ageCheckbox.addEventListener('change', () => {
        if (ageCheckbox.checked) {
            ageCard.classList.add('checked');
        } else {
            ageCard.classList.remove('checked');
        }
    });

    // Initialiser le compteur de description
    descriptionTextarea.dispatchEvent(new Event('input'));

    // Toggle capacité illimitée
    const unlimitedCheckbox = document.getElementById('is_capacity_unlimited');
    const capacityGroup = document.getElementById('capacity-group');
    const capacityInput = document.getElementById('capacity');
    function syncCapacity() {
        const isUnlimited = unlimitedCheckbox && unlimitedCheckbox.checked;
        if (capacityGroup) {
            capacityGroup.style.display = isUnlimited ? 'none' : '';
        }
        if (capacityInput) {
            capacityInput.disabled = !!isUnlimited;
        }
    }
    if (unlimitedCheckbox) {
        unlimitedCheckbox.addEventListener('change', syncCapacity);
        syncCapacity();
    }

    // Toggle gratuit/payant
    const priceSection = document.getElementById('price-section');
    const paymentTypeRadios = document.querySelectorAll('input[name="payment_type"]');
    function syncPaymentType() {
        let type = 'free';
        paymentTypeRadios.forEach(r => { if (r.checked) type = r.value; });
        if (priceSection) priceSection.style.display = type === 'paid' ? '' : 'none';
        const paymentMethods = document.getElementById('payment-methods');
        if (paymentMethods) paymentMethods.style.display = type === 'paid' ? '' : 'none';
    }
    paymentTypeRadios.forEach(r => r.addEventListener('change', syncPaymentType));
    syncPaymentType();
});
</script>
@endpush
