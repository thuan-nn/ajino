<?php

namespace App\Models;

use App\Builders\BannerBuilder;
use App\Supports\Traits\HasUuid;
use App\Supports\Traits\ModelLanguageTrait;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Banner extends BaseModel
{
    use SoftDeletes, Translatable, HasUuid, ModelLanguageTrait;

    protected $table = 'banners';

    protected $fillable = [
        'post_id',
        'type_slide',
        'is_published',
        'order',
        'title'
    ];

    public $translatedAttributes = [
        'additional',
        'banner_id',
        'title',
        'url',
        'description',
        'locale',
        'type',
        'video_url',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    public function provideCustomBuilder()
    {
        return BannerBuilder::class;
    }

    protected $appends = [
        'language',
    ];

    protected $casts = [
        'language' => 'array',
    ];

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
    public function items()
    {
        return $this->hasMany(BannerItem::class, 'banner_id', 'id');
    }
}