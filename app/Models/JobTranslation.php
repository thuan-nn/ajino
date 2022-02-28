<?php

namespace App\Models;

use App\Supports\Traits\ModelTranslationTrait;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Sluggable\HasSlug;

class JobTranslation extends BaseModel
{
    use HasSlug, ModelTranslationTrait;

    protected $table = 'job_translations';

    protected $fillable = [
        'job_id',
        'title',
        'slug',
        'description',
        'job_type',
        'salary',
        'locale',
        'location_id',
        'is_feature',
        'additional',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    protected $casts = [
        'salary'     => 'json',
        'additional' => 'json',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function job()
    {
        return $this->belongsTo(Job::class, 'job_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function candidates()
    {
        return $this->hasMany(Candidate::class, 'job_translation_id', 'id');
    }
}
