@extends('layouts.app')

@section('title', 'Vérification d\'identité')

@section('content')
<div class="py-10">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white shadow-xl sm:rounded-3xl overflow-hidden">
            <div class="bg-indigo-600 px-6 py-10 sm:px-10">
                <p class="text-indigo-100 text-xs uppercase tracking-[0.3em]">Sécurité</p>
                <h1 class="mt-3 text-3xl font-bold text-white">Vérifiez votre identité</h1>
                <p class="mt-2 text-indigo-100 text-sm">
                    La plateforme exige une preuve d'identité pour accéder à certains événements. Toutes les données sont chiffrées et vérifiées manuellement en cas d'anomalie.
                </p>
            </div>

            <div class="px-6 py-10 sm:px-10">
                @if(session('success'))
                    <div class="mb-6 rounded-2xl border border-green-200 bg-green-50 p-4 text-sm text-green-700">
                        {{ session('success') }}
                    </div>
                @endif

                @if($errors->any())
                    <div class="mb-6 rounded-2xl border border-red-200 bg-red-50 p-4 text-sm text-red-700">
                        <p class="font-semibold">Il manque des informations :</p>
                        <ul class="mt-2 list-disc list-inside">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('identity.verification.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                    @csrf

                    <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Type de pièce d'identité <span class="text-red-500">*</span></label>
                            <select name="document_type" required class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="">Sélectionnez</option>
                                @foreach(['CNI', 'Passeport', 'Permis de conduire', 'Carte scolaire', 'Autre'] as $type)
                                    <option value="{{ $type }}" @selected(old('document_type', optional($verification)->document_type) === $type)>
                                        {{ $type }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Numéro de document</label>
                            <input type="text" name="document_number" value="{{ old('document_number', optional($verification)->document_number) }}" class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="Ex : 123456789">
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Téléverser la pièce d'identité @if(!$verification || !$verification->document_path)<span class="text-red-500">*</span>@endif</label>
                        <input type="file" name="document" accept="image/jpeg,image/png,application/pdf" class="mt-1 block w-full text-sm text-gray-700">
                        <p class="mt-2 text-xs text-gray-500">Formats acceptés : JPG, PNG, PDF (5 Mo max).</p>
                        @if($verification && $verification->document_path)
                            <p class="mt-2 text-xs text-gray-500">Une pièce est déjà enregistrée. Téléversez un fichier pour la remplacer.</p>
                        @endif
                    </div>

                    <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Numéro matricule <span class="text-red-500">*</span></label>
                            <input type="text" name="matricule" required value="{{ old('matricule', optional($verification)->matricule) }}" class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="Numéro national / scolaire / universitaire">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Date de naissance (déclarée) <span class="text-red-500">*</span></label>
                            <input type="date" name="date_of_birth" required value="{{ old('date_of_birth', optional($verification)->date_of_birth_document?->format('Y-m-d')) }}" class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <p class="mt-2 text-xs text-gray-500">La date doit vous donner un âge d'au moins 18 ans.</p>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Commentaires (facultatif)</label>
                        <textarea name="remarks" rows="3" class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="Précisions ou informations utiles">{{ old('remarks') }}</textarea>
                    </div>

                    <div class="rounded-2xl border border-amber-200 bg-amber-50 p-4 text-sm text-amber-700">
                        <p class="font-semibold">Avertissement légal</p>
                        <p class="mt-1">Toute tentative de fraude à l'identité est enregistrée et peut entraîner des poursuites. Nous utilisons vos données exclusivement pour vérifier votre éligibilité et les protégeons conformément à la réglementation.</p>
                    </div>

                    <div class="flex flex-col gap-2 sm:flex-row sm:justify-end">
                        <a href="{{ url()->previous() }}" class="inline-flex items-center justify-center rounded-xl border border-gray-200 px-4 py-2 text-sm font-semibold text-gray-600 hover:bg-gray-50">
                            Annuler
                        </a>
                        <button type="submit" class="inline-flex items-center justify-center rounded-xl bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow hover:bg-indigo-500">
                            Soumettre la vérification
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
