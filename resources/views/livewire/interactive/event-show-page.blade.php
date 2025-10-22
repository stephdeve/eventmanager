<div class="min-h-screen py-8 ">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Navigation retour -->
        <div class="mb-8">
            <a href="{{ route('events.show', $event) }}"
               class="group inline-flex items-center gap-3 px-4 py-3 bg-white/80 backdrop-blur-sm border border-gray-200 rounded-2xl text-sm font-medium text-gray-700 hover:bg-white hover:shadow-lg transition-all duration-300 hover:-translate-x-1">
                <svg class="w-5 h-5 transform group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Retour à l'événement
            </a>
        </div>

        <!-- Carte principale -->
        <div class="form-card rounded-2xl border p-8">
            <!-- En-tête de l'événement -->
            <div class="flex items-center gap-6 mb-8">
                <div class="w-16 h-16 rounded-2xl bg-gradient-to-r from-indigo-500 to-purple-600 text-white flex items-center justify-center text-2xl font-bold shadow-lg">
                    {{ mb_strtoupper(mb_substr($event->title, 0, 1, 'UTF-8'), 'UTF-8') }}
                </div>
                <div class="flex-1">
                    <h1 class="text-3xl font-bold bg-gradient-to-r from-[#1E3A8A] to-[#4F46E5] bg-clip-text text-transparent mb-2">
                        {{ $event->title }}
                    </h1>
                    <div class="flex items-center gap-4 text-sm text-[#6B7280]">
                        <span class="flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                            </svg>
                            Expérience interactive
                        </span>
                        @if($event->isInteractiveActive())
                            <span class="flex items-center gap-2 text-green-600">
                                <div class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></div>
                                En cours
                            </span>
                        @else
                            <span class="flex items-center gap-2 text-amber-600">
                                <div class="w-2 h-2 bg-amber-500 rounded-full"></div>
                                Inactive
                            </span>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Alertes statut -->
            @if(!$event->isInteractiveActive())
                <div class="mb-6 rounded-2xl bg-amber-50 border border-amber-200 p-4">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-amber-100 rounded-xl flex items-center justify-center flex-shrink-0">
                            <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                            </svg>
                        </div>
                        <div>
                            <h4 class="font-semibold text-amber-900">Expérience inactive</h4>
                            <p class="text-amber-700 text-sm mt-1">L'expérience interactive n'est pas active pour cet événement pour le moment.</p>
                        </div>
                    </div>
                </div>
            @elseif(!$event->interactive_public && !auth()->check())
                <div class="mb-6 rounded-2xl bg-blue-50 border border-blue-200 p-4">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-blue-100 rounded-xl flex items-center justify-center flex-shrink-0">
                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                            </svg>
                        </div>
                        <div>
                            <h4 class="font-semibold text-blue-900">Connexion requise</h4>
                            <p class="text-blue-700 text-sm mt-1">Connectez-vous pour accéder à l'expérience interactive complète.</p>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Navigation par onglets -->
            <div x-data="tabState()" class="mt-8">
                <!-- Barre d'onglets -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 mb-6">
                    <div class="flex space-x-1 p-2">
                        <button @click="setTab('details')"
                                :class="tab === 'details' ? 'bg-indigo-50 text-indigo-700 border-indigo-200' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-50 border-transparent'"
                                class="flex-1 py-3 px-4 text-sm font-medium rounded-xl border transition-all duration-200">
                            <div class="flex items-center justify-center space-x-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <span>Détails</span>
                            </div>
                        </button>
                        <button @click="setTab('videos')"
                                :class="tab === 'videos' ? 'bg-indigo-50 text-indigo-700 border-indigo-200' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-50 border-transparent'"
                                class="flex-1 py-3 px-4 text-sm font-medium rounded-xl border transition-all duration-200">
                            <div class="flex items-center justify-center space-x-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                                </svg>
                                <span>Vidéos</span>
                            </div>
                        </button>
                        <button @click="setTab('votes')"
                                :class="tab === 'votes' ? 'bg-indigo-50 text-indigo-700 border-indigo-200' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-50 border-transparent'"
                                class="flex-1 py-3 px-4 text-sm font-medium rounded-xl border transition-all duration-200">
                            <div class="flex items-center justify-center space-x-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5"/>
                                </svg>
                                <span>Votes</span>
                            </div>
                        </button>
                        <button @click="setTab('community')"
                                :class="tab === 'community' ? 'bg-indigo-50 text-indigo-700 border-indigo-200' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-50 border-transparent'"
                                class="flex-1 py-3 px-4 text-sm font-medium rounded-xl border transition-all duration-200">
                            <div class="flex items-center justify-center space-x-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                </svg>
                                <span>Communauté</span>
                            </div>
                        </button>
                        <button @click="setTab('leaderboard')"
                                :class="tab === 'leaderboard' ? 'bg-indigo-50 text-indigo-700 border-indigo-200' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-50 border-transparent'"
                                class="flex-1 py-3 px-4 text-sm font-medium rounded-xl border transition-all duration-200">
                            <div class="flex items-center justify-center space-x-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                                </svg>
                                <span>Classement</span>
                            </div>
                        </button>
                    </div>
                </div>

                <!-- Contenu des onglets -->
                <div class="mt-6">
                    <!-- Détails -->
                    <div x-show="tab === 'details'" x-transition:enter="transition ease-out duration-300"
                         x-transition:enter-start="opacity-0 transform translate-y-4"
                         x-transition:enter-end="opacity-100 transform translate-y-0">
                        <div class="bg-white rounded-2xl border border-gray-200 p-6">
                            <h3 class="text-xl font-semibold text-[#1E3A8A] mb-4">À propos de l'événement</h3>
                            <div class="prose max-w-none text-gray-700 leading-relaxed">
                                {!! nl2br(e($event->description)) !!}
                            </div>
                        </div>
                    </div>

                    <!-- Vidéos -->
                    <div x-show="tab === 'videos'" x-transition:enter="transition ease-out duration-300"
                         x-transition:enter-start="opacity-0 transform translate-y-4"
                         x-transition:enter-end="opacity-100 transform translate-y-0"
                         style="display: none;">
                        <div class="bg-white rounded-2xl border border-gray-200 p-6">
                            <h3 class="text-xl font-semibold text-[#1E3A8A] mb-6">Contenu vidéo</h3>
                            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                                @if($event->youtube_url)
                                    <div class="space-y-3">
                                        <h4 class="font-semibold text-gray-900 flex items-center gap-2">
                                            <svg class="w-5 h-5 text-red-600" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M19.615 3.184c-3.604-.246-11.631-.245-15.23 0-3.897.266-4.356 2.62-4.385 8.816.029 6.185.484 8.549 4.385 8.816 3.6.245 11.626.246 15.23 0 3.897-.266 4.356-2.62 4.385-8.816-.029-6.185-.484-8.549-4.385-8.816zm-10.615 12.816v-8l8 3.993-8 4.007z"/>
                                            </svg>
                                            YouTube
                                        </h4>
                                        <div class="aspect-video bg-black rounded-xl overflow-hidden shadow-lg">
                                            <iframe class="w-full h-full"
                                                    src="https://www.youtube.com/embed/{{ \Illuminate\Support\Str::afterLast($event->youtube_url, 'v=') }}"
                                                    title="YouTube video"
                                                    frameborder="0"
                                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                                    allowfullscreen>
                                            </iframe>
                                        </div>
                                    </div>
                                @endif
                                @if($event->tiktok_url)
                                    <div class="space-y-3">
                                        <h4 class="font-semibold text-gray-900 flex items-center gap-2">
                                            <svg class="w-5 h-5 text-gray-900" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M12.525.02c1.31-.02 2.61-.01 3.91-.02.08 1.53.63 3.09 1.75 4.17 1.12 1.11 2.7 1.62 4.24 1.79v4.03c-1.44-.05-2.89-.35-4.2-.97-.57-.26-1.1-.59-1.62-.93-.01 2.92.01 5.84-.02 8.75-.08 1.4-.54 2.79-1.35 3.94-1.31 1.92-3.58 3.17-5.91 3.21-1.43.08-2.86-.31-4.08-1.03-2.02-1.19-3.44-3.37-3.65-5.71-.02-.5-.03-1-.01-1.49.18-1.9 1.12-3.72 2.58-4.96 1.66-1.44 3.98-2.13 6.15-1.72.02 1.48-.04 2.96-.04 4.44-.99-.32-2.15-.23-3.02.37-.63.41-1.11 1.04-1.36 1.75-.21.51-.15 1.07-.14 1.61.24 1.64 1.82 3.02 3.5 2.87 1.12-.01 2.19-.66 2.77-1.61.19-.33.4-.67.41-1.06.1-1.79.06-3.57.07-5.36.01-4.03-.01-8.05.02-12.07z"/>
                                            </svg>
                                            TikTok
                                        </h4>
                                        <div class="aspect-[9/16] bg-black rounded-xl overflow-hidden shadow-lg">
                                            <iframe class="w-full h-full"
                                                    src="{{ $event->tiktok_url }}"
                                                    title="TikTok"
                                                    frameborder="0"
                                                    allowfullscreen>
                                            </iframe>
                                        </div>
                                    </div>
                                @endif
                                @unless($event->youtube_url || $event->tiktok_url)
                                    <div class="col-span-2 text-center py-12">
                                        <div class="w-16 h-16 bg-gray-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
                                            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                                            </svg>
                                        </div>
                                        <h4 class="text-lg font-semibold text-gray-900 mb-2">Aucune vidéo disponible</h4>
                                        <p class="text-gray-500 text-sm">Le contenu vidéo sera bientôt ajouté.</p>
                                    </div>
                                @endunless
                            </div>
                        </div>
                    </div>

                    <!-- Votes -->
                    <div x-show="tab === 'votes'" x-transition:enter="transition ease-out duration-300"
                         x-transition:enter-start="opacity-0 transform translate-y-4"
                         x-transition:enter-end="opacity-100 transform translate-y-0"
                         style="display: block;">
                        @if($event->isInteractiveActive() && ($event->interactive_public || auth()->check()))
                            <livewire:interactive.voting-panel :event="$event" />
                        @else
                            <div class="bg-white rounded-2xl border border-gray-200 p-8 text-center">
                                {{-- <livewire:interactive.voting-panel :event="$event" /> --}}
                                <div class="w-16 h-16 bg-gray-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
                                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                                <h4 class="text-lg font-semibold text-gray-900 mb-2">Votes indisponibles</h4>
                                <p class="text-gray-500 text-sm">Les votes ne sont pas accessibles pour le moment.</p>
                            </div>
                        @endif
                    </div>

                    <!-- Communauté -->
                    <div x-show="tab === 'community'" x-transition:enter="transition ease-out duration-300"
                         x-transition:enter-start="opacity-0 transform translate-y-4"
                         x-transition:enter-end="opacity-100 transform translate-y-0"
                         style="display: none;">
                        <div class="bg-white rounded-2xl border border-gray-200 p-8 text-center">
                            <div class="w-16 h-16 bg-indigo-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
                                <svg class="w-8 h-8 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                </svg>
                            </div>
                            <h4 class="text-xl font-semibold text-gray-900 mb-4">Rejoignez la communauté</h4>
                            <p class="text-gray-600 mb-6 max-w-md mx-auto">
                                Participez aux discussions en direct, échangez avec les autres participants et vivez l'événement ensemble.
                            </p>
                            <a href="{{ route('events.community', $event) }}"
                               class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 text-white text-sm font-semibold rounded-xl hover:from-indigo-700 hover:to-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-200 shadow-sm hover:shadow-md">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                                </svg>
                                Ouvrir la communauté
                            </a>
                        </div>
                    </div>

                    <!-- Classement -->
                    <div x-show="tab === 'leaderboard'" x-transition:enter="transition ease-out duration-300"
                         x-transition:enter-start="opacity-0 transform translate-y-4"
                         x-transition:enter-end="opacity-100 transform translate-y-0"
                         style="display: none;">
                        @if($event->isInteractiveActive())
                            <livewire:interactive.leaderboard :event="$event" />
                        @else
                            <div class="bg-white rounded-2xl border border-gray-200 p-8 text-center">
                                <div class="w-16 h-16 bg-gray-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
                                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                                    </svg>
                                </div>
                                <h4 class="text-lg font-semibold text-gray-900 mb-2">Classement indisponible</h4>
                                <p class="text-gray-500 text-sm">Le classement sera disponible lorsque l'expérience interactive sera active.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .form-gradient {
        background: linear-gradient(135deg, #F9FAFB 0%, #FFFFFF 50%, #E0E7FF 100%);
    }

    .form-card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(20px);
        box-shadow:
            0 20px 40px rgba(79, 70, 229, 0.08),
            inset 0 1px 0 rgba(255, 255, 255, 0.6);
    }

    [x-cloak] {
        display: none !important;
    }
</style>
@endpush

<script>
window.tabState = function() {
    const params = new URLSearchParams(window.location.search);
    const initial = params.get('tab') || 'details';
    return {
        tab: initial,
        setTab(t) {
            this.tab = t;
            const p = new URLSearchParams(window.location.search);
            p.set('tab', t);
            const url = window.location.pathname + '?' + p.toString();
            window.history.replaceState({}, '', url);
        }
    };
}
</script>
