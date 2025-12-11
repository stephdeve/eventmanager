<?php

if (!function_exists('extractYouTubeId')) {
    /**
     * Extract YouTube video ID from various URL formats
     *
     * @param string|null $url
     * @return string|null
     */
    function extractYouTubeId(?string $url): ?string
    {
        if (empty($url)) {
            return null;
        }

        // Remove any whitespace
        $url = trim($url);

        // Try to parse the URL
        $parsedUrl = parse_url($url);
        
        if (!$parsedUrl) {
            return null;
        }

        // Handle youtu.be short links
        if (isset($parsedUrl['host']) && str_contains($parsedUrl['host'], 'youtu.be')) {
            return trim($parsedUrl['path'] ?? '', '/');
        }

        // Handle youtube.com URLs
        if (isset($parsedUrl['host']) && str_contains($parsedUrl['host'], 'youtube.com')) {
            // Parse query string
            if (isset($parsedUrl['query'])) {
                parse_str($parsedUrl['query'], $query);
                
                // Get video ID from 'v' parameter
                if (isset($query['v'])) {
                    // Remove playlist parameter if present
                    return $query['v'];
                }
            }
            
            // Handle embed URLs: /embed/VIDEO_ID
            if (isset($parsedUrl['path']) && preg_match('/\/embed\/([^\/&?]+)/', $parsedUrl['path'], $matches)) {
                return $matches[1];
            }
            
            // Handle /v/ URLs: /v/VIDEO_ID
            if (isset($parsedUrl['path']) && preg_match('/\/v\/([^\/&?]+)/', $parsedUrl['path'], $matches)) {
                return $matches[1];
            }
        }

        return null;
    }
}
