<div wire:poll.5s.keep-alive class="space-y-6">
    @php($active = $activeChallengeId ? $event->challenges->firstWhere('id', $activeChallengeId) : null)

    <!-- Défi en cours -->
    <div class="rounded-xl border border-slate-200 bg-white p-6">
        <div class="flex items-start justify-between gap-4">
            <div class="flex items-start gap-4">
                <div class="w-12 h-12 rounded-xl bg-indigo-600 text-white flex items-center justify-center shadow">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-xl font-bold text-slate-800">
                        {{ $active ? 'Défi en cours: ' . $active->title : 'Aucun défi en cours' }}
                    </h3>
                    @if($active)
                        <div class="mt-1 text-sm text-slate-600 flex flex-wrap items-center gap-2">
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold bg-indigo-100 text-indigo-800">
                                {{ $active->type ?: 'Défi' }}
                            </span>
                            @if($active->max_points)
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-800">
                                    {{ $active->max_points }} pts max
                                </span>
                            @endif
                            @if($activeEndsAt)
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold bg-rose-100 text-rose-800">
                                    <span data-ends-at="{{ $activeEndsAt }}" class="challenge-countdown">00:00</span>
                                </span>
                            @endif
                        </div>
                        @if($active->description)
                            <p class="mt-3 text-slate-700">{{ $active->description }}</p>
                        @endif

                        <div class="mt-4 flex flex-wrap items-center gap-3">
                            @php($type = strtolower((string) $active->type))
                            @if(str_contains($type, 'quiz'))
                                <a href="{{ route('events.chat', $event) }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-indigo-600 text-white font-semibold hover:bg-indigo-700">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                                    Participer via le chat
                                </a>
                            @elseif(str_contains($type, 'vote'))
                                <a href="#votes" class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-emerald-600 text-white font-semibold hover:bg-emerald-700">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M12 5l7 7-7 7"/></svg>
                                    Voter maintenant
                                </a>
                            @else
                                <a href="{{ route('events.chat', $event) }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-slate-800 text-white font-semibold hover:bg-slate-900">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h6m-6 4h10M5 20l2-2H19a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                    Voir la communauté
                                </a>
                            @endif

                            @can('update', $event)
                                <button wire:click="stopChallenge" class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-rose-600 text-white font-semibold hover:bg-rose-700">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                    Terminer le défi
                                </button>
                            @endcan
                        </div>

                        @if(!empty($leaderboard))
                            <div class="mt-6">
                                <div class="text-sm font-semibold text-slate-700 mb-2">Classement du défi</div>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                    @foreach($leaderboard as $idx => $row)
                                        <div class="p-3 rounded-lg border border-slate-200">
                                            <div class="flex items-center justify-between">
                                                <div class="flex items-center gap-3">
                                                    <div class="w-8 h-8 flex items-center justify-center rounded-full bg-slate-100 text-slate-700 text-xs font-bold">#{{ $idx+1 }}</div>
                                                    <div class="flex items-center gap-2">
                                                        @if($row['photo_path'])
                                                            <img src="{{ Storage::url($row['photo_path']) }}" alt="{{ $row['name'] }}" class="w-8 h-8 rounded-full object-cover">
                                                        @else
                                                            <div class="w-8 h-8 rounded-full bg-slate-200"></div>
                                                        @endif
                                                        <div class="font-medium text-slate-800">{{ $row['name'] }}</div>
                                                    </div>
                                                </div>
                                                <div class="text-sm font-semibold text-slate-700">{{ $row['points'] }} pts</div>
                                            </div>
                                            <div class="mt-2">
                                                <div class="h-2 w-full bg-slate-100 rounded-full overflow-hidden">
                                                    <div class="h-2 bg-emerald-500 rounded-full" style="width: {{ $row['percent'] }}%"></div>
                                                </div>
                                                <div class="mt-1 text-xs text-slate-500 font-medium">{{ $row['percent'] }}%</div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @else
                            <div class="mt-6">
                                <div class="text-sm font-semibold text-slate-700 mb-2">Classement du défi</div>
                                <div class="p-4 rounded-lg border border-slate-200 text-slate-600 text-sm">
                                    Pas encore de votes pour ce défi. Soyez le premier à voter !
                                </div>
                            </div>
                        @endif
                    @else
                        <p class="mt-2 text-slate-600 text-sm">L’organisateur peut démarrer un défi pour lancer une animation (quiz, vote, création…).</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Liste des défis -->
    <div class="rounded-xl border border-slate-200 bg-white p-6">
        <div class="flex items-center justify-between gap-4 flex-wrap">
            <div class="flex items-center gap-3">
                <h3 class="text-lg font-bold text-slate-800">Défis disponibles</h3>
                <span class="text-sm text-slate-500">{{ $event->challenges->count() }} défi(s)</span>
            </div>
            @can('update', $event)
                <div class="flex items-center gap-2">
                    <label class="text-sm text-slate-600">Durée</label>
                    <select class="px-2 py-1 border border-slate-300 rounded-lg text-sm" wire:model.number.defer="durationMinutes">
                        <option value="1">1 min</option>
                        <option value="3">3 min</option>
                        <option value="5">5 min</option>
                        <option value="10">10 min</option>
                        <option value="15">15 min</option>
                        <option value="20">20 min</option>
                    </select>
                </div>
            @endcan
        </div>
        @if($event->challenges->count() > 0)
            <div class="mt-4 divide-y divide-slate-200">
                @foreach($event->challenges as $c)
                    <div class="py-4 flex items-start justify-between gap-4">
                        <div>
                            <div class="flex items-center gap-2">
                                <div class="font-semibold text-slate-800">{{ $c->title }}</div>
                                @if($activeChallengeId === $c->id)
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-800">Actif</span>
                                @else
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold bg-slate-100 text-slate-700">Inactif</span>
                                @endif
                            </div>
                            <div class="text-sm text-slate-600 mt-1 flex flex-wrap items-center gap-2">
                                @if($c->type)
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-indigo-50 text-indigo-700">{{ $c->type }}</span>
                                @endif
                                @if($c->max_points)
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-amber-50 text-amber-700">{{ $c->max_points }} pts</span>
                                @endif
                                @if($c->date)
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-slate-50 text-slate-700">{{ $c->date->translatedFormat('d/m/Y H:i') }}</span>
                                @endif
                            </div>
                            @if($c->description)
                                <p class="mt-2 text-sm text-slate-700">{{ \Illuminate\Support\Str::limit($c->description, 140) }}</p>
                            @endif
                        </div>
                        @can('update', $event)
                            <div class="flex items-center gap-2">
                                @if($activeChallengeId !== $c->id)
                                    <button wire:click="startChallenge({{ $c->id }})" class="inline-flex items-center gap-2 px-3 py-2 rounded-lg bg-indigo-600 text-white text-sm font-semibold hover:bg-indigo-700" @disabled(! $event->isInteractiveActive())>
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5"/></svg>
                                        Démarrer
                                    </button>
                                @else
                                    <button wire:click="stopChallenge" class="inline-flex items-center gap-2 px-3 py-2 rounded-lg bg-rose-600 text-white text-sm font-semibold hover:bg-rose-700">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                        Arrêter
                                    </button>
                                @endif
                            </div>
                        @endcan
                    </div>

                    <!-- Affichage détaché du classement pour ce défi -->
                    <div class="pt-1 pb-4">
                        <details class="group">
                            <summary class="list-none cursor-pointer inline-flex items-center gap-2 text-sm text-slate-600 hover:text-slate-800">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M4 14h16M6 18h12"/></svg>
                                Voir le classement
                                <span class="ml-2 text-xs text-slate-400 group-open:hidden">(dérouler)</span>
                                <span class="ml-2 text-xs text-slate-400 hidden group-open:inline">(replier)</span>
                            </summary>
                            <div class="mt-3">
                                <livewire:interactive.challenge-leaderboard :event="$event" :challengeId="$c->id" />
                            </div>
                        </details>
                    </div>
                @endforeach
            </div>
        @else
            <div class="empty-state">
                <div class="empty-icon">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <h4 class="empty-title text-gray-900 dark:text-white">Aucun défi créé</h4>
                <p class="empty-description">Créez des défis depuis le panneau organisateur.</p>
            </div>
        @endif
    </div>
</div>

<script>
(() => {
  function pad(n){return n<10?'0'+n:n}
  function updateAll(){
    document.querySelectorAll('.challenge-countdown').forEach(el => {
      const ends = el.getAttribute('data-ends-at');
      if(!ends){ el.textContent='00:00'; return; }
      const endsAt = new Date(ends);
      const now = new Date();
      let diff = Math.max(0, Math.floor((endsAt - now)/1000));
      const m = Math.floor(diff/60); const s = diff%60;
      el.textContent = pad(m)+':'+pad(s);
    });
  }
  updateAll();
  if (window.__challengeCountdownTimer) clearInterval(window.__challengeCountdownTimer);
  window.__challengeCountdownTimer = setInterval(updateAll, 1000);
  window.addEventListener('livewire:initialized', updateAll);
  window.addEventListener('livewire:updated', updateAll);
})();
</script>
