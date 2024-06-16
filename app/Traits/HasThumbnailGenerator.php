<?php

namespace App\Traits;

use Spatie\MediaLibrary\MediaCollections\Models\Media;

trait HasThumbnailGenerator
{
    public function registerMediaConversions(?Media $media = null): void
    {
        $this->addMediaConversion($this->table . '-thumb')
            ->width(150)
            ->height(150);
    }
}
