@extends('layouts.app')

@section('title', "Modifier l'événement : " . $event->title)

@push('styles')
    <style>
        .form-gradient {
            background: linear-gradient(135deg, #F9FAFB 0%, #FFFFFF 50%, #E0E7FF 100%);
        }

        .form-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.2);
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
            border: 2px solid #E0E7FF;
            border-radius: 12px;
            background: #F8FAFC;
            padding: 1.25rem;
            transition: all 0.3s ease;
        }

        .checkbox-card:hover {
            border-color: #4F46E5;
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
            border: 2px solid #E5E7EB;
        }

        .current-image {
            max-width: 100%;
            border-radius: 8px;
            border: 2px solid #E5E7EB;
            margin-bottom: 1rem;
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

        .image-section {
            transition: all 0.3s ease;
        }

        .image-section.has-image {
            border-color: #4F46E5;
            background: #E0E7FF;
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

        .dark .file-upload {
            background: #0a0a0a;
            border-color: #262626;
        }

        .dark .file-upload:hover,
        .dark .file-upload.dragover {
            background: #0f0f0f;
            border-color: #4F46E5;
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

        .dark .text-\[\#6B7280\] {
            color: #a3a3a3;
        }

        .dark .bg-white {
            background: #0a0a0a;
        }

        .dark .border-slate-100,
        .dark .border-gray-100,
        .dark .border-gray-200 {
            border-color: #262626;
        }
    </style>
@endpush

@section('content')
    <div class="min-h-screen form-gradient py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- En-tête -->
            <div class="text-center mb-8">
                <h1
                    class="text-3xl font-bold bg-gradient-to-r from-[#1E3A8A] to-[#4F46E5] dark:from-green-500 dark:to-green-600 bg-clip-text text-transparent mb-3">
                    Modifier l'événement
                </h1>
                <p class="text-[#6B7280] text-lg">Mettez à jour les informations de votre événement</p>
            </div>

            <!-- Carte du formulaire -->
            <div class="form-card rounded-2xl p-8">
                <form action="{{ route('events.update', $event) }}" method="POST" enctype="multipart/form-data"
                    id="eventForm">
                    @csrf
                    @method('PUT')

                    <div class="grid form-grid gap-8">
                        <!-- Colonne de gauche -->
                        <div class="space-y-6">
                            <!-- Catégorie -->
                            <div class="form-group">
                                <label for="category" class="form-label">Catégorie</label>
                                <select name="category" id="category" class="form-input">
                                    <option value="">— Sélectionner —</option>
                                    @foreach ($categories ?? [] as $key => $label)
                                        <option value="{{ $key }}" @selected(old('category', $event->category) === $key)>{{ $label }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('category')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <!-- Titre -->
                            <div class="form-group">
                                <label for="title" class="form-label">
                                    Titre de l'événement *
                                    <span class="text-[#6B7280] text-sm font-normal">(Soyez créatif !)</span>
                                </label>
                                <input type="text" name="title" id="title"
                                    value="{{ old('title', $event->title) }}"
                                    class="form-input @error('title') error @enderror"
                                    placeholder="Ex: Conférence Tech 2024" required autofocus>
                                @error('title')
                                    <p class="mt-2 text-sm text-red-600 flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <!-- Lien Google Maps (optionnel) -->
                            <div class="form-group">
                                <label for="google_maps_url" class="form-label">Lien Google Maps</label>
                                <input type="url" name="google_maps_url" id="google_maps_url"
                                    value="{{ old('google_maps_url', $event->google_maps_url) }}"
                                    class="form-input @error('google_maps_url') error @enderror"
                                    placeholder="https://maps.google.com/...">
                                @error('google_maps_url')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Description -->
                            <div class="form-group">
                                <label for="description" class="form-label">
                                    Description *
                                    <span class="text-[#6B7280] text-sm font-normal">(Décrivez votre événement)</span>
                                </label>
                                <textarea name="description" id="description" rows="5"
                                    class="form-input @error('description') error @enderror resize-none"
                                    placeholder="Décrivez en détail votre événement, ses objectifs, et ce que les participants peuvent en attendre..."
                                    required>{{ old('description', $event->description) }}</textarea>
                                <div class="flex justify-between text-xs text-[#6B7280] mt-1">
                                    <span>Minimum 50 caractères</span>
                                    <span id="description-counter">{{ strlen($event->description) }} caractères</span>
                                </div>
                                @error('description')
                                    <p class="mt-2 text-sm text-red-600 flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <!-- Date et heure -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="form-group">
                                    <label for="start_date" class="form-label">Date de début *
                                        <span class="text-[#6B7280] text-xs font-normal block">Heure locale du navigateur.
                                            Doit précéder la date de fin.</span>
                                    </label>
                                    <input type="datetime-local" name="start_date" id="start_date"
                                        value="{{ old('start_date', optional($event->start_date)->format('Y-m-d\\TH:i')) }}"
                                        class="form-input @error('start_date') error @enderror" required>
                                    @error('start_date')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="end_date" class="form-label">Date de fin *
                                        <span class="text-[#6B7280] text-xs font-normal block">Doit être postérieure à la
                                            date de début.</span>
                                    </label>
                                    <input type="datetime-local" name="end_date" id="end_date"
                                        value="{{ old('end_date', optional($event->end_date)->format('Y-m-d\\TH:i')) }}"
                                        class="form-input @error('end_date') error @enderror" required>
                                    @error('end_date')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <!-- Heures par jour (optionnel) -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="form-group">
                                    <label for="daily_start_time" class="form-label">Heure de début (par jour)
                                        <span class="text-[#6B7280] text-xs font-normal block">Optionnel. Appliqué chaque
                                            jour si défini.</span>
                                    </label>
                                    <input type="time" name="daily_start_time" id="daily_start_time"
                                        value="{{ old('daily_start_time', optional($event->daily_start_time)->format('H:i')) }}"
                                        class="form-input @error('daily_start_time') error @enderror">
                                    @error('daily_start_time')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="daily_end_time" class="form-label">Heure de fin (par jour)
                                        <span class="text-[#6B7280] text-xs font-normal block">Optionnel. Doit être après
                                            l'heure de début du jour.</span>
                                    </label>
                                    <input type="time" name="daily_end_time" id="daily_end_time"
                                        value="{{ old('daily_end_time', optional($event->daily_end_time)->format('H:i')) }}"
                                        class="form-input @error('daily_end_time') error @enderror">
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
                                <input type="text" name="location" id="location"
                                    value="{{ old('location', $event->location) }}"
                                    class="form-input @error('location') error @enderror"
                                    placeholder="Ex: Paris Event Center ou Lien Zoom" required>
                                @error('location')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Image de couverture -->
                            <div class="form-group">
                                <label class="form-label">Image de couverture</label>

                                @if ($event->cover_image)
                                    <div class="mb-4">
                                        <p class="text-sm text-[#6B7280] mb-2">Image actuelle :</p>
                                        <img src="{{ asset('storage/' . $event->cover_image) }}"
                                            alt="Image actuelle de l'événement" class="current-image">
                                    </div>
                                @endif

                                <div class="file-upload @if ($event->cover_image) hidden @endif"
                                    id="file-upload-area">
                                    <input type="file" name="cover_image" id="cover_image" class="hidden"
                                        accept="image/*">
                                    <div class="text-center">
                                        <svg class="w-12 h-12 mx-auto text-[#6B7280] mb-3" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        <p class="text-sm text-[#6B7280] mb-2">
                                            <span class="font-semibold text-[#4F46E5]">Cliquez pour uploader</span> ou
                                            glissez-déposez
                                        </p>
                                        <p class="text-xs text-[#6B7280]">PNG, JPG, JPEG jusqu'à 5MB</p>
                                    </div>
                                </div>
                                <img id="image-preview" class="preview-image hidden" alt="Aperçu de la nouvelle image">

                                @if ($event->cover_image)
                                    <button type="button" id="change-image-btn"
                                        class="cancel-btn w-full mt-3 text-center">
                                        Changer l'image
                                    </button>
                                @endif

                                @error('cover_image')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Capacité -->
                            <div class="space-y-2">
                                <div class="checkbox-card" id="capacity-card">
                                    <label class="flex items-start space-x-3 cursor-pointer">
                                        <input type="checkbox" id="is_capacity_unlimited" name="is_capacity_unlimited"
                                            value="1"
                                            class="mt-1 h-5 w-5 rounded border-gray-300 text-[#4F46E5] focus:ring-[#4F46E5]"
                                            {{ old('is_capacity_unlimited', $event->is_capacity_unlimited) ? 'checked' : '' }}>
                                        <div>
                                            <span class="block text-sm font-semibold text-[#1E3A8A]">Places
                                                illimitées</span>
                                            <span class="block text-xs text-[#6B7280]">Décochez pour définir une capacité
                                                maximale</span>
                                        </div>
                                    </label>
                                </div>
                                <div class="form-group" id="capacity-group">
                                    <label for="capacity" class="form-label">Capacité maximale</label>
                                    <input type="number" name="capacity" id="capacity" min="1"
                                        value="{{ old('capacity', $event->capacity) }}"
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
                                            <input type="radio" name="payment_type" value="free" class="hidden"
                                                @checked(old('payment_type', ($event->price ?? 0) > 0 ? 'paid' : 'free') === 'free')>
                                            <span class="block text-sm font-semibold text-[#1E3A8A]">Gratuit</span>
                                        </label>
                                        <label class="checkbox-card">
                                            <input type="radio" name="payment_type" value="paid" class="hidden"
                                                @checked(old('payment_type', ($event->price ?? 0) > 0 ? 'paid' : 'free') === 'paid')>
                                            <span class="block text-sm font-semibold text-[#1E3A8A]">Payant</span>
                                        </label>
                                    </div>
                                    @error('payment_type')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4" id="price-section">
                                    <div class="form-group">
                                        <label for="price" class="form-label">Prix
                                            <span class="text-[#6B7280] text-xs font-normal block">Montant en unité majeure
                                                (ex: 10.00).</span>
                                        </label>
                                        <div class="relative">
                                            <input type="number" name="price" id="price" min="0"
                                                step="0.01"
                                                value="{{ old('price', App\Support\Currency::toMajorUnits($event->price, $event->currency)) }}"
                                                class="form-input @error('price') error @enderror pr-12">
                                            <div
                                                class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                                <span class="text-[#6B7280] text-sm" id="currency-symbol">
                                                    {{ $currencies[$event->currency]['symbol'] ?? $event->currency }}
                                                </span>
                                            </div>
                                        </div>
                                        @error('price')
                                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="currency" class="form-label">Devise *
                                            <span class="text-[#6B7280] text-xs font-normal block">Détermine le format
                                                d'affichage des prix.</span>
                                        </label>
                                        <select name="currency" id="currency"
                                            class="form-input currency-select @error('currency') error @enderror">
                                            @foreach ($currencies as $code => $data)
                                                <option value="{{ $code }}"
                                                    data-symbol="{{ $data['symbol'] ?? $code }}"
                                                    @selected(old('currency', $event->currency) === $code)>
                                                    {{ $data['flag'] ?? '' }} {{ $code }} — {{ $data['name'] ?? $code }} ({{ $data['symbol'] ?? $code }})
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
                                    <label class="form-label">Méthodes de paiement disponibles
                                        <span class="text-[#6B7280] text-xs font-normal block">Cochez au moins une méthode
                                            si l'événement est payant.</span>
                                    </label>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                        <label class="checkbox-card flex items-center gap-3">
                                            <input type="checkbox" name="allow_payment_numeric" value="1"
                                                class="h-5 w-5 rounded border-gray-300 text-[#4F46E5] focus:ring-[#4F46E5]"
                                                {{ old('allow_payment_numeric', $event->allow_payment_numeric) ? 'checked' : '' }}>
                                            <span class="text-sm">Paiement numérique (Kkiapay)</span>
                                        </label>
                                        <label class="checkbox-card flex items-center gap-3">
                                            <input type="checkbox" name="allow_payment_physical" value="1"
                                                class="h-5 w-5 rounded border-gray-300 text-[#4F46E5] focus:ring-[#4F46E5]"
                                                {{ old('allow_payment_physical', $event->allow_payment_physical) ? 'checked' : '' }}>
                                            <span class="text-sm">Paiement sur place</span>
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <!-- Politique de transfert de ticket -->
                            <div class="checkbox-card @if (old('allow_ticket_transfer', $event->allow_ticket_transfer)) checked @endif">
                                <label class="flex items-start space-x-3 cursor-pointer">
                                    <input id="allow_ticket_transfer" name="allow_ticket_transfer" type="checkbox"
                                        value="1"
                                        class="mt-1 h-5 w-5 rounded border-gray-300 text-[#4F46E5] focus:ring-[#4F46E5]"
                                        {{ old('allow_ticket_transfer', $event->allow_ticket_transfer) ? 'checked' : '' }}>
                                    <div class="flex-1">
                                        <span class="block text-sm font-semibold text-[#1E3A8A]">Autoriser le transfert de
                                            tickets</span>
                                        <span class="mt-1 block text-sm text-[#6B7280]">Les participants peuvent transférer
                                            leur ticket à une autre personne.</span>
                                    </div>
                                </label>
                            </div>

                            <!-- Restriction d'âge -->
                            <div class="checkbox-card @if (old('is_restricted_18', $event->is_restricted_18)) checked @endif"
                                id="age-restriction-card">
                                <div class="flex items-start space-x-3">
                                    <input id="is_restricted_18" name="is_restricted_18" type="checkbox" value="1"
                                        class="mt-1 h-5 w-5 rounded border-gray-300 text-[#4F46E5] focus:ring-[#4F46E5]"
                                        {{ old('is_restricted_18', $event->is_restricted_18) ? 'checked' : '' }}>
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

                    {{-- Stories Vidéo Section --}}
                    <div class="form-card p-8 rounded-2xl mb-8">
                        <div class="flex items-center gap-3 mb-6">
                            <div
                                class="w-12 h-12 bg-gradient-to-br from-purple-500 to-pink-500 rounded-xl flex items-center justify-center shadow-lg">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-xl font-bold text-slate-900">📱 Stories Vidéo</h3>
                                <p class="text-sm text-slate-600">Publiez des vidéos courtes pour promouvoir votre événement
                                    (15-60s)</p>
                            </div>
                        </div>

                        {{-- Upload Story --}}
                        <div class="mb-6">
                            {{-- Tabs --}}
                            <div class="flex border-b border-slate-300 mb-6">
                                <button type="button" class="story-tab-btn px-6 py-3 font-semibold text-indigo-600 border-b-2 border-indigo-600" data-tab="upload">
                                    📤 Upload Vidéo
                                </button>
                                <button type="button" class="story-tab-btn px-6 py-3 font-semibold text-slate-600 hover:text-indigo-600 transition" data-tab="url">
                                    🔗 URL Externe
                                </button>
                            </div>

                            {{-- Upload Tab Content --}}
                            <div id="upload-tab-content" class="story-tab-content">
                                <form action="{{ route('stories.store', $event) }}" method="POST"
                                    enctype="multipart/form-data" id="story-upload-form">
                                    @csrf
                                    <div
                                        class="border-2 border-dashed border-indigo-300 rounded-xl p-6 bg-indigo-50/50 hover:border-indigo-400 transition">
                                        <input type="file" name="video" id="story-video-input"
                                            accept="video/mp4,video/mov,video/webm" class="hidden"
                                            onchange="handleStoryUpload(this)">

                                        <label for="story-video-input" class="cursor-pointer flex flex-col items-center gap-3">
                                            <svg class="w-12 h-12 text-indigo-500" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                            </svg>
                                            <div class="text-center">
                                                <p class="font-semibold text-indigo-700">Cliquez pour uploader une vidéo</p>
                                                <p class="text-sm text-slate-600 mt-1">MP4, MOV, WebM • Max 50MB • 15-60
                                                    secondes</p>
                                                <p class="text-xs text-slate-500 mt-2">📱 Format portrait (9:16) recommandé</p>
                                            </div>
                                        </label>

                                        <div id="upload-progress" class="hidden mt-4">
                                            <div class="flex items-center justify-between mb-2">
                                                <span class="text-sm font-medium text-slate-700">Upload en cours...</span>
                                                <span id="progress-percent" class="text-sm font-bold text-indigo-600">0%</span>
                                            </div>
                                            <div class="w-full bg-slate-200 rounded-full h-2">
                                                <div id="progress-bar" class="bg-indigo-600 h-2 rounded-full transition-all"
                                                    style="width: 0%"></div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mt-4 flex items-center gap-4">
                                        <label class="flex items-center gap-2">
                                            <input type="checkbox" name="is_active" value="1"
                                                class="w-4 h-4 text-indigo-600 border-gray-300 rounded">
                                            <span class="text-sm font-medium text-slate-700">Publier immédiatement</span>
                                        </label>
                                    </div>
                                </form>
                            </div>

                            {{-- URL Tab Content --}}
                            <div id="url-tab-content" class="story-tab-content hidden">
                                <form action="{{ route('stories.store', $event) }}" method="POST" id="story-url-form">
                                    @csrf
                                    <div class="space-y-4">
                                        <div>
                                            <label class="block text-sm font-semibold text-slate-700 mb-2">
                                                URL de la vidéo
                                            </label>
                                            <input type="url" name="external_url" 
                                                class="w-full px-4 py-3 border-2 border-slate-300 rounded-lg focus:border-indigo-500 focus:outline-none transition"
                                                placeholder="https://www.youtube.com/watch?v=..." required>
                                            <p class="text-xs text-slate-500 mt-2">
                                                Plateformes supportées: YouTube, TikTok, Instagram
                                            </p>
                                        </div>

                                        <div class="grid grid-cols-3 gap-3">
                                            <div class="p-4 border-2 border-slate-200 rounded-lg text-center hover:border-red-400 transition">
                                                <svg class="w-8 h-8 mx-auto mb-2 text-red-600" fill="currentColor" viewBox="0 0 24 24">
                                                    <path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/>
                                                </svg>
                                                <p class="text-xs font-semibold text-slate-700">YouTube</p>
                                            </div>
                                            <div class="p-4 border-2 border-slate-200 rounded-lg text-center hover:border-black transition">
                                                <svg class="w-8 h-8 mx-auto mb-2" fill="currentColor" viewBox="0 0 24 24">
                                                    <path d="M12.525.02c1.31-.02 2.61-.01 3.91-.02.08 1.53.63 3.09 1.75 4.17 1.12 1.11 2.7 1.62 4.24 1.79v4.03c-1.44-.05-2.89-.35-4.2-.97-.57-.26-1.1-.59-1.62-.93-.01 2.92.01 5.84-.02 8.75-.08 1.4-.54 2.79-1.35 3.94-1.31 1.92-3.58 3.17-5.91 3.21-1.43.08-2.86-.31-4.08-1.03-2.02-1.19-3.44-3.37-3.65-5.71-.02-.5-.03-1-.01-1.49.18-1.9 1.12-3.72 2.58-4.96 1.66-1.44 3.98-2.13 6.15-1.72.02 1.48-.04 2.96-.04 4.44-.99-.32-2.15-.23-3.02.37-.63.41-1.11 1.04-1.36 1.75-.21.51-.15 1.07-.14 1.61.24 1.64 1.82 3.02 3.5 2.87 1.12-.01 2.19-.66 2.77-1.61.19-.33.4-.67.41-1.06.1-1.79.06-3.57.07-5.36.01-4.03-.01-8.05.02-12.07z"/>
                                                </svg>
                                                <p class="text-xs font-semibold text-slate-700">TikTok</p>
                                            </div>
                                            <div class="p-4 border-2 border-slate-200 rounded-lg text-center hover:border-pink-400 transition">
                                                <svg class="w-8 h-8 mx-auto mb-2 text-pink-600" fill="currentColor" viewBox="0 0 24 24">
                                                    <path d="M12 0C8.74 0 8.333.015 7.053.072 5.775.132 4.905.333 4.14.63c-.789.306-1.459.717-2.126 1.384S.935 3.35.63 4.14C.333 4.905.131 5.775.072 7.053.012 8.333 0 8.74 0 12s.015 3.667.072 4.947c.06 1.277.261 2.148.558 2.913.306.788.717 1.459 1.384 2.126.667.666 1.336 1.079 2.126 1.384.766.296 1.636.499 2.913.558C8.333 23.988 8.74 24 12 24s3.667-.015 4.947-.072c1.277-.06 2.148-.262 2.913-.558.788-.306 1.459-.718 2.126-1.384.666-.667 1.079-1.335 1.384-2.126.296-.765.499-1.636.558-2.913.06-1.28.072-1.687.072-4.947s-.015-3.667-.072-4.947c-.06-1.277-.262-2.149-.558-2.913-.306-.789-.718-1.459-1.384-2.126C21.319 1.347 20.651.935 19.86.63c-.765-.297-1.636-.499-2.913-.558C15.667.012 15.26 0 12 0zm0 2.16c3.203 0 3.585.016 4.85.071 1.17.055 1.805.249 2.227.415.562.217.96.477 1.382.896.419.42.679.819.896 1.381.164.422.36 1.057.413 2.227.057 1.266.07 1.646.07 4.85s-.015 3.585-.074 4.85c-.061 1.17-.256 1.805-.421 2.227-.224.562-.479.96-.899 1.382-.419.419-.824.679-1.38.896-.42.164-1.065.36-2.235.413-1.274.057-1.649.07-4.859.07-3.211 0-3.586-.015-4.859-.074-1.171-.061-1.816-.256-2.236-.421-.569-.224-.96-.479-1.379-.899-.421-.419-.69-.824-.9-1.38-.165-.42-.359-1.065-.42-2.235-.045-1.26-.061-1.649-.061-4.844 0-3.196.016-3.586.061-4.861.061-1.17.255-1.814.42-2.234.21-.57.479-.96.9-1.381.419-.419.81-.689 1.379-.898.42-.166 1.051-.361 2.221-.421 1.275-.045 1.65-.06 4.859-.06l.045.03zm0 3.678c-3.405 0-6.162 2.76-6.162 6.162 0 3.405 2.76 6.162 6.162 6.162 3.405 0 6.162-2.76 6.162-6.162 0-3.405-2.76-6.162-6.162-6.162zM12 16c-2.21 0-4-1.79-4-4s1.79-4 4-4 4 1.79 4 4-1.79 4-4 4zm7.846-10.405c0 .795-.646 1.44-1.44 1.44-.795 0-1.44-.646-1.44-1.44 0-.794.646-1.439 1.44-1.439.793-.001 1.44.645 1.44 1.439z"/>
                                                </svg>
                                                <p class="text-xs font-semibold text-slate-700">Instagram</p>
                                            </div>
                                        </div>

                                        <div class="mt-4 flex items-center gap-4">
                                            <label class="flex items-center gap-2">
                                                <input type="checkbox" name="is_active" value="1"
                                                    class="w-4 h-4 text-indigo-600 border-gray-300 rounded">
                                                <span class="text-sm font-medium text-slate-700">Publier immédiatement</span>
                                            </label>
                                        </div>

                                        <button type="submit" class="w-full bg-indigo-600 text-white font-semibold py-3 px-6 rounded-lg hover:bg-indigo-700 transition">
                                            ➕ Ajouter la Story
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>

                        {{-- Existing Stories List --}}
                        @if ($event->stories->count() > 0)
                            <div class="border-t border-slate-200 pt-6">
                                <h4 class="font-bold text-slate-900 mb-4 flex items-center gap-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                    </svg>
                                    Vos stories ({{ $event->stories->count() }})
                                </h4>

                                <div id="stories-list" class="space-y-3">
                                    @foreach ($event->stories()->orderBy('order')->get() as $story)
                                        <div
                                            class="story-item bg-white border border-slate-200 rounded-xl p-4 flex items-center gap-4 hover:border-indigo-300 transition"
                                            data-story-id="{{ $story->id }}">
                                            {{-- Drag handle --}}
                                            <div class="drag-handle cursor-move text-slate-400 hover:text-slate-600">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M4 8h16M4 16h16" />
                                                </svg>
                                            </div>

                                            {{-- Video thumbnail --}}
                                            <div class="w-16 h-28 bg-slate-100 rounded-lg overflow-hidden flex-shrink-0">
                                                @if ($story->thumbnail_path)
                                                    <img src="{{ asset('storage/' . $story->thumbnail_path) }}"
                                                        alt="Thumbnail" class="w-full h-full object-cover">
                                                @else
                                                    <div
                                                        class="w-full h-full flex items-center justify-center text-slate-400">
                                                        <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                                                            <path
                                                                d="M2 6a2 2 0 012-2h6a2 2 0 012 2v8a2 2 0 01-2 2H4a2 2 0 01-2-2V6z" />
                                                            <path
                                                                d="M14.553 7.106A1 1 0 0014 8v4a1 1 0 00.553.894l2 1A1 1 0 0018 13V7a1 1 0 00-1.447-.894l-2 1z" />
                                                        </svg>
                                                    </div>
                                                @endif
                                            </div>

                                            {{-- Story info --}}
                                            <div class="flex-1">
                                                <div class="flex items-center gap-2 mb-1">
                                                    <span class="font-semibold text-slate-900">Story #{{ $story->order + 1 }}</span>
                                                    @if ($story->is_active)
                                                        <span
                                                            class="px-2 py-0.5 bg-green-100 text-green-700 text-xs font-semibold rounded-full">Publié</span>
                                                    @else
                                                        <span
                                                            class="px-2 py-0.5 bg-slate-100 text-slate-600 text-xs font-semibold rounded-full">Brouillon</span>
                                                    @endif
                                                </div>
                                                <div class="flex items-center gap-4 text-sm text-slate-600">
                                                    <span>⏱️ {{ $story->duration }}s</span>
                                                    <span>👁️ {{ number_format($story->views_count) }} vues</span>
                                                    <span>📅 {{ $story->created_at->diffForHumans() }}</span>
                                                </div>
                                            </div>

                                            {{-- Actions --}}
                                            <div class="flex items-center gap-2">
                                                {{-- Toggle Active --}}
                                                <form action="{{ route('stories.update', [$event, $story]) }}"
                                                    method="POST" class="inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <input type="hidden" name="is_active"
                                                        value="{{ $story->is_active ? '0' : '1' }}">
                                                    <button type="submit"
                                                        class="p-2 rounded-lg {{ $story->is_active ? 'bg-slate-100 text-slate-600 hover:bg-slate-200' : 'bg-indigo-100 text-indigo-600 hover:bg-indigo-200' }} transition">
                                                        @if ($story->is_active)
                                                            <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                                viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                                                            </svg>
                                                        @else
                                                            <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                                viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                            </svg>
                                                        @endif
                                                    </button>
                                                </form>

                                                {{-- Delete --}}
                                                <form action="{{ route('stories.destroy', [$event, $story]) }}"
                                                    method="POST" class="inline"
                                                    onsubmit="return confirm('Supprimer cette story ?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="p-2 bg-red-100 text-red-600 rounded-lg hover:bg-red-200 transition">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                            viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                        </svg>
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                                <div class="mt-4 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                                    <p class="text-sm text-blue-800">
                                        💡 <strong>Astuce:</strong> Glissez-déposez les stories pour changer leur ordre
                                        d'affichage.
                                    </p>
                                </div>
                            </div>
                        @else
                            <div class="border-t border-slate-200 pt-6">
                                <div class="text-center py-8 text-slate-500">
                                    <svg class="w-16 h-16 mx-auto mb-3 text-slate-300" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                    </svg>
                                    <p class="font-medium">Aucune story publiée</p>
                                    <p class="text-sm mt-1">Uploadez votre première vidéo pour commencer</p>
                                </div>
                            </div>
                        @endif
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
                                Enregistrer les modifications
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
            const changeImageBtn = document.getElementById('change-image-btn');
            const currentImageSection = document.querySelector('.form-group .mb-4');

            if (fileUploadArea) {
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
            }

            if (changeImageBtn) {
                changeImageBtn.addEventListener('click', () => {
                    fileUploadArea.classList.remove('hidden');
                    changeImageBtn.classList.add('hidden');
                    if (currentImageSection) {
                        currentImageSection.classList.add('hidden');
                    }
                });
            }

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
                        imagePreview.classList.remove('hidden');
                        if (fileUploadArea) fileUploadArea.style.display = 'none';
                        if (changeImageBtn) changeImageBtn.classList.remove('hidden');
                        if (currentImageSection) currentImageSection.classList.add('hidden');
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
                paymentTypeRadios.forEach(r => {
                    if (r.checked) type = r.value;
                });
                if (priceSection) priceSection.style.display = type === 'paid' ? '' : 'none';
                const paymentMethods = document.getElementById('payment-methods');
                if (paymentMethods) paymentMethods.style.display = type === 'paid' ? '' : 'none';
            }
            paymentTypeRadios.forEach(r => r.addEventListener('change', syncPaymentType));
            syncPaymentType();
        });
    </script>

    {{-- Story Upload & Reorder JavaScript --}}
    <script>
        // Handle story video upload
        function handleStoryUpload(input) {
            if (input.files && input.files[0]) {
                const file = input.files[0];
                const maxSize = 50 * 1024 * 1024; // 50MB
                
                // Validate file size
                if (file.size > maxSize) {
                    alert('La vidéo est trop volumineuse. Maximum 50MB.');
                    input.value = '';
                    return;
                }
                
                // Validate video duration (would require loading the video)
                const form = document.getElementById('story-upload-form');
                const progressDiv = document.getElementById('upload-progress');
                const progressBar = document.getElementById('progress-bar');
                const progressPercent = document.getElementById('progress-percent');
                
                // Show progress
                progressDiv.classList.remove('hidden');
                
                // Create FormData and submit
                const formData = new FormData(form);
                
                // Submit with progress tracking
                const xhr = new XMLHttpRequest();
                
                xhr.upload.addEventListener('progress', (e) => {
                    if (e.lengthComputable) {
                        const percent = Math.round((e.loaded / e.total) * 100);
                        progressBar.style.width = percent + '%';
                        progressPercent.textContent = percent + '%';
                    }
                });
                
                xhr.addEventListener('load', () => {
                    if (xhr.status === 200 || xhr.status === 302) {
                        window.location.reload();
                    } else {
                        alert('Erreur lors de l\'upload');
                        progressDiv.classList.add('hidden');
                        input.value = '';
                    }
                });
                
                xhr.addEventListener('error', () => {
                    alert('Erreur réseau');
                    progressDiv.classList.add('hidden');
                    input.value = '';
                });
                
                xhr.open('POST', form.action);
                xhr.setRequestHeader('X-CSRF-TOKEN', document.querySelector('meta[name="csrf-token"]').content);
                xhr.send(formData);
            }
        }
        
        // Drag and drop reordering
        document.addEventListener('DOMContentLoaded', () => {
            const storiesList = document.getElementById('stories-list');
            if (!storiesList) return;
            
            let draggedItem = null;
            
            const items = storiesList.querySelectorAll('.story-item');
            items.forEach(item => {
                const handle = item.querySelector('.drag-handle');
                
                handle.addEventListener('mousedown', () => {
                    item.setAttribute('draggable', true);
                });
                
                item.addEventListener('dragstart', (e) => {
                    draggedItem = item;
                    e.dataTransfer.effectAllowed = 'move';
                    item.classList.add('opacity-50');
                });
                
                item.addEventListener('dragend', () => {
                    item.classList.remove('opacity-50');
                    item.setAttribute('draggable', false);
                });
                
                item.addEventListener('dragover', (e) => {
                    e.preventDefault();
                    e.dataTransfer.dropEffect = 'move';
                    
                    if (draggedItem && draggedItem !== item) {
                        const rect = item.getBoundingClientRect();
                        const midpoint = rect.top + rect.height / 2;
                        
                        if (e.clientY < midpoint) {
                            item.parentNode.insertBefore(draggedItem, item);
                        } else {
                            item.parentNode.insertBefore(draggedItem, item.nextSibling);
                        }
                    }
                });
                
                item.addEventListener('drop', (e) => {
                    e.preventDefault();
                    saveNewOrder();
                });
            });
            
            function saveNewOrder() {
                const items = Array.from(storiesList.querySelectorAll('.story-item'));
                const stories = items.map((item, index) => ({
                    id: item.dataset.storyId,
                    order: index
                }));
                
                // Send to server
                fetch('{{ route('stories.reorder', $event) }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({ stories })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Update order numbers in UI
                        items.forEach((item, index) => {
                            const orderSpan = item.querySelector('.font-semibold');
                            if (orderSpan) {
                                orderSpan.textContent = `Story #${index + 1}`;
                            }
                        });
                    }
                })
                .catch(error => console.error('Error saving order:', error));
            }
        });
    </script>

    {{-- Story Tabs JavaScript --}}
    <script>
        // Tab switching for upload vs URL
        document.querySelectorAll('.story-tab-btn').forEach(btn => {
            btn.addEventListener('click', () => {
                const tab = btn.dataset.tab;
                
                // Update tab buttons
                document.querySelectorAll('.story-tab-btn').forEach(b => {
                    b.classList.remove('text-indigo-600', 'border-b-2', 'border-indigo-600');
                    b.classList.add('text-slate-600');
                });
                btn.classList.remove('text-slate-600');
                btn.classList.add('text-indigo-600', 'border-b-2', 'border-indigo-600');
                
                // Update tab content
                document.querySelectorAll('.story-tab-content').forEach(content => {
                    content.classList.add('hidden');
                });
                document.getElementById(`${tab}-tab-content`).classList.remove('hidden');
            });
        });
    </script>
@endpush
