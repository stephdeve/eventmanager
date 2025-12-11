/**
 * Story Viewer - TikTok/Instagram Style
 * Handles story navigation, auto-progression, and interactions
 * Now supports both uploaded videos and external URLs (YouTube, TikTok, Instagram)
 */

class StoryViewer {
    constructor() {
        this.stories = window.storiesData || {};
        this.currentEventId = null;
        this.currentStoryIndex = 0;
        this.isPaused = false;
        this.progressTimer = null;
        this.video = document.getElementById('story-video');
        this.modal = document.getElementById('story-viewer-modal');

        this.init();
    }

    init() {
        // Prevent body scroll when modal is open
        this.modal.addEventListener('touchmove', (e) => {
            if (e.target === this.modal) {
                e.preventDefault();
            }
        }, { passive: false });

        // Swipe down to close
        this.setupSwipeGestures();

        // Keyboard navigation
        document.addEventListener('keydown', (e) => {
            if (!this.isModalOpen()) return;

            if (e.key === 'ArrowLeft') this.previousStory();
            else if (e.key === 'ArrowRight') this.nextStory();
            else if (e.key === 'Escape') this.close();
            else if (e.key === ' ') {
                e.preventDefault();
                this.togglePlayPause();
            }
        });

        // Video ended event
        this.video.addEventListener('ended', () => {
            this.onStoryComplete();
        });

        // Video ready to play
        this.video.addEventListener('canplay', () => {
            this.startProgress();
        });
    }

    open(eventId) {
        if (!this.stories[eventId] || this.stories[eventId].length === 0) {
            console.error('No stories for event:', eventId);
            return;
        }

        this.currentEventId = eventId;
        this.currentStoryIndex = 0;
        this.isPaused = false;

        // Show modal
        this.modal.style.display = 'flex';
        document.body.style.overflow = 'hidden';

        // Load first story
        this.loadStory();
    }

    close() {
        this.modal.style.display = 'none';
        document.body.style.overflow = '';

        // Stop video and clear progress
        this.video.pause();
        this.video.src = '';
        this.stopProgress();

        // Clear any iframes
        const wrapper = document.querySelector('.story-video-wrapper');
        const iframe = wrapper.querySelector('iframe');
        if (iframe) iframe.remove();

        this.currentEventId = null;
        this.currentStoryIndex = 0;
    }

    isModalOpen() {
        return this.modal.style.display !== 'none';
    }

    loadStory() {
        const stories = this.stories[this.currentEventId];
        if (!stories || this.currentStoryIndex >= stories.length) {
            this.moveToNextEvent();
            return;
        }

        const story = stories[this.currentStoryIndex];

        // Update progress bars
        this.updateProgressBars(stories.length, this.currentStoryIndex);

        // Check if story is external URL type or uploaded video
        if (story.video_type === 'url' && story.embed_url) {
            // Load external video via iframe
            this.loadExternalVideo(story);
        } else {
            // Load normal uploaded video
            this.loadUploadedVideo(story);
        }

        // Update event info
        this.updateUI(story);

        // Track view
        this.trackView(story.id);
    }

    loadUploadedVideo(story) {
        // Hide iframe if exists
        const wrapper = document.querySelector('.story-video-wrapper');
        const existingIframe = wrapper.querySelector('iframe');
        if (existingIframe) {
            existingIframe.remove();
        }

        // Show video element
        this.video.style.display = 'block';
        this.video.src = story.video_url;
        this.video.load();
        this.video.play().catch(e => console.error('Play failed:', e));
    }

    loadExternalVideo(story) {
        // Hide video element
        this.video.style.display = 'none';
        this.video.pause();
        this.video.src = '';

        // Create or update iframe
        const wrapper = document.querySelector('.story-video-wrapper');
        let iframe = wrapper.querySelector('iframe');

        if (!iframe) {
            iframe = document.createElement('iframe');
            iframe.className = 'story-video';
            iframe.allow = 'accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture';
            iframe.allowFullscreen = true;
            iframe.frameBorder = '0';
            wrapper.appendChild(iframe);
        }

        iframe.src = story.embed_url;

        // For external videos, start progress manually since we can't detect video events
        setTimeout(() => {
            this.startProgress();
        }, 500);
    }

    updateProgressBars(total, current) {
        const container = document.getElementById('progress-bars');
        container.innerHTML = '';

        for (let i = 0; i < total; i++) {
            const bar = document.createElement('div');
            bar.className = 'progress-bar';

            if (i < current) {
                bar.classList.add('viewed');
            } else if (i === current) {
                bar.classList.add('active');
            }

            const fill = document.createElement('div');
            fill.className = 'progress-bar-fill';
            bar.appendChild(fill);

            container.appendChild(bar);
        }
    }

    startProgress() {
        this.stopProgress();

        const stories = this.stories[this.currentEventId];
        const story = stories[this.currentStoryIndex];
        const duration = story.duration * 1000; // Convert to milliseconds

        const activebar = document.querySelector('.progress-bar.active .progress-bar-fill');
        if (activebar) {
            activebar.style.transitionDuration = `${duration}ms`;
            activebar.style.width = '100%';
        }

        // Set timer to move to next story
        this.progressTimer = setTimeout(() => {
            this.onStoryComplete();
        }, duration);
    }

    stopProgress() {
        if (this.progressTimer) {
            clearTimeout(this.progressTimer);
            this.progressTimer = null;
        }

        const activebar = document.querySelector('.progress-bar.active .progress-bar-fill');
        if (activebar) {
            activebar.style.transitionDuration = '0s';
            activebar.style.width = '0%';
        }
    }

    updateUI(story) {
        const event = story.event;

        // Event logo and name
        document.getElementById('story-event-logo').src = event.cover_image || '';
        document.getElementById('story-event-name').textContent = event.title;

        // Event details
        document.getElementById('story-date').textContent = event.start_date;
        document.getElementById('story-location').textContent = event.location || 'Lieu non défini';

        // CTA link
        document.getElementById('story-cta').href = event.url;
    }

    onStoryComplete() {
        this.stopProgress();
        this.nextStory();
    }

    nextStory() {
        const stories = this.stories[this.currentEventId];

        if (this.currentStoryIndex < stories.length - 1) {
            this.currentStoryIndex++;
            this.loadStory();
        } else {
            this.moveToNextEvent();
        }
    }

    previousStory() {
        if (this.currentStoryIndex > 0) {
            this.currentStoryIndex--;
            this.loadStory();
        } else {
            // Go to previous event
            const eventIds = Object.keys(this.stories);
            const currentIndex = eventIds.indexOf(this.currentEventId);

            if (currentIndex > 0) {
                this.currentEventId = eventIds[currentIndex - 1];
                this.currentStoryIndex = this.stories[this.currentEventId].length - 1;
                this.loadStory();
            }
        }
    }

    moveToNextEvent() {
        const eventIds = Object.keys(this.stories);
        const currentIndex = eventIds.indexOf(this.currentEventId);

        if (currentIndex < eventIds.length - 1) {
            this.currentEventId = eventIds[currentIndex + 1];
            this.currentStoryIndex = 0;
            this.loadStory();
        } else {
            // No more stories, close modal
            this.close();
        }
    }

    togglePlayPause() {
        if (this.isPaused) {
            this.video.play();
            this.startProgress();
            this.isPaused = false;
        } else {
            this.video.pause();
            this.stopProgress();
            this.isPaused = true;
        }
    }

    setupSwipeGestures() {
        let startY = 0;
        let startX = 0;
        let currentY = 0;
        let currentX = 0;
        let isSwiping = false;
        const container = document.querySelector('.story-container');

        container.addEventListener('touchstart', (e) => {
            startY = e.touches[0].clientY;
            startX = e.touches[0].clientX;
            isSwiping = true;
        }, { passive: true });

        container.addEventListener('touchmove', (e) => {
            if (!isSwiping) return;

            currentY = e.touches[0].clientY;
            currentX = e.touches[0].clientX;

            const diffY = currentY - startY;
            const diffX = Math.abs(currentX - startX);

            // If vertical swipe is dominant
            if (Math.abs(diffY) > diffX && diffY > 50) {
                container.style.transform = `translateY(${diffY}px)`;
                container.style.opacity = 1 - (diffY / 300);
            }
        }, { passive: true });

        container.addEventListener('touchend', () => {
            if (!isSwiping) return;

            const diffY = currentY - startY;
            const diffX = Math.abs(currentX - startX);

            // Swipe down to close
            if (Math.abs(diffY) > diffX && diffY > 100) {
                this.close();
            }

            // Reset
            container.style.transform = '';
            container.style.opacity = '';
            isSwiping = false;
        }, { passive: true });
    }

    async trackView(storyId) {
        try {
            const csrfToken = document.querySelector('meta[name="csrf-token"]');
            if (!csrfToken) {
                console.warn('CSRF token not found, skipping view tracking');
                return;
            }

            await fetch(`/stories/${storyId}/track`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken.content
                }
            });
        } catch (error) {
            console.error('Failed to track view:', error);
        }
    }
}

// Global functions for onclick handlers
let storyViewer;

function openStoryViewer(eventId) {
    if (!storyViewer) {
        storyViewer = new StoryViewer();
    }
    storyViewer.open(eventId);
}

function closeStoryViewer() {
    if (storyViewer) {
        storyViewer.close();
    }
}

function nextStory() {
    if (storyViewer) {
        storyViewer.nextStory();
    }
}

function previousStory() {
    if (storyViewer) {
        storyViewer.previousStory();
    }
}

function togglePlayPause() {
    if (storyViewer) {
        storyViewer.togglePlayPause();
    }
}

// Initialize when DOM is ready
document.addEventListener('DOMContentLoaded', () => {
    if (window.storiesData && Object.keys(window.storiesData).length > 0) {
        storyViewer = new StoryViewer();
    }
});
