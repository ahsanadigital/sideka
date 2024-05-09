<?php

namespace App\Services;

use Exception;
use Illuminate\Support\Facades\Storage;

/**
 * Class FilePDFService
 *
 * Service class for compressing PDF files.
 */
class FilePDFService
{
    /**
     * Compresses a PDF file.
     *
     * @param string $filePath Path to the PDF file.
     * @param string $destinationPath Destination path to save the compressed PDF file.
     * @param int $compressionLevel Compression level for the PDF file. Default is 9.
     * @param bool $deleteOriginalFile Whether to delete the original PDF file after compression. Default is false.
     * @return string|null Path to the compressed PDF file, or null if compression fails.
     * @throws Exception
     */
    public function compressPDF(string $filePath, string $destinationPath, int $compressionLevel = 9, bool $deleteOriginalFile = false): ?string
    {
        if (!Storage::exists($filePath)) {
            throw new Exception('File PDF tidak ditemukan.');
        }

        $fileContent = Storage::get($filePath);

        $fileName = pathinfo($filePath, PATHINFO_FILENAME);
        $compressedFilePath = $destinationPath . '/' . $fileName . '_compressed.pdf';

        $compressed = $this->compress($fileContent, $compressedFilePath, $compressionLevel);

        if ($compressed && $deleteOriginalFile) {
            Storage::delete($filePath);
        }

        return $compressed ? $compressedFilePath : null;
    }

    /**
     * Compresses PDF content and saves it to a file.
     *
     * @param string $content Content of the PDF file to compress.
     * @param string $filePath Path to save the compressed PDF file.
     * @param int $compressionLevel Compression level for the PDF file. Default is 9.
     * @return bool True if compression is successful, false otherwise.
     * @throws Exception
     */
    private function compress(string $content, string $filePath, int $compressionLevel = 9): bool
    {
        if (!extension_loaded('zlib')) {
            throw new Exception('Ekstensi zlib tidak tersedia. Pastikan zlib telah diaktifkan pada konfigurasi PHP Anda.');
        }

        $compressed = gzcompress($content, $compressionLevel);

        $result = Storage::put($filePath, $compressed);

        return $result;
    }
}
