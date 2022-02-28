<?php

namespace App\Models;

class BannerItemTranslation extends BaseModel
{
    protected $table = 'banner_item_translations';

    protected $fillable = [
        'banner_item_id',
        'title',
        'url',
        'description',
        'type',
        'video_url',
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
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function banner_item()
    {
        return $this->belongsTo(BannerItem::class, 'banner_item_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
     */
    public function files()
    {
        return $this->morphToMany(File::class, 'model', 'model_has_files');
    }

    /**
     * @param $value
     * @return string|null
     */
    public function setVideoUrlAttribute($value)
    {
        if ($this->type === 'video') {
            parse_str(parse_url($value, PHP_URL_QUERY), $params);

            if (isset($params['v'])) {
                return $this->attributes['video_url'] = (string) 'https://www.youtube.com/embed/'.$params['v'].'?enablejsapi=1&controls=0&fs=0&iv_load_policy=3&rel=0&showinfo=0&loop=1&start=1&vq=hd720';
            }

            return $this->attributes['video_url'] = $value;
        }

        return $this->attributes['video_url'] = null;
    }
}
