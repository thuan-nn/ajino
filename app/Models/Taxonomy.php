<?php

namespace App\Models;

use App\Builders\TaxonomyBuilder;
use App\Supports\Traits\ModelLanguageTrait;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;

class Taxonomy extends BaseModel implements TranslatableContract
{
    use Translatable, ModelLanguageTrait;

    protected $table = 'taxonomies';

    protected $translatedAttributes = [
        'title',
        'slug',
        'content',
        'locale',
        'additional',
    ];

    protected $fillable = [
        'type',
        'is_published',
        'page',
        'order',
        'created_by',
        'updated_by',
    ];

    protected $appends = [
        'language',
    ];

    protected $casts = [
        'language' => 'array',
    ];

    /**
     * @return string
     */
    public function provideCustomBuilder()
    {
        return TaxonomyBuilder::class;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function posts()
    {
        return $this->belongsToMany(Post::class,
            'taxonomy_posts',
            'taxonomy_id',
            'post_id')->withPivot('locale');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function jobs()
    {
        return $this->belongsToMany(Job::class,
            'job_taxonomies',
            'taxonomy_id',
            'job_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function menuLinks()
    {
        return $this->hasMany(MenuLink::class, 'taxonomy_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function banner()
    {
        return $this->hasOne(Banner::class, 'taxonomy_id', 'id');
    }
}
