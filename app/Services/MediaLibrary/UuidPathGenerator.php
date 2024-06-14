<?php

namespace App\Services\MediaLibrary;

use Illuminate\Support\Str;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\MediaLibrary\Support\PathGenerator\PathGenerator;

/**
 * Class UuidPathGenerator
 *
 * Path generator for Laravel MediaLibrary that generates paths based on UUID of the media ID.
 */
class UuidPathGenerator implements PathGenerator
{
    /**
     * Get the path for the given media, relative to the root storage path.
     *
     * @param Media $media The media instance.
     * @return string The generated path.
     */
    public function getPath(Media $media): string
    {
        return $this->generatePath('/');
    }

    /**
     * Get the path for conversions of the given media, relative to the root storage path.
     *
     * @param Media $media The media instance.
     * @return string The generated path.
     */
    public function getPathForConversions(Media $media): string
    {
        return $this->generatePath('/conversions/');
    }

    /**
     * Get the path for responsive images of the given media, relative to the root storage path.
     *
     * @param Media $media The media instance.
     * @return string The generated path.
     */
    public function getPathForResponsiveImages(Media $media): string
    {
        return $this->generatePath('/responsive/');
    }

    /**
     * Generate the path based on UUID of the media ID.
     *
     * @param int $id The ID of the media.
     * @return string The generated path.
     */
    protected function generatePath(?string $path = null): string
    {
        // Generate UUID based on the ID
        $uuid = Str::uuid();

        return "media-libraries/{$uuid}/{$path}";
    }
}
