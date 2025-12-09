<div x-show="sidebarOpen" x-transition:enter="transition-opacity ease-linear duration-300"
    x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
    x-transition:leave="transition-opacity ease-linear duration-300" x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0" class="fixed inset-0 flex z-50 lg:hidden" x-cloak style="display: none;">

    <div class="fixed inset-0 bg-neutral-950/50 dark:bg-black/70 backdrop-blur-sm" @click="sidebarOpen = false"></div>

    <div class="relative flex-1 flex flex-col max-w-xs w-full bg-white dark:bg-neutral-900 dark:border-r dark:border-violet-800/50 dark:backdrop-blur-lg transform transition-transform duration-500 ease-in-out shadow-lg dark:shadow-2xl"
        :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'">

        <div
            class="flex items-center justify-between px-4 py-4 border-b border-gray-200 bg-white dark:bg-neutral-900 dark:border-neutral-800">
            <a href="{{ route('dashboard') }}" class="flex items-center space-x-2">
                <div
                    class="w-10 h-10 bg-gradient-to-br from-indigo-600 to-purple-500 rounded-lg flex items-center justify-center text-white font-bold shadow-md">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="lucide lucide-calendar-days-icon lucide-calendar-days">
                        <path d="M8 2v4" />
                        <path d="M16 2v4" />
                        <rect width="18" height="18" x="3" y="4" rx="2" />
                        <path d="M3 10h18" />
                        <path d="M8 14h.01" />
                        <path d="M12 14h.01" />
                        <path d="M16 14h.01" />
                        <path d="M8 18h.01" />
                        <path d="M12 18h.01" />
                        <path d="M16 18h.01" />
                    </svg>
                </div>
                <span
                    class="text-xl font-bold text-gray-800 dark:text-neutral-100 bg-clip-text bg-gradient-to-r from-gray-800 to-gray-600 dark:bg-none dark:text-white">
                    EventManager
                </span>
            </a>

            <button @click="sidebarOpen = false"
                class="p-2 rounded-lg hover:bg-gray-100 transition-colors dark:hover:bg-neutral-800">
                <svg class="w-6 h-6 text-gray-500 dark:text-neutral-300" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <nav class="flex-1 px-3 py-4 space-y-1 overflow-y-auto">
            @auth
                @include('layouts.sidebar-navigation')
            @endauth
        </nav>

        <div class="border-t border-gray-200 p-4 bg-gray-50 dark:bg-neutral-800/60 dark:border-neutral-800">
            <div class="flex items-center space-x-3">
                <div
                    class="w-10 h-10 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-full flex items-center justify-center text-white font-semibold shadow-sm flex-shrink-0">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-medium text-gray-900 truncate dark:text-white">{{ Auth::user()->name }}
                    </p>
                    <p class="text-xs text-gray-500 capitalize truncate dark:text-neutral-400">
                        @if (auth()->user()->isAdmin())
                            Administrateur
                        @elseif(auth()->user()->isOrganizer())
                            Organisateur
                        @else
                            Participant
                        @endif
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<aside
    class="hidden lg:flex flex-col bg-white border-r border-gray-200 fixed inset-y-0 left-0 z-40 transform transition-all duration-300 ease-in-out overflow-hidden dark:bg-neutral-900 dark:border-neutral-800"
    :class="sidebarCollapsed ? 'w-16' : 'w-64'" style="height: 100vh;">

    <div class="flex items-center justify-between px-4 py-[13.5px] border-b border-gray-200 bg-white flex-shrink-0 dark:bg-neutral-900 dark:border-neutral-800"
        :class="sidebarCollapsed ? 'px-3' : 'px-4'">

        <a href="{{ route('dashboard') }}" class="flex items-center space-x-2 transition-all duration-300"
            :class="sidebarCollapsed ? 'opacity-0 w-0 overflow-hidden' : 'opacity-100'">
            <div
                class="w-10 h-10 bg-gradient-to-br from-indigo-600 to-purple-500 rounded-xl flex items-center justify-center text-white font-bold shadow-md flex-shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="lucide lucide-calendar-days-icon lucide-calendar-days">
                    <path d="M8 2v4" />
                    <path d="M16 2v4" />
                    <rect width="18" height="18" x="3" y="4" rx="2" />
                    <path d="M3 10h18" />
                    <path d="M8 14h.01" />
                    <path d="M12 14h.01" />
                    <path d="M16 14h.01" />
                    <path d="M8 18h.01" />
                    <path d="M12 18h.01" />
                    <path d="M16 18h.01" />
                </svg>
            </div>
            <span
                class="text-xl font-bold text-gray-800 dark:text-neutral-100 whitespace-nowrap">
                EventManager
            </span>
        </a>

        <a href="{{ route('dashboard') }}"
            class="flex items-center justify-center mx-auto transition-all duration-300"
            :class="sidebarCollapsed ? 'block items-center justify-center -ml-1' : 'opacity-100 hidden'">
            <div
                class="collapsed-icon w-10 h-10 bg-gradient-to-br from-indigo-600 to-purple-500 rounded-xl flex text-center items-center justify-center text-white font-bold shadow-md flex-shrink-0 mx-auto">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="lucide lucide-calendar-days-icon lucide-calendar-days">
                    <path d="M8 2v4" />
                    <path d="M16 2v4" />
                    <rect width="18" height="18" x="3" y="4" rx="2" />
                    <path d="M3 10h18" />
                    <path d="M8 14h.01" />
                    <path d="M12 14h.01" />
                    <path d="M16 14h.01" />
                    <path d="M8 18h.01" />
                    <path d="M12 18h.01" />
                    <path d="M16 18h.01" />
                </svg>
            </div>
        </a>
    </div>

    <nav class="flex-1 px-3 py-4 space-y-1 overflow-y-auto">
        @auth
            @include('layouts.sidebar-navigation')
            {{-- NOTE: Les liens dans sidebar-navigation doivent gérer la classe 'is-active' pour afficher le bord extérieur. --}}
            {{-- Exemple de lien pour le mode réduit (w-10 h-10) : class="group is-active:ring-2 is-active:ring-indigo-500/50" --}}
        @endauth
    </nav>

    <div class="border-t border-gray-200 p-4 bg-white flex-shrink-0 dark:bg-neutral-900 dark:border-neutral-800"
        :class="sidebarCollapsed ? 'px-3' : 'px-4'">
        <div class="flex items-center space-x-3">
            <div
                class=" w-10 h-10 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-full flex items-center justify-center text-white font-semibold shadow-sm flex-shrink-0">
                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
            </div>

            <div class="flex-1 min-w-0 transition-all duration-300"
                :class="sidebarCollapsed ? 'opacity-0 w-0 overflow-hidden' : 'opacity-100'">
                <p class="text-sm font-medium text-gray-900 truncate dark:text-white">{{ Auth::user()->name }}</p>
                <p class="text-xs text-gray-500 capitalize truncate dark:text-neutral-400">
                    @if (auth()->user()->isAdmin())
                        Administrateur
                    @elseif(auth()->user()->isOrganizer())
                        Organisateur
                    @else
                        Participant
                    @endif
                </p>
            </div>
        </div>
    </div>
</aside>
