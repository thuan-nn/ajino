<?php

namespace App\Models;

use App\Supports\Traits\ModelTranslationTrait;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Sluggable\HasSlug;

class TaxonomyTranslation extends BaseModel
{
    use HasSlug, ModelTranslationTrait;

    protected $table = 'taxonomy_translations';

    protected $fillable = [
        'taxonomy_id',
        'title',
        'slug',
        'locale',
        'additional',
    ];

    protected $casts = [
        'additional' => 'json',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function taxonomy()
    {
        return $this->belongsTo(Taxonomy::class, 'taxonomy_id', 'id');
    }
}
