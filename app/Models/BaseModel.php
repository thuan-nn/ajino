<?php

namespace App\Models;

use App\Supports\Traits\ClearsResponseCache;
use App\Supports\Traits\HasUuid;
use App\Supports\Traits\OverridesBuilder;
use App\Supports\Traits\UserStamps;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class BaseModel extends Model
{
    use HasFactory, Notifiable, HasUuid, HasRoles, OverridesBuilder, UserStamps, ClearsResponseCache, SoftDeletes;

    /**
     * Scope a query to only include published model.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return mixed
     */
    public function scopeIsPublished($query)
    {
        return $query->where('is_published', 1);
    }
}
