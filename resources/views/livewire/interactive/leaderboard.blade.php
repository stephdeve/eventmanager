<div x-data id="leaderboard" data-event-id="{{ $event->id }}" wire:poll.5s="refreshData">
    <h3 class="text-lg font-semibold text-gray-900 mb-3">Top 10</h3>
    <ol class="list-decimal pl-6 space-y-2">
        @forelse($top as $row)
            <li class="text-sm flex items-center justify-between">
                <span class="font-medium text-gray-800">{{ $row['name'] }} <span class="text-gray-500 text-xs">{{ $row['country'] }}</span></span>
                <span class="text-gray-900 font-semibold">{{ $row['score_total'] }}</span>
            </li>
        @empty
            <li class="text-sm text-gray-500">Aucun participant pour le moment.</li>
        @endforelse
    </ol>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const wrap = document.getElementById('leaderboard');
            if (!wrap) return;
            const eventId = Number(wrap.getAttribute('data-event-id'));
            if (!window.Echo || !eventId) return;
            try {
                window.Echo.join('event.' + eventId)
                    .listen('.vote.cast', () => {
                        if (window.Livewire && typeof window.Livewire.dispatch === 'function') {
                            window.Livewire.dispatch('refresh-leaderboard');
                        }
                    });
            } catch (_) {}
        });
    </script>
</div>
