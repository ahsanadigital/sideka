<?php

namespace App\Models;

use App\Enums\MeetingTypeEnum;
use App\Traits\HasAuthor;
use App\Traits\HasCategory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\Image\Enums\Fit;

/**
 * Model for Meeting Data
 *
 * @method static \Database\Factories\MeetingFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Meeting newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Meeting newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Meeting query()
 * @mixin \Eloquent
 */
class Meeting extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia, HasCategory, HasAuthor;

    /**
     * The attributes that are guarded to mass assignable.
     *
     * @var array<int, string>
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
            ->addMediaConversion('meeting-media-thumbnail')
            ->performOnCollections('meeting-photos')
            ->width(300)
            ->height(300)
            ->sharpen(10)
            ->quality(60)
            ->nonQueued();
    }

    /**
     * Getting the meeting type enumerator
     *
     * @return \Illuminate\Support\Collection|null
     */
    public static function getMeetingTypeEnum(): Collection
    {
        return collect(MeetingTypeEnum::cases())->pluck('value');
    }
}
