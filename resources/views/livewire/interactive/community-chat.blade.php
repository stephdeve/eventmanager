<div class="min-h-screen py-8 bg-[#0B1220] text-slate-200">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- En-tête -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-extrabold text-white mb-2">
                        {{ $event->title }}
                    </h1>
                    <p class="text-slate-400 text-lg">Communauté de l'événement</p>
                </div>

                <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-slate-800 text-slate-300 text-sm border border-slate-700 shadow-sm">
                    <span class="inline-block w-2 h-2 rounded-full bg-green-500 animate-pulse"></span>
                    <span>Participants en ligne: <span id="online-count" class="font-semibold">0</span></span>
                </div>
            </div>

            <div class="mt-4">
                <a href="{{ route('interactive.events.show', ['event' => $event->slug ?? $event->id]) }}" class="inline-flex items-center gap-2 px-4 py-2 bg-slate-900 border border-slate-700 rounded-xl text-sm font-medium text-slate-200 hover:bg-slate-800 shadow-sm transition-all duration-200 hover:shadow-md">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                    Retour à l'événement
                </a>
            </div>
        </div>

        @if($readOnly)
            <div class="mb-6 rounded-xl bg-gradient-to-r from-amber-50 to-yellow-50 border border-amber-200 p-4 text-amber-800 text-sm shadow-sm">
                <div class="flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                    </svg>
                    <span>La communauté de cet événement est désormais clôturée. Merci pour votre participation !</span>
                </div>
            </div>
        @endif

        <!-- Carte de chat -->
        <div class="form-card rounded-2xl border border-slate-700 overflow-hidden shadow-lg bg-slate-800">
            <!-- En-tête de la carte -->
            <div class="px-6 py-4 border-b border-slate-700 bg-slate-800 text-slate-100">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-slate-700 text-white flex items-center justify-center text-sm font-semibold">
                        {{ mb_strtoupper(mb_substr($event->title, 0, 1, 'UTF-8'), 'UTF-8') }}
                    </div>
                    <div>
                        <h2 class="text-lg font-semibold text-white">{{ $event->title }}</h2>
                        <span class="text-sm text-slate-300">Communauté de discussion</span>
                    </div>
                </div>
            </div>

            <!-- Zone des messages -->
            <div id="messages" wire:poll.2s="refreshMessages" class="h-[60vh] overflow-y-auto p-6 space-y-5 bg-gradient-to-b from-slate-900 to-slate-900">
                @forelse($this->messages as $m)
                    @php $own = auth()->check() && auth()->id() === $m->user_id; @endphp
                    @if($own)
                        <!-- Message de l'utilisateur actuel -->
                        <div class="flex justify-end">
                            <div class="max-w-[85%] rounded-2xl px-4 py-3 text-sm bg-gradient-to-br from-[#4F46E5] to-[#6366F1] text-white shadow-lg">
                                <div class="flex items-center justify-between gap-3 mb-1">
                                    <span class="font-semibold text-white/90">{{ optional($m->user)->name ?? 'Participant' }}</span>
                                    <span class="text-xs text-white/75">{{ $m->created_at?->translatedFormat('d/m H:i') }}</span>
                                </div>
                                <div class="whitespace-pre-wrap leading-relaxed">{{ $m->message }}</div>
                            </div>
                        </div>
                    @else
                        <!-- Message d'un autre utilisateur -->
                        <div class="flex items-start gap-3">
                            <div class="shrink-0 w-9 h-9 rounded-full bg-gradient-to-br from-[#4F46E5] to-[#6366F1] text-white flex items-center justify-center text-xs font-semibold shadow-sm">
                                {{ mb_strtoupper(mb_substr(optional($m->user)->name ?? 'P', 0, 1, 'UTF-8'), 'UTF-8') }}
                            </div>
                            <div class="max-w-[85%] rounded-2xl px-4 py-3 text-sm bg-slate-900 ring-1 ring-slate-700 text-slate-200 shadow-sm">
                                <div class="flex items-center gap-2 mb-1">
                                    <span class="font-semibold text-slate-100 text-sm">{{ optional($m->user)->name ?? 'Participant' }}</span>
                                    <span class="text-xs text-slate-400">{{ $m->created_at?->translatedFormat('d/m H:i') }}</span>
                                </div>
                                <div class="whitespace-pre-wrap leading-relaxed">{{ $m->message }}</div>
                            </div>
                        </div>
                    @endif
                @empty
                    <!-- État vide -->
                    <div id="empty-state" class="text-center text-slate-400 py-16">
                        <div class="mx-auto w-16 h-16 rounded-full bg-slate-800 text-slate-300 flex items-center justify-center mb-4 shadow-sm">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4-.8L3 20l.8-4A8.993 8.993 0 013 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                        </div>
                        <h3 class="text-lg font-medium text-slate-200 mb-1">Démarrez la conversation !</h3>
                        <p class="text-sm text-slate-400">Soyez le premier à envoyer un message</p>
                    </div>
                @endforelse
            </div>

            <!-- Zone de saisie -->
            <div class="px-6 py-4 border-t border-slate-700 bg-slate-800">
                <div class="flex items-center gap-3 bg-slate-900 border border-slate-700 rounded-xl p-3 shadow-sm">
                    <input
                        type="text"
                        wire:model.defer="messageText"
                        wire:keydown.enter.prevent="send"
                        placeholder="Écrire un message..."
                        class="flex-1 rounded-lg border-0 focus:ring-0 px-3 py-2 text-sm text-slate-200 placeholder:text-slate-500 bg-transparent"
                        @if($readOnly) disabled @endif
                    />
                    <button
                        wire:click="send"
                        class="inline-flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-fuchsia-600 to-violet-600 text-white text-sm font-medium rounded-lg hover:from-fuchsia-700 hover:to-violet-700 transition-all duration-200 shadow-sm hover:shadow-md disabled:opacity-50 disabled:cursor-not-allowed"
                        @if($readOnly) disabled @endif
                    >
                        <svg class="w-4 h-4" viewBox="0 0 20 20" fill="currentColor"><path d="M2.94 2.94a.75.75 0 01.82-.17l14 6a.75.75 0 010 1.38l-14 6a.75.75 0 01-1.04-.9L3.9 11H10a.75.75 0 000-1.5H3.9L2.72 3.84a.75.75 0 01.22-.9z"/></svg>
                        Envoyer
                    </button>
                </div>
                @if($readOnly)
                    <p class="mt-2 text-xs text-slate-400 text-center">Lecture seule: l'événement est terminé.</p>
                @endif
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .form-gradient { background: linear-gradient(135deg, #0B1220 0%, #0F172A 50%, #111827 100%); }
    .form-card { background: rgba(17, 24, 39, 0.95); backdrop-filter: blur(20px); box-shadow: 0 20px 40px rgba(0,0,0,0.35), inset 0 1px 0 rgba(255,255,255,0.04); }
    #messages::-webkit-scrollbar { width: 6px; }
    #messages::-webkit-scrollbar-track { background: #0f172a; border-radius: 10px; }
    #messages::-webkit-scrollbar-thumb { background: #334155; border-radius: 10px; }
    #messages::-webkit-scrollbar-thumb:hover { background: #475569; }
    
</style>
@endpush

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const onlineCountEl = document.getElementById('online-count');
        const messagesContainer = document.getElementById('messages');

        // Faire défiler vers le bas pour voir les derniers messages
        if (messagesContainer) {
            messagesContainer.scrollTop = messagesContainer.scrollHeight;
        }

        try {
            if (window.Echo) {
                window.Echo.join('event.' + {{ (int) $event->id }})
                    .here(users => {
                        if (onlineCountEl) onlineCountEl.textContent = users.length;
                    })
                    .joining(() => {
                        if (onlineCountEl) onlineCountEl.textContent = Number(onlineCountEl.textContent||0)+1;
                    })
                    .leaving(() => {
                        if (onlineCountEl) onlineCountEl.textContent = Math.max(0, Number(onlineCountEl.textContent||0)-1);
                    })
                    .listen('.message.sent', () => {
                        if (window.Livewire && typeof window.Livewire.dispatch === 'function') {
                            window.Livewire.dispatch('refresh-messages');

                            // Faire défiler vers le bas après l'ajout d'un nouveau message
                            setTimeout(() => {
                                if (messagesContainer) {
                                    messagesContainer.scrollTop = messagesContainer.scrollHeight;
                                }
                            }, 100);
                        }
                    });
            }
        } catch (_) {}

        // Mise à jour automatique du défilement lors de l'ajout de messages
        Livewire.hook('message.processed', () => {
            setTimeout(() => {
                if (messagesContainer) {
                    messagesContainer.scrollTop = messagesContainer.scrollHeight;
                }
            }, 50);
        });
    });
</script>
