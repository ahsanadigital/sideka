<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

/**
 * Trait for extending the auto generate slug
 *
 * @package laravel-10-template
 * @since 1.0.0
 * @author cakadi190 <cakadi190@gmail.com>
 */
trait HasSlug
{
    /**
     * Extending the boot method from eloquent
     */
    protected static function boot(): void
    {
        parent::boot();

        static::creating(fn(Model $model) => $model->setAttribute('slug', Str::slug($model->title ? $model->title : $model->name)));
        static::updating(fn(Model $model) => $model->setAttribute('slug', Str::slug($model->title ? $model->title : $model->name)));
    }
}
