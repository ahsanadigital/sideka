<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

/**
 * Class for handling upload, update and delete file from eloquent
 *
 * @package humma-esport
 * @since 1.0.0
 * @author cakadi190 <cakadi190@gmail.com>
 */
class FileService
{
    public function __construct()
    {}

    /**
     * Check if the file is exists
     *
     * @param string $file The path of file
     * @return boolean
     */
    public static function exists(string $file): bool
    {
        return Storage::disk('public')->exists($file);
    }

    /**
     * Removes a file from the storage.
     *
     * @param string $file The path to the file to be removed.
     * @return void
     */
    public static function remove(string $file): void
    {
        if (self::exists($file)) {
            Storage::disk('public')->delete($file);
        }
    }

    /**
     * Uploads a file to the specified upload path.
     *
     * @param Request $request The HTTP request object.
     * @param string $uploadPath The path where the file will be uploaded.
     * @return string The path where the file was uploaded.
     */
    public static function upload(Request $request, string $uploadPath = 'temp'): string
    {
        if ($request->file('image')) {
            $path = $request->file('image')->store($uploadPath, "public");
        } elseif ($request->file('document')) {
            $path = $request->file('document')->store($uploadPath, "public");
        }

        return $path;
    }

    /**
     * Downloads a file with the desired name from the specified path.
     *
     * @param string $filePath The path to the file to be downloaded.
     * @param string $desiredName The desired name for the downloaded file.
     * @return Response|BinaryFileResponse
     */
    public static function download(string $filePath, string $desiredName): BinaryFileResponse
    {
        $file = Storage::disk('public')->path($filePath);

        return response()->download($file, $desiredName);
    }

    /**
     * Replaces the file at the given file path with a new file uploaded from the request.
     *
     * @param string $filePath The path to the file to be replaced.
     * @param Request $request The HTTP request object containing the new file.
     * @param string $uploadPath The path where the new file will be uploaded.
     * @return string The path where the new file was uploaded.
     */
    public static function replace($filePath, Request $request, string $uploadPath): string
    {
        self::remove($filePath);
        return self::upload($request, $uploadPath);
    }
    /**
     * Retrieves information about a file.
     *
     * @param string $filePath The path to the file.
     * @return array|null An associative array containing file information, or null if the file does not exist.
     */
    public static function getFileInformation(string $filePath): ?array
    {
        if (self::exists($filePath)) {
            return [
                'fullpath' => $filePath,
                'fullurl' => Storage::disk('public')->url($filePath),
                'filename' => pathinfo($filePath, PATHINFO_FILENAME),
                'mimetype' => Storage::disk('public')->mimeType($filePath),
                'size' => Storage::disk('public')->size($filePath),
                'created_at' => Storage::disk('public')->lastModified($filePath),
                'modified_at' => Storage::disk('public')->lastModified($filePath),
            ];
        }

        return null;
    }
}
