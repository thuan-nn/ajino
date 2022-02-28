<?php

namespace App\Supports\Traits;

use App\Enums\LanguageEnum;
use App\Models\File;
use Spatie\Sluggable\SlugOptions;

trait ModelLanguageTrait
{
    /**
     * @return array
     */
    public function getLanguageAttribute() {
        $languages = LanguageEnum::asArray();
        $result = [];
        foreach ($languages as $language) {
            $result[$language] = $this->hasTranslation($language);
        }

        return $result;
    }
}