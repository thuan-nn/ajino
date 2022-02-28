<?php

namespace App\Models;

use App\Builders\BannerItemBuilder;
use App\Supports\Traits\ModelLanguageTrait;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;

class BannerItem extends BaseModel implements TranslatableContract
{
    use Translatable, ModelLanguageTrait;

    protected $table = 'banner_items';

    protected $fillable = ['banner_id', 'order', 'locale'];

    protected $translatedAttributes = [
        'banner_item_id',
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

    protected $appends = [
        'language',
    ];

    protected $casts = [
        'language' => 'array',
    ];

    public function provideCustomBuilder()
    {
        return BannerItemBuilder::class;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function banner()
    {
        return $this->belongsTo(Banner::class);
    }
}
