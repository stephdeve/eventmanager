<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 dark:text-neutral-200 leading-tight">
                    Mon Profil
                </h2>
            </div>
        </div>
    </x-slot>

    @section('content')
        <div class="py-8">
            <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
                <!-- Header du profil -->
                <div class="bg-gradient-to-r from-indigo-500 to-purple-600 rounded-2xl p-6 text-white mb-8 shadow-xl dark:from-indigo-600 dark:to-purple-700">
                    <div class="flex items-center space-x-4">
                        <div
                            class="w-16 h-16 bg-white/20 dark:bg-white/10 rounded-full flex items-center justify-center text-white font-bold text-2xl backdrop-blur-sm border border-white/30 dark:border-white/20">
                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                        </div>
                        <div>
                            <h1 class="text-2xl font-bold">{{ Auth::user()->name }}</h1>
                            <p class="text-indigo-100 dark:text-indigo-200">{{ Auth::user()->email }}</p>
                            <div class="flex flex-wrap items-center mt-2 gap-3 text-sm">
                                <span class="flex items-center space-x-1 bg-white/10 dark:bg-white/5 px-3 py-1 rounded-full">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                    <span>Membre depuis {{ Auth::user()->created_at->diffForHumans() }}</span>
                                </span>
                                @if (Auth::user()->email_verified_at)
                                    <span class="flex items-center space-x-1 bg-green-500 dark:bg-green-600 px-3 py-1 rounded-full">
                                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        <span>Email vérifié</span>
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Contenu des onglets -->
                <div x-data="{ activeTab: 'profile' }">
                    <!-- Navigation des tabs -->
                    <div class="bg-white dark:bg-neutral-800 rounded-2xl shadow-sm dark:shadow-neutral-900/50 border border-gray-100 dark:border-neutral-700 mb-6 overflow-hidden">
                        <div class="flex p-2 space-x-2 bg-gray-50/50 dark:bg-neutral-900/50">
                            <!-- Tab Profil -->
                            <button
                                @click="activeTab = 'profile'"
                                :class="{
                                    'bg-white dark:bg-neutral-700 text-emerald-700 dark:text-emerald-400 border-emerald-200 dark:border-emerald-800 shadow-sm dark:shadow-emerald-900/30': activeTab === 'profile',
                                    'text-gray-600 dark:text-neutral-400 hover:text-gray-900 dark:hover:text-neutral-300 hover:bg-gray-100 dark:hover:bg-neutral-800/80 border-transparent': activeTab !== 'profile'
                                }"
                                class="flex-1 py-3 px-4 text-sm font-medium rounded-xl border transition-all duration-200 flex items-center justify-center space-x-2 group"
                            >
                                <svg class="w-4 h-4" :class="activeTab === 'profile' ? 'text-emerald-600 dark:text-emerald-400' : 'text-gray-500 dark:text-neutral-500 group-hover:text-gray-700 dark:group-hover:text-neutral-300'" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                                <span>Informations personnelles</span>
                            </button>

                            <!-- Tab Sécurité -->
                            <button
                                @click="activeTab = 'security'"
                                :class="{
                                    'bg-white dark:bg-neutral-700 text-blue-700 dark:text-blue-400 border-blue-200 dark:border-blue-800 shadow-sm dark:shadow-blue-900/30': activeTab === 'security',
                                    'text-gray-600 dark:text-neutral-400 hover:text-gray-900 dark:hover:text-neutral-300 hover:bg-gray-100 dark:hover:bg-neutral-800/80 border-transparent': activeTab !== 'security'
                                }"
                                class="flex-1 py-3 px-4 text-sm font-medium rounded-xl border transition-all duration-200 flex items-center justify-center space-x-2 group"
                            >
                                <svg class="w-4 h-4" :class="activeTab === 'security' ? 'text-blue-600 dark:text-blue-400' : 'text-gray-500 dark:text-neutral-500 group-hover:text-gray-700 dark:group-hover:text-neutral-300'" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>
                                <span>Sécurité</span>
                            </button>

                            <!-- Tab Danger -->
                            <button
                                @click="activeTab = 'danger'"
                                :class="{
                                    'bg-white dark:bg-neutral-700 text-rose-700 dark:text-rose-400 border-rose-200 dark:border-rose-800 shadow-sm dark:shadow-rose-900/30': activeTab === 'danger',
                                    'text-gray-600 dark:text-neutral-400 hover:text-gray-900 dark:hover:text-neutral-300 hover:bg-gray-100 dark:hover:bg-neutral-800/80 border-transparent': activeTab !== 'danger'
                                }"
                                class="flex-1 py-3 px-4 text-sm font-medium rounded-xl border transition-all duration-200 flex items-center justify-center space-x-2 group"
                            >
                                <svg class="w-4 h-4" :class="activeTab === 'danger' ? 'text-rose-600 dark:text-rose-400' : 'text-gray-500 dark:text-neutral-500 group-hover:text-gray-700 dark:group-hover:text-neutral-300'" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.618 5.984A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016zM12 9v2m0 4h.01" />
                                </svg>
                                <span>Zone de danger</span>
                            </button>
                        </div>
                    </div>

                    <!-- Indicateur de tab active -->
                    <div class="relative mb-6">
                        <div class="flex items-center space-x-4 px-2">
                            <div class="flex-1">
                                <div class="h-1 bg-gray-100 dark:bg-neutral-800 rounded-full overflow-hidden">
                                    <div
                                        class="h-full transition-all duration-300 ease-out"
                                        :class="{
                                            'w-1/3 translate-x-0': activeTab === 'profile',
                                            'w-1/3 translate-x-full': activeTab === 'security',
                                            'w-1/3 translate-x-[200%]': activeTab === 'danger'
                                        }"
                                        :style="activeTab === 'profile' ? 'background: linear-gradient(to right, #10b981, #34d399)' :
                                                activeTab === 'security' ? 'background: linear-gradient(to right, #3b82f6, #60a5fa)' :
                                                'background: linear-gradient(to right, #f43f5e, #fb7185)'"
                                    ></div>
                                </div>
                            </div>
                            <div class="text-sm text-gray-500 dark:text-neutral-400 font-medium">
                                <span x-text="activeTab === 'profile' ? 'Étape 1/3' : activeTab === 'security' ? 'Étape 2/3' : 'Étape 3/3'"></span>
                            </div>
                        </div>
                    </div>

                    <!-- Contenu des tabs -->
                    <div class="relative">
                        <!-- Tab Profil -->
                        <div
                            x-show="activeTab === 'profile'"
                            x-transition:enter="transition ease-out duration-300"
                            x-transition:enter-start="opacity-0 transform translate-x-4"
                            x-transition:enter-end="opacity-100 transform translate-x-0"
                            x-transition:leave="transition ease-in duration-200"
                            x-transition:leave-start="opacity-100 transform translate-x-0"
                            x-transition:leave-end="opacity-0 transform -translate-x-4"
                            class="bg-white dark:bg-neutral-800 rounded-2xl shadow-sm dark:shadow-neutral-900/50 border border-gray-100 dark:border-neutral-700 overflow-hidden"
                        >
                            @include('profile.partials.update-profile-information-form')
                        </div>

                        <!-- Tab Sécurité -->
                        <div
                            x-show="activeTab === 'security'"
                            x-transition:enter="transition ease-out duration-300"
                            x-transition:enter-start="opacity-0 transform translate-x-4"
                            x-transition:enter-end="opacity-100 transform translate-x-0"
                            x-transition:leave="transition ease-in duration-200"
                            x-transition:leave-start="opacity-100 transform translate-x-0"
                            x-transition:leave-end="opacity-0 transform -translate-x-4"
                            style="display: none;"
                            class="bg-white dark:bg-neutral-800 rounded-2xl shadow-sm dark:shadow-neutral-900/50 border border-gray-100 dark:border-neutral-700 overflow-hidden"
                        >
                            @include('profile.partials.update-password-form')
                        </div>

                        <!-- Tab Danger -->
                        <div
                            x-show="activeTab === 'danger'"
                            x-transition:enter="transition ease-out duration-300"
                            x-transition:enter-start="opacity-0 transform translate-x-4"
                            x-transition:enter-end="opacity-100 transform translate-x-0"
                            x-transition:leave="transition ease-in duration-200"
                            x-transition:leave-start="opacity-100 transform translate-x-0"
                            x-transition:leave-end="opacity-0 transform -translate-x-4"
                            style="display: none;"
                            class="bg-white dark:bg-neutral-800 rounded-2xl shadow-sm dark:shadow-neutral-900/50 border border-gray-100 dark:border-neutral-700 overflow-hidden"
                        >
                            @include('profile.partials.delete-user-form')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection
</x-app-layout>
