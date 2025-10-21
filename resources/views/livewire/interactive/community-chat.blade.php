<div class="min-h-[70vh]">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mb-4 flex items-center justify-between">
            <a href="{{ route('interactive.events.show', ['event' => $event->slug ?? $event->id]) }}" class="inline-flex items-center gap-2 px-3 py-2 bg-white border border-gray-200 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                Retour à l'événement
            </a>
            <div class="inline-flex items-center gap-2 px-2.5 py-1 rounded-full bg-green-50 text-green-700 text-xs border border-green-200">
                <span class="inline-block w-2 h-2 rounded-full bg-green-500"></span>
                <span>Participants: <span id="online-count" class="font-semibold">0</span></span>
            </div>
        </div>

        @if($readOnly)
            <div class="mb-4 rounded-lg bg-amber-50 border border-amber-200 p-3 text-amber-800 text-sm">
                La communauté de cet événement est désormais clôturée. Merci pour votre participation !
            </div>
        @endif

        <div class="bg-white border border-gray-200 rounded-2xl overflow-hidden">
            <div class="px-4 py-3 border-b border-gray-200 flex items-center gap-3">
                <div class="w-10 h-10 rounded-full bg-indigo-100 text-indigo-700 flex items-center justify-center text-sm font-semibold">
                    {{ mb_strtoupper(mb_substr($event->title, 0, 1, 'UTF-8'), 'UTF-8') }}
                </div>
                <div>
                    <h1 class="text-base sm:text-lg font-semibold text-gray-900">{{ $event->title }}</h1>
                    <span class="text-xs text-gray-500">Communauté</span>
                </div>
            </div>

            <div id="messages" class="h-[60vh] overflow-y-auto p-5 space-y-4 bg-gray-50">
                @forelse($this->messages as $m)
                    @php $own = auth()->check() && auth()->id() === $m->user_id; @endphp
                    @if($own)
                        <div class="flex justify-end">
                            <div class="max-w-[78%] rounded-2xl px-3 py-2 text-sm bg-gradient-to-br from-indigo-600 to-indigo-500 text-white shadow">
                                <div class="flex items-center justify-between gap-2">
                                    <span class="font-semibold text-white/90">{{ optional($m->user)->name ?? 'Participant' }}</span>
                                    <span class="text-[11px] text-white/75">{{ $m->created_at?->translatedFormat('d/m H:i') }}</span>
                                </div>
                                <div class="mt-1 whitespace-pre-wrap leading-relaxed">{{ $m->message }}</div>
                            </div>
                        </div>
                    @else
                        <div class="flex items-end gap-2">
                            <div class="shrink-0 w-8 h-8 rounded-full bg-indigo-100 text-indigo-700 flex items-center justify-center text-xs font-semibold">
                                {{ mb_strtoupper(mb_substr(optional($m->user)->name ?? 'P', 0, 1, 'UTF-8'), 'UTF-8') }}
                            </div>
                            <div class="max-w-[78%] rounded-2xl px-3 py-2 text-sm bg-white ring-1 ring-gray-200 text-gray-800 shadow-sm">
                                <div class="flex items-center gap-2">
                                    <span class="font-semibold text-gray-900 text-xs">{{ optional($m->user)->name ?? 'Participant' }}</span>
                                    <span class="text-[11px] text-gray-500">{{ $m->created_at?->translatedFormat('d/m H:i') }}</span>
                                </div>
                                <div class="mt-1 whitespace-pre-wrap leading-relaxed">{{ $m->message }}</div>
                            </div>
                        </div>
                    @endif
                @empty
                    <div id="empty-state" class="text-center text-gray-500 text-sm py-10">
                        <div class="mx-auto w-12 h-12 rounded-full bg-indigo-100 text-indigo-600 flex items-center justify-center mb-3">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4-.8L3 20l.8-4A8.993 8.993 0 013 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                        </div>
                        Démarrez la conversation !
                    </div>
                @endforelse
            </div>

            <div class="px-4 pb-4">
                <div class="flex items-center gap-2 bg-white border border-gray-200 rounded-xl p-2 shadow-sm">
                    <input type="text" wire:model.defer="messageText" wire:keydown.enter.prevent="send" placeholder="Écrire un message..." class="flex-1 rounded-lg border-0 focus:ring-0 px-3 py-2 text-sm placeholder:text-gray-400" @if($readOnly) disabled @endif />
                    <button wire:click="send" class="inline-flex items-center gap-2 px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-lg hover:bg-indigo-700 disabled:opacity-50" @if($readOnly) disabled @endif>
                        <svg class="w-4 h-4" viewBox="0 0 20 20" fill="currentColor"><path d="M2.94 2.94a.75.75 0 01.82-.17l14 6a.75.75 0 010 1.38l-14 6a.75.75 0 01-1.04-.9L3.9 11H10a.75.75 0 000-1.5H3.9L2.72 3.84a.75.75 0 01.22-.9z"/></svg>
                        Envoyer
                    </button>
                </div>
                @if($readOnly)
                    <p class="mt-2 text-xs text-gray-500">Lecture seule: l'événement est terminé.</p>
                @endif
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const onlineCountEl = document.getElementById('online-count');
            try {
                if (window.Echo) {
                    window.Echo.join('event.' + {{ (int) $event->id }})
                        .here(users => { if (onlineCountEl) onlineCountEl.textContent = users.length; })
                        .joining(() => { if (onlineCountEl) onlineCountEl.textContent = Number(onlineCountEl.textContent||0)+1; })
                        .leaving(() => { if (onlineCountEl) onlineCountEl.textContent = Math.max(0, Number(onlineCountEl.textContent||0)-1); })
                        .listen('.message.sent', () => {
                            if (window.Livewire && typeof window.Livewire.dispatch === 'function') {
                                window.Livewire.dispatch('refresh-messages');
                            }
                        });
                }
            } catch (_) {}
        });
    </script>
</div>
