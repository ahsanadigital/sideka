<?php

namespace App\Traits;

use App\Models\CouncilCategory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait HasCategory
{
    /**
     * Getting Category relation
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(CouncilCategory::class, 'category_id', 'id');
    }
}
