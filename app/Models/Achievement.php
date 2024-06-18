<?php

namespace App\Models;

use App\Traits\HasAuthor;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

/**
 * Achievement Model for Data
 *
 * @method static \Database\Factories\AchievementFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Achievement newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Achievement newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Achievement query()
 * @mixin \Eloquent
 */
class Achievement extends Model implements HasMedia
{
    use HasFactory, HasAuthor, InteractsWithMedia;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * Register media conversions for the meeting.
     *
     * @param Media|null $media The media to register conversions for.
     * @return void
     */
    public function registerMediaConversions(Media|null $media = null): void
    {
        $this
            ->addMediaConversion('achievement-media-thumbnail')
            ->performOnCollections('achievement-photos')
            ->width(300)
            ->height(300)
            ->sharpen(10)
            ->quality(60)
            ->nonQueued();
    }
}
