<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\EventStory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class StoryController extends Controller
{
    /**
     * Display stories for the landing page
     */
    public function index()
    {
        $stories = EventStory::with('event')
            ->active()
            ->ordered()
            ->get()
            ->groupBy('event_id');

        return view('stories.index', compact('stories'));
    }

    /**
     * Store a newly created story
     */
    public function store(Request $request, Event $event)
    {
        $this->authorize('update', $event);

        // Check if it's URL mode or upload mode
        if ($request->filled('external_url')) {
            // URL Mode - YouTube, TikTok, Instagram
            $validated = $request->validate([
                'external_url' => ['required', 'url'],
                'order' => ['nullable', 'integer', 'min:0'],
                'is_active' => ['nullable', 'boolean'],
            ]);

            // Detect platform
            $platform = EventStory::detectPlatform($validated['external_url']);
            
            if (!$platform) {
                return redirect()->back()->withErrors(['external_url' => 'Plateforme non supportée. Utilisez YouTube, TikTok ou Instagram.']);
            }

            // Create story with URL
            $story = $event->stories()->create([
                'video_type' => EventStory::TYPE_URL,
                'external_url' => $validated['external_url'],
                'platform' => $platform,
                'video_path' => null,
                'duration' => 30, // Default duration for external videos
                'order' => $validated['order'] ?? $event->stories()->max('order') + 1,
                'is_active' => $validated['is_active'] ?? false,
            ]);

            return redirect()->back()->with('success', 'Story depuis ' . ucfirst($platform) . ' ajoutée avec succès !');
        } else {
            // Upload Mode (original)
            $validated = $request->validate([
                'video' => ['required', 'file', 'mimes:mp4,mov,webm', 'max:51200'], // 50MB max
                'order' => ['nullable', 'integer', 'min:0'],
                'is_active' => ['nullable', 'boolean'],
            ]);

            // Upload video
            $videoPath = $request->file('video')->store('stories/videos', 'public');

            // Get video duration (requires FFmpeg or getID3 library)
            $duration = $this->getVideoDuration(storage_path('app/public/' . $videoPath));

            // Create story
            $story = $event->stories()->create([
                'video_type' => EventStory::TYPE_UPLOAD,
                'video_path' => $videoPath,
                'external_url' => null,
                'platform' => null,
                'duration' => $duration,
                'order' => $validated['order'] ?? $event->stories()->max('order') + 1,
                'is_active' => $validated['is_active'] ?? false,
            ]);

            // Generate thumbnail
            $this->generateThumbnail($story);

            return redirect()->back()->with('success', 'Story uploadée avec succès !');
        }
    }

    /**
     * Update an existing story
     */
    public function update(Request $request, Event $event, EventStory $story)
    {
        $this->authorize('update', $event);

        abort_unless($story->event_id === $event->id, 404);

        $validated = $request->validate([
            'order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $story->update($validated);

        return redirect()->back()->with('success', 'Story mise à jour !');
    }

    /**
     * Remove a story
     */
    public function destroy(Event $event, EventStory $story)
    {
        $this->authorize('update', $event);

        abort_unless($story->event_id === $event->id, 404);

        // Delete files
        if ($story->video_path) {
            Storage::disk('public')->delete($story->video_path);
        }
        if ($story->thumbnail_path) {
            Storage::disk('public')->delete($story->thumbnail_path);
        }

        $story->delete();

        return redirect()->back()->with('success', 'Story supprimée !');
    }

    /**
     * Track a story view
     */
    public function track(EventStory $story)
    {
        $story->incrementViews();

        return response()->json(['success' => true, 'views' => $story->views_count]);
    }

    /**
     * Reorder stories
     */
    public function reorder(Request $request, Event $event)
    {
        $this->authorize('update', $event);

        $validated = $request->validate([
            'stories' => ['required', 'array'],
            'stories.*.id' => ['required', 'exists:event_stories,id'],
            'stories.*.order' => ['required', 'integer', 'min:0'],
        ]);

        foreach ($validated['stories'] as $storyData) {
            EventStory::where('id', $storyData['id'])
                ->where('event_id', $event->id)
                ->update(['order' => $storyData['order']]);
        }

        return response()->json(['success' => true]);
    }

    /**
     * Get video duration using FFprobe
     */
    protected function getVideoDuration(string $filePath): int
    {
        // Check if FFprobe is available
        if (!function_exists('shell_exec')) {
            return 30; // Default to 30 seconds if we can't get duration
        }

        try {
            $command = "ffprobe -v error -show_entries format=duration -of default=noprint_wrappers=1:nokey=1 " . escapeshellarg($filePath);
            $output = shell_exec($command);
            
            if ($output !== null) {
                return (int) round(floatval(trim($output)));
            }
        } catch (\Exception $e) {
            // Log error
            logger()->error('Failed to get video duration: ' . $e->getMessage());
        }

        return 30; // Default fallback
    }

    /**
     * Generate thumbnail from video
     */
    protected function generateThumbnail(EventStory $story): void
    {
        // Check if FFmpeg is available
        if (!function_exists('shell_exec')) {
            return;
        }

        try {
            $videoPath = storage_path('app/public/' . $story->video_path);
            $thumbnailDir = storage_path('app/public/stories/thumbnails');
            
            // Create thumbnails directory if it doesn't exist
            if (!file_exists($thumbnailDir)) {
                mkdir($thumbnailDir, 0755, true);
            }

            $thumbnailFilename = pathinfo($story->video_path, PATHINFO_FILENAME) . '.jpg';
            $thumbnailPath = $thumbnailDir . '/' . $thumbnailFilename;

            // Extract frame at 2 seconds
            $command = sprintf(
                'ffmpeg -i %s -ss 00:00:02 -vframes 1 -vf scale=360:640 %s 2>&1',
                escapeshellarg($videoPath),
                escapeshellarg($thumbnailPath)
            );

            shell_exec($command);

            if (file_exists($thumbnailPath)) {
                $story->update([
                    'thumbnail_path' => 'stories/thumbnails/' . $thumbnailFilename
                ]);
            }
        } catch (\Exception $e) {
            logger()->error('Failed to generate thumbnail: ' . $e->getMessage());
        }
    }
}
