@extends('layouts.app')

@section('title', 'Communauté - ' . $event->title)

@section('content')
<div class="min-h-[70vh]">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mb-4 flex items-center justify-between">
            <a href="{{ route('events.show', $event) }}" class="inline-flex items-center gap-2 px-3 py-2 bg-white border border-gray-200 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                Retour à l'événement
            </a>
        </div>

        @if($readOnly)
            <div class="mb-4 rounded-lg bg-amber-50 border border-amber-200 p-3 text-amber-800 text-sm">
                La communauté de cet événement est désormais clôturée. Merci pour votre participation !
            </div>
        @endif

        <div class="bg-white border border-gray-200 rounded-2xl overflow-hidden">
            <div class="px-4 py-3 border-b border-gray-200 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-indigo-100 text-indigo-700 flex items-center justify-center text-sm font-semibold">
                        {{ mb_strtoupper(mb_substr($event->title, 0, 1, 'UTF-8'), 'UTF-8') }}
                    </div>
                    <div>
                        <h1 class="text-base sm:text-lg font-semibold text-gray-900">{{ $event->title }}</h1>
                        <span class="text-xs text-gray-500">Chat en temps réel</span>
                    </div>
                </div>
                <div class="inline-flex items-center gap-2 px-2.5 py-1 rounded-full bg-green-50 text-green-700 text-xs border border-green-200">
                    <span class="inline-block w-2 h-2 rounded-full bg-green-500"></span>
                    <span>Participants: <span id="online-count" class="font-semibold">0</span></span>
                </div>
            </div>

            <div id="messages" class="h-[60vh] overflow-y-auto p-5 space-y-4 bg-gray-50">
                @forelse($messages as $m)
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
                <div id="typing" class="px-1 py-2 text-xs text-gray-500 hidden">Quelqu'un est en train d'écrire...</div>
                <div class="flex items-center gap-2 bg-white border border-gray-200 rounded-xl p-2 shadow-sm">
                    <input id="chat-input" type="text" placeholder="Écrire un message..." class="flex-1 rounded-lg border-0 focus:ring-0 px-3 py-2 text-sm placeholder:text-gray-400" @if($readOnly) disabled @endif />
                    <button id="send-btn" class="inline-flex items-center gap-2 px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-lg hover:bg-indigo-700 disabled:opacity-50" @if($readOnly) disabled @endif>
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
</div>
@endsection

@push('scripts')
<script>
(function(){
    const eventId = {{ (int) $event->id }};
    const userId = {{ (int) auth()->id() }};
    const userName = @json(optional(auth()->user())->name ?? 'Participant');
    const readOnly = {{ $readOnly ? 'true' : 'false' }};

    const messagesEl = document.getElementById('messages');
    const inputEl = document.getElementById('chat-input');
    const sendBtn = document.getElementById('send-btn');
    const typingEl = document.getElementById('typing');
    const onlineCountEl = document.getElementById('online-count');

    function scrollToBottom(force = false){
        // If user is near bottom, auto-scroll
        const threshold = 120;
        if (force || messagesEl.scrollHeight - messagesEl.scrollTop - messagesEl.clientHeight < threshold) {
            messagesEl.scrollTop = messagesEl.scrollHeight;
        }
    }
    scrollToBottom(true);

    function appendMessage(payload, own = false){
        const empty = document.getElementById('empty-state');
        if (empty) empty.remove();
        const wrap = document.createElement('div');
        if (own) {
            wrap.className = 'flex justify-end';
            const bubble = document.createElement('div');
            bubble.className = 'max-w-[78%] rounded-2xl px-3 py-2 text-sm bg-gradient-to-br from-indigo-600 to-indigo-500 text-white shadow';
            bubble.innerHTML = `
                <div class="flex items-center justify-between gap-2">
                    <span class="font-semibold text-white/90">${payload.user?.name || 'Participant'}</span>
                    <span class="text-[11px] text-white/75">${new Date(payload.created_at || Date.now()).toLocaleString()}</span>
                </div>
                <div class="mt-1 whitespace-pre-wrap leading-relaxed"></div>
            `;
            bubble.querySelector('div.mt-1').textContent = payload.message || '';
            wrap.appendChild(bubble);
        } else {
            wrap.className = 'flex items-end gap-2';
            const avatar = document.createElement('div');
            const name = (payload.user?.name || 'Participant').toString();
            const initial = name.trim().charAt(0).toUpperCase() || 'P';
            avatar.className = 'shrink-0 w-8 h-8 rounded-full bg-indigo-100 text-indigo-700 flex items-center justify-center text-xs font-semibold';
            avatar.textContent = initial;
            const bubble = document.createElement('div');
            bubble.className = 'max-w-[78%] rounded-2xl px-3 py-2 text-sm bg-white ring-1 ring-gray-200 text-gray-800 shadow-sm';
            bubble.innerHTML = `
                <div class="flex items-center gap-2">
                    <span class="font-semibold text-gray-900 text-xs">${name}</span>
                    <span class="text-[11px] text-gray-500">${new Date(payload.created_at || Date.now()).toLocaleString()}</span>
                </div>
                <div class="mt-1 whitespace-pre-wrap leading-relaxed"></div>
            `;
            bubble.querySelector('div.mt-1').textContent = payload.message || '';
            wrap.appendChild(avatar);
            wrap.appendChild(bubble);
        }
        messagesEl.appendChild(wrap);
        scrollToBottom();
    }

    if (window.Echo) {
        const presence = window.Echo.join('event.' + eventId)
            .here(users => { onlineCountEl.textContent = users.length; })
            .joining(user => { onlineCountEl.textContent = Number(onlineCountEl.textContent||0)+1; })
            .leaving(user => { onlineCountEl.textContent = Math.max(0, Number(onlineCountEl.textContent||0)-1); })
            .listen('.message.sent', (e) => {
                appendMessage(e, false);
            })
            .listenForWhisper('typing', (e) => {
                if (!typingEl) return;
                typingEl.textContent = `${e.name || 'Quelqu\'un'} est en train d'écrire...`;
                typingEl.classList.remove('hidden');
                clearTimeout(typingEl._t);
                typingEl._t = setTimeout(()=> typingEl.classList.add('hidden'), 1200);
            });

        // Typing whisper
        let lastWhisper = 0;
        function whisperTyping(){
            const now = Date.now();
            if (now - lastWhisper > 800) {
                presence.whisper('typing', { name: userName });
                lastWhisper = now;
            }
        }

        if (inputEl && !readOnly) {
            inputEl.addEventListener('input', whisperTyping);
        }
    }

    async function send(){
        const text = (inputEl?.value || '').trim();
        if (!text) return;
        sendBtn.disabled = true;
        try {
            const res = await fetch(@json(route('events.chat.messages', $event)), {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'X-Socket-Id': (window.Echo && typeof window.Echo.socketId === 'function') ? window.Echo.socketId() : '',
                    'Accept': 'application/json',
                },
                body: new URLSearchParams({ message: text })
            });
            const data = await res.json();
            if (res.ok && data.success) {
                appendMessage(data.message, true);
                inputEl.value = '';
            } else {
                alert(data.message || 'Envoi impossible.');
            }
        } catch (e) {
            alert('Réseau indisponible.');
        } finally {
            sendBtn.disabled = false;
            inputEl?.focus();
        }
    }

    if (sendBtn && inputEl && !readOnly) {
        sendBtn.addEventListener('click', send);
        inputEl.addEventListener('keydown', function(e){
            if (e.key === 'Enter' && !e.shiftKey) {
                e.preventDefault();
                send();
            }
        });
    }
})();
</script>
@endpush
