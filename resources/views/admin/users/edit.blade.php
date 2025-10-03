@extends('layouts.app')

@section('content')
<div class="relative overflow-hidden py-12">
    <div class="absolute inset-0 -z-10 bg-gradient-to-br from-indigo-500 via-purple-500/70 to-sky-500 opacity-30"></div>

    <div class="container mx-auto px-4">
        <div class="mx-auto max-w-2xl overflow-hidden rounded-3xl bg-white/70 shadow-2xl backdrop-blur">
            <div class="bg-gradient-to-r from-indigo-600 via-purple-500 to-sky-500 px-8 py-7 text-white">
                <div class="flex items-center gap-4">
                    <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-white/20 text-xl font-semibold">
                        {{ strtoupper(mb_substr($user->name, 0, 1)) }}
                    </div>
                    <div>
                        <p class="text-sm uppercase tracking-wide text-white/80">Gestion des rôles</p>
                        <h2 class="text-2xl font-bold">Modifier l’utilisateur</h2>
                        <p class="text-sm text-white/80">Ajustez le rôle et les permissions de ce membre.</p>
                    </div>
                </div>
            </div>

            <div class="px-8 py-8">
                <form action="{{ route('admin.users.update', $user) }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                        <div>
                            <label class="block text-sm font-semibold text-slate-600" for="name">Nom</label>
                            <div class="mt-2 flex items-center rounded-2xl border border-slate-200 bg-slate-50/80 px-4 py-3 text-sm text-slate-600">
                                <svg class="mr-3 h-5 w-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M9 11a4 4 0 118 0 4 4 0 01-8 0zm10 1v6"></path></svg>
                                {{ $user->name }}
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-slate-600" for="email">Email</label>
                            <div class="mt-2 flex items-center rounded-2xl border border-slate-200 bg-slate-50/80 px-4 py-3 text-sm text-slate-600">
                                <svg class="mr-3 h-5 w-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8m-18 8h18"></path></svg>
                                {{ $user->email }}
                            </div>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-slate-600" for="role">Rôle attribué</label>
                        <div class="mt-2 grid gap-4 sm:grid-cols-3">
                            @foreach($roles as $value => $label)
                                <label class="relative flex cursor-pointer flex-col rounded-2xl border border-slate-200 bg-white/70 p-4 shadow-sm transition hover:border-indigo-300 hover:shadow-md">
                                    <input type="radio" name="role" value="{{ $value }}" class="sr-only" {{ $user->role === $value ? 'checked' : '' }}>
                                    <div class="flex items-center justify-between">
                                        <span class="text-sm font-semibold text-slate-800">{{ $label }}</span>
                                        @if($user->role === $value)
                                            <span class="inline-flex h-6 w-6 items-center justify-center rounded-full bg-indigo-500 text-white">
                                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                            </span>
                                        @else
                                            <span class="inline-flex h-6 w-6 items-center justify-center rounded-full border border-slate-300 text-transparent">•</span>
                                        @endif
                                    </div>
                                    <p class="mt-3 text-xs text-slate-500">@switch($value)
                                        @case('admin')Responsable global de l’application.@break
                                        @case('organizer')Gère les événements et les participants.@break
                                        @defaultAccès dédié à la réservation et participation.@endswitch</p>
                                </label>
                            @endforeach
                        </div>
                        @error('role')
                            <p class="mt-2 text-xs font-medium text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex flex-col gap-3 sm:flex-row sm:justify-end">
                        <a href="{{ route('admin.users.index') }}" class="inline-flex items-center justify-center gap-2 rounded-xl border border-slate-200 px-5 py-3 text-sm font-semibold text-slate-600 transition hover:border-slate-300 hover:bg-slate-50">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 17l-5-5m0 0l5-5m-5 5h12"></path></svg>
                            Retour
                        </a>
                        <button type="submit" class="inline-flex items-center justify-center gap-2 rounded-xl bg-gradient-to-r from-indigo-600 to-purple-600 px-6 py-3 text-sm font-semibold text-white shadow-lg transition hover:from-indigo-500 hover:to-purple-500">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            Enregistrer
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
