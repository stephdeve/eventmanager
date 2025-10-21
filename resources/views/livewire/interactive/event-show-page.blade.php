<div class="min-h-screen py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mb-6">
            <a href="{{ route('events.show', $event) }}" class="inline-flex items-center gap-2 px-3 py-2 bg-white border border-gray-200 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                Retour à l'événement
            </a>
        </div>

        <div class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden">
            <div class="px-6 pt-6">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-full bg-indigo-100 text-indigo-700 flex items-center justify-center text-base font-semibold">
                        {{ mb_strtoupper(mb_substr($event->title, 0, 1, 'UTF-8'), 'UTF-8') }}
                    </div>
                    <div>
                        <h1 class="text-xl font-semibold text-gray-900">{{ $event->title }}</h1>
                        <div class="text-xs text-gray-500">Expérience interactive</div>
                    </div>
                </div>
            </div>

            <div class="px-6 mt-6">
                @if(!$event->isInteractiveActive())
                    <div class="mb-4 rounded-lg border border-amber-200 bg-amber-50 px-4 py-3 text-amber-800 text-sm">
                        L'expérience interactive n'est pas active pour cet événement pour le moment.
                    </div>
                @elseif(!$event->interactive_public && !auth()->check())
                    <div class="mb-4 rounded-lg border border-blue-200 bg-blue-50 px-4 py-3 text-blue-800 text-sm">
                        Connectez-vous pour accéder à l'expérience interactive.
                    </div>
                @endif

                <div x-data="tabState()">
                    <div class="flex flex-wrap gap-2 border-b border-gray-200">
                        <button @click="setTab('details')" :class="tab==='details' ? 'border-indigo-600 text-indigo-700' : 'border-transparent text-gray-600 hover:text-gray-800'" class="px-4 py-2 text-sm font-medium border-b-2">Détails</button>
                        <button @click="setTab('videos')" :class="tab==='videos' ? 'border-indigo-600 text-indigo-700' : 'border-transparent text-gray-600 hover:text-gray-800'" class="px-4 py-2 text-sm font-medium border-b-2">Vidéos</button>
                        <button @click="setTab('votes')" :class="tab==='votes' ? 'border-indigo-600 text-indigo-700' : 'border-transparent text-gray-600 hover:text-gray-800'" class="px-4 py-2 text-sm font-medium border-b-2">Votes</button>
                        <button @click="setTab('community')" :class="tab==='community' ? 'border-indigo-600 text-indigo-700' : 'border-transparent text-gray-600 hover:text-gray-800'" class="px-4 py-2 text-sm font-medium border-b-2">Communauté</button>
                        <button @click="setTab('leaderboard')" :class="tab==='leaderboard' ? 'border-indigo-600 text-indigo-700' : 'border-transparent text-gray-600 hover:text-gray-800'" class="px-4 py-2 text-sm font-medium border-b-2">Classement</button>
                    </div>

                    <div class="py-6">
                        <div x-show="tab === 'details'" x-cloak>
                            <div class="prose max-w-none text-gray-700">
                                {!! nl2br(e($event->description)) !!}
                            </div>
                        </div>

                        <div x-show="tab === 'videos'" x-cloak>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                @if($event->youtube_url)
                                    <div class="aspect-video bg-black rounded-xl overflow-hidden">
                                        <iframe class="w-full h-full" src="https://www.youtube.com/embed/{{ \Illuminate\Support\Str::afterLast($event->youtube_url, 'v=') }}" title="YouTube video" frameborder="0" allowfullscreen></iframe>
                                    </div>
                                @endif
                                @if($event->tiktok_url)
                                    <div class="aspect-video bg-black rounded-xl overflow-hidden">
                                        <iframe class="w-full h-full" src="{{ $event->tiktok_url }}" title="TikTok" frameborder="0" allowfullscreen></iframe>
                                    </div>
                                @endif
                                @unless($event->youtube_url || $event->tiktok_url)
                                    <div class="text-sm text-gray-500">Aucune vidéo pour le moment.</div>
                                @endunless
                            </div>
                        </div>

                        <div x-show="tab === 'votes'" x-cloak>
                            @if($event->isInteractiveActive() && ($event->interactive_public || auth()->check()))
                                <livewire:interactive.voting-panel :event="$event" />
                            @else
                                <div class="text-sm text-gray-600">Votes indisponibles pour le moment.</div>
                            @endif
                        </div>

                        <div x-show="tab === 'community'" x-cloak>
                            <a href="{{ route('events.community', $event) }}" class="inline-flex items-center gap-2 px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-md hover:bg-indigo-700">Ouvrir la communauté</a>
                        </div>

                        <div x-show="tab === 'leaderboard'" x-cloak>
                            @if($event->isInteractiveActive())
                                <livewire:interactive.leaderboard :event="$event" />
                            @else
                                <div class="text-sm text-gray-600">Classement indisponible pour le moment.</div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

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
