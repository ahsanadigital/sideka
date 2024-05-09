<?php

namespace Tests\Unit\Services;

use App\Services\FileService;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class FileServiceTest extends TestCase
{
    /** @test */
    public function it_can_remove_a_file_from_storage()
    {
        // Arrange
        $filePath = 'test-file.txt';
        Storage::fake('public');
        Storage::disk('public')->put($filePath, 'Test file content');

        // Act
        FileService::remove($filePath);

        // Assert
        Storage::disk('public')->assertMissing($filePath);
    }

    /** @test */
    public function it_can_upload_an_image_file()
    {
        // Arrange
        Storage::fake('public');
        $uploadPath = 'images';
        $request = Request::create('/', 'POST', [], [], ['image' => $this->createDummyImage()]);

        // Act
        $uploadedPath = FileService::upload($request, $uploadPath);

        // Assert
        Storage::disk('public')->assertExists($uploadedPath);
        $this->assertStringStartsWith($uploadPath . '/', $uploadedPath);
    }

    /** @test */
    public function it_can_upload_a_document_file()
    {
        // Arrange
        Storage::fake('public');
        $uploadPath = 'documents';
        $request = Request::create('/', 'POST', [], [], ['document' => $this->createDummyDocument()]);

        // Act
        $uploadedPath = FileService::upload($request, $uploadPath);

        // Assert
        Storage::disk('public')->assertExists($uploadedPath);
        $this->assertStringStartsWith($uploadPath . '/', $uploadedPath);
    }

    /** @test */
    public function it_can_replace_a_file()
    {
        // Arrange
        Storage::fake('public');
        $originalFilePath = 'original-file.txt';
        $newFilePath = 'new-file.txt';
        Storage::disk('public')->put($originalFilePath, 'Original file content');
        $request = Request::create('/', 'POST', [], [], ['image' => $this->createDummyImage()]);

        // Act
        $replacedPath = FileService::replace($originalFilePath, $request, 'replaced-files');

        // Assert
        Storage::disk('public')->assertMissing($originalFilePath);
        Storage::disk('public')->assertExists($replacedPath);
        $this->assertStringStartsWith('replaced-files/', $replacedPath);
    }

    // Helper method to create a dummy image file
    private function createDummyImage()
    {
        return UploadedFile::fake()->image('dummy-image.jpg');
    }

    // Helper method to create a dummy document file
    private function createDummyDocument()
    {
        return UploadedFile::fake()->create('dummy-document.pdf');
    }
}
