<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EventStory extends Model
{
    use HasFactory, HasUuids;

    public $incrementing = false;
    protected $keyType = 'string';

    // Video type constants
    const TYPE_UPLOAD = 'upload';
    const TYPE_URL = 'url';

    // Platform constants
    const PLATFORM_YOUTUBE = 'youtube';
    const PLATFORM_TIKTOK = 'tiktok';
    const PLATFORM_INSTAGRAM = 'instagram';

    protected $fillable = [
        'event_id',
        'video_type',
        'video_path',
        'external_url',
        'platform',
        'thumbnail_path',
        'duration',
        'order',
        'is_active',
        'views_count',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'duration' => 'integer',
        'order' => 'integer',
        'views_count' => 'integer',
    ];

    /**
     * Get the event that owns the story
     */
    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    /**
     * Scope to get only active stories
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope to order by display order
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('order');
    }

    /**
     * Increment view count
     */
    public function incrementViews(): void
    {
        $this->increment('views_count');
    }

    /**
     * Check if story is external URL
     */
    public function isExternal(): bool
    {
        return $this->video_type === self::TYPE_URL;
    }

    /**
     * Get the full URL for the video
     */
    public function getVideoUrlAttribute(): string
    {
        if ($this->isExternal()) {
            return $this->getEmbedUrlAttribute();
        }
        
        return asset('storage/' . $this->video_path);
    }

    /**
     * Get the full URL for the thumbnail
     */
    public function getThumbnailUrlAttribute(): ?string
    {
        return $this->thumbnail_path ? asset('storage/' . $this->thumbnail_path) : null;
    }

    /**
     * Get embed URL based on platform
     */
    public function getEmbedUrlAttribute(): ?string
    {
        if (!$this->isExternal() || !$this->external_url) {
            return null;
        }

        return match($this->platform) {
            self::PLATFORM_YOUTUBE => $this->getYouTubeEmbedUrl(),
            self::PLATFORM_TIKTOK => $this->getTikTokEmbedUrl(),
            self::PLATFORM_INSTAGRAM => $this->getInstagramEmbedUrl(),
            default => $this->external_url,
        };
    }

    /**
     * Generate YouTube embed URL
     */
    protected function getYouTubeEmbedUrl(): string
    {
        $videoId = $this->extractYouTubeId($this->external_url);
        return "https://www.youtube.com/embed/{$videoId}?autoplay=1&mute=0&controls=1&rel=0&modestbranding=1&playsinline=1";
    }

    /**
     * Generate TikTok embed URL
     */
    protected function getTikTokEmbedUrl(): string
    {
        $videoId = $this->extractTikTokId($this->external_url);
        return "https://www.tiktok.com/embed/v2/{$videoId}?autoplay=1";
    }

    /**
     * Generate Instagram embed URL
     */
    protected function getInstagramEmbedUrl(): string
    {
        // Instagram embeds are tricky, using direct URL for now
        // For proper embed, would need oEmbed API
        return $this->external_url . 'embed/';
    }

    /**
     * Extract YouTube video ID from URL
     */
    protected function extractYouTubeId(string $url): ?string
    {
        // Use the helper function if available, otherwise parse manually
        if (function_exists('extractYouTubeId')) {
            return extractYouTubeId($url);
        }

        // Fallback parsing
        preg_match('/(?:youtube\.com\/watch\?v=|youtu\.be\/)([^&\?\/]+)/', $url, $matches);
        return $matches[1] ?? null;
    }

    /**
     * Extract TikTok video ID from URL
     */
    protected function extractTikTokId(string $url): ?string
    {
        preg_match('/tiktok\.com\/@[^\/]+\/video\/(\d+)/', $url, $matches);
        return $matches[1] ?? null;
    }

    /**
     * Extract Instagram post ID from URL
     */
    protected function extractInstagramId(string $url): ?string
    {
        preg_match('/instagram\.com\/(?:p|reel)\/([^\/\?]+)/', $url, $matches);
        return $matches[1] ?? null;
    }

    /**
     * Detect platform from URL
     */
    public static function detectPlatform(string $url): ?string
    {
        if (str_contains($url, 'youtube.com') || str_contains($url, 'youtu.be')) {
            return self::PLATFORM_YOUTUBE;
        }
        
        if (str_contains($url, 'tiktok.com')) {
            return self::PLATFORM_TIKTOK;
        }
        
        if (str_contains($url, 'instagram.com')) {
            return self::PLATFORM_INSTAGRAM;
        }

        return null;
    }
}
