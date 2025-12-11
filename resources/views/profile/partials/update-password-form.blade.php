<section>
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        <header class="mb-6">
            <div class="flex items-center space-x-3 mb-2">
                <div class="w-10 h-10 bg-green-100 rounded-xl flex items-center justify-center">
                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                </div>
                <div>
                    <h2 class="text-lg font-semibold text-gray-900">
                        Sécurité du compte
                    </h2>
                    <p class="text-sm text-gray-600">
                        Modifiez votre mot de passe pour renforcer la sécurité
                    </p>
                </div>
            </div>
        </header>

        <form method="post" action="{{ route('password.update') }}" class="space-y-6">
            @csrf
            @method('put')

            <div class="grid grid-cols-1 gap-6">
                <!-- Mot de passe actuel -->
                <div>
                    <label for="update_password_current_password"
                        class="block text-sm font-medium text-gray-700 mb-2">Mot de passe actuel</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                        </div>
                        <input id="update_password_current_password" name="current_password" type="password"
                            autocomplete="current-password"
                            class="block w-full pl-10 pr-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors duration-200"
                            placeholder="Votre mot de passe actuel">
                    </div>
                    @error('current_password', 'updatePassword')
                        <p class="mt-2 text-sm text-red-600 flex items-center space-x-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span>{{ $message }}</span>
                        </p>
                    @enderror
                </div>

                <!-- Nouveau mot de passe -->
                <div>
                    <label for="update_password_password" class="block text-sm font-medium text-gray-700 mb-2">Nouveau
                        mot de passe</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                        </div>
                        <input id="update_password_password" name="password" type="password" autocomplete="new-password"
                            class="block w-full pl-10 pr-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors duration-200"
                            placeholder="Votre nouveau mot de passe">
                    </div>
                    @error('password', 'updatePassword')
                        <p class="mt-2 text-sm text-red-600 flex items-center space-x-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span>{{ $message }}</span>
                        </p>
                    @enderror
                </div>

                <!-- Confirmation mot de passe -->
                <div>
                    <label for="update_password_password_confirmation"
                        class="block text-sm font-medium text-gray-700 mb-2">Confirmer le mot de passe</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                        </div>
                        <input id="update_password_password_confirmation" name="password_confirmation" type="password"
                            autocomplete="new-password"
                            class="block w-full pl-10 pr-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors duration-200"
                            placeholder="Confirmez votre nouveau mot de passe">
                    </div>
                    @error('password_confirmation', 'updatePassword')
                        <p class="mt-2 text-sm text-red-600 flex items-center space-x-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span>{{ $message }}</span>
                        </p>
                    @enderror
                </div>
            </div>

            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4 pt-8 border-t border-gray-200 dark:border-neutral-700">
    <!-- Conseils de sécurité -->
    <div class="flex-1">
        <div class="flex items-start gap-3 p-4 bg-gradient-to-r from-emerald-50 to-green-50 dark:from-emerald-900/20 dark:to-green-900/20 rounded-xl border border-emerald-100 dark:border-emerald-800/30">
            <div class="flex-shrink-0 p-2 bg-emerald-100 dark:bg-emerald-900/40 rounded-lg">
                <svg class="w-5 h-5 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                </svg>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-900 dark:text-gray-100 mb-1">Recommandations de sécurité</p>
                <p class="text-sm text-gray-600 dark:text-gray-400">
                    Utilisez un mot de passe fort contenant au moins 8 caractères avec un mélange de lettres majuscules/minuscules,
                    chiffres et caractères spéciaux.
                </p>
            </div>
        </div>
    </div>

    <!-- Actions -->
    <div class="flex flex-col sm:flex-row items-start sm:items-center gap-4">
        <!-- Message de confirmation -->
        @if (session('status') === 'password-updated')
            <div x-data="{ show: true }" x-show="show" x-transition
                x-init="setTimeout(() => show = false, 3000)"
                class="flex items-center gap-2 px-4 py-2.5 bg-emerald-500/10 dark:bg-emerald-500/20 border border-emerald-200 dark:border-emerald-800 rounded-xl shadow-sm">
                <div class="flex-shrink-0">
                    <div class="w-6 h-6 bg-emerald-500 rounded-full flex items-center justify-center">
                        <svg class="w-3.5 h-3.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                </div>
                <div>
                    <p class="text-sm font-semibold text-emerald-700 dark:text-emerald-400">Mot de passe modifié</p>
                    <p class="text-xs text-emerald-600 dark:text-emerald-500/80">Votre mot de passe a été mis à jour avec succès</p>
                </div>
                <button @click="show = false" class="ml-2 text-emerald-500 hover:text-emerald-700 dark:text-emerald-400 dark:hover:text-emerald-300">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        @endif

        <!-- Bouton d'action -->
        <button type="submit"
            class="group relative inline-flex items-center justify-center gap-2 px-6 py-3.5 bg-gradient-to-r from-emerald-600 to-green-600 dark:from-emerald-700 dark:to-green-700 text-white font-medium rounded-xl hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 dark:focus:ring-emerald-600 transition-all duration-200 shadow-md hover:shadow-emerald-500/25 dark:shadow-emerald-900/30 overflow-hidden">
            <!-- Effet de fond animé -->
            <span class="absolute inset-0 w-full h-full bg-gradient-to-r from-emerald-700 to-green-700 dark:from-emerald-800 dark:to-green-800 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></span>

            <!-- Icône -->
            <svg class="relative z-10 w-4 h-4 group-hover:scale-110 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
            </svg>

            <!-- Texte -->
            <span class="relative z-10">Mettre à jour le mot de passe</span>

            <!-- Effet de bordure animé -->
            <span class="absolute inset-0 rounded-xl border-2 border-transparent group-hover:border-emerald-400/30 dark:group-hover:border-emerald-500/30 transition-all duration-300"></span>
        </button>
    </div>
</div>
        </form>
    </div>
</section>
