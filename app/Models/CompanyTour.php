<?php

namespace App\Models;

use App\Builders\CompanyTourBuilder;
use Illuminate\Database\Eloquent\SoftDeletes;

class CompanyTour extends BaseModel
{
    protected $table = 'company_tours';

    protected $fillable = [
        'location_id',
        'date',
        'type',
        'description',
        'people_amount',
        'registry_amount',
        'participant_amount',
        'is_published',
        'is_cancel',
        'additional',
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'is_cancel'    => 'boolean',
    ];

    /**
     * @return string
     */
    public function provideCustomBuilder()
    {
        return CompanyTourBuilder::class;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function visitors()
    {
        return $this->hasMany(Visitor::class, 'company_tour_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function location()
    {
        return $this->belongsTo(Location::class, 'location_id', 'id');
    }
}
