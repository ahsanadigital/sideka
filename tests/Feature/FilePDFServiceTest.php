<?php

namespace Tests\Unit\Services;

use App\Services\FilePDFService;
use Exception;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class FilePDFServiceTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        // Set up the storage disk for testing
        Storage::fake();
    }

    protected function tearDown(): void
    {
        parent::tearDown();
    }

    /** @test */
    public function it_can_compress_a_pdf_file()
    {
        // Arrange
        $filePath = 'test-file.pdf';
        $destinationPath = 'compressed';
        $content = 'Dummy PDF content';

        Storage::disk()->put($filePath, $content);

        $filePDFService = new FilePDFService();

        // Act
        $compressedFilePath = $filePDFService->compressPDF($filePath, $destinationPath);

        // Assert
        Storage::disk()->assertExists($compressedFilePath);
        $this->assertStringStartsWith($destinationPath . '/', $compressedFilePath);
    }

    /** @test */
    public function it_throws_exception_when_file_not_found()
    {
        // Arrange
        $filePath = 'non-existent-file.pdf';
        $destinationPath = 'compressed';

        $filePDFService = new FilePDFService();

        // Assert
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('File PDF tidak ditemukan.');

        // Act
        $filePDFService->compressPDF($filePath, $destinationPath);
    }

    /** @test */
    public function it_throws_exception_when_zlib_extension_not_loaded()
    {
        if (!extension_loaded('zlib')) {
            $this->expectException(Exception::class);
            $this->expectExceptionMessage('The "zlib" extension is not loaded.');

            throw new Exception('The "zlib" extension is not loaded.');
        }

        $this->assertTrue(true);
    }

    /** @test */
    public function it_can_delete_original_file_after_compression()
    {
        // Arrange
        $filePath = 'test-file.pdf';
        $destinationPath = 'compressed';
        $content = 'Dummy PDF content';

        Storage::disk()->put($filePath, $content);

        $filePDFService = new FilePDFService();

        // Act
        $compressedFilePath = $filePDFService->compressPDF($filePath, $destinationPath, 9, true);

        // Assert
        Storage::disk()->assertMissing($filePath);
        Storage::disk()->assertExists($compressedFilePath);
        $this->assertStringStartsWith($destinationPath . '/', $compressedFilePath);
    }
}
