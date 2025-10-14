@extends('layouts.app')

@section('title', "Modifier l'événement : " . $event->title)

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-2xl font-semibold text-gray-800">Modifier l'événement</h2>
                    <a href="{{ route('events.show', $event) }}" class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                        Retour à l'événement
                    </a>
                </div>

                <form action="{{ route('events.update', $event) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Colonne de gauche -->
                        <div class="space-y-6">
                            <!-- Titre -->
                            <div>
                                <label for="title" class="block text-sm font-medium text-gray-700">Titre de l'événement *</label>
                                <input type="text" name="title" id="title" value="{{ old('title', $event->title) }}" 
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" 
                                    required autofocus>
                                @error('title')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Description -->
                            <div>
                                <label for="description" class="block text-sm font-medium text-gray-700">Description *</label>
                                <textarea name="description" id="description" rows="4" 
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" 
                                    required>{{ old('description', $event->description) }}</textarea>
                                @error('description')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Date et heure -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="start_date" class="block text-sm font-medium text-gray-700">Date de début *</label>
                                    <input type="datetime-local" name="start_date" id="start_date" 
                                        value="{{ old('start_date', optional($event->start_date)->format('Y-m-d\TH:i')) }}"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" 
                                        required>
                                    @error('start_date')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label for="end_date" class="block text-sm font-medium text-gray-700">Date de fin *</label>
                                    <input type="datetime-local" name="end_date" id="end_date" 
                                        value="{{ old('end_date', optional($event->end_date)->format('Y-m-d\TH:i')) }}"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" 
                                        required>
                                    @error('end_date')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Colonne de droite -->
                        <div class="space-y-6">
                            <!-- Lieu -->
                            <div>
                                <label for="location" class="block text-sm font-medium text-gray-700">Lieu *</label>
                                <input type="text" name="location" id="location" value="{{ old('location', $event->location) }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" 
                                    required>
                                @error('location')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Image de couverture -->
                            <div>
                                <label for="cover_image" class="block text-sm font-medium text-gray-700">Image de couverture</label>
                                <div class="mt-1 space-y-3">
                                    @if($event->cover_image)
                                        <div class="h-32 w-full overflow-hidden rounded-md">
                                            <img src="{{ asset('storage/' . $event->cover_image) }}" alt="Image actuelle" class="w-full h-full object-cover">
                                        </div>
                                    @endif
                                    <input type="file" name="cover_image" id="cover_image" 
                                        class="block w-full text-sm text-gray-500
                                            file:mr-4 file:py-2 file:px-4
                                            file:rounded-md file:border-0
                                            file:text-sm file:font-semibold
                                            file:bg-indigo-50 file:text-indigo-700
                                            hover:file:bg-indigo-100"
                                        accept="image/*">
                                    @error('cover_image')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <!-- Capacité maximale -->
                            <div>
                                <label for="capacity" class="block text-sm font-medium text-gray-700">Capacité maximale</label>
                                <input type="number" name="capacity" id="capacity" min="1" value="{{ old('capacity', $event->capacity) }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                @error('capacity')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Prix et devise -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="price" class="block text-sm font-medium text-gray-700">Prix *</label>
                                    <input type="number" name="price" id="price" min="0" step="0.01" value="{{ old('price', App\Support\Currency::toMajorUnits($event->price, $event->currency)) }}"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" 
                                        required>
                                    @error('price')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="currency" class="block text-sm font-medium text-gray-700">Devise *</label>
                                    <select name="currency" id="currency" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                        @foreach($currencies as $code => $data)
                                            <option value="{{ $code }}" @selected(old('currency', $event->currency) === $code)>
                                                {{ $code }} — {{ $data['name'] ?? $code }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('currency')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <!-- Restriction d'âge -->
                            <div class="flex items-start gap-3 rounded-xl border border-amber-200 bg-amber-50 p-4">
                                <input id="is_restricted_18" name="is_restricted_18" type="checkbox" value="1" class="mt-1 h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500" {{ old('is_restricted_18', $event->is_restricted_18) ? 'checked' : '' }}>
                                <div>
                                    <label for="is_restricted_18" class="text-sm font-medium text-amber-900">Événement réservé aux majeurs</label>
                                    <p class="mt-1 text-xs text-amber-700">Si cette case est cochée, les participants devront simplement confirmer avoir au moins 18 ans lors de l'inscription.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Boutons de soumission -->
                    <div class="mt-8 flex justify-end space-x-4">
                        <a href="{{ route('events.show', $event) }}" 
                            class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out durée-150">
                            Annuler
                        </a>
                        <button type="submit" 
                            class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-800 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out durée-150">
                            Enregistrer les modifications
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
