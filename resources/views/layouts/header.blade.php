<header class="bg-white border-b border-gray-200 sticky top-0 z-30">
    <div class="flex items-center justify-between px-4 py-2 lg:px-6">
        <!-- Left side: Mobile menu and page title -->
        <div class="flex items-center space-x-3 lg:space-x-4">
            <!-- Mobile menu button -->
            <button @click="sidebarOpen = true" class="lg:hidden p-2 rounded-lg hover:bg-gray-100 transition-colors">
                <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>

            <!-- Desktop toggle button -->
            <button @click="sidebarCollapsed = !sidebarCollapsed"
                class="hidden lg:flex p-2 rounded-lg hover:bg-gray-100 transition-colors">
                <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>

            <!-- Page Title -->
            <div class="flex flex-col">
                <h1 class="text-lg lg:text-xl font-semibold text-gray-900 leading-tight">
                    @if (isset($header))
                        {{ $header }}
                    @else
                        @yield('title', 'Tableau de bord')
                    @endif
                </h1>
                @hasSection('breadcrumb')
                    <nav class="hidden sm:flex" aria-label="Breadcrumb">
                        <ol class="flex items-center space-x-1 text-sm text-gray-500">
                            @yield('breadcrumb')
                        </ol>
                    </nav>
                @endif
            </div>
        </div>

        <!-- Right side: Actions and user menu -->
        <div class="flex items-center space-x-2 lg:space-x-4">
            <!-- Header Actions -->
            @hasSection('header-actions')
                <div class="hidden sm:flex items-center space-x-2">
                    @yield('header-actions')
                </div>
            @endif

            <!-- Notifications -->
            <button
                class="relative p-2 text-gray-500 hover:text-gray-700 transition-colors duration-200 rounded-lg hover:bg-gray-100 bg-gray-100/50">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0" />
                </svg>
                <span
                    class="absolute -top-1 -right-1 w-3 h-3 bg-red-500 rounded-full border-2 border-white shadow-sm"></span>
            </button>

            <!-- User Menu Dropdown -->
            <div class="relative" x-data="{ open: false }">
                <button @click="open = !open"
                    class="flex items-center space-x-2 lg:space-x-3 p-1 lg:p-2 rounded-xl border border-gray-200 bg-white hover:border-gray-300 hover:shadow-sm transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 min-w-0"
                    :class="{ 'border-indigo-300 bg-indigo-50': open }">
                    @if (Auth::user()->avatar_url)
                        <img src="{{ Auth::user()->avatar_url }}" alt="{{ Auth::user()->name }}"
                             class="w-8 h-8 rounded-full object-cover flex-shrink-0">
                    @else
                        <div
                            class="w-8 h-8 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-full flex items-center justify-center text-white text-sm font-semibold shadow-sm flex-shrink-0">
                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                        </div>
                    @endif
                    <div class="text-left hidden lg:block min-w-0 flex-1">
                        <div class="text-sm font-medium text-gray-900 truncate">{{ Auth::user()->name }}</div>
                        <div class="text-xs text-gray-500 capitalize truncate">
                            @if (auth()->user()->isAdmin())
                                Administrateur
                            @elseif(auth()->user()->isOrganizer())
                                Organisateur
                            @else
                                Participant
                            @endif
                        </div>
                    </div>
                    <svg class="w-4 h-4 text-gray-400 transition-transform duration-200 flex-shrink-0"
                        :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>

                <!-- Dropdown Menu -->
                <div x-show="open" x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                    x-transition:leave="transition ease-in duration-150"
                    x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
                    @click.away="open = false"
                    class="absolute right-0 mt-2 w-48 lg:w-64 bg-white rounded-xl shadow-lg border border-gray-200 py-2 z-50"
                    style="display: none;">
                    <!-- User Info -->
                    <div class="px-4 py-3 border-b border-gray-100">
                        <div class="text-sm font-medium text-gray-900 truncate">{{ Auth::user()->name }}</div>
                        <div class="text-sm text-gray-500 truncate">{{ Auth::user()->email }}</div>
                    </div>

                    <!-- Menu Items -->
                    <div class="py-2">
                        <a href="{{ route('profile.edit') }}"
                            class="flex items-center space-x-3 px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 transition-colors duration-150">
                            <div class="w-6 h-6 bg-gray-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                <svg class="w-3 h-3 text-gray-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                            </div>
                            <span>Mon profil</span>
                        </a>
                    </div>

                    <!-- Logout -->
                    <div class="border-t border-gray-100 pt-2">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                class="flex items-center space-x-3 w-full px-4 py-2 text-sm text-gray-700 hover:bg-red-50 hover:text-red-700 transition-colors duration-150">
                                <div
                                    class="w-6 h-6 bg-red-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                    <svg class="w-3 h-3 text-red-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                                        </path>
                                    </svg>
                                </div>
                                <span>Se déconnecter</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Mobile Header Actions -->
    @hasSection('header-actions')
        <div class="sm:hidden px-4 pb-3">
            <div class="flex items-center space-x-2 overflow-x-auto">
                @yield('header-actions')
            </div>
        </div>
    @endif
</header>
