@auth
    <a href="{{ route('dashboard') }}"
        class="flex items-center px-3 py-3 rounded-xl transition-all duration-200 group relative"
        :class="[
            sidebarCollapsed ? 'lg:justify-center lg:h-10 lg:hover:bg-transparent' : 'lg:space-x-3',
            isActive ?
            'bg-indigo-50 text-indigo-700 dark:border border-indigo-600 dark:bg-neutral-800 dark:text-neutral-100 dark:border-neutral-700' :
            'text-gray-700 hover:bg-indigo-50 hover:text-indigo-700 dark:text-neutral-300 dark:hover:bg-neutral-800 dark:hover:text-neutral-100'
        ]"
        x-data="{
            isActive: {{ request()->routeIs('dashboard') ? 'true' : 'false' }}
        }">

        <div class="w-8 h-8 rounded-lg flex items-center justify-center transition-colors flex-shrink-0"
            :class="[
                // Contexte actif standard
                isActive ?
                    'bg-indigo-200 dark:bg-neutral-800' :
                    'bg-indigo-100 group-hover:bg-indigo-200 dark:bg-neutral-800 dark:ring-1 dark:ring-neutral-700 dark:group-hover:bg-neutral-700',
                // NOUVEAU: Indicateur actif en mode réduit (anneau autour de l'icône)
                sidebarCollapsed && isActive ? 'lg:ring-2 lg:ring-indigo-600/70 lg:bg-indigo-200/50' : ''
            ]">
            <svg class="w-4 h-4 transition-colors group-hover:text-indigo-700 dark:group-hover:text-indigo-300"
                :class="isActive ? 'text-indigo-700 dark:text-indigo-400' : 'text-indigo-600 dark:text-indigo-300'"
                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z">
                </path>
            </svg>
        </div>

        <span class="font-medium whitespace-nowrap transition-all duration-300 ml-3 lg:ml-0"
            :class="sidebarCollapsed ? 'lg:hidden' : ''">
            Tableau de bord
        </span>

        <div x-show="sidebarCollapsed && !isActive"
            class="absolute left-full ml-2 px-2 py-1 bg-gray-900 text-white text-sm rounded-md opacity-0 group-hover:opacity-100 transition-opacity duration-200 whitespace-nowrap z-50 hidden lg:block dark:bg-neutral-800 dark:text-neutral-100"
            x-cloak>
            Tableau de bord
        </div>
    </a>


    <a href="{{ route('events.index', ['interactive' => 1]) }}"
        class="flex items-center px-3 py-3 rounded-xl transition-all duration-200 group relative"
        :class="[
            sidebarCollapsed ? 'lg:justify-center lg:h-10 lg:hover:bg-transparent' : 'lg:space-x-3',
            isActive ?
            'bg-emerald-50 text-emerald-700 dark:border border-emerald-600 dark:bg-neutral-800 dark:text-neutral-100 dark:border-neutral-700' :
            'text-gray-700 hover:bg-emerald-50 hover:text-emerald-700 dark:text-neutral-300 dark:hover:bg-neutral-800 dark:hover:text-neutral-100'
        ]"
        x-data="{
            isActive: {{ request()->routeIs('events.index') && request('interactive') == '1' ? 'true' : 'false' }}
        }">

        <div class="w-8 h-8 rounded-lg flex items-center justify-center transition-colors flex-shrink-0"
            :class="[
                // Contexte actif standard
                isActive ?
                    'bg-emerald-200 dark:bg-neutral-800' :
                    'bg-emerald-100 group-hover:bg-emerald-200 dark:bg-neutral-800 dark:ring-1 dark:ring-neutral-700 dark:group-hover:bg-neutral-700',
                // NOUVEAU: Indicateur actif en mode réduit (anneau autour de l'icône)
                sidebarCollapsed && isActive ? 'lg:ring-2 lg:ring-emerald-600/70 lg:bg-emerald-200/50' : ''
            ]">
            <svg class="w-4 h-4 transition-colors group-hover:text-emerald-700 dark:group-hover:text-emerald-300"
                :class="isActive ? 'text-emerald-700 dark:text-emerald-400' : 'text-emerald-600 dark:text-emerald-300'"
                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
            </svg>
        </div>

        <span class="font-medium whitespace-nowrap transition-all duration-300 ml-3 lg:ml-0"
            :class="sidebarCollapsed ? 'lg:hidden' : ''">
            Interactif
        </span>

        <div x-show="sidebarCollapsed && !isActive"
            class="absolute left-full ml-2 px-2 py-1 bg-gray-900 text-white text-sm rounded-md opacity-0 group-hover:opacity-100 transition-opacity duration-200 whitespace-nowrap z-50 hidden lg:block dark:bg-neutral-800 dark:text-neutral-100"
            x-cloak>
            Interactif
        </div>
    </a>



    <a href="{{ route('events.index') }}"
        class="flex items-center px-3 py-3 rounded-xl transition-all duration-200 group relative"
        :class="[
            sidebarCollapsed ? 'lg:justify-center lg:h-10 lg:hover:bg-transparent' : 'lg:space-x-3',
            isActive ?
            'bg-blue-50 text-blue-700 dark:border border-blue-600 dark:bg-neutral-800 dark:text-neutral-100 dark:border-neutral-700' :
            'text-gray-700 hover:bg-blue-50 hover:text-blue-700 dark:text-neutral-300 dark:hover:bg-neutral-800 dark:hover:text-neutral-100'
        ]"
        x-data="{
            isActive: {{ request()->routeIs('events.*') && !request()->routeIs('events.create') && !(request()->routeIs('events.index') && request('interactive') == '1') ? 'true' : 'false' }}
        }">

        <div class="w-8 h-8 rounded-lg flex items-center justify-center transition-colors flex-shrink-0"
            :class="[
                // Contexte actif standard
                isActive ?
                    'bg-blue-200 dark:bg-neutral-800' :
                    'bg-blue-100 group-hover:bg-blue-200 dark:bg-neutral-800 dark:ring-1 dark:ring-neutral-700 dark:group-hover:bg-neutral-700',
                // NOUVEAU: Indicateur actif en mode réduit (anneau autour de l'icône)
                sidebarCollapsed && isActive ? 'lg:ring-2 lg:ring-blue-600/70 lg:bg-blue-200/50' : ''
            ]">
            <svg class="w-4 h-4 transition-colors group-hover:text-blue-700 dark:group-hover:text-blue-300"
                :class="isActive ? 'text-blue-700 dark:text-blue-400' : 'text-blue-600 dark:text-blue-300'" fill="none"
                stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
            </svg>
        </div>

        <span class="font-medium whitespace-nowrap transition-all duration-300 ml-3 lg:ml-0"
            :class="sidebarCollapsed ? 'lg:hidden' : ''">
            Événements
        </span>

        <div x-show="sidebarCollapsed && !isActive"
            class="absolute left-full ml-2 px-2 py-1 bg-gray-900 text-white text-sm rounded-md opacity-0 group-hover:opacity-100 transition-opacity duration-200 whitespace-nowrap z-50 hidden lg:block dark:bg-neutral-800 dark:text-neutral-100"
            x-cloak>
            Événements
        </div>
    </a>



    @if (auth()->user()->isOrganizer())
        <a href="{{ route('events.create') }}"
            class="flex items-center px-3 py-3 rounded-xl transition-all duration-200 group relative"
            :class="[
                sidebarCollapsed ? 'lg:justify-center lg:h-10 lg:hover:bg-transparent' : 'lg:space-x-3',
                isActive ?
                'bg-emerald-50 text-emerald-700 dark:border border-emerald-600 dark:bg-neutral-800 dark:text-neutral-100 dark:border-neutral-700' :
                'text-gray-700 hover:bg-emerald-50 hover:text-emerald-700 dark:text-neutral-300 dark:hover:bg-neutral-800 dark:hover:text-neutral-100'
            ]"
            x-data="{
                isActive: {{ request()->routeIs('events.create') ? 'true' : 'false' }}
            }">

            <div class="w-8 h-8 rounded-lg flex items-center justify-center transition-colors flex-shrink-0"
                :class="[
                    // Contexte actif standard
                    isActive ?
                        'bg-emerald-200 dark:bg-neutral-800' :
                        'bg-emerald-100 group-hover:bg-emerald-200 dark:bg-neutral-800 dark:ring-1 dark:ring-neutral-700 dark:group-hover:bg-neutral-700',
                    // NOUVEAU: Indicateur actif en mode réduit (anneau autour de l'icône)
                    sidebarCollapsed && isActive ? 'lg:ring-2 lg:ring-emerald-600/70 lg:bg-emerald-200/50' : ''
                ]">
                <svg class="w-4 h-4 transition-colors group-hover:text-emerald-700 dark:group-hover:text-emerald-300"
                    :class="isActive ? 'text-emerald-700 dark:text-emerald-400' : 'text-emerald-600 dark:text-emerald-300'"
                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6">
                    </path>
                </svg>
            </div>

            <span class="font-medium whitespace-nowrap transition-all duration-300 ml-3 lg:ml-0"
                :class="sidebarCollapsed ? 'lg:hidden' : ''">
                Créer
            </span>

            <div x-show="sidebarCollapsed && !isActive"
                class="absolute left-full ml-2 px-2 py-1 bg-gray-900 text-white text-sm rounded-md opacity-0 group-hover:opacity-100 transition-opacity duration-200 whitespace-nowrap z-50 hidden lg:block dark:bg-neutral-800 dark:text-neutral-100"
                x-cloak>
                Créer
            </div>
        </a>



        <a href="{{ route('scanner') }}"
            class="flex items-center px-3 py-3 rounded-xl transition-all duration-200 group relative"
            :class="[
                sidebarCollapsed ? 'lg:justify-center lg:h-10 lg:hover:bg-transparent' : 'lg:space-x-3',
                isActive ?
                'bg-amber-50 text-amber-700 dark:border border-amber-600 dark:bg-neutral-800 dark:text-neutral-100 dark:border-neutral-700' :
                'text-gray-700 hover:bg-amber-50 hover:text-amber-700 dark:text-neutral-300 dark:hover:bg-neutral-800 dark:hover:text-neutral-100'
            ]"
            x-data="{
                isActive: {{ request()->routeIs('scanner') ? 'true' : 'false' }}
            }">

            <div class="w-8 h-8 rounded-lg flex items-center justify-center transition-colors flex-shrink-0"
                :class="[
                    // Contexte actif standard
                    isActive ?
                        'bg-amber-200 dark:bg-neutral-800' :
                        'bg-amber-100 group-hover:bg-amber-200 dark:bg-neutral-800 dark:ring-1 dark:ring-neutral-700 dark:group-hover:bg-neutral-700',
                    // NOUVEAU: Indicateur actif en mode réduit (anneau autour de l'icône)
                    sidebarCollapsed && isActive ? 'lg:ring-2 lg:ring-amber-600/70 lg:bg-amber-200/50' : ''
                ]">
                <svg class="w-4 h-4 transition-colors group-hover:text-amber-700 dark:group-hover:text-amber-300"
                    :class="isActive ? 'text-amber-700 dark:text-amber-400' : 'text-amber-600 dark:text-amber-300'"
                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z">
                    </path>
                </svg>
            </div>

            <span class="font-medium whitespace-nowrap transition-all duration-300 ml-3 lg:ml-0"
                :class="sidebarCollapsed ? 'lg:hidden' : ''">
                Scanner
            </span>

            <div x-show="sidebarCollapsed && !isActive"
                class="absolute left-full ml-2 px-2 py-1 bg-gray-900 text-white text-sm rounded-md opacity-0 group-hover:opacity-100 transition-opacity duration-200 whitespace-nowrap z-50 hidden lg:block dark:bg-neutral-800 dark:text-neutral-100"
                x-cloak>
                Scanner
            </div>
        </a>

        <a href="{{ route('organizer.events.history') }}"
            class="flex items-center px-3 py-3 rounded-xl transition-all duration-200 group relative"
            :class="[
                sidebarCollapsed ? 'lg:justify-center lg:h-10 lg:hover:bg-transparent' : 'lg:space-x-3',
                isActive ?
                'bg-purple-50 text-purple-700 dark:border border-purple-600 dark:bg-neutral-800 dark:text-neutral-100 dark:border-neutral-700' :
                'text-gray-700 hover:bg-purple-50 hover:text-purple-700 dark:text-neutral-300 dark:hover:bg-neutral-800 dark:hover:text-neutral-100'
            ]"
            x-data="{
                isActive: {{ request()->routeIs('organizer.*') ? 'true' : 'false' }}
            }">

            <div class="w-8 h-8 rounded-lg flex items-center justify-center transition-colors flex-shrink-0"
                :class="[
                    isActive ?
                        'bg-purple-200 dark:bg-neutral-800' :
                        'bg-purple-100 group-hover:bg-purple-200 dark:bg-neutral-800 dark:ring-1 dark:ring-neutral-700 dark:group-hover:bg-neutral-700',
                    sidebarCollapsed && isActive ? 'lg:ring-2 lg:ring-purple-600/70 lg:bg-purple-200/50' : ''
                ]">
                <svg class="w-4 h-4 transition-colors group-hover:text-purple-700 dark:group-hover:text-purple-300"
                    :class="isActive ? 'text-purple-700 dark:text-purple-400' : 'text-purple-600 dark:text-purple-300'"
                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                    </path>
                </svg>
            </div>

            <span class="font-medium whitespace-nowrap transition-all duration-300 ml-3 lg:ml-0"
                :class="sidebarCollapsed ? 'lg:hidden' : ''">
                Historique
            </span>

            <div x-show="sidebarCollapsed && !isActive"
                class="absolute left-full ml-2 px-2 py-1 bg-gray-900 text-white text-sm rounded-md opacity-0 group-hover:opacity-100 transition-opacity duration-200 whitespace-nowrap z-50 hidden lg:block dark:bg-neutral-800 dark:text-neutral-100"
                x-cloak>
                Historique
            </div>
        </a>
    @endif

    @if (auth()->user()->isStudent())
        <a href="{{ route('participant.history') }}"
            class="flex items-center px-3 py-3 rounded-xl transition-all duration-200 group relative"
            :class="[
                sidebarCollapsed ? 'lg:justify-center lg:h-10 lg:hover:bg-transparent' : 'lg:space-x-3',
                isActive ?
                'bg-cyan-50 text-cyan-700 dark:border border-cyan-600 dark:bg-neutral-800 dark:text-neutral-100 dark:border-neutral-700' :
                'text-gray-700 hover:bg-cyan-50 hover:text-cyan-700 dark:text-neutral-300 dark:hover:bg-neutral-800 dark:hover:text-neutral-100'
            ]"
            x-data="{
                isActive: {{ request()->routeIs('participant.*') ? 'true' : 'false' }}
            }">

            <div class="w-8 h-8 rounded-lg flex items-center justify-center transition-colors flex-shrink-0"
                :class="[
                    isActive ?
                        'bg-cyan-200 dark:bg-neutral-800' :
                        'bg-cyan-100 group-hover:bg-cyan-200 dark:bg-neutral-800 dark:ring-1 dark:ring-neutral-700 dark:group-hover:bg-neutral-700',
                    sidebarCollapsed && isActive ? 'lg:ring-2 lg:ring-cyan-600/70 lg:bg-cyan-200/50' : ''
                ]">
                <svg class="w-4 h-4 transition-colors group-hover:text-cyan-700 dark:group-hover:text-cyan-300"
                    :class="isActive ? 'text-cyan-700 dark:text-cyan-400' : 'text-cyan-600 dark:text-cyan-300'"
                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z">
                    </path>
                </svg>
            </div>

            <span class="font-medium whitespace-nowrap transition-all duration-300 ml-3 lg:ml-0"
                :class="sidebarCollapsed ? 'lg:hidden' : ''">
                Historique
            </span>

            <div x-show="sidebarCollapsed && !isActive"
                class="absolute left-full ml-2 px-2 py-1 bg-gray-900 text-white text-sm rounded-md opacity-0 group-hover:opacity-100 transition-opacity duration-200 whitespace-nowrap z-50 hidden lg:block dark:bg-neutral-800 dark:text-neutral-100"
                x-cloak>
                Historique
            </div>
        </a>
    @endif

    @if (auth()->user()->isAdmin())

        <div class="pt-4 border-t border-gray-200 mt-4 dark:border-neutral-800">
            <p class="px-3  font-semibold  uppercase tracking-wider mb-2  duration-300"
                :class="sidebarCollapsed ? 'lg:hidden' : ''">
                Administration
            </p>

            <a href="{{ route('admin.users.index') }}"
                class="flex items-center px-3 py-3 rounded-xl transition-all duration-200 group relative"
                :class="[
                    sidebarCollapsed ? 'lg:justify-center lg:h-10 lg:hover:bg-transparent' : 'lg:space-x-3',
                    isActive ?
                    'bg-purple-50 text-purple-700 dark:border border-purple-600 dark:bg-neutral-800 dark:text-neutral-100 dark:border-neutral-700' :
                    'text-gray-700 hover:bg-purple-50 hover:text-purple-700 dark:text-neutral-300 dark:hover:bg-neutral-800 dark:hover:text-neutral-100'
                ]"
                x-data="{
                    isActive: {{ request()->routeIs('admin.*') ? 'true' : 'false' }}
                }">

                <div class="w-8 h-8 rounded-lg flex items-center justify-center transition-colors flex-shrink-0"
                    :class="[
                        // Contexte actif standard
                        isActive ?
                            'bg-purple-200 dark:bg-neutral-800' :
                            'bg-purple-100 group-hover:bg-purple-200 dark:bg-neutral-800 dark:ring-1 dark:ring-neutral-700 dark:group-hover:bg-neutral-700',
                        // NOUVEAU: Indicateur actif en mode réduit (anneau autour de l'icône)
                        sidebarCollapsed && isActive ? 'lg:ring-2 lg:ring-purple-600/70 lg:bg-purple-200/50' : ''
                    ]">
                    <svg class="w-4 h-4 transition-colors group-hover:text-purple-700 dark:group-hover:text-purple-300"
                        :class="isActive ? 'text-purple-700 dark:text-purple-400' : 'text-purple-600 dark:text-purple-300'"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0111-3.5M13 7a4 4 0 11-8 0 4 4 0 018 0zm6 2a4 4 0 100 8 4 4 0 000-8z">
                        </path>
                    </svg>
                </div>

                <span class="font-medium whitespace-nowrap transition-all duration-300 ml-3 lg:ml-0"
                    :class="sidebarCollapsed ? 'lg:hidden' : ''">
                    Utilisateurs
                </span>

                <div x-show="sidebarCollapsed && !isActive"
                    class="absolute left-full ml-2 px-2 py-1 bg-gray-900 text-white text-sm rounded-md opacity-0 group-hover:opacity-100 transition-opacity duration-200 whitespace-nowrap z-50 hidden lg:block"
                    x-cloak>
                    Gestion des utilisateurs
                </div>
            </a>
        </div>
    @endif
@endauth
