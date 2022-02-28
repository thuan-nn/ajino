<?php

namespace App\Models;

use App\Supports\Traits\ModelTranslationTrait;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Spatie\Sluggable\HasSlug;

class PostTranslation extends BaseModel
{
    use HasSlug, ModelTranslationTrait;

    protected $table = 'post_translations';

    protected $fillable = [
        'post_id',
        'title',
        'description',
        'slug',
        'content',
        'description',
        'locale',
        'additional',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    protected $casts = [
        'additional' => 'json',
    ];

    /**
     * @param $value
     */
    public function setSlugAttribute($value)
    {
        $this->attributes['slug'] = Str::slug($value, '-');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function post()
    {
        return $this->belongsTo(Post::class, 'post_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function candidates()
    {
        return $this->hasMany(Candidate::class, 'post_translation_id', 'id');
    }
}
