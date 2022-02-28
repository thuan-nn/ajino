<?php


namespace App\Supports\Traits;


use App\Enums\LanguageEnum;
use App\Models\Banner;

trait PostBannerTrait {
    /**
     * @param $post
     * @return array
     */
    private function getBannerLanguage($post)
    {
        return [
            LanguageEnum::EN => $this->countBannerLanguage($post, LanguageEnum::EN),
            LanguageEnum::VI => $this->countBannerLanguage($post, LanguageEnum::VI),
        ];
    }

    /**
     * @param \App\Models\Post $post
     * @param $language
     * @return bool
     */
    private function countBannerLanguage($post, $language)
    {
        $banners = optional($post)->banners;
        if ($banners) {
            $filter = $banners->filter(function ($value, $key) use ($language) {
                return $value->hasTranslation($language);
            })->count();

            if ($filter !== 0) {
                return true;
            }

            return false;
        }

        $banners = Banner::query()->whereNull('post_id')->translatedIn($language)->get();

        if ($banners->count() !== 0) {
            return true;
        }

        return false;
    }
}
