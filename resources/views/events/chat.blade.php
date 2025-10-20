@extends('layouts.app')

@section('title', 'Communauté - ' . $event->title)

@section('content')
<div class="min-h-[70vh]">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mb-4 flex items-center justify-between">
            <a href="{{ route('events.show', $event) }}" class="inline-flex items-center gap-2 px-3 py-2 bg-white border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                Retour à l'événement
            </a>
            <div class="text-sm text-gray-600">Participants connectés: <span id="online-count" class="font-semibold">0</span></div>
        </div>

        @if($readOnly)
            <div class="mb-4 rounded-lg bg-amber-50 border border-amber-200 p-3 text-amber-800 text-sm">
                La communauté de cet événement est désormais clôturée. Merci pour votre participation !
            </div>
        @endif

        <div class="bg-white border border-gray-200 rounded-2xl overflow-hidden">
            <div class="px-4 py-3 border-b border-gray-200 flex items-center justify-between">
                <h1 class="text-lg font-semibold text-gray-900">{{ $event->title }}</h1>
                <span class="text-xs text-gray-500">Chat en temps réel</span>
            </div>

            <div id="messages" class="h-[55vh] overflow-y-auto p-4 space-y-3 bg-gray-50">
                @forelse($messages as $m)
                    @php $own = auth()->check() && auth()->id() === $m->user_id; @endphp
                    <div class="flex {{ $own ? 'justify-end' : 'justify-start' }}">
                        <div class="max-w-[80%] rounded-lg px-3 py-2 text-sm {{ $own ? 'bg-indigo-600 text-white' : 'bg-white border border-gray-200 text-gray-800' }}">
                            <div class="flex items-center justify-between gap-3">
                                <span class="font-semibold">{{ optional($m->user)->name ?? 'Participant' }}</span>
                                <span class="text-[11px] opacity-75">{{ $m->created_at?->translatedFormat('d/m H:i') }}</span>
                            </div>
                            <div class="mt-1 whitespace-pre-wrap">{{ $m->message }}</div>
                        </div>
                    </div>
                @empty
                    <div id="empty-state" class="text-center text-gray-500 text-sm py-8">Aucun message pour le moment. Démarrez la conversation !</div>
                @endforelse
            </div>

            <div class="px-4 pb-4">
                <div id="typing" class="px-1 py-2 text-xs text-gray-500 hidden">Quelqu'un est en train d'écrire...</div>
                <div class="flex items-center gap-2">
                    <input id="chat-input" type="text" placeholder="Écrire un message..." class="flex-1 rounded-md border-gray-300 focus:ring-indigo-500 focus:border-indigo-500 px-3 py-2" @if($readOnly) disabled @endif />
                    <button id="send-btn" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-md hover:bg-indigo-700 disabled:opacity-50" @if($readOnly) disabled @endif>Envoyer</button>
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
        wrap.className = 'flex ' + (own ? 'justify-end' : 'justify-start');
        const bubble = document.createElement('div');
        bubble.className = 'max-w-[80%] rounded-lg px-3 py-2 text-sm ' + (own ? 'bg-indigo-600 text-white' : 'bg-white border border-gray-200 text-gray-800');
        bubble.innerHTML = `
            <div class="flex items-center justify-between gap-3">
                <span class="font-semibold">${payload.user?.name || 'Participant'}</span>
                <span class="text-[11px] opacity-75">${new Date(payload.created_at || Date.now()).toLocaleString()}</span>
            </div>
            <div class="mt-1 whitespace-pre-wrap"></div>
        `;
        bubble.querySelector('div.mt-1').textContent = payload.message || '';
        wrap.appendChild(bubble);
        messagesEl.appendChild(wrap);
        scrollToBottom();
    }

    if (window.Echo) {
        const presence = window.Echo.join('presence-event.' + eventId)
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
