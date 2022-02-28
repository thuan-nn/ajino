<?php

namespace App\Models;

use App\Builders\MailHistoryBuilder;
use App\Supports\Traits\ClearsResponseCache;
use App\Supports\Traits\HasUuid;
use App\Supports\Traits\OverridesBuilder;
use App\Supports\Traits\UserStamps;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class MailHistory extends Model
{
    use HasFactory, Notifiable, HasUuid, HasRoles, OverridesBuilder, UserStamps, ClearsResponseCache;

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

    protected $fillable = [
        'email',
        'status',
        'company_tour_id',
        'content',
    ];

    /**
     * Company tour relation
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function companyTour()
    {
        return $this->belongsTo(CompanyTour::class, 'company_tour_id', 'id');
    }

    public function provideCustomBuilder()
    {
        return MailHistoryBuilder::class;
    }
}
