<?php

namespace App\Models;

use App\Traits\HasAuthor;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Achievement Model for Data
 *
 * @method static \Database\Factories\AchievementFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Achievement newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Achievement newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Achievement query()
 * @mixin \Eloquent
 */
class Achievement extends Model
{
    use HasFactory, HasAuthor;
}
