<?php

namespace App\Models;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * 
 *
 * @property string $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $title
 * @property string $number
 * @property string|null $nomenclature
 * @property \Illuminate\Support\Carbon|null $start_from
 * @property \Illuminate\Support\Carbon|null $end_to
 * @property string|null $file
 * @property int $users_id
 * @property-read \App\Models\User|null $user
 * @method static \Database\Factories\DecreeFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Decree newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Decree newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Decree query()
 * @method static \Illuminate\Database\Eloquent\Builder|Decree whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Decree whereEndTo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Decree whereFile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Decree whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Decree whereNomenclature($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Decree whereNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Decree whereStartFrom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Decree whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Decree whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Decree whereUsersId($value)
 * @mixin \Eloquent
 */
class Decree extends Model
{
    use HasFactory, HasUuid;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'number',
        'nomenclature',
        'start_from',
        'end_from',
        'file',
        'users_id',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected $casts = [
        'start_from' => 'datetime',
        'end_to' => 'datetime',
    ];

    /**
     * User relation method
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
