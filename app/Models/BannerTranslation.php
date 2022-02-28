<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class BannerTranslation extends BaseModel
{
    protected $table = 'banner_translations';

    protected $fillable = [
        'banner_id',
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
    public function banner()
    {
        return $this->belongsTo(Banner::class, 'banner_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
     */
    public function files()
    {
        return $this->morphToMany(File::class, 'model', 'model_has_files');
    }
}
