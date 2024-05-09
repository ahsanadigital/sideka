<?php

namespace App\Services;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class ImageService
{
    /**
     * Getting image size from image path
     *
     * @param string $filePath
     * @return array
     */
    public static function getImageSize(string $filePath): array
    {
        return getimagesize($filePath);
    }

    /**
     * Convert an image to WebP format and perform compression.
     *
     * @param string $filePath
     * @param string $storePath
     * @param int $quality
     * @param int|null $width
     * @param int|null $height
     * @return string|null
     */
    public static function convertToWebP(string $filePath, string $storePath = null, int $quality = 80, int $width = null, int $height = null): ?string
    {
        $tempPath = storage_path(!is_null($storePath) ? "app/public/{$storePath}" : 'app/public/temp');
        if (!File::isDirectory($tempPath)) {
            File::makeDirectory($tempPath, 0777, true, true);
        }

        $newFilePath = $tempPath . '/' . pathinfo($filePath, PATHINFO_FILENAME) . '.webp';

        $image = imagecreatefromstring(file_get_contents($filePath));

        if ($width && $height) {
            $resizedImage = imagescale($image, $width, $height);
            imagewebp($resizedImage, $newFilePath, $quality);
        } else {
            imagewebp($image, $newFilePath, $quality);
        }

        imagedestroy($image);

        // Ubah path absolut menjadi relative URL
        $relativeUrl = str_replace(storage_path('app/public'), '', $newFilePath);
        $relativeUrl = str_replace('\\', '/', $relativeUrl);
        $relativeUrl = ltrim($relativeUrl, '/');

        return $relativeUrl;
    }

    /**
     * Convert an image to JPG format and perform compression.
     *
     * @param string $filePath
     * @param string $storePath
     * @param int $quality
     * @param int|null $width
     * @param int|null $height
     * @return string|null
     */
    public static function convertToJpg(string $filePath, string $storePath = null, int $quality = 80, int $width = null, int $height = null): ?string
    {
        $tempPath = storage_path(!is_null($storePath) ? "app/public/{$storePath}" : 'app/public/temp');
        if (!File::isDirectory($tempPath)) {
            File::makeDirectory($tempPath, 0777, true, true);
        }

        $newFilePath = $tempPath . '/' . pathinfo($filePath, PATHINFO_FILENAME) . '.jpg';

        $image = imagecreatefromstring(file_get_contents($filePath));

        if ($width && $height) {
            $resizedImage = imagescale($image, $width, $height);
            imagejpeg($resizedImage, $newFilePath, $quality);
        } else {
            imagejpeg($image, $newFilePath, $quality);
        }

        imagedestroy($image);

        // Ubah path absolut menjadi relative URL
        $relativeUrl = str_replace(storage_path('app/public'), '', $newFilePath);
        $relativeUrl = str_replace('\\', '/', $relativeUrl);
        $relativeUrl = ltrim($relativeUrl, '/');

        return $relativeUrl;
    }
}
