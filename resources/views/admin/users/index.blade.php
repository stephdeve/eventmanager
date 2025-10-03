@extends('layouts.app')

@section('content')
@php
    $totalUsers = $users->count();
    $totalOrganizers = $users->where('role', 'organizer')->count();
    $totalStudents = $users->where('role', 'student')->count();
@endphp

<div class="relative overflow-hidden py-10">
    <div class="absolute inset-0 -z-10 bg-gradient-to-br from-indigo-500 via-purple-500/70 to-sky-500 opacity-40"></div>

    <div class="container mx-auto px-4">
        <div class="rounded-3xl bg-white/30 backdrop-blur-lg p-8 shadow-xl">
            <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                <div>
                    <span class="inline-flex items-center rounded-full bg-white/60 px-3 py-1 text-xs font-semibold uppercase tracking-widest text-indigo-700">Administration</span>
                    <h1 class="mt-4 text-3xl font-bold text-slate-900">Gestion des utilisateurs</h1>
                    <p class="mt-2 text-sm text-slate-600">Administrez les rôles et accédez rapidement aux informations clés de votre communauté.</p>
                </div>
                <div class="flex items-center gap-3">
                    <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-white/70 text-lg font-semibold text-indigo-600">
                        {{ $totalUsers }}
                    </div>
                    <div class="text-sm text-slate-600">
                        <p class="font-semibold text-slate-900">Utilisateurs inscrits</p>
                        <p>Gérez les rôles et permissions en temps réel.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container mx-auto px-4 pb-12">
    @isset($charts)
        <div class="grid grid-cols-1 gap-8 xl:grid-cols-2 mb-10">
            <div class="mx-auto w-full max-w-2xl rounded-3xl bg-white px-4 py-5 shadow-lg">
                <div class="flex items-center justify-between">
                    <h2 class="text-base font-semibold text-slate-800">Répartition des rôles</h2>
                </div>
                <div class="mt-3">
                    <canvas id="adminUsersRoleChart" height="100"></canvas>
                </div>
            </div>

            <div class="rounded-3xl bg-white p-6 shadow-lg">
                <div class="flex items-center justify-between">
                    <h2 class="text-lg font-semibold text-slate-800">Nouvelles inscriptions (6 mois)</h2>
                    <span class="rounded-full bg-indigo-50 px-3 py-1 text-xs font-semibold text-indigo-600">Tendance</span>
                </div>
                <div class="mt-6">
                    <canvas id="adminUsersSignupChart" height="260"></canvas>
                </div>
            </div>
        </div>
    @endisset

    @if(session('success'))
        <div class="mb-6 flex items-start gap-3 rounded-2xl border border-green-200 bg-green-50 px-5 py-4 text-sm text-green-700 shadow-sm">
            <span class="mt-0.5 inline-flex h-6 w-6 items-center justify-center rounded-full bg-green-600/10 text-green-600">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
            </span>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <div class="grid grid-cols-1 gap-6 md:grid-cols-3">
        <div class="rounded-2xl border border-indigo-100 bg-white p-6 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-500">Utilisateurs</p>
                    <p class="mt-2 text-3xl font-bold text-slate-900">{{ $totalUsers }}</p>
                </div>
                <span class="inline-flex h-12 w-12 items-center justify-center rounded-2xl bg-indigo-50 text-indigo-600">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M9 11a4 4 0 118 0 4 4 0 01-8 0zm10 1v6"></path></svg>
                </span>
            </div>
        </div>
        <div class="rounded-2xl border border-blue-100 bg-white p-6 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-500">Organisateurs</p>
                    <p class="mt-2 text-3xl font-bold text-slate-900">{{ $totalOrganizers }}</p>
                </div>
                <span class="inline-flex h-12 w-12 items-center justify-center rounded-2xl bg-blue-50 text-blue-600">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422A12.083 12.083 0 0112 21.5a12.083 12.083 0 01-6.16-10.922L12 14z"></path></svg>
                </span>
            </div>
        </div>
        <div class="rounded-2xl border border-emerald-100 bg-white p-6 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-500">Étudiants</p>
                    <p class="mt-2 text-3xl font-bold text-slate-900">{{ $totalStudents }}</p>
                </div>
                <span class="inline-flex h-12 w-12 items-center justify-center rounded-2xl bg-emerald-50 text-emerald-600">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422A12.083 12.083 0 0112 21.5a12.083 12.083 0 01-6.16-10.922L12 14z"></path></svg>
                </span>
            </div>
        </div>
    </div>

    {{-- Bloc principal de gestion des filtres et du tableau (piloté par Alpine.js pour éviter un rechargement) --}}
    <div class="mt-8 rounded-2xl bg-white shadow-lg" x-data="userTable()">
        <div class="border-b border-slate-100 px-6 py-5">
            <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                <div class="flex w-full flex-1 items-center gap-3">
                    <div class="w-full md:w-80">
                        {{-- Champ de recherche filtrant dynamiquement les lignes du tableau --}}
                        <label for="search" class="sr-only">Rechercher un utilisateur</label>
                        <div class="relative">
                            <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M17 11a6 6 0 11-12 0 6 6 0 0112 0z"></path></svg>
                            </span>
                            <input id="search"
                                   type="search"
                                   placeholder="Rechercher par nom ou email"
                                   class="w-full rounded-xl border border-slate-200 bg-slate-50 py-2.5 pl-10 pr-4 text-sm text-slate-700 placeholder-slate-400 focus:border-indigo-400 focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-200"
                                   x-model.debounce.300ms="searchTerm"
                                   {{-- Liaison Alpine pour déclencher le filtrage sans rechargement --}} />
                        </div>
                    </div>
                    <div class="w-full sm:w-52">
                        {{-- Sélecteur de rôle combiné à la recherche pour filtrer côté client --}}
                        <label for="role-filter" class="sr-only">Filtrer par rôle</label>
                        <select id="role-filter"
                                class="w-full rounded-xl border border-slate-200 bg-slate-50 py-2.5 px-3 text-sm text-slate-700 focus:border-indigo-400 focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-200"
                                x-model="roleFilter"
                                {{-- Mise à jour instantanée du filtre via Alpine --}}>
                            <option value="">Tous les rôles</option>
                            <option value="admin">Administrateurs</option>
                            <option value="organizer">Organisateurs</option>
                            <option value="student">Étudiants</option>
                        </select>
                    </div>
                </div>
                <a href="{{ route('admin.users.export') }}" class="inline-flex items-center justify-center gap-2 rounded-xl border border-indigo-200 bg-indigo-50 px-4 py-2 text-sm font-semibold text-indigo-600 transition hover:bg-indigo-100">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2M7 10l5 5 5-5M12 4v12"></path></svg>
                    Exporter
                </a>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200">
                <thead class="bg-slate-50 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                    <tr>
                        <th class="whitespace-nowrap px-6 py-4">Nom</th>
                        <th class="whitespace-nowrap px-6 py-4">Email</th>
                        <th class="whitespace-nowrap px-6 py-4">Rôle</th>
                        <th class="whitespace-nowrap px-6 py-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 bg-white text-sm text-slate-600">
                    @forelse($users as $user)
                        <tr class="transition hover:bg-indigo-50/60">
                            <td class="whitespace-nowrap px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="flex h-10 w-10 items-center justify-center rounded-full bg-indigo-100 text-sm font-semibold text-indigo-600">
                                        {{ strtoupper(mb_substr($user->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <p class="font-semibold text-slate-900">{{ $user->name }}</p>
                                        <p class="text-xs text-slate-400">ID #{{ $user->id }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="whitespace-nowrap px-6 py-4 text-slate-500">{{ $user->email }}</td>
                            <td class="whitespace-nowrap px-6 py-4">
                                <span class="inline-flex items-center rounded-full px-3 py-1 text-xs font-semibold @class([
                                    'bg-purple-100 text-purple-700' => $user->role === 'admin',
                                    'bg-blue-100 text-blue-700' => $user->role === 'organizer',
                                    'bg-emerald-100 text-emerald-700' => $user->role === 'student',
                                ])">
                                    {{ __('roles.' . $user->role) ?? ucfirst($user->role) }}
                                </span>
                            </td>
                            <td class="whitespace-nowrap px-6 py-4 text-right">
                                <div class="flex justify-end gap-3">
                                    @can('update', $user)
                                        <a href="{{ route('admin.users.edit', $user) }}" class="inline-flex items-center gap-2 rounded-full border border-indigo-200 px-4 py-2 text-xs font-semibold text-indigo-600 transition hover:border-indigo-300 hover:bg-indigo-50">
                                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5h2M5 7h2m5 12h2m4-4h2M7 17h2m-4-4h2m5-4h2m4-4h2"></path></svg>
                                            Modifier
                                        </a>
                                    @endcan

                                    @can('delete', $user)
                                        <button type="button"
                                                x-data
                                                x-on:click="$dispatch('open-delete-modal', {{ $user->id }})"
                                                class="inline-flex items-center gap-2 rounded-full border border-rose-200 px-4 py-2 text-xs font-semibold text-rose-600 transition hover:border-rose-300 hover:bg-rose-50">
                                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                            Supprimer
                                        </button>
                                    @endcan
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-10 text-center text-sm text-slate-400">
                                Aucun utilisateur pour le moment. Invitez des membres ou inscrivez de nouveaux utilisateurs pour commencer.
                            </td>
                        </tr>
                    @endforelse
                    @if($users->isNotEmpty())
                        {{-- Message affiché lorsque les filtres ne correspondent à aucun résultat --}}
                        <tr x-ref="filteredMessage" class="hidden">
                            <td colspan="4" class="px-6 py-10 text-center text-sm text-slate-400">
                                Aucun utilisateur ne correspond à votre recherche pour le moment.
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>
    <div x-data="deleteUserModal()"
         x-on:open-delete-modal.window="open($event.detail)"
         x-show="isOpen"
         x-cloak
         class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/60 backdrop-blur">
        <div class="w-full max-w-md rounded-3xl bg-white p-8 shadow-2xl">
            <div class="flex items-start gap-4">
                <span class="inline-flex h-12 w-12 items-center justify-center rounded-2xl bg-rose-100 text-rose-600">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                </span>
                <div>
                    <h3 class="text-lg font-semibold text-slate-900">Confirmer la suppression</h3>
                    <p class="mt-2 text-sm text-slate-600">Cette action est définitive. Voulez-vous vraiment supprimer cet utilisateur ?</p>
                </div>
            </div>

            <form x-ref="form" method="POST" class="mt-6" x-bind:action="deleteUrl">
                @csrf
                @method('DELETE')

                <div class="flex flex-col-reverse gap-3 sm:flex-row sm:justify-end">
                    <button type="button"
                            x-on:click="close()"
                            class="inline-flex items-center justify-center gap-2 rounded-xl border border-slate-200 px-4 py-2 text-sm font-semibold text-slate-600 transition hover:border-slate-300 hover:bg-slate-50">
                        Annuler
                    </button>
                    <button type="submit"
                            class="inline-flex items-center justify-center gap-2 rounded-xl bg-gradient-to-r from-rose-600 to-amber-500 px-5 py-2 text-sm font-semibold text-white shadow-lg transition hover:from-rose-500 hover:to-amber-400">
                        Supprimer définitivement
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script type="module">
    import { initAdminUsersCharts } from '{{ Vite::asset('resources/js/components/admin-users-charts.js') }}';

    initAdminUsersCharts({
        roles: @json($charts['roles'] ?? []),
        signups: @json($charts['signups'] ?? []),
    });
</script>
@endpush

@push('scripts')
<script>
    // Fonction d'enregistrement des composants Alpine. Appelée lors de l'événement "alpine:init"
    // et immédiatement si Alpine est déjà démarré (cas fréquent avec Vite).
    const registerAdminUsersComponents = () => {
        if (window.__adminUsersComponentsRegistered) {
            return;
        }

        window.__adminUsersComponentsRegistered = true;

        // Composant Alpine gérant la fenêtre de confirmation de suppression
        Alpine.data('deleteUserModal', () => ({
            isOpen: false,
            deleteUrl: '',
            open(userId) {
                // Injection dynamique de l'URL de suppression sécurisée
                this.deleteUrl = `{{ route('admin.users.destroy', ':id') }}`.replace(':id', userId);
                this.isOpen = true;
            },
            close() {
                // Fermeture de la modale et nettoyage de l'URL cible
                this.isOpen = false;
                this.deleteUrl = '';
            }
        }));

        // Composant Alpine orchestrant la recherche et le filtrage des utilisateurs
        Alpine.data('userTable', () => ({
            searchTerm: '',
            roleFilter: '',
            // Méthode appelée automatiquement par Alpine à l'initialisation du composant
            init() {
                this.filterRows();

                // Surveille les changements des filtres pour appliquer le rafraîchissement
                this.$watch('searchTerm', () => this.filterRows());
                this.$watch('roleFilter', () => this.filterRows());
            },
            // Applique le filtrage en manipulant directement les lignes du tableau (aucun rechargement requis)
            filterRows() {
                const rows = this.$refs.tbody?.querySelectorAll('[data-user-row]') ?? [];
                const term = this.searchTerm.trim().toLowerCase();
                let visibleCount = 0;

                rows.forEach((row) => {
                    const role = row.dataset.role ?? '';
                    const name = (row.dataset.name ?? '').toLowerCase();
                    const email = (row.dataset.email ?? '').toLowerCase();

                    const matchesRole = this.roleFilter === '' || role === this.roleFilter;
                    const matchesSearch = term === '' || name.includes(term) || email.includes(term);
                    const isVisible = matchesRole && matchesSearch;

                    row.classList.toggle('hidden', !isVisible);

                    if (isVisible) {
                        visibleCount++;
                    }
                });

                if (this.$refs.filteredMessage) {
                    this.$refs.filteredMessage.classList.toggle('hidden', visibleCount !== 0);
                }
            }
        }));
    };

    document.addEventListener('alpine:init', registerAdminUsersComponents);

    if (window.Alpine) {
        registerAdminUsersComponents();
    }
</script>
@endpush
@endsection
