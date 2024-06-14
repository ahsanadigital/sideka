<?php

namespace App\Services\MediaLibrary;

use Illuminate\Support\Facades\Config;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\MediaLibrary\Support\PathGenerator\PathGenerator;

/**
 * Class Md5PathGenerator
 *
 * Path generator for Laravel MediaLibrary that generates paths based on the MD5 hash of the media ID.
 */
class Md5PathGenerator implements PathGenerator
{
    /**
     * Get the path for the given media, relative to the root storage path.
     *
     * @param Media $media The media instance.
     * @return string The generated path.
     */
    public function getPath(Media $media): string
    {
        return $this->generatePath($media->getAttribute('id')) . '/';
    }

    /**
     * Get the path for conversions of the given media, relative to the root storage path.
     *
     * @param Media $media The media instance.
     * @return string The generated path.
     */
    public function getPathForConversions(Media $media): string
    {
        return $this->generatePath($media->getAttribute('id')) . '/conversions/';
    }

    /**
     * Get the path for responsive images of the given media, relative to the root storage path.
     *
     * @param Media $media The media instance.
     * @return string The generated path.
     */
    public function getPathForResponsiveImages(Media $media): string
    {
        return $this->generatePath($media->getAttribute('id')) . '/responsive/';
    }

    /**
     * Generate the path based on MD5 hash of the media ID.
     *
     * @param int $id The ID of the media.
     * @return string The generated path.
     */
    protected function generatePath(int $id): string
    {
        // Generate MD5 hash from the id
        $hash = md5($id . config('app.key'));

        return "media-libraries/{$hash}";
    }
}
