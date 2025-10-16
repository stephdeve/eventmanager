<nav x-data="{ open: false }" class="bg-white border-b border-[#E0E7FF] shadow-sm">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex items-center">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('home') }}" class="flex items-center space-x-3 group">
                        <div class="flex items-center justify-center h-10 w-10 rounded-xl bg-gradient-to-r from-[#4F46E5] to-[#6366F1] text-white font-bold shadow-lg transition-transform group-hover:scale-105">
                            EM
                        </div>
                        <div>
                            <span class="text-xl font-bold bg-gradient-to-r from-[#1E3A8A] to-[#4F46E5] bg-clip-text text-transparent">EventManager</span>
                            <div class="text-xs text-[#6B7280] -mt-1">Plateforme événementielle</div>
                        </div>
                    </a>
                </div>

                <!-- Navigation Links -->
                @auth
                <div class="hidden lg:flex items-center space-x-1 ml-10">
                    <!-- Tableau de bord -->
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="nav-item">
                        <div class="nav-icon">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
                            </svg>
                        </div>
                        <span class="nav-text">Tableau de bord</span>
                    </x-nav-link>

                    <!-- Événements -->
                    <x-nav-link :href="route('events.index')" :active="request()->routeIs('events.*') && !request()->routeIs('events.create')" class="nav-item">
                        <div class="nav-icon">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <span class="nav-text">Mes événements</span>
                    </x-nav-link>

                    @if(auth()->user()->isOrganizer())
                    <!-- Créer un événement -->
                    <x-nav-link :href="route('events.create')" :active="request()->routeIs('events.create')" class="nav-item create-event">
                        <div class="nav-icon">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                            </svg>
                        </div>
                        <span class="nav-text">Créer un événement</span>
                    </x-nav-link>

                    <!-- Scanner -->
                    <x-nav-link :href="route('scanner')" :active="request()->routeIs('scanner')" class="nav-item">
                        <div class="nav-icon">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/>
                            </svg>
                        </div>
                        <span class="nav-text">Scanner</span>
                    </x-nav-link>
                    @endif
                </div>
                @endauth
            </div>

            <!-- User Menu & Actions -->
            <div class="flex items-center space-x-4">
                @auth
                <!-- Quick Actions (Desktop) -->
                <div class="hidden md:flex items-center space-x-3">
                    @if(auth()->user()->isOrganizer())
                    <!-- Notification Badge -->
                    <button class="relative p-2 rounded-xl text-[#6B7280] hover:text-[#4F46E5] hover:bg-[#E0E7FF] transition-all duration-200 group">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-5 5v-5zM10.24 8.56a5.97 5.97 0 01-4.66-7.4 1 1 0 00-.68-1.23A10.96 10.96 0 003.5 6.5a11 11 0 005.74 10.74 1 1 0 001.23-.68 5.97 5.97 0 01-1.23-7.98z"/>
                        </svg>
                        <span class="absolute -top-1 -right-1 w-3 h-3 bg-red-500 rounded-full border-2 border-white"></span>
                        <span class="absolute -top-1 -right-1 w-3 h-3 bg-red-500 rounded-full animate-ping"></span>
                    </button>
                    @endif
                </div>
                @endauth

                <!-- User Dropdown -->
                <div class="flex items-center">
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="user-menu-trigger">
                                <div class="flex items-center space-x-3">
                                    <!-- Avatar -->
                                    <div class="w-8 h-8 bg-gradient-to-r from-[#4F46E5] to-[#6366F1] rounded-full flex items-center justify-center text-white text-sm font-semibold shadow-md">
                                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                    </div>

                                    <!-- User Info (Desktop) -->
                                    <div class="hidden lg:block text-left">
                                        <div class="text-sm font-semibold text-[#1E3A8A]">{{ Auth::user()->name }}</div>
                                        <div class="text-xs text-[#6B7280] capitalize">{{ Auth::user()->account_type }}</div>
                                    </div>

                                    <!-- Chevron -->
                                    <svg class="w-4 h-4 text-[#6B7280] transition-transform" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                    </svg>
                                </div>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <!-- Header -->
                            <div class="px-4 py-3 border-b border-[#E0E7FF]">
                                <div class="text-sm font-semibold text-[#1E3A8A]">{{ Auth::user()->name }}</div>
                                <div class="text-xs text-[#6B7280] mt-1">{{ Auth::user()->email }}</div>
                            </div>

                            <!-- Menu Items -->
                            <div class="py-1">
                                <x-dropdown-link :href="route('profile.edit')" class="menu-item">
                                    <svg class="w-4 h-4 mr-3 text-[#6B7280]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                    Mon profil
                                </x-dropdown-link>

                                @if(auth()->user()->isAdmin())
                                <div class="border-t border-[#E0E7FF] my-2"></div>
                                <x-dropdown-link :href="route('admin.users.index')" class="menu-item admin-item">
                                    <svg class="w-4 h-4 mr-3 text-[#4F46E5]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0111-3.5M13 7a4 4 0 11-8 0 4 4 0 018 0zm6 2a4 4 0 100 8 4 4 0 000-8z"/>
                                    </svg>
                                    <span class="text-[#4F46E5] font-semibold">Gérer les utilisateurs</span>
                                </x-dropdown-link>
                                @endif

                                <!-- Authentication -->
                                <div class="border-t border-[#E0E7FF] mt-2 pt-2">
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <x-dropdown-link :href="route('logout')"
                                                onclick="event.preventDefault(); this.closest('form').submit();"
                                                class="menu-item logout-item">
                                            <svg class="w-4 h-4 mr-3 text-[#6B7280]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                            </svg>
                                            Se déconnecter
                                        </x-dropdown-link>
                                    </form>
                                </div>
                            </div>
                        </x-slot>
                    </x-dropdown>
                </div>

                <!-- Mobile menu button -->
                <div class="flex items-center lg:hidden">
                    <button @click="open = ! open" class="mobile-menu-button">
                        <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                            <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Mobile Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden lg:hidden mobile-menu">
        <div class="px-4 pt-2 pb-3 space-y-1 bg-[#F9FAFB] border-b border-[#E0E7FF]">
            <!-- Mobile Navigation Links -->
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="mobile-nav-item">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
                </svg>
                Tableau de bord
            </x-responsive-nav-link>

            <x-responsive-nav-link :href="route('events.index')" :active="request()->routeIs('events.*') && !request()->routeIs('events.create')" class="mobile-nav-item">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                Mes événements
            </x-responsive-nav-link>

            @if(auth()->user()->isOrganizer())
            <x-responsive-nav-link :href="route('events.create')" :active="request()->routeIs('events.create')" class="mobile-nav-item create-event">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                </svg>
                Créer un événement
            </x-responsive-nav-link>

            <x-responsive-nav-link :href="route('scanner')" :active="request()->routeIs('scanner')" class="mobile-nav-item">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/>
                </svg>
                Scanner
            </x-responsive-nav-link>
            @endif
        </div>

        <!-- Mobile User Menu -->
        <div class="pt-4 pb-3 border-t border-[#E0E7FF] bg-white">
            <div class="px-4">
                <div class="text-base font-semibold text-[#1E3A8A]">{{ Auth::user()->name }}</div>
                <div class="text-sm text-[#6B7280] mt-1">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')" class="mobile-nav-item">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                    Mon profil
                </x-responsive-nav-link>

                @if(auth()->user()->isAdmin())
                <x-responsive-nav-link :href="route('admin.users.index')" class="mobile-nav-item admin-item">
                    <svg class="w-5 h-5 mr-3 text-[#4F46E5]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0111-3.5M13 7a4 4 0 11-8 0 4 4 0 018 0zm6 2a4 4 0 100 8 4 4 0 000-8z"/>
                    </svg>
                    <span class="text-[#4F46E5] font-semibold">Gérer les utilisateurs</span>
                </x-responsive-nav-link>
                @endif

                <!-- Mobile Logout -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault(); this.closest('form').submit();"
                            class="mobile-nav-item logout-item">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                        </svg>
                        Se déconnecter
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>

<style>
    /* Navigation Styles */
    .nav-item {
        @apply flex items-center px-4 py-2 rounded-xl text-sm font-medium transition-all duration-200;
    }

    .nav-item:hover {
        @apply bg-[#E0E7FF] text-[#4F46E5];
        transform: translateY(-1px);
    }

    .nav-item.active {
        @apply bg-gradient-to-r from-[#4F46E5] to-[#6366F1] text-white shadow-lg;
    }

    .nav-icon {
        @apply mr-2 transition-transform duration-200;
    }

    .nav-item:hover .nav-icon {
        transform: scale(1.1);
    }

    .nav-text {
        @apply whitespace-nowrap;
    }

    /* Create Event Special Style */
    .create-event {
        @apply bg-gradient-to-r from-[#4F46E5] to-[#6366F1] text-white shadow-md;
    }

    .create-event:hover {
        @apply from-[#3730A3] to-[#4F46E5] shadow-lg;
        transform: translateY(-2px);
    }

    /* User Menu */
    .user-menu-trigger {
        @apply flex items-center px-3 py-2 rounded-xl text-sm transition-all duration-200 hover:bg-[#E0E7FF] hover:text-[#4F46E5] focus:outline-none focus:ring-2 focus:ring-[#4F46E5] focus:ring-offset-2;
    }

    .menu-item {
        @apply flex items-center px-4 py-2 text-sm text-[#6B7280] hover:text-[#4F46E5] hover:bg-[#F9FAFB] transition-colors duration-150;
    }

    .admin-item {
        @apply border-l-4 border-[#4F46E5];
    }

    .logout-item {
        @apply text-red-600 hover:text-red-700 hover:bg-red-50;
    }

    /* Mobile Styles */
    .mobile-menu-button {
        @apply inline-flex items-center justify-center p-2 rounded-xl text-[#6B7280] hover:text-[#4F46E5] hover:bg-[#E0E7FF] transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-[#4F46E5] focus:ring-offset-2;
    }

    .mobile-nav-item {
        @apply flex items-center px-3 py-3 rounded-lg text-base font-medium transition-colors duration-200;
    }

    .mobile-nav-item:hover {
        @apply bg-[#E0E7FF] text-[#4F46E5];
    }

    .mobile-nav-item.active {
        @apply bg-[#4F46E5] text-white;
    }

    /* Responsive Design */
    @media (max-width: 1024px) {
        .nav-text {
            @apply hidden;
        }

        .nav-item {
            @apply px-3;
        }
    }

    @media (max-width: 768px) {
        .mobile-menu {
            @apply shadow-lg;
        }
    }

    /* Animation for notification badge */
    @keyframes ping {
        75%, 100% {
            transform: scale(2);
            opacity: 0;
        }
    }

    .animate-ping {
        animation: ping 1s cubic-bezier(0, 0, 0.2, 1) infinite;
    }
</style>
