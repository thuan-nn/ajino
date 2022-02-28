<?php

namespace App\Models;

use App\Builders\JobBuilder;
use App\Supports\Traits\ModelLanguageTrait;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Job extends BaseModel
{
    use Translatable, ModelLanguageTrait;

    /**
     * @var string
     */
    protected $table = 'jobs';

    /**
     * @var string[]
     */
    protected $fillable = [
        'order',
        'is_published',
        'location_id',
    ];

    /**
     * @var string[]
     */
    protected $translatedAttributes = [
        'title',
        'slug',
        'description',
        'job_type',
        'salary',
        'locale',
        'is_feature',
        'additional',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    protected $appends = [
        'language',
    ];

    protected $casts = [
        'language' => 'array',
    ];

    public function provideCustomBuilder()
    {
        return JobBuilder::class;
    }

    public function taxonomies()
    {
        return $this->belongsToMany(Taxonomy::class,
            'job_taxonomies',
            'job_id',
            'taxonomy_id');
    }

    public function location()
    {
        return $this->belongsTo(Location::class, 'location_id', 'id');
    }
}
