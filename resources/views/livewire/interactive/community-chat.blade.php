<div class="min-h-screen py-8 ">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- En-tête -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold bg-gradient-to-r from-[#1E3A8A] to-[#4F46E5] bg-clip-text text-transparent mb-2">
                        {{ $event->title }}
                    </h1>
                    <p class="text-[#6B7280] text-lg">Communauté de l'événement</p>
                </div>

                <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-gradient-to-r from-green-50 to-emerald-50 text-green-700 text-sm border border-green-200 shadow-sm">
                    <span class="inline-block w-2 h-2 rounded-full bg-green-500 animate-pulse"></span>
                    <span>Participants en ligne: <span id="online-count" class="font-semibold">0</span></span>
                </div>
            </div>

            <div class="mt-4">
                <a href="{{ route('interactive.events.show', ['event' => $event->slug ?? $event->id]) }}" class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-gray-200 rounded-xl text-sm font-medium text-gray-700 hover:bg-gray-50 shadow-sm transition-all duration-200 hover:shadow-md">
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
        <div class="form-card rounded-2xl border overflow-hidden shadow-lg">
            <!-- En-tête de la carte -->
            <div class="px-6 py-4 border-b border-[#E0E7FF] bg-gradient-to-r from-[#1E3A8A] to-[#4F46E5] text-white">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-white/20 text-white flex items-center justify-center text-sm font-semibold backdrop-blur-sm">
                        {{ mb_strtoupper(mb_substr($event->title, 0, 1, 'UTF-8'), 'UTF-8') }}
                    </div>
                    <div>
                        <h2 class="text-lg font-semibold">{{ $event->title }}</h2>
                        <span class="text-sm text-white/80">Communauté de discussion</span>
                    </div>
                </div>
            </div>

            <!-- Zone des messages -->
            <div id="messages" wire:poll.2s="refreshMessages" class="h-[60vh] overflow-y-auto p-6 space-y-5 bg-gradient-to-b from-gray-50 to-white">
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
                            <div class="max-w-[85%] rounded-2xl px-4 py-3 text-sm bg-white ring-1 ring-gray-200 text-gray-800 shadow-sm">
                                <div class="flex items-center gap-2 mb-1">
                                    <span class="font-semibold text-gray-900 text-sm">{{ optional($m->user)->name ?? 'Participant' }}</span>
                                    <span class="text-xs text-gray-500">{{ $m->created_at?->translatedFormat('d/m H:i') }}</span>
                                </div>
                                <div class="whitespace-pre-wrap leading-relaxed">{{ $m->message }}</div>
                            </div>
                        </div>
                    @endif
                @empty
                    <!-- État vide -->
                    <div id="empty-state" class="text-center text-gray-500 py-16">
                        <div class="mx-auto w-16 h-16 rounded-full bg-gradient-to-br from-indigo-100 to-purple-100 text-indigo-600 flex items-center justify-center mb-4 shadow-sm">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4-.8L3 20l.8-4A8.993 8.993 0 013 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                        </div>
                        <h3 class="text-lg font-medium text-gray-700 mb-1">Démarrez la conversation !</h3>
                        <p class="text-sm text-gray-500">Soyez le premier à envoyer un message</p>
                    </div>
                @endforelse
            </div>

            <!-- Zone de saisie -->
            <div class="px-6 py-4 border-t border-[#E0E7FF] bg-white">
                <div class="flex items-center gap-3 bg-white border border-gray-200 rounded-xl p-3 shadow-sm">
                    <input
                        type="text"
                        wire:model.defer="messageText"
                        wire:keydown.enter.prevent="send"
                        placeholder="Écrire un message..."
                        class="flex-1 rounded-lg border-0 focus:ring-0 px-3 py-2 text-sm placeholder:text-gray-400 bg-transparent"
                        @if($readOnly) disabled @endif
                    />
                    <button
                        wire:click="send"
                        class="inline-flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-[#4F46E5] to-[#6366F1] text-white text-sm font-medium rounded-lg hover:from-[#4338CA] hover:to-[#5852D6] transition-all duration-200 shadow-sm hover:shadow-md disabled:opacity-50 disabled:cursor-not-allowed"
                        @if($readOnly) disabled @endif
                    >
                        <svg class="w-4 h-4" viewBox="0 0 20 20" fill="currentColor"><path d="M2.94 2.94a.75.75 0 01.82-.17l14 6a.75.75 0 010 1.38l-14 6a.75.75 0 01-1.04-.9L3.9 11H10a.75.75 0 000-1.5H3.9L2.72 3.84a.75.75 0 01.22-.9z"/></svg>
                        Envoyer
                    </button>
                </div>
                @if($readOnly)
                    <p class="mt-2 text-xs text-gray-500 text-center">Lecture seule: l'événement est terminé.</p>
                @endif
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

    /* Personnalisation de la barre de défilement */
    #messages::-webkit-scrollbar {
        width: 6px;
    }

    #messages::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }

    #messages::-webkit-scrollbar-thumb {
        background: #c5c5c5;
        border-radius: 10px;
    }

    #messages::-webkit-scrollbar-thumb:hover {
        background: #a8a8a8;
    }
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
