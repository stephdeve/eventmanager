<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Mon Profil
                </h2>
            </div>
        </div>
    </x-slot>
    @section('content')
        <div class="py-8">
            <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
                <!-- Header du profil -->
                <div class="bg-gradient-to-r from-indigo-500 to-purple-600 rounded-2xl p-6 text-white mb-8 shadow-xl">
                    <div class="flex items-center space-x-4">
                        <div
                            class="w-16 h-16 bg-white/20 rounded-full flex items-center justify-center text-white font-bold text-2xl backdrop-blur-sm border border-white/30">
                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                        </div>
                        <div>
                            <h1 class="text-2xl font-bold">{{ Auth::user()->name }}</h1>
                            <p class="text-indigo-100">{{ Auth::user()->email }}</p>
                            <div class="flex items-center mt-2 space-x-4 text-sm">
                                <span class="flex items-center space-x-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                    <span>Membre depuis {{ Auth::user()->created_at->diffForHumans() }}</span>
                                </span>
                                @if (Auth::user()->email_verified_at)
                                    <span class="flex items-center space-x-1 bg-white/20 px-2 py-1 rounded-full">
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
                    <!-- Navigation -->
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 mb-6">
                        <div class="flex space-x-1 p-2">
                            <button @click="activeTab = 'profile'"
                                :class="activeTab === 'profile' ? 'bg-green-50 text-white-50 border-green-200' :
                                    'text-gray-600 hover:text-gray-900 hover:bg-green-200 border-transparent'"
                                class="flex-1 py-3 px-4  hover:bg-green-100 text-sm bg-green-100 font-medium rounded-xl border transition-all duration-200">
                                Informations personnelles
                            </button>
                            <button @click="activeTab = 'security'"
                                :class="activeTab === 'security' ? 'bg-indigo-50 text-indigo-700 border-indigo-200' :
                                    'text-gray-600 hover:text-gray-900 hover:bg-blue-200 border-transparent'"
                                class="flex-1 py-3 px-4  text-sm bg-blue-100 font-medium rounded-xl border transition-all duration-200">
                                Sécurité
                            </button>
                            <button @click="activeTab = 'danger'"
                                :class="activeTab === 'danger' ? 'bg-red-50 text-red-700 border-red-200' :
                                    'text-gray-600 hover:text-gray-900 hover:bg-red-200 border-transparent'"
                                class="flex-1 py-3 px-4 hover:bg-red-200 text-sm bg-red-100 font-medium rounded-xl border transition-all duration-200">
                                Zone de danger
                            </button>
                        </div>
                    </div>

                    <!-- Contenu -->
                    <div>
                        <div x-show="activeTab === 'profile'">
                            @include('profile.partials.update-profile-information-form')
                        </div>

                        <div x-show="activeTab === 'security'" style="display: none;">
                            @include('profile.partials.update-password-form')
                        </div>

                        <div x-show="activeTab === 'danger'" style="display: none;">
                            @include('profile.partials.delete-user-form')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection
</x-app-layout>
