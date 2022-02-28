<?php

namespace App\Models;

use App\Builders\PostBuilder;
use App\Supports\Traits\ModelLanguageTrait;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;

class Post extends BaseModel implements TranslatableContract
{
    use Translatable, ModelLanguageTrait;

    protected $table = 'posts';

    protected $fillable = ['parent_id', 'type', 'is_published', 'order'];

    protected $translatedAttributes = [
        'title',
        'description',
        'slug',
        'content',
        'description',
        'additional',
        'locale',
    ];

    protected $appends = [
        'language',
    ];

    protected $casts = [
        'language' => 'array',
    ];

    public function provideCustomBuilder()
    {
        return PostBuilder::class;
    }

    public static function boot()
    {
        parent::boot();

        $locale = request('locale') ?? request()->header('App-Locale');
        static::deleting(function ($post) use ($locale) {
            $post->translations()->where('locale', $locale)->delete();
            $post->children()->update(['deleted_at' => now()]);
        });
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function taxonomies()
    {
        return $this->belongsToMany(Taxonomy::class,
            'taxonomy_posts',
            'post_id',
            'taxonomy_id')->withPivot('locale');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function menuLinks()
    {
        return $this->hasMany(MenuLink::class, 'post_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function banners()
    {
        return $this->hasMany(Banner::class, 'post_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function parent()
    {
        return $this->belongsTo(Post::class, 'parent_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function children()
    {
        return $this->hasMany(Post::class, 'parent_id', 'id');
    }
}
