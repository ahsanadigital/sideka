<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

/**
 * Trait for extending the auto generate UUID to id primary key
 *
 * @package laravel-10-template
 * @since 1.0.0
 * @author cakadi190 <cakadi190@gmail.com>
 */
trait HasUuid
{
    /**
     * Extending the boot method from eloquent
     *
     * @see https://www.larashout.com/using-uuids-in-laravel-models
     */
    protected static function boot()
    {
        parent::boot();
        static::creating(function (Model $model) {
            if (empty($model->getAttribute($model->getKeyName()))) {
                $model->setAttribute($model->getKeyName(), Str::uuid()->toString());
            }
        });
    }

    /**
     * Get the value indicating whether the IDs are incrementing.
     *
     * @return bool
     */
    public function getIncrementing()
    {
        return false;
    }

    /**
     * Get the auto-incrementing key type.
     *
     * @return string
     */
    public function getKeyType()
    {
        return 'string';
    }
}
