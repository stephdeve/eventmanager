{{-- Stories Grid Component - Display on Landing Page --}}
@props(['stories' => []])

@if($stories->isNotEmpty())

{{-- Include styles --}}
<link rel="stylesheet" href="{{ asset('css/stories.css') }}">

<div class="stories-section py-6">
    <div class="container mx-auto px-4">
        <h2 class="text-2xl font-bold text-slate-900 dark:text-white mb-4">📱 Stories Événements</h2>

        <div class="stories-grid">
            @foreach($stories as $eventId => $eventStories)
                @php
                    $event = $eventStories->first()->event;
                    $hasUnviewedStories = true; // TODO: Track user views
                @endphp

                <div class="story-avatar"
                     data-event-id="{{ $event->id }}"
                     onclick="openStoryViewer('{{ $event->id }}')">
                    <div class="story-ring {{ $hasUnviewedStories ? 'unviewed' : 'viewed' }}">
                        <div class="story-image">
                            @if($event->cover_image)
                                <img src="{{ asset('storage/' . $event->cover_image) }}"
                                     alt="{{ $event->title }}">
                            @else
                                <div class="story-placeholder">
                                    <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M10 2a8 8 0 100 16 8 8 0 000-16z"/>
                                    </svg>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="story-title">{{ Str::limit($event->title, 12) }}</div>

                    @if($eventStories->first()->created_at->gt(now()->subDay()))
                        <div class="story-badge">NOUVEAU</div>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
</div>

{{-- Story Viewer Modal --}}
<div id="story-viewer-modal" class="story-modal !bg-gradient-to-br from-slate-800 to-slate-600" style="display: none;">
    <div class="story-close" onclick="closeStoryViewer()">
        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
        </svg>
    </div>

    <div class="story-container ">
        {{-- Progress bars --}}
        <div class="story-progress">
            <div class="progress-bars !bg-blue-600" id="progress-bars"></div>
        </div>

        {{-- Video container --}}
        <div class="story-video-wrapper">
            <video id="story-video"
                   class="story-video"
                   playsinline
                   preload="metadata">
            </video>

            {{-- Tap zones - invisible --}}
            <div class="story-tap-zones">
                <div class="tap-zone tap-left" onclick="previousStory()"></div>
                <div class="tap-zone tap-center" onclick="togglePlayPause()"></div>
                <div class="tap-zone tap-right" onclick="nextStory()"></div>
            </div>
        </div>

        {{-- Event info overlay --}}
        <div class="story-header">
            <div class="story-event-info">
                <img id="story-event-logo" src="" alt="" class="story-event-logo">
                <span id="story-event-name"></span>
            </div>
        </div>

        <div class="story-footer">
            <div class="story-details" id="story-details">
                <div class="detail-item">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    <span id="story-date"></span>
                </div>
                <div class="detail-item">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    <span id="story-location"></span>
                </div>
            </div>

            <a id="story-cta" href="#" class="story-cta">
                Voir l'événement
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </a>
        </div>
    </div>
</div>

@php
    // Prepare stories data for JavaScript
    $jsData = $stories->map(function($eventStories, $eventId) {
        return $eventStories->map(function($story) {
            return [
                'id' => $story->id,
                'video_type' => $story->video_type,
                'video_url' => $story->video_url,
                'embed_url' => $story->embed_url,
                'duration' => $story->duration,
                'event' => [
                    'id' => $story->event->id,
                    'title' => $story->event->title,
                    'start_date' => $story->event->start_date->format('d/m/Y à H:i'),
                    'location' => $story->event->location,
                    'cover_image' => $story->event->cover_image ? asset('storage/' . $story->event->cover_image) : null,
                    'url' => route('events.show', $story->event),
                ],
            ];
        });
    });
@endphp

{{-- Include scripts --}}
<script>
    // Stories data from backend
    window.storiesData = {!! json_encode($jsData) !!};
</script>
<script src="{{ asset('js/story-viewer.js') }}"></script>
@endif
