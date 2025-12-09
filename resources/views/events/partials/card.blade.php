<!-- Image Container -->
<div class="relative h-56 overflow-hidden">
    <img src="{{ $event->cover_image_url }}" alt="{{ $event->title }}"
        class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
    <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent"></div>

    <!-- Date Overlay -->
    @if ($event->start_date)
        <div class="absolute bottom-4 left-4">
            <div class="bg-white/95 backdrop-blur-sm rounded-xl p-3 text-center shadow-xl dark:bg-neutral-900/90">
                <div class="text-xl font-bold text-slate-900 leading-none dark:text-neutral-100">
                    {{ $event->start_date->format('d') }}
                </div>
                <div class="text-xs font-semibold text-slate-600 uppercase mt-1 dark:text-neutral-400">
                    {{ $event->start_date->format('M') }}
                </div>
            </div>
        </div>
    @endif

    <!-- Badges -->
    <div class="absolute top-4 right-4 flex flex-col space-y-2">
        @if ($seats > 0)
            <span
                class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-bold bg-green-500 text-white shadow-lg">
                {{ $seats }} places
            </span>
        @else
            <span
                class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-bold bg-red-500 text-white shadow-lg">
                Complet
            </span>
        @endif

        <span
            class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-bold {{ $isFree ? 'bg-blue-500 text-white' : 'bg-purple-500 text-white' }} shadow-lg">
            {{ $isFree ? 'Gratuit' : $event->price_for_display }}
        </span>

        @if ($isInteractive)
            @if (!empty($event->slug))
                <a href="{{ route('interactive.events.show', ['event' => $event->slug]) }}"
                    class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-bold bg-emerald-600 text-white shadow-lg hover:bg-emerald-700 transition-colors duration-200">
                    @if (method_exists($event, 'isInteractiveActive') && $event->isInteractiveActive())
                        <span class="w-2 h-2 bg-white rounded-full mr-1.5 pulse-dot"></span>
                    @endif
                    Interactif
                </a>
            @else
                <span
                    class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-bold bg-emerald-600 text-white shadow-lg">
                    Interactif
                </span>
            @endif
        @endif
    </div>
</div>

<!-- Content -->
<div class="p-6">
    <!-- Status Badge -->
    @if ($isUpcoming)
        <div
            class="inline-flex items-center px-3 py-1.5 bg-blue-50 text-blue-700 rounded-full text-xs font-semibold mb-4 border border-blue-200 dark:bg-blue-500/10 dark:text-blue-300 dark:border-blue-500/30">
            <div class="w-2 h-2 bg-blue-500 rounded-full mr-2 pulse-dot dark:bg-blue-400"></div>
            À venir
        </div>
    @endif
        @if (!$isUpcoming && $event->end_date && $event->end_date->isPast())
        <div
            class="inline-flex items-center px-3 py-1.5 bg-green-50 text-green-700 rounded-full text-xs font-semibold mb-4 border border-green-200 dark:bg-green-500/10 dark:text-green-300 dark:border-green-500/30">
            <div class="w-2 h-2 bg-green-500 rounded-full mr-2 pulse-dot dark:bg-green-400"></div>
            Terminé
        </div>
    @elseif (!$isUpcoming && $event->start_date && $event->start_date->isPast() && (!$event->end_date || $event->end_date->isFuture()))
        <div
            class="inline-flex items-center px-3 py-1.5 bg-yellow-50 text-yellow-700 rounded-full text-xs font-semibold mb-4 border border-yellow-200 dark:bg-yellow-500/10 dark:text-yellow-300 dark:border-yellow-500/30">
            <div class="w-2 h-2 bg-yellow-500 rounded-full mr-2 pulse-dot dark:bg-yellow-400"></div>
            En cours
        </div>
    @endif




    <h3
        class="font-bold text-xl text-slate-900 line-clamp-2 leading-tight group-hover:text-indigo-600 transition-colors duration-200 min-h-[2rem] mb-3 dark:text-neutral-100 dark:group-hover:text-indigo-400">
        {{ $event->title }}
    </h3>

    <!-- Meta Info -->
    <div class="space-y-3 mb-4">
        <div class="flex items-center text-slate-600 text-sm dark:text-neutral-400">
            <svg class="w-5 h-5 mr-3 text-indigo-500 flex-shrink-0" fill="none" stroke="currentColor"
                viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
            </svg>
            <span class="truncate font-medium">{{ $event->location }}</span>
        </div>

        <div class="flex items-center text-slate-600 text-sm dark:text-neutral-400">
            <svg class="w-5 h-5 mr-3 text-purple-500 flex-shrink-0" fill="none" stroke="currentColor"
                viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <span class="font-medium">
                @if ($event->start_date)
                    {{ $event->start_date->translatedFormat('d M Y, H:i') }}
                @endif
            </span>
        </div>
    </div>

    <!-- Description -->
    <p
        class="text-slate-600 text-sm p-4 bg-slate-50 rounded-xl mb-5 line-clamp-2 leading-relaxed border border-slate-100 dark:text-neutral-300 dark:bg-neutral-900/50 dark:border-neutral-800">
        {{ $description }}
    </p>

    <!-- CTA Button -->
    <div class="flex flex-col sm:flex-row gap-3">
        <a href="{{ route('events.show', $event) }}"
            class="group/btn flex-1 inline-flex items-center justify-center px-5 py-3.5 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200 text-sm">
            <span>Voir les détails</span>
            <svg class="w-4 h-4 ml-2 group-hover/btn:translate-x-1 transition-transform duration-200" fill="none"
                stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
        </a>
        @if ($isInteractive && !empty($event->slug))
            <a href="{{ route('interactive.events.show', ['event' => $event->slug]) }}?tab=votes"
                class="flex-1 inline-flex items-center justify-center px-5 py-3.5 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200 text-sm">
                <span>Expérience interactive</span>
                <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" />
                </svg>
            </a>
        @endif
    </div>
</div>
