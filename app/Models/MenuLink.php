<?php

namespace App\Models;

use App\Supports\Traits\ModelLanguageTrait;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Kalnoy\Nestedset\NodeTrait;

class MenuLink extends BaseModel implements TranslatableContract
{
    use NodeTrait, Translatable, ModelLanguageTrait;

    protected $table = 'menulinks';

    protected $translatedAttributes = [
        'title',
        'content',
        'locale',
        'url',
        'additional',
    ];

    protected $fillable = [
        'menu_id',
        'order',
        'taxonomy_id',
        'post_id',
        'parent_id',
        'class',
        '_lft',
        '_rgt',
    ];

    protected $hidden = ['translations', 'post'];

    protected $appends = [
        'language',
        'type',
        'slug',
    ];

    protected $casts = [
        'language' => 'array',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function menu()
    {
        return $this->belongsTo(Menu::class, 'menu_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function taxonomy()
    {
        return $this->belongsTo(Taxonomy::class, 'taxonomy_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function post()
    {
        return $this->belongsTo(Post::class, 'post_id', 'id');
    }

    public function getTypeAttribute()
    {
        return $this->post_id ? 'Page' : ($this->taxonomy_id ? 'Category' : 'Custom link');
    }

    /**
     * @return mixed|string
     */
    public function getSlugAttribute()
    {
        $locale = request('locale') ?? request()->header('locale');
        if (! is_null($this->taxonomy_id) && $this->taxonomy) {
            return $this->taxonomy->translate($locale)->slug;
        }

        if (! is_null($this->post) && $this->post) {
            return $this->getPostSlug($this->post);
        }
    }

    /**
     * @param \App\Models\Post $post
     * @return mixed|string
     */
    private function getPostSlug(Post $post)
    {
        if (! is_null(optional($post)->parent_id) && $post->parent) {
            return $this->getPostSlug($post->parent)."/".$post->slug;
        }

        return $post->slug;
    }

    public static function boot()
    {
        parent::boot();

        $locale = request('locale') ?? request()->header('App-Locale');
        static::deleting(function ($menuLink) use ($locale) {
            $menuLink->translations()->where('locale', $locale)->delete();
        });
    }
}
