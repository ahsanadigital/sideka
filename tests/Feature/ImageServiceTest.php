<?php

use App\Services\ImageService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ImageServiceTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
    }

    protected function tearDown(): void
    {
        parent::tearDown();
    }

    /** @test */
    public function it_can_get_image_size()
    {
        $filePath = storage_path('app/test-big-image.jpg');

        $imageSize = ImageService::getImageSize($filePath);

        $this->assertCount(7, $imageSize);
    }

    /** @test */
    public function it_can_convert_image_to_webp_and_perform_compression()
    {
        $filePath = storage_path('app/test-big-image.jpg');
        $storePath = 'converted';
        $quality = 80;
        $width = 500;
        $height = 500;

        $result = ImageService::convertToWebP($filePath, $storePath, $quality, $width, $height);

        $this->assertNotNull($result);
    }

    /** @test */
    public function it_can_convert_image_to_jpg_and_perform_compression()
    {
        $filePath = storage_path('app/test-big-image.jpg');
        $storePath = 'converted';
        $quality = 80;
        $width = 500;
        $height = 500;

        $result = ImageService::convertToJpg($filePath, $storePath, $quality, $width, $height);

        $this->assertNotNull($result);
    }
}
