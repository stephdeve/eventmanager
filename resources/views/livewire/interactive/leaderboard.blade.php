<div x-data id="leaderboard" data-event-id="{{ $event->id }}" wire:poll.5s="refreshData" class="w-full">
    <!-- En-tête du classement -->
    <div class="flex items-center justify-between mb-6">
        <h3 class="text-xl font-semibold text-[#1E3A8A]">Classement en direct</h3>
        <div class="flex items-center gap-2 text-sm text-[#6B7280]">
            <div class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></div>
            <span>En temps réel</span>
        </div>
    </div>

    <!-- Liste du classement -->
    <div class="space-y-3">
        @forelse($top as $index => $row)
            @php
                $rank = $index + 1;
                $isTop3 = $rank <= 3;
                $rankColors = [
                    1 => 'from-yellow-400 to-yellow-500 border-yellow-200',
                    2 => 'from-gray-400 to-gray-500 border-gray-200',
                    3 => 'from-amber-600 to-amber-700 border-amber-200',
                ];
            @endphp

            <div class="flex items-center gap-4 p-4 bg-white rounded-2xl border border-gray-200 shadow-sm hover:shadow-md transition-all duration-200 hover:-translate-y-0.5">
                <!-- Numéro de rang -->
                <div class="flex-shrink-0 w-10 h-10 flex items-center justify-center">
                    @if($isTop3)
                        <div class="w-8 h-8 rounded-full bg-gradient-to-r {{ $rankColors[$rank] }} text-white flex items-center justify-center text-sm font-bold shadow-lg">
                            {{ $rank }}
                        </div>
                    @else
                        <div class="w-8 h-8 rounded-full bg-gray-100 text-gray-600 flex items-center justify-center text-sm font-semibold">
                            {{ $rank }}
                        </div>
                    @endif
                </div>

                <!-- Informations du participant -->
                <div class="flex-1 min-w-0">
                    <div class="flex items-center gap-2 mb-1">
                        <span class="font-semibold text-gray-900 text-sm truncate">{{ $row['name'] }}</span>
                        @if($row['country'])
                            <span class="inline-flex items-center gap-1 px-2 py-0.5 bg-blue-100 text-blue-700 text-xs rounded-full font-medium">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                {{ $row['country'] }}
                            </span>
                        @endif
                    </div>
                    @if($row['bio'])
                        <p class="text-xs text-gray-500 truncate">{{ $row['bio'] }}</p>
                    @endif
                </div>

                <!-- Score -->
                <div class="flex-shrink-0 text-right">
                    <div class="flex items-center gap-2">
                        <span class="text-lg font-bold text-gray-900">{{ $row['score_total'] }}</span>
                        <span class="text-xs text-gray-500 font-medium">pts</span>
                    </div>
                    <div class="text-xs text-gray-400 mt-1">Score total</div>
                </div>
            </div>
        @empty
            <!-- État vide -->
            <div class="text-center py-12">
                <div class="w-16 h-16 bg-gray-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                    </svg>
                </div>
                <h4 class="text-lg font-semibold text-gray-900 mb-2">Classement vide</h4>
                <p class="text-gray-500 text-sm">Les participants apparaîtront ici dès les premiers votes.</p>
            </div>
        @endforelse
    </div>

    <!-- Légende et informations -->
    <div class="mt-6 pt-6 border-t border-gray-200">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-xs text-gray-600">
            <div class="flex items-center gap-2">
                <div class="w-3 h-3 bg-gradient-to-r from-yellow-400 to-yellow-500 rounded-full"></div>
                <span>1ère place</span>
            </div>
            <div class="flex items-center gap-2">
                <div class="w-3 h-3 bg-gradient-to-r from-gray-400 to-gray-500 rounded-full"></div>
                <span>2ème place</span>
            </div>
            <div class="flex items-center gap-2">
                <div class="w-3 h-3 bg-gradient-to-r from-amber-600 to-amber-700 rounded-full"></div>
                <span>3ème place</span>
            </div>
        </div>

        <!-- Mise à jour automatique -->
        <div class="mt-4 flex items-center justify-center gap-2 text-xs text-gray-500">
            <svg class="w-3 h-3 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
            </svg>
            <span>Mise à jour automatique toutes les 5 secondes</span>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const wrap = document.getElementById('leaderboard');
            if (!wrap) return;
            const eventId = Number(wrap.getAttribute('data-event-id'));
            if (!window.Echo || !eventId) return;

            try {
                window.Echo.join('event.' + eventId)
                    .listen('.vote.cast', (e) => {
                        console.log('Nouveau vote reçu:', e);
                        if (window.Livewire && typeof window.Livewire.dispatch === 'function') {
                            window.Livewire.dispatch('refresh-leaderboard');
                        }
                    })
                    .error((error) => {
                        console.error('Erreur WebSocket:', error);
                    });
            } catch (error) {
                console.error('Erreur initialisation Echo:', error);
            }
        });
    </script>
</div>
