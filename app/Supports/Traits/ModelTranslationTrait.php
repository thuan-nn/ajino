<?php

namespace App\Supports\Traits;

use App\Models\File;
use Spatie\Sluggable\SlugOptions;

trait ModelTranslationTrait
{
    /**
     * @return \Spatie\Sluggable\SlugOptions
     */
    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()->generateSlugsFrom('title')
                          ->saveSlugsTo('slug')
                          ->doNotGenerateSlugsOnUpdate();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
     */
    public function files()
    {
        return $this->morphToMany(File::class, 'model', 'model_has_files');
    }
}